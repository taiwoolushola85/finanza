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

// Prepare base query with proper escaping
$searchEscaped = mysqli_real_escape_string($con, $search);
$baseWhere = "Status != 'Cancelled'";

// Build query based on conditions
if (!empty($search)) {
$baseWhere .= " AND (Name LIKE '%$searchEscaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM groups WHERE $baseWhere";
$countResult = mysqli_query($con, $countQuery);
$countRow = mysqli_fetch_array($countResult);
$total = $countRow[0];

// Data query
$dataQuery = "SELECT id, Name, Branch, Officer_Name, Date_Register, Status FROM groups WHERE $baseWhere ORDER BY id ASC";

if ($maxRows > 0) {
$dataQuery .= " LIMIT $maxRows";
} elseif (empty($search) && $maxRows == 0) {
$dataQuery .= " LIMIT 10"; // Default limit
}

$result = mysqli_query($con, $dataQuery) or die("Database query failed: " . mysqli_error($con));

// Store results
$results = array();
while ($row = mysqli_fetch_assoc($result)) {
$results[] = $row;
}

// Save to JSON file
$fp = fopen('../data/group_list.json', 'w');
fwrite($fp, json_encode($results));
fclose($fp);

mysqli_close($con);
?>

<small>
Total Record: <?php echo $total; ?>
</small>
<br><br>

<div id="table-container" style="height:350px;">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">OFFICER NAME</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php foreach ($results as $member): ?>
<tr style="font-size:8px">
<td><?php echo htmlspecialchars($member['id']); ?></td>
<td style="text-transform:capitalize"><?php echo htmlspecialchars($member['Name']); ?></td>
<td><?php echo htmlspecialchars($member['Branch']); ?></td>
<td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
<td>
<?php 
$status = $member['Status'];
if ($status == 'Waiting For Approval') {
echo "<span class=''>" . htmlspecialchars($status) . "</span>";
} elseif ($status == 'Declined') {
echo "<span class=''>" . htmlspecialchars($status) . "</span>";
} else {
echo "<span class=''>" . htmlspecialchars($status) . "</span>";
}
?>
</td>
<td><?php echo htmlspecialchars($member['Date_Register']); ?></td>
<td>
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo htmlspecialchars($member['id']); ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>





<script>
// Modal data loading
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');
if (id) {
$.ajax({
url: 'review_group_info.php',
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


<script type="text/javascript">
function load()  {
$.ajax({
method: "POST",
url: "load_group_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 