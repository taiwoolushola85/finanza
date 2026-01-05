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

// Fixed WHERE clause - Status = 'Active' AND current date > Maturity_Date
$whereClause = "Status = ? AND Maturity_Date < ? AND Branch_id = ?";
$params = ['Active', $d, $branch_id];
$types = 'sss';

if (!empty($search)) {
$searchParam = "%$search%";
// Fixed: Removed duplicate condition and cleaned up logic
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
$dataQuery = "SELECT id, Loan_Account_No, Firstname, Lastname, Middlename, Product, Branch, Phone,
Total_Loan, Paid, Maturity_Status, Expected_Amount, Date_Disbursed, Maturity_Date, Officer_Name,
Status, Total_Bal FROM repayments WHERE $whereClause ORDER BY Firstname ASC";

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

// Fetch results
$results = array();
while($row = mysqli_fetch_assoc($result)) {
$results[] = $row; 
}
mysqli_stmt_close($stmt);

// Save to JSON file with proper error handling
$jsonData = json_encode($results, JSON_PRETTY_PRINT);
if ($jsonData === false) {
error_log("JSON encoding failed: " . json_last_error_msg());
} else {
$filePath = '../data/branch_default_portfolio_list.json';
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
    height: 340px;
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
    background-color: #f8f9fa;
    z-index: 10;
}

#table-container th {
    padding: 8px;
    text-align: left;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    white-space: nowrap;
}

#table-container td {
    padding: 6px 8px;
    border-bottom: 1px solid #dee2e6;
}

#table-container tbody tr:hover {
    background-color: #f5f5f5;
}

.expired-badge {
    color: #dc3545;
    font-weight: 100;
}
</style>

<div class="row mb-3">
<div class="col-sm-10">
<small>
Total Expired Loans: <strong><?php echo htmlspecialchars($total, ENT_QUOTES, 'UTF-8'); ?></strong>
</small>
</div>
<div class="col-sm-2">
<button type="button" hidden class="btn btn-outline-primary btn-sm btn-flat w-100" onclick="tableToExcel()">
<i class="fa fa-download"></i> Export to Excel
</button>
</div>
</div>

<?php if (empty($results) && !empty($search)): ?>

<?php elseif (empty($results)): ?>

<?php endif; ?>

<div id="table-container">
<table id="expiredLoansTable">
<thead>
<tr>
<th>LOAN ACCT</th>
<th>NAME</th>
<th>PHONE</th>
<th>BRANCH</th>
<th>PRODUCT</th>
<th>TOTAL LOAN</th>
<th>PAID</th>
<th>OUTSTANDING</th>
<th>EXPECTED AMT</th>
<th>CREDIT OFFICER</th>
<th>DATE DISBURSED</th>
<th>DATE EXPIRED</th>
<th>STATUS</th>
<th>ACTION</th>
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
$totalloan = (float)($member['Total_Loan'] ?? 0);
$paid = (float)($member['Paid'] ?? 0);
$exp = (float)($member['Expected_Amount'] ?? 0);
$totalbal = (float)($member['Total_Bal'] ?? 0);
$datedisburse = htmlspecialchars($member['Date_Disbursed'] ?? '', ENT_QUOTES, 'UTF-8');
$maturitydate = htmlspecialchars($member['Maturity_Date'] ?? '', ENT_QUOTES, 'UTF-8');
$ofn = htmlspecialchars($member['Officer_Name'] ?? '', ENT_QUOTES, 'UTF-8');
$id = (int)$member['id'];
// Calculate days overdue
$daysOverdue = 0;
if (!empty($maturitydate)) {
$maturityDateTime = new DateTime($maturitydate);
$currentDateTime = new DateTime($d);
$interval = $currentDateTime->diff($maturityDateTime);
$daysOverdue = $interval->days;
}
?>
<tr>
<td><?php echo $vrt; ?></td>
<td style="text-transform:capitalize"><?php echo trim("$firstname $middlename $lastname"); ?></td>
<td><?php echo $ph; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $product; ?></td>
<td><?php echo number_format($totalloan, 2); ?></td>
<td><?php echo number_format($paid, 2); ?></td>
<td><?php echo number_format($totalbal, 2); ?></td>
<td><?php echo number_format($exp, 2); ?></td>
<td><?php echo $ofn; ?></td>
<td><?php echo date('d M Y', strtotime($datedisburse)); ?></td>
<td><?php echo date('d M Y', strtotime($maturitydate)); ?></td>
<td><span class="expired-badge">Expired</span></td>
<td>
<a class="invks" href="#" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $id; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php
}
} else {
echo '<tr><td colspan="20" style="text-align:center; padding: 10px;">No expired loans found</td></tr>';
}
?>
</tbody>
</table>
</div>

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
// Generate Excel file and trigger download
XLSX.writeFile(workbook, "Expired_Loans_" + new Date().toISOString().split('T')[0] + ".xlsx");
} catch (error) {
console.error('Export error:', error);
alert('Failed to export data: ' + error.message);
}
}

// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {
e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');
if (!id || id <= 0) {
alert('Invalid loan ID');
$("#view").hide();
return;
}
$.ajax({
url: 'defaulter_profile.php',
type: "GET",
data: {'id': id},
dataType: 'html',
timeout: 10000, // 10 second timeout
success: function(data) { 
setTimeout(function() {
$("#updateModal").show();
$("#view").hide();
$('#profile').html(data);
}, 1000);
},
error: function(xhr, status, error) {
$("#view").hide();
let errorMessage = 'Error loading profile';
if (status === 'timeout') {
errorMessage = 'Request timed out. Please try again.';
} else if (xhr.status === 404) {
errorMessage = 'Profile not found.';
} else if (xhr.status === 500) {
errorMessage = 'Server error. Please contact support.';
} else if (error) {
errorMessage += ': ' + error;
}
alert(errorMessage);
console.error('AJAX Error:', {status: status, error: error, xhr: xhr});
}
});
});
});
</script>