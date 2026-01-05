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
$date = isset($_POST['date']) ? trim($_POST['date']) : '';// date
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? max(0, (int)$_POST['maxRows']) : 0;

// Fixed WHERE clause - Status = 'Active' AND current date > Maturity_Date (loans that have expired)
$whereClause = "Status = ? AND Maturity_Date = '$date'";
$params = ['Active'];
$types = 's';

if (!empty($search)) {
$searchParam = "%$search%";
// Fixed: Removed duplicate conditions and cleaned up logic
$whereClause .= " AND (BVN LIKE ? OR Account_Number LIKE ? OR Loan_Account_No LIKE ? 
OR Disbursement_No LIKE ? OR Transaction_id LIKE ? OR Savings_Account_No LIKE ? 
OR Unions LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?)";
    
// Add search parameter 10 times for all LIKE clauses
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
$dataQuery = "SELECT id, Loan_Account_No, Firstname, Lastname, Middlename, Product, Branch, Phone, Duration,
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

// Fetch results and calculate overdue amounts
$results = array();
$totalOverdue = 0;
while($row = mysqli_fetch_assoc($result)) {
// Calculate overdue amount: Expected_Amount that should have been paid by maturity date
$expectedAmt = (float)($row['Expected_Amount'] ?? 0);
$paid = (float)($row['Paid'] ?? 0);
    
// Overdue is the difference between what was expected and what was paid
$overdueAmt = max(0, $expectedAmt - $paid);
$row['Overdue_Amount'] = $overdueAmt;
$totalOverdue += $overdueAmt;
$results[] = $row; 
}
mysqli_stmt_close($stmt);

// Save to JSON file with proper error handling
$jsonData = json_encode($results, JSON_PRETTY_PRINT);
if ($jsonData === false) {
error_log("JSON encoding failed: " . json_last_error_msg());
} else {
$filePath = '../data/expired_portfolio_list.json';
$dirPath = dirname($filePath);
    
    // Ensure directory exists
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
    height: 360px;
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

.overdue-days {
    color: #856404;
    font-weight: 600;
    background: #fff3cd;
    padding: 2px 6px;
    border-radius: 3px;
    display: inline-block;
}


.stat-summary strong {
    font-size: 20px;
}
</style>

<div class="row mb-3">
<div class="col-sm-10">
<div class="stat-summary">
<small style="opacity: 0.9;">Total Expired Loans:</small>
<strong style="font-size:12px;"><?php echo number_format($total); ?></strong>
<?php if ($total > 0): ?>
<small style="margin-left: 15px; opacity: 0.9;">Total Expired Loan Outstanding:</small>
<strong style="font-size:12px; color:red"><?php 
$totalOutstanding = array_sum(array_column($results, 'Total_Bal'));
echo number_format($totalOutstanding, 2); 
?></strong>
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
<div class="alert alert-success" style="display: none;">
<i class="fa fa-check-circle"></i> No expired loans found. All active loans are within their maturity period!
</div>
<?php endif; ?>

<div id="table-container" style="height:360px;">
<table id="expiredLoansTable" style="font-size: 8px;">
<thead>
<tr>
<th>LOAN ACCT</th>
<th>NAME</th>
<th>PHONE</th>
<th>BRANCH</th>
<th>PRODUCT</th>
<th>TENURE</th>
<th>TOTAL LOAN</th>
<th>PAID</th>
<th>OUTSTANDING</th>
<th>EXPECTED AMT</th>
<th>CREDIT OFFICER</th>
<th>DATE DISBURSED</th>
<th>DATE EXPIRED</th>
<th>STATUS</th>
</tr>
</thead>
<tbody>
<?php
if (!empty($results)) {
foreach($results as $member) {
// Escape output for XSS protection
$vrt = htmlspecialchars($member['Loan_Account_No'] ?? '', ENT_QUOTES, 'UTF-8');
$firstname = htmlspecialchars($member['Firstname'] ?? '', ENT_QUOTES, 'UTF-8');
$middlename = htmlspecialchars($member['Middlename'] ?? '', ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($member['Lastname'] ?? '', ENT_QUOTES, 'UTF-8');
$ph = htmlspecialchars($member['Phone'] ?? '', ENT_QUOTES, 'UTF-8');
$branch = htmlspecialchars($member['Branch'] ?? '', ENT_QUOTES, 'UTF-8');
$product = htmlspecialchars($member['Product'] ?? '', ENT_QUOTES, 'UTF-8');
$dur = htmlspecialchars($member['Duration'] ?? '', ENT_QUOTES, 'UTF-8');
$totalloan = (float)($member['Total_Loan'] ?? 0);
$paid = (float)($member['Paid'] ?? 0);
$exp = (float)($member['Expected_Amount'] ?? 0);
$totalbal = (float)($member['Total_Bal'] ?? 0);
$overdueamt = (float)($member['Overdue_Amount'] ?? 0);
$datedisburse = htmlspecialchars($member['Date_Disbursed'] ?? '', ENT_QUOTES, 'UTF-8');
$maturitydate = htmlspecialchars($member['Maturity_Date'] ?? '', ENT_QUOTES, 'UTF-8');
$ofn = htmlspecialchars($member['Officer_Name'] ?? '', ENT_QUOTES, 'UTF-8');
// Calculate days overdue
$daysOverdue = 0;
if (!empty($maturitydate)) {
try {
$maturityDateTime = new DateTime($maturitydate);
$currentDateTime = new DateTime($d);
$interval = $currentDateTime->diff($maturityDateTime);
$daysOverdue = $interval->days;
} catch (Exception $e) {
$daysOverdue = 0;
}
}
// Determine severity color based on days overdue
$overdueClass = '';
if ($daysOverdue > 90) {
$overdueClass = 'style="background-color: #f8d7da;"'; // Red for >90 days
} elseif ($daysOverdue > 30) {
$overdueClass = 'style="background-color: #fff3cd;"'; // Yellow for >30 days
}
?>
<tr <?php echo $overdueClass; ?>>
<td><?php echo $vrt; ?></td>
<td style="text-transform:capitalize"><?php echo trim("$firstname $middlename $lastname"); ?></td>
<td><?php echo $ph; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $product; ?></td>
<td><?php echo $dur; ?></td>
<td><?php echo number_format($totalloan, 2); ?></td>
<td><?php echo number_format($paid, 2); ?></td>
<td><strong style="color: #dc3545;"><?php echo number_format($totalbal, 2); ?></strong></td>
<td><?php echo number_format($exp, 2); ?></td>
<td><?php echo $ofn; ?></td>
<td><?php echo !empty($datedisburse) ? date('d M Y', strtotime($datedisburse)) : 'N/A'; ?></td>
<td><?php echo !empty($maturitydate) ? date('d M Y', strtotime($maturitydate)) : 'N/A'; ?></td>
<td><span class="expired-badge">EXPIRED</span></td>
</tr>
<?php
}
} else {
echo '<tr><td colspan="15" style="text-align:center; padding: 10px; color: #6c757d;">No expired loan records found</td></tr>';
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
// Get the table element
let table = document.getElementById('expiredLoansTable');
if (!table) {
alert('Table not found');
return;
}
// Convert table to workbook
let workbook = XLSX.utils.table_to_book(table, {sheet: "Expired Loans"});
// Generate filename with current date
let filename = "Expired_Loans_" + new Date().toISOString().split('T')[0] + ".xlsx";
// Generate Excel file and trigger download
XLSX.writeFile(workbook, filename);
console.log('Excel file exported successfully');
} catch (error) {
console.error('Export error:', error);
alert('Failed to export data: ' + error.message);
}
}
</script>