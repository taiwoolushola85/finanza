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
$maxRows = isset($_POST['maxRows']) ? max(0, (int)$_POST['maxRows']) : 0;

// Fixed WHERE clause - Status = 'Active' AND current date > Maturity_Date (loans that have expired)
$whereClause = "Status = ? AND Maturity_Date < ? AND Branch_id = '$branch_id'";
$params = ['Active', $d];
$types = 'ss';

if (!empty($search)) {
    $searchParam = "%$search%";
    $whereClause .= " AND (BVN LIKE ? OR Account_Number LIKE ? OR Loan_Account_No LIKE ? 
    OR Disbursement_No LIKE ? OR Transaction_id LIKE ? OR Savings_Account_No LIKE ? 
    OR Branch LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?)";
    
    for ($i = 0; $i < 10; $i++) {
        $params[] = $searchParam;
        $types .= 's';
    }
}

// Count query using prepared statement
$countQuery = "SELECT COUNT(*) as total FROM repayments WHERE $whereClause";
$stmt = mysqli_prepare($con, $countQuery);

if ($stmt === false) {
    die("Error preparing count query: " . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$countResult = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($countResult);
$total = $row['total'];
mysqli_stmt_close($stmt);

// Data query using prepared statement
$dataQuery = "SELECT id, BVN, Loan_Account_No, Firstname, Lastname, Middlename, Product, Branch, Phone, Duration, Frequency,
Total_Loan, Paid, Maturity_Status, Expected_Amount, Date_Disbursed, Maturity_Date, Officer_Name,
Status, Total_Bal FROM repayments WHERE $whereClause ORDER BY Maturity_Date ASC";

if ($maxRows > 0) {
    $dataQuery .= " LIMIT ?";
    $params[] = $maxRows;
    $types .= 'i';
}

$stmt = mysqli_prepare($con, $dataQuery);

if ($stmt === false) {
    die("Error preparing data query: " . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch results and calculate PAR metrics
$results = array();
$totalOverdue = 0;
$par30_count = 0;
$par60_count = 0;
$par90_count = 0;
$par30_amount = 0;
$par60_amount = 0;
$par90_amount = 0;

while($row = mysqli_fetch_assoc($result)) {
    // Calculate days overdue
    $daysOverdue = 0;
    if (!empty($row['Maturity_Date'])) {
        try {
            $maturityDateTime = new DateTime($row['Maturity_Date']);
            $currentDateTime = new DateTime($d);
            $interval = $currentDateTime->diff($maturityDateTime);
            $daysOverdue = $interval->days;
        } catch (Exception $e) {
            $daysOverdue = 0;
        }
    }
    
    $row['Days_Overdue'] = $daysOverdue;
    
    // Calculate overdue amount
    $expectedAmt = (float)($row['Expected_Amount'] ?? 0);
    $paid = (float)($row['Paid'] ?? 0);
    $totalBal = (float)($row['Total_Bal'] ?? 0);
    
    $overdueAmt = max(0, $expectedAmt - $paid);
    $row['Overdue_Amount'] = $overdueAmt;
    $totalOverdue += $overdueAmt;
    
    // Categorize by PAR buckets
    if ($daysOverdue >= 90) {
        $par90_count++;
        $par90_amount += $totalBal;
        $row['PAR_Category'] = 'PAR 90+';
    } elseif ($daysOverdue >= 60) {
        $par60_count++;
        $par60_amount += $totalBal;
        $row['PAR_Category'] = 'PAR 60-89';
    } elseif ($daysOverdue >= 30) {
        $par30_count++;
        $par30_amount += $totalBal;
        $row['PAR_Category'] = 'PAR 30-59';
    } else {
        $row['PAR_Category'] = 'PAR 1-29';
    }
    
    $results[] = $row; 
}
mysqli_stmt_close($stmt);

// Calculate total outstanding
$totalOutstanding = array_sum(array_column($results, 'Total_Bal'));

// Save to JSON file with proper error handling
$jsonData = json_encode($results, JSON_PRETTY_PRINT);
if ($jsonData === false) {
    error_log("JSON encoding failed: " . json_last_error_msg());
} else {
    $filePath = '../data/expired_portfolio_list.json';
    $dirPath = dirname($filePath);
    
    if (!is_dir($dirPath)) {
        if (!mkdir($dirPath, 0755, true)) {
            error_log("Failed to create directory: $dirPath");
        }
    }
    
    if (file_put_contents($filePath, $jsonData) === false) {
        error_log("Failed to write JSON file: $filePath");
    }
}

mysqli_close($con);
?>

<style>
#table-container {
    height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 4px;
}

#table-container table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8px;
}

#table-container thead {
    position: sticky;
    top: 0;
    background-color: #343a40;
    color: white;
    z-index: 10;
}

#table-container th {
    padding: 10px 8px;
    text-align: left;
    font-weight: 600;
    white-space: nowrap;
    border-bottom: 2px solid #dee2e6;
}

