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

// Escape user input for SQL
$User_escaped = mysqli_real_escape_string($con, $User);
$search_escaped = mysqli_real_escape_string($con, $search);

// Build query based on conditions
$whereClause = "Status = 'Ready For Disbursement'";

if (!empty($search)) {
$whereClause .= " AND (BVN LIKE '%$search_escaped%' OR Firstname LIKE '%$search_escaped%' OR Middlename LIKE '%$search_escaped%' OR Lastname LIKE '%$search_escaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM register WHERE $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Firstname, Lastname, Middlename, Gender, Phone, Branch, BVN, Status, Date_Reg, Time_Reg, Officer_Name 
FROM register WHERE $whereClause ORDER BY id ASC";

if ($maxRows > 0) {
$dataQuery .= " LIMIT $maxRows";
} elseif (empty($search) && $maxRows == 0) {
$dataQuery .= " LIMIT 10";
}

$result = mysqli_query($con, $dataQuery) or die("Database query failed: " . mysqli_error($con));

// Fetch results
$results = array();
while($row = mysqli_fetch_assoc($result)) {
$results[] = $row; 
}

// Save to JSON file
$fp = fopen('../data/loan_disbursement_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);

mysqli_close($con);
?>

<small>
Total Record: <?php echo $total; ?>
</small>
<br><br>
<div id="table-container" style="height:400px;">
<table>
<thead>
<tr>
<th style="font-size:8px">BVN</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">GENDER</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">LOAN OFFICER</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">TIME</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
foreach($results as $member) {
// Escape output for XSS protection
$bvn = htmlspecialchars($member['BVN']);
$firstname = htmlspecialchars($member['Firstname']);
$middlename = htmlspecialchars($member['Middlename']);
$lastname = htmlspecialchars($member['Lastname']);
$phone = htmlspecialchars($member['Phone']);
$gender = htmlspecialchars($member['Gender']);
$branch = htmlspecialchars($member['Branch']);
$officer = htmlspecialchars($member['Officer_Name']);
$status = htmlspecialchars($member['Status']);
$dateReg = htmlspecialchars($member['Date_Reg']);
$timeReg = htmlspecialchars($member['Time_Reg']);
$id = (int)$member['id'];
// Status badge
$badgeClass = 'badge-soft-success';
if ($status == 'Under Review') {
$badgeClass = 'badge-soft-info';
} elseif ($status == 'Declined') {
$badgeClass = 'badge-soft-danger';
}
?>
<tr style="font-size:8px">
<td><?php echo $bvn; ?></td>
<td style="text-transform:capitalize"><?php echo "$firstname $middlename $lastname"; ?></td>
<td><?php echo $phone; ?></td>
<td><?php echo $gender; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $officer; ?></td>
<td>
<span class=''><?php echo $status; ?></span>
</td>
<td><?php echo $dateReg; ?></td>
<td><?php echo $timeReg; ?></td>
<td>
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $id; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>


<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'client_loan_disbursement_page.php',
type: "GET",
data: {'id': id},
success: function(data) { 
setTimeout(function() {
$("#updateModal").show();
$("#view").hide();
$('#profile').html(data);
}, 1000);
},
error: function(xhr, status, error) {
alert('Error loading profile: ' + error);
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



