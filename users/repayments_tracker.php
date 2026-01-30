<?php
// Set CORS headers
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

include '../config/db.php';
include '../config/user_session.php';

$d = date('Y-m-d');
$today = new DateTime($d);

// Sanitize and validate inputs
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : '';

// Build WHERE clause
$whereClause = "Status = 'Active'";
$params = [];
$types = '';

if (!empty($search)) {
    $searchParam = "%$search%";
    $whereClause .= " AND (BVN LIKE ? OR Account_Number LIKE ? OR Loan_Account_No LIKE ? 
    OR Disbursement_No LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ? 
    OR Branch LIKE ? OR Officer_Name LIKE ? OR Phone LIKE ?)";
    
    for ($i = 0; $i < 10; $i++) {
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

// Data query - include Repayment_Day
$dataQuery = "SELECT id, Loan_Account_No, Firstname, Lastname, Middlename, Product, Branch, Phone,
    Total_Loan, Paid, Expected_Amount, Date_Disbursed, Maturity_Date, Officer_Name,
    Status, Total_Bal, Duration, Frequency, Disbursement_No, Repayment_Day 
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

// Fetch results and calculate repayment tracking
$results = array();
$totalLoansAmount = 0;
$totalPaidAmount = 0;
$totalOutstanding = 0;
$totalMissedPayments = 0;
$onTrackCount = 0;
$behindCount = 0;

while($row = mysqli_fetch_assoc($result)) {
    $expectedAmt = (float)($row['Expected_Amount'] ?? 0);
    $paid = (float)($row['Paid'] ?? 0);
    $dateDisbursed = $row['Date_Disbursed'] ?? null;
    $maturityDate = $row['Maturity_Date'] ?? null;
    $duration = (int)($row['Duration'] ?? 0);
    $frequency = $row['Frequency'] ?? 'Daily';
    $repaymentDay = $row['Repayment_Day'] ?? null;
    $totalLoan = (float)($row['Total_Loan'] ?? 0);
    $totalBal = (float)($row['Total_Bal'] ?? 0);

    $missedRepayments = 0;
    $expectedDueAmt = 0;
    $nextPaymentDate = null;
    $repaymentStatus = 'On Track';
    $statusColor = '#28a745';

    if ($dateDisbursed && $maturityDate && $repaymentDay) {
        try {
            $startDate = new DateTime($dateDisbursed);
            $endDate = new DateTime($maturityDate);
            
            // Calculate how many payment dates have passed based on frequency and repayment day
            $paymentDates = [];
            $currentPaymentDate = clone $startDate;
            
            if ($frequency === 'Daily') {
                // For daily, every day is a payment day
                while ($currentPaymentDate <= $today && $currentPaymentDate <= $endDate) {
                    $paymentDates[] = clone $currentPaymentDate;
                    $currentPaymentDate->modify('+1 day');
                }
                
            } elseif ($frequency === 'Weekly') {
                // For weekly, find the specific day of week (e.g., "Monday", "Friday")
                // Repayment_Day should contain day name like "Monday"
                while ($currentPaymentDate <= $endDate) {
                    // Move to the specified day of week
                    if ($currentPaymentDate->format('l') !== $repaymentDay) {
                        $currentPaymentDate->modify("next $repaymentDay");
                    }
                    
                    if ($currentPaymentDate <= $today && $currentPaymentDate <= $endDate) {
                        $paymentDates[] = clone $currentPaymentDate;
                    }
                    
                    $currentPaymentDate->modify('+1 week');
                    
                    if (count($paymentDates) >= $duration) break;
                }
                
            } else { // Monthly
                // For monthly, find the specific day of month (e.g., 5, 15, 28)
                $dayOfMonth = (int)$repaymentDay;
                
                while ($currentPaymentDate <= $endDate) {
                    // Set to the repayment day of current month
                    $year = (int)$currentPaymentDate->format('Y');
                    $month = (int)$currentPaymentDate->format('m');
                    $lastDayOfMonth = (int)date('t', mktime(0, 0, 0, $month, 1, $year));
                    
                    // Handle cases where repayment day > days in month
                    $actualDay = min($dayOfMonth, $lastDayOfMonth);
                    $paymentDate = new DateTime("$year-$month-$actualDay");
                    
                    if ($paymentDate >= $startDate && $paymentDate <= $today && $paymentDate <= $endDate) {
                        $paymentDates[] = clone $paymentDate;
                    }
                    
                    $currentPaymentDate->modify('+1 month');
                    
                    if (count($paymentDates) >= $duration) break;
                }
            }
            
            // Count payment dates that have passed
            $expectedPaymentCount = count($paymentDates);
            
            // Calculate expected amount based on actual payment dates passed
            $expectedDueAmt = $expectedPaymentCount * $expectedAmt;
            
            // Calculate how many payments were actually made
            $actualPaymentsMade = $expectedAmt > 0 ? floor($paid / $expectedAmt) : 0;
            
            // Missed payments = expected payments - actual payments made
            $missedRepayments = max(0, $expectedPaymentCount - $actualPaymentsMade);
            
            // Find next payment date
            if ($frequency === 'Daily') {
                $nextPaymentDate = clone $today;
                $nextPaymentDate->modify('+1 day');
            } elseif ($frequency === 'Weekly') {
                $nextPaymentDate = clone $today;
                $nextPaymentDate->modify("next $repaymentDay");
            } else { // Monthly
                $nextMonth = clone $today;
                $nextMonth->modify('+1 month');
                $year = (int)$nextMonth->format('Y');
                $month = (int)$nextMonth->format('m');
                $lastDayOfMonth = (int)date('t', mktime(0, 0, 0, $month, 1, $year));
                $actualDay = min((int)$repaymentDay, $lastDayOfMonth);
                $nextPaymentDate = new DateTime("$year-$month-$actualDay");
            }

            // Determine repayment status
            if ($missedRepayments > 5) {
                $repaymentStatus = 'Critical';
                $statusColor = '#dc3545';
                $behindCount++;
            } elseif ($missedRepayments > 2) {
                $repaymentStatus = 'Behind';
                $statusColor = '#ff9800';
                $behindCount++;
            } elseif ($missedRepayments > 0) {
                $repaymentStatus = 'Warning';
                $statusColor = '#ffc107';
            } else {
                $repaymentStatus = 'On Track';
                $statusColor = '#28a745';
                $onTrackCount++;
            }

        } catch (Exception $e) {
            $missedRepayments = 0;
            $expectedDueAmt = 0;
        }
    }

    $row['Missed_Repayments'] = $missedRepayments;
    $row['Expected_Due_Amount'] = round($expectedDueAmt, 2);
    $row['Next_Payment_Date'] = $nextPaymentDate ? $nextPaymentDate->format('Y-m-d') : null;
    $row['Repayment_Status'] = $repaymentStatus;
    $row['Status_Color'] = $statusColor;
    $row['Repayment_Percent'] = $totalLoan > 0 ? round(($paid / $totalLoan) * 100) : 0;
    
    $totalLoansAmount += $totalLoan;
    $totalPaidAmount += $paid;
    $totalOutstanding += $totalBal;
    $totalMissedPayments += $missedRepayments;

    $results[] = $row;
}
mysqli_stmt_close($stmt);

// Save to JSON file
$jsonData = json_encode($results, JSON_PRETTY_PRINT);
if ($jsonData !== false) {
    $filePath = '../data/repayment_tracking.json';
    $dirPath = dirname($filePath);
    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0755, true);
    }
    file_put_contents($filePath, $jsonData);
}

