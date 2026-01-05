<?php
// Set CORS headers at the top
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

include '../config/db.php';
include '../config/user_session.php';

$d = date('Y-m-d');

// Sanitize and validate inputs
$branch_id = isset($_POST['branch']) ? trim($_POST['branch']) : '';// branch id
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 100; // Default to 100

// Build WHERE clause
$whereClause = "Status = 'Active' AND Branch_id = '$branch_id'";
$params = [];
$types = '';

if (!empty($search)) {
    $searchParam = "%$search%";
    $whereClause .= " AND (BVN LIKE ? OR Account_Number LIKE ? OR Loan_Account_No LIKE ? 
    OR Disbursement_No LIKE ? OR Transaction_id LIKE ? OR Savings_Account_No LIKE ? 
    OR Unions LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ? 
    OR Branch LIKE ? OR Officer_Name LIKE ? OR Phone LIKE ?)";
    
    // Add search parameter 13 times for all LIKE clauses
    for ($i = 0; $i < 13; $i++) {
        $params[] = $searchParam;
        $types .= 's';
    }
}

// Count query
if (!empty($search)) {
    $countQuery = "SELECT COUNT(*) as total FROM repayments WHERE $whereClause";
    $stmt = mysqli_prepare($con, $countQuery);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
} else {
    $countQuery = "SELECT COUNT(*) as total FROM repayments WHERE $whereClause";
    $stmt = mysqli_prepare($con, $countQuery);
}

mysqli_stmt_execute($stmt);
$countResult = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($countResult);
$total = $row['total'];
mysqli_stmt_close($stmt);

// Data query with Frequency field added
$dataQuery = "SELECT id, Loan_Account_No, Firstname, Lastname, Middlename, Product, Branch, Phone,
    Total_Loan, Paid, Maturity_Status, Expected_Amount, Date_Disbursed, Maturity_Date, Officer_Name,
    Status, Total_Bal, Duration, Frequency, Savings_Bal, Disbursement_No 
    FROM repayments WHERE $whereClause ORDER BY Firstname ASC";

if ($maxRows > 0) {
    $dataQuery .= " LIMIT ?";
    $tempParams = $params;
    $tempParams[] = $maxRows;
    $tempTypes = $types . 'i';
} else {
    $tempParams = $params;
    $tempTypes = $types;
}

$stmt = mysqli_prepare($con, $dataQuery);

