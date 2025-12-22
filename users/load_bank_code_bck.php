<br>
<small>
Total: 
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM bank");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</small>
<br><br>
<?php
// Get and sanitize the search parameter
$nm = isset($_POST['search']) ? trim($_POST['search']) : '';

// Set CORS headers at the top (before any output if possible)
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");

include '../config/db.php';

// Use prepared statements to prevent SQL injection
if($nm == ''){
// No search term - get all records
$stmt = mysqli_prepare($con, "SELECT id, Bank_Name, Date_Created, Time_Created FROM bank ORDER BY Bank_Name ASC LIMIT 10");
} else {
// Search term provided
$searchTerm = "%$nm%";
$stmt = mysqli_prepare($con, "SELECT id, Bank_Name, Date_Created, Time_Created FROM bank WHERE Bank_Name LIKE ? ORDER BY Bank_Name ASC");
mysqli_stmt_bind_param($stmt, "s", $searchTerm);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
mysqli_stmt_close($stmt);
mysqli_close($con);
// Save to JSON file
$fp = fopen('../data/bank_lists.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
?>

<div id="table-container" style="overflow:auto; height:240px;">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">BANK</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">TIME</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
// Read from JSON file
$url = '../data/bank_lists.json';
$data = file_get_contents($url);
$json = json_decode($data);

if($json && is_array($json)){
foreach($json as $member){
?>
<tr style="font-size:8px">
<td><?php echo htmlspecialchars($member->id); ?></td>
<td style="text-transform:capitalize"><?php echo htmlspecialchars($member->Bank_Name); ?></td>
<td><?php echo htmlspecialchars($member->Date_Created); ?></td>
<td><?php echo htmlspecialchars($member->Time_Created); ?></td>
<td><a class="invks" href="#!" data-id="<?php echo htmlspecialchars($member->id); ?>" style="color:red;"><i class="fa fa-trash"></i> Remove</a></td>
</tr>
<?php
}
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
WRN_PROFILE_DELETE = "You are about to remove bank record from the database..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).data('id');
alert(id);
if(id) {
$.ajax({
url: 'delete_bank_record.php',
type: "GET",
data: {'id': id},
success: function(data) { 
if(data == 1){
setTimeout(function() {
loadBank();
}, 100);
}else{
alert("Error" + data)
}
},
error: function(xhr, status, error) {
alert('Error removing record: ' + error);
$("#view").hide();
}
});
} else {
alert('Invalid ID');
}
}
});
});
</script>
