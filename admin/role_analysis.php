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
$search_escaped = mysqli_real_escape_string($con, $search);

// Build query based on conditions
$whereClause = "WHERE Status='Active'";
if (!empty($search)) {
$whereClause .= " AND (Name LIKE '%$search_escaped%' OR Categorys LIKE '%$search_escaped%')";
}

// Count query (without LIMIT or ORDER BY)
$countQuery = "SELECT COUNT(*) FROM role $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Name, Categorys, Date_Register, Time_Register, Status FROM role $whereClause ORDER BY Name ASC";

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
$fp = fopen('../data/role_analysis.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);

mysqli_close($con);
?>

<small>
Total Record: <?php echo $total; ?>
</small>
<br><br>

<div class="table-container" style="height:200px;">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">ROLE TITLE</th>
<th style="font-size:8px">ROLE CATEGORY</th>
<th style="font-size:8px">DATE CREATED</th>
<th style="font-size:8px">TIME CREATED</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">EDIT</th>
<th style="font-size:8px">DELETE</th>
</tr>
</thead>
<tbody>
<?php
foreach($results as $member) {
// Escape output for XSS protection
$id = (int)$member['id'];
$name = htmlspecialchars($member['Name']);
$category = htmlspecialchars($member['Categorys']);
$dateRegister = htmlspecialchars($member['Date_Register']);
$timeRegister = htmlspecialchars($member['Time_Register']);
$status = htmlspecialchars($member['Status']);
// Format date
$formattedDate = date("d-M-Y", strtotime($dateRegister));
?>
<tr style="font-size:8px">
<td><?php echo $id; ?></td>
<td style="text-transform:capitalize"><?php echo $name; ?></td>
<td style="text-transform:capitalize"><?php echo $category; ?></td>
<td><?php echo $formattedDate; ?></td>
<td><?php echo $timeRegister; ?></td>
<td><?php echo $status; ?></td>
<td>
<a href="#!" class="invks" data-id="<?php echo $id; ?>">
<i class="fa fa-edit"></i> Edit
</a>
</td>
<td>
<a href="#" class="indel" data-id="<?php echo $id; ?>" style="color:red;">
<i class="fa fa-trash"></i> Remove
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
// Load role data into modal for editing
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'edit_role_json.php',
type: "POST",
data: {'id': id},
dataType: "json",
success: function(data) { 
$('#stid').val(data.roleId);
$('#des').val(data.roleName);
$('#cat').val(data.roleCat);
},
error: function(xhr, status, error) {
alert('Error loading role data: ' + error);
}
});
} else {
alert('Invalid role ID');
}
});
});

// Delete role with confirmation
$(document).ready(function() {
$('.indel').on('click', function(e) {e.preventDefault();
var WRN_PROFILE_DELETE = "You are about to delete this role from database";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#roleModal").modal('hide');
$("#please").show();
$("#tst1").css("display", "block");
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'role_delete_json.php',
type: "POST",
data: {'id': id},
dataType: "json",
success: function(data) { 
setTimeout(function() {
$("#please").hide();
$("#toasts").show();
}, 3000);
setTimeout(function() {
$("#roleModal").modal('show');
$("#toasts").hide();
loadup();
}, 7000);
},
error: function(xhr, status, error) {
$("#please").hide();
alert('Error deleting role: ' + error);
}
});
} else {
$("#please").hide();
alert('Invalid role ID');
}
}
});
});

// Reload role list
function loadup(){
$.ajax({
method: "POST",
url: "role_analysis.php",
dataType: "html",
success: function(data) {
setTimeout(function() {
$('#result').html(data);
}, 1000);
},
error: function(xhr, status, error) {
console.error('Error reloading roles: ' + error);
}
});
}

// Update role form submission
$(document).ready(function(e) {
$("#uploadForm").on('submit', function(e) { e.preventDefault();
$("#roleModal").modal('hide');
$("#please").show();
$.ajax({
url: "update_role_json.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData: false,
success: function(data) { 
if(data == 1) {
setTimeout(function() {
$("#please").hide();
$("#roleModal").modal('show');
$("#rupdate").show();
loadup();
}, 3000);
setTimeout(function() {
$("#rupdate").hide();
}, 6000);
} else {
$("#please").hide();
alert('Update failed: ' + data);
}
},
error: function(xhr, status, error) {
$("#please").hide();
alert('Error updating role: ' + error);
}
});
});
});
</script>