if (!empty($tempParams)) {
    mysqli_stmt_bind_param($stmt, $tempTypes, ...$tempParams);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch results and calculate values
$results = array();
$totalOverdue = 0;
$totalOutstanding = 0;

// PAR calculations
$par30_count = 0;
$par30_amount = 0;
$par60_count = 0;
$par60_amount = 0;
$par90_count = 0;
$par90_amount = 0;

while($row = mysqli_fetch_assoc($result)) {
    $expectedAmt = (float)($row['Expected_Amount'] ?? 0);
    $paid = (float)($row['Paid'] ?? 0);
    $dateDisbursed = $row['Date_Disbursed'] ?? null;
    $maturityDate  = $row['Maturity_Date'] ?? null;
    $duration = (int)($row['Duration'] ?? 0);
    $frequency = $row['Frequency'] ?? 'Daily';
    $totalBal = (float)($row['Total_Bal'] ?? 0);

    $overdueAmt  = 0;
    $daysOverdue = 0;
    $tenureUsed = 0;
    $tenureRemain = 0;
    $expectedDueAmt = 0;
    $overdueDays = 0;

    if ($dateDisbursed && $maturityDate) {
        try {
            $start = new DateTime($dateDisbursed);
            $end   = new DateTime($maturityDate);
            $today = new DateTime($d);

            // Calculate tenure used based on frequency
            if ($frequency == 'Daily') {
                $tenureUsed = $start->diff($today)->days;
                $tenureRemain = max(0, $duration - $tenureUsed);
                
                if ($duration > $tenureUsed) {
                    $expectedDueAmt = $expectedAmt * $tenureUsed;
                    $overdueAmt = max(0, $expectedDueAmt - $paid);
                    if ($overdueAmt > 0) {
                        $overdueDays = round($overdueAmt / $expectedAmt);
                    }
                } else {
                    $expectedDueAmt = $row['Total_Loan'];
                    $overdueAmt = $totalBal;
                    $overdueDays = round($totalBal / $expectedAmt);
                    $tenureRemain = 0;
                }
                
            } elseif ($frequency == 'Weekly') {
                $daysElapsed = $start->diff($today)->days;
                $tenureUsed = round($daysElapsed / 7);
                $tenureRemain = max(0, $duration - $tenureUsed);
                
                if ($tenureUsed == 0) {
                    $expectedDueAmt = 0;
                    $overdueAmt = 0;
                    $overdueDays = 0;
                } elseif ($duration > $tenureUsed) {
                    $expectedDueAmt = $expectedAmt * $tenureUsed;
                    $overdueAmt = max(0, $expectedDueAmt - $paid);
                    if ($overdueAmt > 0) {
                        // Convert weeks to days for overdue period
                        $overdueDays = round(($overdueAmt / $expectedAmt) * 7);
                    }
                } else {
                    $expectedDueAmt = $row['Total_Loan'];
                    $overdueAmt = $totalBal;
                    // Convert weeks to days for overdue period
                    $overdueDays = round(($totalBal / $expectedAmt) * 7);
                    $tenureRemain = 0;
                }
                
            } else { // Monthly
                $daysElapsed = $start->diff($today)->days;
                $tenureUsed = round($daysElapsed / 30);
                $tenureRemain = max(0, $duration - $tenureUsed);
                
                if ($tenureUsed == 0) {
                    $expectedDueAmt = 0;
                    $overdueAmt = 0;
                    $overdueDays = 0;
                } elseif ($duration > $tenureUsed) {
                    $expectedDueAmt = $expectedAmt * $tenureUsed;
                    $overdueAmt = max(0, $expectedDueAmt - $paid);
                    if ($overdueAmt > 0) {
                        // Convert months to days for overdue period
                        $overdueDays = round(($overdueAmt / $expectedAmt) * 30);
                    }
                } else {
                    $expectedDueAmt = $row['Total_Loan'];
                    $overdueAmt = $totalBal;
                    // Convert months to days for overdue period
                    $overdueDays = round(($totalBal / $expectedAmt) * 30);
                    $tenureRemain = 0;
                }
            }

            // Calculate days overdue from maturity date
            if ($today > $end) {
                $daysOverdue = $end->diff($today)->days;
            }
            
            // Calculate PAR categories based on days past maturity
            if ($daysOverdue >= 30 && $overdueAmt > 0) {
                $par30_count++;
                $par30_amount += $totalBal;
            }
            if ($daysOverdue >= 60 && $overdueAmt > 0) {
                $par60_count++;
                $par60_amount += $totalBal;
            }
            if ($daysOverdue >= 90 && $overdueAmt > 0) {
                $par90_count++;
                $par90_amount += $totalBal;
            }
            
        } catch (Exception $e) {
            $overdueAmt  = 0;
            $daysOverdue = 0;
            $tenureUsed = 0;
        }
    }

    $row['Overdue_Amount'] = round($overdueAmt, 2);
    $row['Days_Overdue'] = $daysOverdue;
    $row['Tenure_Used'] = $tenureUsed;
    $row['Tenure_Remain'] = $tenureRemain;
    $row['Expected_Due_Amount'] = round($expectedDueAmt, 2);
    $row['Overdue_Days_Count'] = $overdueDays;
    $row['Repayment_Percent'] = $row['Total_Loan'] > 0 ? round(($paid / $row['Total_Loan']) * 100) : 0;
    
    $totalOverdue += $row['Overdue_Amount'];
    $totalOutstanding += $totalBal;

    $results[] = $row; 
}
mysqli_stmt_close($stmt);

// Save to JSON file
$jsonData = json_encode($results, JSON_PRETTY_PRINT);
if ($jsonData !== false) {
    $filePath = '../data/overdue_portfolio_list.json';
    $dirPath = dirname($filePath);
    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0755, true);
    }
    file_put_contents($filePath, $jsonData);
}

mysqli_close($con);
?>



<div class="row mb-3">
    <div class="col-sm-10">
        <div class="stat-summary">
            <small style="opacity: 0.9;"><b>Total Active Loans:</b></small>
            <strong><?php echo number_format($total); ?></strong>
            <?php if (!empty($search)): ?>
                <small style="margin-left: 10px; opacity: 0.7;">(Showing <?php echo number_format(count($results)); ?> results)</small>
            <?php elseif ($maxRows > 0 && $total > $maxRows): ?>
                <small style="margin-left: 10px; opacity: 0.7;">(Showing first <?php echo number_format($maxRows); ?>)</small>
            <?php endif; ?>
            <?php if ($total > 0): ?>
                <small style="margin-left: 15px; opacity: 0.9;"><b>Total Outstanding:</b></small>
                <strong><?php echo number_format($totalOutstanding, 2); ?></strong>
                <small style="margin-left: 15px; opacity: 0.9;"><b>Total Overdue:</b></small>
                <strong><?php echo number_format($totalOverdue, 2); ?></strong>
            <?php endif; ?>
        </div>
        </div>
        

    <div class="col-sm-2">
        <button type="button" class="btn btn-outline-primary btn-sm btn-flat w-100" onclick="tableToExcel()">
            <i class="fa fa-download"></i> Export to Excel
        </button>
    </div>