#table-container td {
    padding: 8px;
    border-bottom: 1px solid #dee2e6;
}

#table-container tbody tr:hover {
    background-color: #f8f9fa;
}

#table-container tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.expired-badge {
    color: #dc3545;
    font-weight: 700;
    padding: 2px 6px;
    background: #fee;
    border-radius: 3px;
    display: inline-block;
}

.par-badge {
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 3px;
    display: inline-block;
    font-size: 7px;
}

.par-30 {
    background: #fff3cd;
    color: #856404;
}

.par-60 {
    background: #f8d7da;
    color: #721c24;
}

.par-90 {
    background: #721c24;
    color: white;
}

.stat-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: center;
}

.stat-item {
    display: inline-flex;
    flex-direction: column;
}

.stat-item small {
    opacity: 0.9;
    font-size: 10px;
}

.stat-item strong {
    font-size: 12px;
}

.par-summary-cards {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.par-card {
    flex: 1;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    border: 1px solid #ddd;
}

.par-card.par30 {
    background: #fff3cd;
    border-color: #ffc107;
}

.par-card.par60 {
    background: #f8d7da;
    border-color: #dc3545;
}

.par-card.par90 {
    background: #721c24;
    color: white;
    border-color: #5a1419;
}

.par-card .label {
    font-size: 10px;
    font-weight: 600;
    margin-bottom: 5px;
}

.par-card .count {
    font-size: 18px;
    font-weight: 700;
}

.par-card .amount {
    font-size: 11px;
    margin-top: 5px;
}
</style>

<!-- PAR Summary Cards -->
<div class="par-summary-cards" style="color:black">
    <div class="par-card par30">
        <div class="label">PAR 30+ Days</div>
        <div class="count"><?php echo number_format($par30_count); ?></div>
        <div class="amount">₦<?php echo number_format($par30_amount, 2); ?></div>
    </div>
    <div class="par-card par60">
        <div class="label">PAR 60+ Days</div>
        <div class="count"><?php echo number_format($par60_count); ?></div>
        <div class="amount">₦<?php echo number_format($par60_amount, 2); ?></div>
    </div>
    <div class="par-card par90">
        <div class="label">PAR 90+ Days</div>
        <div class="count"><?php echo number_format($par90_count); ?></div>
        <div class="amount">₦<?php echo number_format($par90_amount, 2); ?></div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-sm-10">
        <div class="stat-summary">
            <div class="stat-item">
                <span>Total Expired Loans: <strong><?php echo number_format($total); ?></strong></span>
                
            </div>
            <?php if ($total > 0): ?>
            <div class="stat-item">
                <span>Total Outstanding:  <strong style="color:red">₦<?php echo number_format($totalOutstanding, 2); ?></strong></span>
               
            </div>
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
<div class="alert alert-warning">
    <i class="fa fa-search"></i> No results found for "<strong><?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?></strong>"
</div>
<?php elseif (empty($results)): ?>
<div class="alert alert-success">
    <i class="fa fa-check-circle"></i> No expired loans found. All active loans are within their maturity period!
</div>
<?php endif; ?>

<div id="table-container">
    <table id="expiredLoansTable">
        <thead>
            <tr>
                <th>LOAN ACCT</th>
                <th>BVN</th>
                <th>NAME</th>
                <th>PHONE</th>
                <th>BRANCH</th>
                <th>PRODUCT</th>
                <th>TENURE</th>
                <th>FREQUENCY</th>
                <th>TOTAL LOAN</th>
                <th>PAID</th>
                <th>OUTSTANDING</th>
                <th>EXPECTED AMT</th>
                <th>CREDIT OFFICER</th>
                <th>DATE DISBURSED</th>
                <th>DATE EXPIRED</th>
                <th>DAYS OVERDUE</th>
                <th>PAR CATEGORY</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($results)) {
                foreach($results as $member) {
                    $vrt = htmlspecialchars($member['Loan_Account_No'] ?? '', ENT_QUOTES, 'UTF-8');
                    $bvn = htmlspecialchars($member['BVN'] ?? '', ENT_QUOTES, 'UTF-8');
                    $firstname = htmlspecialchars($member['Firstname'] ?? '', ENT_QUOTES, 'UTF-8');
                    $middlename = htmlspecialchars($member['Middlename'] ?? '', ENT_QUOTES, 'UTF-8');
                    $lastname = htmlspecialchars($member['Lastname'] ?? '', ENT_QUOTES, 'UTF-8');
                    $ph = htmlspecialchars($member['Phone'] ?? '', ENT_QUOTES, 'UTF-8');
                    $branch = htmlspecialchars($member['Branch'] ?? '', ENT_QUOTES, 'UTF-8');
                    $product = htmlspecialchars($member['Product'] ?? '', ENT_QUOTES, 'UTF-8');
                    $fr = htmlspecialchars($member['Frequency'] ?? '', ENT_QUOTES, 'UTF-8');
                    $dur = htmlspecialchars($member['Duration'] ?? '', ENT_QUOTES, 'UTF-8');
                    $totalloan = (float)($member['Total_Loan'] ?? 0);
                    $paid = (float)($member['Paid'] ?? 0);
                    $exp = (float)($member['Expected_Amount'] ?? 0);
                    $totalbal = (float)($member['Total_Bal'] ?? 0);
                    $datedisburse = htmlspecialchars($member['Date_Disbursed'] ?? '', ENT_QUOTES, 'UTF-8');
                    $maturitydate = htmlspecialchars($member['Maturity_Date'] ?? '', ENT_QUOTES, 'UTF-8');
                    $ofn = htmlspecialchars($member['Officer_Name'] ?? '', ENT_QUOTES, 'UTF-8');
                    $daysOverdue = $member['Days_Overdue'];
                    $parCategory = $member['PAR_Category'];
                    
                    // Determine row color based on PAR category
                    $rowClass = '';
                    $parBadgeClass = 'par-badge';
                    if ($daysOverdue >= 90) {
                        $rowClass = 'style="background-color: #f8d7da;"';
                        $parBadgeClass .= ' par-90';
                    } elseif ($daysOverdue >= 60) {
                        $rowClass = 'style="background-color: #fff3cd;"';
                        $parBadgeClass .= ' par-60';
                    } elseif ($daysOverdue >= 30) {
                        $rowClass = 'style="background-color: #fffbf0;"';
                        $parBadgeClass .= ' par-30';
                    }
            ?>
            <tr <?php echo $rowClass; ?>>
                <td><?php echo $vrt; ?></td>
                <td><?php echo $bvn; ?></td>
                <td style="text-transform:capitalize"><?php echo trim("$firstname $middlename $lastname"); ?></td>
                <td><?php echo $ph; ?></td>
                <td><?php echo $branch; ?></td>
                <td><?php echo $product; ?></td>
                <td><?php echo $dur; ?></td>
                <td><?php echo $fr; ?></td>
                <td>₦<?php echo number_format($totalloan, 2); ?></td>
                <td>₦<?php echo number_format($paid, 2); ?></td>
                <td><strong style="color: #dc3545;">₦<?php echo number_format($totalbal, 2); ?></strong></td>
                <td>₦<?php echo number_format($exp, 2); ?></td>
                <td><?php echo $ofn; ?></td>
                <td><?php echo !empty($datedisburse) ? date('d M Y', strtotime($datedisburse)) : 'N/A'; ?></td>
                <td><?php echo !empty($maturitydate) ? date('d M Y', strtotime($maturitydate)) : 'N/A'; ?></td>
                <td><strong><?php echo $daysOverdue; ?> days</strong></td>
                <td><span class="<?php echo $parBadgeClass; ?>"><?php echo $parCategory; ?></span></td>
                <td><span class="expired-badge">EXPIRED</span></td>
            </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="18" style="text-align:center">No expired loan records found</td></tr>';
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
        
        let workbook = XLSX.utils.table_to_book(table, {sheet: "Expired Loans"});
        let filename = "Expired_Loans_PAR_" + new Date().toISOString().split('T')[0] + ".xlsx";
        XLSX.writeFile(workbook, filename);
        console.log('Excel file exported successfully');
    } catch (error) {
        console.error('Export error:', error);
        alert('Failed to export data: ' + error.message);
    }
}
</script>