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

// Use prepared statements to prevent SQL injection
$whereClause = "Status = ? AND Maturity_Date = '$date'";
$params = ['Active'];
$types = 's';

if (!empty($search)) {
$searchParam = "%$search%";
$whereClause .= " AND (BVN LIKE ? OR Account_Number LIKE ? OR Loan_Account_No LIKE ? 
OR Disbursement_No LIKE ? OR Transaction_id LIKE ? OR Savings_Account_No LIKE ? 
OR Status LIKE ? OR Unions LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ? AND Status != 'Disbursed')";
    
// Add search parameter 11 times for all LIKE clauses
for ($i = 0; $i < 11; $i++) {
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
Status, Total_Bal FROM repayments WHERE $whereClause ORDER BY id ASC";

if ($maxRows > 0) {
$dataQuery .= " LIMIT ?";
$params[] = $maxRows;
$types .= 'i';
} elseif (empty($search) && $maxRows == 0) {
$dataQuery .= "";
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
$filePath = '../data/date_expired_portfolio_list.json';
$dirPath = dirname($filePath);
// Ensure directory exists
if (!is_dir($dirPath)) {
mkdir($dirPath, 0755, true);
}
    
if (file_put_contents($filePath, $jsonData) === false) {
error_log("Failed to write JSON file: $filePath");
}
}

mysqli_close($con);
?>

<div class="row">
<div class="col-sm-10">
<small>
Total Record: <?php echo htmlspecialchars($total); ?>
</small>
</div>
<div class="col-sm-2">
<button type="button" class="btn btn-outline-primary btn-sm btn-flat w-100" onclick="tableToExcel()"><i class="fa fa-download"></i> Export Data Excel</button>
<script type="text/javascript">
function tableToExcel() {
// Get the table element (adjust selector to match your table)
let table = document.querySelector('table');
// Convert table to workbook
let workbook = XLSX.utils.table_to_book(table, {sheet: "Expired Loans"});
// Generate Excel file and trigger download
XLSX.writeFile(workbook, "All_expired_loan.xlsx");
}
</script>
</div>
</div>
<br>

<?php if (empty($results) && !empty($search)): ?>
<?php elseif (empty($results)): ?>
<i class="fas fa-info-circle"></i> No records available at this time.
<br><br>
<?php endif; ?>

<div id="table-container" style="height:340px; overflow-y:auto;">
<table >
<thead>
<tr>
<th style="font-size:8px">LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">PRODUCT</th>
<th style="font-size:8px">TOTAL LOAN</th>
<th style="font-size:8px">PAID</th>
<th style="font-size:8px">OUTSTANDING</th>
<th style="font-size:8px">EXPECTED AMT</th>
<th style="font-size:8px">CREDIT OFFICER</th>
<th style="font-size:8px">DATE DISBURSED</th>
<th style="font-size:8px">DATE EXPIRED</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
if (!empty($results)) {
foreach($results as $member) {
// Escape output for XSS protection
$vrt = htmlspecialchars($member['Loan_Account_No'], ENT_QUOTES, 'UTF-8');
$firstname = htmlspecialchars($member['Firstname'], ENT_QUOTES, 'UTF-8');
$middlename = htmlspecialchars($member['Middlename'], ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($member['Lastname'], ENT_QUOTES, 'UTF-8');
$ph = htmlspecialchars($member['Phone'], ENT_QUOTES, 'UTF-8');
$branch = htmlspecialchars($member['Branch'], ENT_QUOTES, 'UTF-8');
$product = htmlspecialchars($member['Product'], ENT_QUOTES, 'UTF-8');
$totalloan = htmlspecialchars($member['Total_Loan'], ENT_QUOTES, 'UTF-8');
$paid = htmlspecialchars($member['Paid'], ENT_QUOTES, 'UTF-8');
$exp = htmlspecialchars($member['Expected_Amount'], ENT_QUOTES, 'UTF-8');
$totalbal = htmlspecialchars($member['Total_Bal'], ENT_QUOTES, 'UTF-8');
$datedisburse = htmlspecialchars($member['Date_Disbursed'], ENT_QUOTES, 'UTF-8');
$maturitydate = htmlspecialchars($member['Maturity_Date'], ENT_QUOTES, 'UTF-8');
$status = htmlspecialchars($member['Maturity_Status'], ENT_QUOTES, 'UTF-8');
$ofn = htmlspecialchars($member['Officer_Name'], ENT_QUOTES, 'UTF-8');
$id = (int)$member['id'];
?>
<tr style="font-size:8px">
<td><?php echo $vrt; ?></td>
<td style="text-transform:capitalize"><?php echo "$firstname $middlename $lastname"; ?></td>
<td><?php echo $ph; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $product; ?></td>
<td><?php echo number_format((float)$totalloan, 2); ?></td>
<td><?php echo number_format((float)$paid, 2); ?></td>
<td><?php echo number_format((float)$totalbal, 2); ?></td>
<td><?php echo number_format((float)$exp, 2); ?></td>
<td><?php echo $ofn; ?></td>
<td><?php echo $datedisburse; ?></td>
<td><?php echo $maturitydate; ?></td>
<td>
<span style="color:red;"><?php echo "Expired"; ?></span>
</td>
</tr>
<?php
}
} else {
echo '<tr><td colspan="20" style="text-align:center; font-size:10px; padding: 10px;">No matching records</td></tr>';
}
?>
</tbody>
</table>
</div>