mysqli_close($con);
?>


<div class="row">
<div class="col-sm-3">
 <small><b>Total Loans:</b></small>
                <strong><?php echo number_format($total); ?></strong>
</div>
<div class="col-sm-3">
<small><b>On Track:</b></small>
                <strong><?php echo number_format($onTrackCount); ?></strong>
</div>
<div class="col-sm-3">
     <small><b>Behind:</b></small>
                <strong><?php echo number_format($behindCount); ?></strong>
</div>
<div class="col-sm-3">
<small><b>Behind:</b></small>
                <strong><?php echo number_format($behindCount); ?></strong>
</div>
<div class="col-sm-3">
 <small><b>Total Loan Amount:</b></small>
                <strong>₦<?php echo number_format($totalLoansAmount, 2); ?></strong>
</div>
<div class="col-sm-3">
 <small><b>Total Paid:</b></small>
                <strong>₦<?php echo number_format($totalPaidAmount, 2); ?></strong>
</div>
<div class="col-sm-3">
 <small><b>Total Outstanding:</b></small>
                <strong>₦<?php echo number_format($totalOutstanding, 2); ?></strong>
</div>
<div class="col-sm-3">
      <small><b>Total Missed Payments:</b></small>
                <strong><?php echo number_format($totalMissedPayments); ?></strong>
</div>
</div>
    
               
            


<div class="row mb-3">
    <div class="col-sm-10">
     
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
<div class="alert alert-info" style="display:none;">
    <i class="fa fa-info-circle"></i> No active loans found!
</div>
<?php endif; ?>

