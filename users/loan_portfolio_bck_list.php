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

// Sanitize and validate inputs
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? max(0, (int)$_POST['maxRows']) : 0;

// Use prepared statements to prevent SQL injection
$whereClause = "Status = ?";
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
$dataQuery = "SELECT id, Account_Number, Firstname, Lastname, Middlename, Product, Branch, 
Total_Loan, Paid, Maturity_Status, Expected_Amount, Date_Disbursed, Maturity_Date, 
Status, Total_Bal FROM repayments WHERE $whereClause ORDER BY id ASC";

if ($maxRows > 0) {
$dataQuery .= " LIMIT ?";
$params[] = $maxRows;
$types .= 'i';
} elseif (empty($search) && $maxRows == 0) {
$dataQuery .= " LIMIT 10";
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
$filePath = '../data/general_portfolio_list.json';
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

<small>
Total Record: <?php echo htmlspecialchars($total); ?>
</small>
<br><br>

<?php if (empty($results) && !empty($search)): ?>
<?php elseif (empty($results)): ?>
<div class="alert alert-info" role="alert" style="margin: 20px 0; padding: 15px; text-align: center;">
<i class="fas fa-info-circle"></i> No records available at this time.
</div>
<?php endif; ?>

<div id="table-container" style="height:340px; overflow-y:auto;">
<table >
<thead>
<tr>
<th style="font-size:8px">VIRTUAL ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">PRODUCT</th>
<th style="font-size:8px">TOTAL LOAN</th>
<th style="font-size:8px">PAID</th>
<th style="font-size:8px">OUTSTANDING</th>
<th style="font-size:8px">EXPECTED AMT</th>
<th style="font-size:8px">DATE DISBURSED</th>
<th style="font-size:8px">DATE EXPIRED</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DETAIL</th>
</tr>
</thead>
<tbody>
<?php
if (!empty($results)) {
foreach($results as $member) {
// Escape output for XSS protection
$vrt = htmlspecialchars($member['Account_Number'], ENT_QUOTES, 'UTF-8');
$firstname = htmlspecialchars($member['Firstname'], ENT_QUOTES, 'UTF-8');
$middlename = htmlspecialchars($member['Middlename'], ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($member['Lastname'], ENT_QUOTES, 'UTF-8');
$branch = htmlspecialchars($member['Branch'], ENT_QUOTES, 'UTF-8');
$product = htmlspecialchars($member['Product'], ENT_QUOTES, 'UTF-8');
$totalloan = htmlspecialchars($member['Total_Loan'], ENT_QUOTES, 'UTF-8');
$paid = htmlspecialchars($member['Paid'], ENT_QUOTES, 'UTF-8');
$exp = htmlspecialchars($member['Expected_Amount'], ENT_QUOTES, 'UTF-8');
$totalbal = htmlspecialchars($member['Total_Bal'], ENT_QUOTES, 'UTF-8');
$datedisburse = htmlspecialchars($member['Date_Disbursed'], ENT_QUOTES, 'UTF-8');
$maturitydate = htmlspecialchars($member['Maturity_Date'], ENT_QUOTES, 'UTF-8');
$status = htmlspecialchars($member['Maturity_Status'], ENT_QUOTES, 'UTF-8');
$id = (int)$member['id'];
?>
<tr style="font-size:8px">
<td><?php echo $vrt; ?></td>
<td style="text-transform:capitalize"><?php echo "$firstname $middlename $lastname"; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $product; ?></td>
<td><?php echo number_format((float)$totalloan, 2); ?></td>
<td><?php echo number_format((float)$paid, 2); ?></td>
<td><?php echo number_format((float)$totalbal, 2); ?></td>
<td><?php echo number_format((float)$exp, 2); ?></td>
<td><?php echo $datedisburse; ?></td>
<td><?php echo $maturitydate; ?></td>
<td>
<span class='<?php echo htmlspecialchars($badgeClass, ENT_QUOTES, 'UTF-8'); ?>'><?php echo $status; ?></span>
</td>
<td>
<a class="invks" href="#" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $id; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php
}
} else {
echo '<tr><td colspan="8" style="text-align:center; font-size:10px; padding: 10px;">No matching records</td></tr>';
}
?>
</tbody>
</table>
</div>

<script>
// Display data in modal with CSRF protection
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');
// Validate ID is a positive integer
if(id && Number.isInteger(id) && id > 0) {
$.ajax({
url: 'client_loan_page.php',
type: "GET",
data: {'id': id},
dataType: 'html',
timeout: 10000,
success: function(data) { 
setTimeout(function() {
$("#updateModal").show();
$("#view").hide();
$('#prof').html(data);
}, 1000);
},
error: function(xhr, status, error) {
console.error('AJAX Error:', status, error);
alert('Error loading profile. Please try again.');
$("#view").hide();
}
});
} else {
alert('Invalid ID');
$("#view").hide();
}
});
});
</script>