</div>

<?php if (empty($results) && !empty($search)): ?>
<div class="alert alert-warning" style="display:none;">
    <i class="fa fa-search"></i> No results found for "<strong><?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?></strong>"
</div>
<?php elseif (empty($results)): ?>
<div class="alert alert-success" style="display:none;">
    <i class="fa fa-check-circle"></i> No overdue loans found!
</div>
<?php endif; ?>


<div id="table-container" style="height:360px;">
<table id="expiredLoansTable" style="font-size: 8px;">
<thead>
<tr>
                <th>DISBURSEMENT NO</th>
                <th>LOAN ACCT</th>
                <th>NAME</th>
                <th>BRANCH</th>
                <th>PHONE</th>
                <th>PRODUCT</th>
                <th>TOTAL LOAN</th>
                <th>AMT PAID</th>
                <th>OUTSTANDING</th>
                <th>EXPD AMT</th>
                <th>SAVINGS</th>
                <th>REPAYMENT %</th>
                <th>TENURE</th>
                <th>TENURE USED</th>
                <th>TENURE REMAIN</th>
                <th>EXPECTED DUE AMT</th>
                <th>OVERDUE AMT</th>
                <th>OVERDUE DAY</th>
                <th>DAYS PAST DUE</th>
                <th>PAR STATUS</th>
                <th>CREDIT OFFICER</th>
                <th>DATE DISBURSED</th>
                <th>DUE DATE</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($results)) {
            foreach($results as $member) {
                $disbursementNo = htmlspecialchars($member['Disbursement_No'] ?? '', ENT_QUOTES, 'UTF-8');
                $loanAcct = htmlspecialchars($member['Loan_Account_No'] ?? '', ENT_QUOTES, 'UTF-8');
                $firstname = htmlspecialchars($member['Firstname'] ?? '', ENT_QUOTES, 'UTF-8');
                $middlename = htmlspecialchars($member['Middlename'] ?? '', ENT_QUOTES, 'UTF-8');
                $lastname = htmlspecialchars($member['Lastname'] ?? '', ENT_QUOTES, 'UTF-8');
                $ph = htmlspecialchars($member['Phone'] ?? '', ENT_QUOTES, 'UTF-8');
                $branch = htmlspecialchars($member['Branch'] ?? '', ENT_QUOTES, 'UTF-8');
                $product = htmlspecialchars($member['Product'] ?? '', ENT_QUOTES, 'UTF-8');
                $duration = (int)($member['Duration'] ?? 0);
                $frequency = htmlspecialchars($member['Frequency'] ?? 'Daily', ENT_QUOTES, 'UTF-8');
                $tenureUsed = (int)($member['Tenure_Used'] ?? 0);
                $tenureRemain = (int)($member['Tenure_Remain'] ?? 0);
                $totalloan = (float)($member['Total_Loan'] ?? 0);
                $paid = (float)($member['Paid'] ?? 0);
                $exp = (float)($member['Expected_Amount'] ?? 0);
                $totalbal = (float)($member['Total_Bal'] ?? 0);
                $savingsBal = (float)($member['Savings_Bal'] ?? 0);
                $overdueamt = (float)($member['Overdue_Amount'] ?? 0);
                $expectedDueAmt = (float)($member['Expected_Due_Amount'] ?? 0);
                $overdueDaysCount = (int)($member['Overdue_Days_Count'] ?? 0);
                $repaymentPercent = (int)($member['Repayment_Percent'] ?? 0);
                $datedisburse = htmlspecialchars($member['Date_Disbursed'] ?? '', ENT_QUOTES, 'UTF-8');
                $maturitydate = htmlspecialchars($member['Maturity_Date'] ?? '', ENT_QUOTES, 'UTF-8');
                $ofn = htmlspecialchars($member['Officer_Name'] ?? '', ENT_QUOTES, 'UTF-8');
                
                $daysOverdue = (int)($member['Days_Overdue'] ?? 0);

                // Determine PAR status
                $parStatus = '';
                $parColor = '';
                if ($daysOverdue >= 90) {
                    $parStatus = 'PAR 90+';
                    $parColor = '#dc3545';
                } elseif ($daysOverdue >= 60) {
                    $parStatus = 'PAR 60+';
                    $parColor = '#ff9800';
                } elseif ($daysOverdue >= 30) {
                    $parStatus = 'PAR 30+';
                    $parColor = '#ffc107';
                } elseif ($daysOverdue > 0) {
                    $parStatus = 'PAR 1-29';
                    $parColor = '#28a745';
                } else {
                    $parStatus = 'Current';
                    $parColor = '#17a2b8';
                }

                $overdueClass = '';
                if ($daysOverdue > 90) {
                    $overdueClass = 'style="background-color:#f8d7da;"';
                } elseif ($daysOverdue > 60) {
                    $overdueClass = 'style="background-color:#ffe6e6;"';
                } elseif ($daysOverdue > 30) {
                    $overdueClass = 'style="background-color:#fff3cd;"';
                }

                $frequencyLabel = $frequency == 'Daily' ? 'Days' : ($frequency == 'Weekly' ? 'Weeks' : 'Months');
        ?>
                <tr <?php echo $overdueClass; ?>>
                    <td><?php echo $disbursementNo; ?></td>
                    <td><?php echo $loanAcct; ?></td>
                    <td style="text-transform:capitalize"><?php echo trim("$firstname $middlename $lastname"); ?></td>
                    <td><?php echo $branch; ?></td>
                    <td><?php echo $ph; ?></td>
                    <td><?php echo $product; ?></td>
                    <td><?php echo number_format($totalloan, 2); ?></td>
                    <td><?php echo number_format($paid, 2); ?></td>
                    <td><strong style="color: #dc3545;"><?php echo number_format($totalbal, 2); ?></strong></td>
                    <td><?php echo number_format($exp, 2); ?></td>
                    <td><?php echo number_format($savingsBal, 2); ?></td>
                    <td><?php echo $repaymentPercent; ?>%</td>
                    <td><?php echo $duration; ?></td>
                    <td><strong><?php echo $tenureUsed . ' ' . $frequencyLabel; ?></strong></td>
                    <td><?php echo ($tenureRemain > 0) ? $tenureRemain . ' ' . $frequencyLabel : '<span style="color:red;">Exceeded</span>'; ?></td>
                    <td><?php echo number_format($expectedDueAmt, 2); ?></td>
                    <td><strong style="color: #d9534f; background: #ffe6e6; padding: 2px 6px; border-radius: 3px;"><?php echo number_format($overdueamt, 2); ?></strong></td>
                    <td><?php echo $overdueDaysCount . ' days'; ?></td>
                    <td><strong><?php echo $daysOverdue; ?> days</strong></td>
                    <td><span style="background: <?php echo $parColor; ?>; color: white; padding: 3px 8px; border-radius: 3px; font-weight: 600; font-size: 9px;"><?php echo $parStatus; ?></span></td>
                    <td><?php echo $ofn; ?></td>
                    <td><?php echo !empty($datedisburse) ? date('d-M-Y', strtotime($datedisburse)) : 'N/A'; ?></td>
                    <td><?php echo !empty($maturitydate) ? date('d-M-Y', strtotime($maturitydate)) : 'N/A'; ?></td>
                    <td>
                        <?php 
                        if($d > $maturitydate){
                            echo "<span style='color:red; font-weight:600;'>Expired</span>";
                        }else{
                            echo "<span style='color:green; font-weight:600;'>Active</span>";
                        }
                        ?>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="20" style="text-align:center;  color: #6c757d;">No overdue loan records found</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Include XLSX library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
function tableToExcel() {
    try {
        let table = document.getElementById('expiredLoansTable');
        if (!table) {
            alert('Table not found');
            return;
        }
        let workbook = XLSX.utils.table_to_book(table, {sheet: "Overdue Loans"});
        let filename = "Overdue_Loans_PAR_Report_" + new Date().toISOString().split('T')[0] + ".xlsx";
        XLSX.writeFile(workbook, filename);
        console.log('Excel file exported successfully');
    } catch (error) {
        console.error('Export error:', error);
        alert('Failed to export data: ' + error.message);
    }
}

function resetSearch() {
    document.getElementById('searchInput').value = '';
    document.getElementById('maxRowsSelect').value = '100';
    document.getElementById('searchForm').submit();
}

// Auto-submit on limit change
document.getElementById('maxRowsSelect').addEventListener('change', function() {
    document.getElementById('searchForm').submit();
});
</script>