<div id="table-container" style="height:350px; overflow:auto;">
<table id="repaymentTrackingTable" style="font-size: 9px;">
<thead>
<tr>
    <th>DISBURSEMENT NO</th>
    <th>LOAN ACCT</th>
    <th>NAME</th>
    <th>BRANCH</th>
    <th>PHONE</th>
    <th>PRODUCT</th>
    <th>FREQUENCY</th>
    <th>REPAYMENT DAY</th>
    <th>TOTAL LOAN</th>
    <th>EXPECTED PER PERIOD</th>
    <th>AMOUNT PAID</th>
    <th>OUTSTANDING</th>
    <th>EXPECTED DUE</th>
    <th>REPAYMENT %</th>
    <th>MISSED PAYMENTS</th>
    <th>NEXT PAYMENT</th>
    <th>REPAYMENT STATUS</th>
    <th>CREDIT OFFICER</th>
    <th>DATE DISBURSED</th>
    <th>MATURITY DATE</th>
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
        $frequency = htmlspecialchars($member['Frequency'] ?? 'Daily', ENT_QUOTES, 'UTF-8');
        $repaymentDay = htmlspecialchars($member['Repayment_Day'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
        $totalloan = (float)($member['Total_Loan'] ?? 0);
        $paid = (float)($member['Paid'] ?? 0);
        $exp = (float)($member['Expected_Amount'] ?? 0);
        $totalbal = (float)($member['Total_Bal'] ?? 0);
        $expectedDueAmt = (float)($member['Expected_Due_Amount'] ?? 0);
        $missedRepayments = (int)($member['Missed_Repayments'] ?? 0);
        $nextPaymentDate = $member['Next_Payment_Date'] ?? null;
        $repaymentPercent = (int)($member['Repayment_Percent'] ?? 0);
        $repaymentStatus = htmlspecialchars($member['Repayment_Status'] ?? '', ENT_QUOTES, 'UTF-8');
        $statusColor = htmlspecialchars($member['Status_Color'] ?? '', ENT_QUOTES, 'UTF-8');
        $datedisburse = htmlspecialchars($member['Date_Disbursed'] ?? '', ENT_QUOTES, 'UTF-8');
        $maturitydate = htmlspecialchars($member['Maturity_Date'] ?? '', ENT_QUOTES, 'UTF-8');
        $ofn = htmlspecialchars($member['Officer_Name'] ?? '', ENT_QUOTES, 'UTF-8');

        $frequencyLabel = $frequency == 'Daily' ? 'Payment(s)' : ($frequency == 'Weekly' ? 'Week(s)' : 'Month(s)');

        // Determine row background based on status
        $rowStyle = '';
        if ($repaymentStatus == 'Critical') {
            $rowStyle = 'background-color: #f8d7da;';
        } elseif ($repaymentStatus == 'Behind') {
            $rowStyle = 'background-color: #ffe6e6;';
        } elseif ($repaymentStatus == 'Warning') {
            $rowStyle = 'background-color: #fff3cd;';
        }
?>
        <tr style="<?php echo $rowStyle; ?>">
            <td><?php echo $disbursementNo; ?></td>
            <td><?php echo $loanAcct; ?></td>
            <td style="text-transform:capitalize"><?php echo trim("$firstname $middlename $lastname"); ?></td>
            <td><?php echo $branch; ?></td>
            <td><?php echo $ph; ?></td>
            <td><?php echo $product; ?></td>
            <td><?php echo $frequency; ?></td>
            <td><strong><?php echo $repaymentDay; ?></strong></td>
            <td>₦<?php echo number_format($totalloan, 2); ?></td>
            <td>₦<?php echo number_format($exp, 2); ?></td>
            <td><strong style="color: #28a745;">₦<?php echo number_format($paid, 2); ?></strong></td>
            <td><strong style="color: #dc3545;">₦<?php echo number_format($totalbal, 2); ?></strong></td>
            <td>₦<?php echo number_format($expectedDueAmt, 2); ?></td>
            <td>
                <div style="display: flex; align-items: center;">
                    <div style="width: 50px; height: 8px; background: #e9ecef; border-radius: 3px; margin-right: 5px;">
                        <div style="width: <?php echo $repaymentPercent; ?>%; height: 100%; background: #28a745; border-radius: 3px;"></div>
                    </div>
                    <span><?php echo $repaymentPercent; ?>%</span>
                </div>
            </td>
            <td>
                <?php if ($missedRepayments > 0): ?>
                    <strong style="color: #fff; background: #dc3545; padding: 3px 8px; border-radius: 3px; font-size: 9px;">
                        <?php echo $missedRepayments . ' ' . $frequencyLabel; ?>
                    </strong>
                <?php else: ?>
                    <span style="color: #28a745; font-weight: 600;">0</span>
                <?php endif; ?>
            </td>
            <td><?php echo $nextPaymentDate ? date('d-M-Y', strtotime($nextPaymentDate)) : 'N/A'; ?></td>
            <td>
                <span style="background: <?php echo $statusColor; ?>; color: white; padding: 3px 10px; border-radius: 3px; font-weight: 600; font-size: 9px;">
                    <?php echo $repaymentStatus; ?>
                </span>
            </td>
            <td><?php echo $ofn; ?></td>
            <td><?php echo !empty($datedisburse) ? date('d-M-Y', strtotime($datedisburse)) : 'N/A'; ?></td>
            <td><?php echo !empty($maturitydate) ? date('d-M-Y', strtotime($maturitydate)) : 'N/A'; ?></td>
        </tr>
<?php
    }
} else {
    echo '<tr><td colspan="20" style="text-align:center;">No repayment records found</td></tr>';
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
        let table = document.getElementById('repaymentTrackingTable');
        if (!table) {
            alert('Table not found');
            return;
        }
        let workbook = XLSX.utils.table_to_book(table, {sheet: "Repayment Tracking"});
        let filename = "Repayment_Tracking_Report_" + new Date().toISOString().split('T')[0] + ".xlsx";
        XLSX.writeFile(workbook, filename);
        console.log('Excel file exported successfully');
    } catch (error) {
        console.error('Export error:', error);
        alert('Failed to export data: ' + error.message);
    }
}
</script>