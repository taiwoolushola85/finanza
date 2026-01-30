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
$whereClause = "";
if (!empty($search)) {
$whereClause = "WHERE (Discription LIKE '%$search_escaped%')";
}

// Count query (without LIMIT or ORDER BY - these don't apply to COUNT)
$countQuery = "SELECT COUNT(*) FROM holidays $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Holiday_Date, Discription FROM holidays $whereClause ORDER BY id ASC";

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
$fp = fopen('../data/holiday_list.json', 'w'); 
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
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">DESCRIPTION</th>
<th style="font-size:8px">EDIT</th>
<th style="font-size:8px">DELETE</th>
</tr>
</thead>
<tbody>
<?php
foreach($results as $member) {
// Escape output for XSS protection
$id = (int)$member['id'];
$name = htmlspecialchars($member['Holiday_Date']);
$address = htmlspecialchars($member['Discription']);
?>
<tr style="font-size:8px">
<td><?php echo $id; ?></td>
<td style="text-transform:capitalize"><?php echo $name; ?></td>
<td><?php echo $address; ?></td>
<td>
<a href="#!" class="invks"  data-id="<?php echo $id; ?>">
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
// Load branch data into modal for editing
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'edit_holiday.php',
type: "POST",
data: {'id': id},
dataType: "json",
success: function(data) { 
$('#stid').val(data.branchId);
$('#branchname').val(data.branchName);
$('#dis').val(data.disCrpition);
},
error: function(xhr, status, error) {
alert('Error loading branch data: ' + error);
}
});
} else {
alert('Invalid branch ID');
}
});
});

// Delete branch with confirmation
$(document).ready(function() {
$('.indel').on('click', function(e) {e.preventDefault();
var WRN_PROFILE_DELETE = "You are about to delete this holiday record from database";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#tst1").css("display", "block");
$("#branchModal").modal('hide');
$("#please").show();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'delete_holiday.php',
type: "POST",
data: {'id': id},
dataType: "json",
success: function(data) { 
setTimeout(function() {
$("#please").hide();
$("#toast1").show();
}, 3000);
setTimeout(function() {
$("#toast1").hide();
$("#branchModal").modal('show');
loadup();
}, 7000);
},
error: function(xhr, status, error) {
$("#please").hide();
alert('Error deleting branch: ' + error);
}
});
} else {
$("#please").hide();
alert('Invalid branch ID');
}
}
});
});

// Reload branch list
function loadup() {
$.ajax({
method: "POST",
url: "load_holiday_json.php",
dataType: "html",
success: function(data) {
setTimeout(function() {
$('#result').html(data);
}, 1000);
},
error: function(xhr, status, error) {
console.error('Error reloading branches: ' + error);
}
});
}

// Update branch form submission
$(document).ready(function(e) {
$("#uploadForm").on('submit', function(e) { e.preventDefault();
$("#branchModal").modal('hide');
$("#please").show();
$.ajax({
url: "update_holiday.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData: false,
success: function(data) { 
if(data == 1) {
setTimeout(function() {
$("#please").hide();
$("#bexit").show();
$("#branchModal").modal('show');
$("#uploadForm")[0].reset();
loadup();
}, 3000);
setTimeout(function() {
$("#bexit").hide();
loadup();
}, 6000);
} else {
$("#please").hide();
alert('Update failed: ' + data);
}
},
error: function(xhr, status, error) {
$("#please").hide();
alert('Error updating branch: ' + error);
}
});
});
});
</script>