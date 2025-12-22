<?php
// Sanitize and validate inputs
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 0;

// Set CORS headers at the top
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");

include '../config/db.php';
include '../config/user_session.php';

// Build WHERE clause with prepared statement
$whereClause = "";
$params = array();
$types = "";

if (!empty($search)) {
$whereClause = " WHERE (BVN LIKE ? OR Virtual_Account LIKE ? OR Phone LIKE ? 
OR Branch LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?)";
$searchParam = "%$search%";
$params = array_fill(0, 7, $searchParam);
$types = str_repeat('s', 7);
}

// Count query with prepared statement
$countQuery = "SELECT COUNT(*) FROM register" . $whereClause;
$countStmt = mysqli_prepare($con, $countQuery);

if (!empty($search)) {
mysqli_stmt_bind_param($countStmt, $types, ...$params);
}

mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$row = mysqli_fetch_array($countResult);
$total = $row[0];
mysqli_stmt_close($countStmt);

// Data query with prepared statement
$dataQuery = "SELECT DISTINCT id, Virtual_Account, BVN, Firstname, Lastname, Middlename, Phone, Gender, Branch, Officer_Name, Status
FROM register" . $whereClause . " ORDER BY Firstname ASC";

// Add LIMIT clause
if ($maxRows > 0) {
$dataQuery .= " LIMIT ?";
$params[] = $maxRows;
$types .= 'i';
} elseif (empty($search) && $maxRows == 0) {
$dataQuery .= " LIMIT ?";
$params[] = 10;
$types .= 'i';
}

$dataStmt = mysqli_prepare($con, $dataQuery);

if (!empty($params)) {
mysqli_stmt_bind_param($dataStmt, $types, ...$params);
}

mysqli_stmt_execute($dataStmt);
$result = mysqli_stmt_get_result($dataStmt);

// Fetch results
$results = array();
while($row = mysqli_fetch_assoc($result)) {
$results[] = $row; 
}

mysqli_stmt_close($dataStmt);

// Save to JSON file with error handling
$jsonData = json_encode($results);
if ($jsonData !== false) {
$fp = fopen('../data/customer_record.json', 'w');
if ($fp) {
fwrite($fp, $jsonData);
fclose($fp);
}
}

mysqli_close($con);
?>

<small>
Total Record: <?php echo htmlspecialchars($total); ?>
</small>
<br><br>
<div id="table-container" style="overflow:auto; height:350px;">
<div class="table-responsive">
<table>
<thead>
<tr>
<th style="font-size:8px">VIRTUAL ACCT</th>
<th style="font-size:8px">BVN NO</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE NO</th>
<th style="font-size:8px">GENDER</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">LOAN OFFICER</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DETAIL</th>
</tr>
</thead>
<tbody>
<?php
if (!empty($results)) {
foreach($results as $member) {
// Escape output for XSS protection
$vrt = htmlspecialchars($member['Virtual_Account'] ?? '');
$firstname = htmlspecialchars($member['Firstname'] ?? '');
$middlename = htmlspecialchars($member['Middlename'] ?? '');
$lastname = htmlspecialchars($member['Lastname'] ?? '');
$bvn = htmlspecialchars($member['BVN'] ?? '');
$phone = htmlspecialchars($member['Phone'] ?? '');
$gender = htmlspecialchars($member['Gender'] ?? '');
$branch = htmlspecialchars($member['Branch'] ?? '');
$ofn = htmlspecialchars($member['Officer_Name'] ?? '');
$status = htmlspecialchars($member['Status'] ?? '');
$id = (int)$member['id'];
?>
<tr style="font-size:8px">
<td><?php echo $vrt; ?></td>
<td><?php echo $bvn; ?></td>
<td style="text-transform:capitalize"><?php echo trim("$firstname $middlename $lastname"); ?></td>
<td><?php echo $phone; ?></td>
<td><?php echo $gender; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $ofn; ?></td>
<td><span><?php echo $status; ?></span></td>
<td>
<a class="invks" href="#" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $id; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php
}
} else {
?>
<tr>
<td colspan="9" style="text-align:center; font-size:8px">No records found</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>

<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');
if(id && id > 0) {
$.ajax({
url: 'client_profile_page.php',
type: "GET",
data: {'id': id},
dataType: 'html',
success: function(data) { 
setTimeout(function() {
$("#updateModal").show();
$("#view").hide();
$('#profile').html(data);
}, 1000);
},
error: function(xhr, status, error) {
console.error('Error loading profile:', error);
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