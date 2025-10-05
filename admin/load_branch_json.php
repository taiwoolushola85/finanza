<?php
$maxRows = @$_POST['maxRows']; // number of rows
$search = @$_POST['search']; // search term
?>


<?php 
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 0;
?>



<?php
if(empty($search) && empty($maxRows)){
?>



<small>
Total Record: 
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM branch");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</small>
<br><br>
<div>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Name, Zone, Address, State, Country, Status FROM branch ORDER BY Name ASC LIMIT 5") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/branch_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">ADDRESS</th>
<th style="font-size:8px">ZONE</th>
<th style="font-size:8px">STATE</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">EDIT</th>
<th style="font-size:8px">DELETE</th>
</tr>
<tbody>
<?php
$url = '../data/branch_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->id?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Address?></td>
<td ><?php echo $member->Zone?></td>
<td ><?php echo $member->State?></td>
<td ><?php echo $member->Country?></td>
<td ><?php echo $member->Status?></td>
<td ><a href="#modal-dialog" class="invks" data-bs-toggle="modal" id="<?php echo $member->id?>">
<i class="fa fa-edit"></i> Edit</a>
</td>
<td ><a href="#" class="indel" id="<?php echo $member->id?>" style="color:red;"><i class="fa fa-trash"></i> Remove</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>



<?php
} elseif(!empty($search) && !empty($maxRows)){
// Search with limit
//echo "Showing search results for '{$search}' limited to {$maxRows} records";
?>


<small>
Total Record: 
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM branch WHERE Name LIKE '%$search%' OR Zone LIKE '%$search%' ORDER BY Name ASC LIMIT $maxRows");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</small>
<br><br>
<div>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Name, Zone, Address, State, Country, Status  FROM branch WHERE Name LIKE '%$search%' OR Zone LIKE '%$search%'
ORDER BY Name ASC LIMIT $maxRows") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/branch_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">ADDRESS</th>
<th style="font-size:8px">ZONE</th>
<th style="font-size:8px">STATE</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">EDIT</th>
<th style="font-size:8px">DELETE</th>
</tr>
<tbody>
<?php
$url = '../data/branch_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->id?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Address?></td>
<td ><?php echo $member->Zone?></td>
<td ><?php echo $member->State?></td>
<td ><?php echo $member->Country?></td>
<td ><?php echo $member->Status?></td>
<td ><a href="#modal-dialog" class="invks" data-bs-toggle="modal" id="<?php echo $member->id?>">
<i class="fa fa-edit"></i> Edit</a>
</td>
<td ><a href="#" class="indel" id="<?php echo $member->id?>" style="color:red;"><i class="fa fa-trash"></i> Remove</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>



<?php
} elseif(!empty($search)){
// Search without limit
//echo "Showing all search results for '{$search}'";
?>


<small>
Total Record: 
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM branch WHERE Name LIKE '%$search%' OR Zone LIKE '%$search%'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</small>
<br><br>
<div>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Name, Zone, Address, State, Country, Status  FROM branch WHERE Name LIKE '%$search%' OR Zone LIKE '%$search%'
ORDER BY Name ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/branch_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">ADDRESS</th>
<th style="font-size:8px">ZONE</th>
<th style="font-size:8px">STATE</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">EDIT</th>
<th style="font-size:8px">DELETE</th>
</tr>
<tbody>
<?php
$url = '../data/branch_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->id?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Address?></td>
<td ><?php echo $member->Zone?></td>
<td ><?php echo $member->State?></td>
<td ><?php echo $member->Country?></td>
<td ><?php echo $member->Status?></td>
<td ><a href="#modal-dialog" class="invks" data-bs-toggle="modal" id="<?php echo $member->id?>">
<i class="fa fa-edit"></i> Edit</a>
</td>
<td ><a href="#" class="indel" id="<?php echo $member->id?>" style="color:red;"><i class="fa fa-trash"></i> Remove</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>



<?php
} else {
// Only maxRows is set
///echo "Showing {$maxRows} records";
?>


<small>
Total Record: 
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM branch ORDER BY Name ASC LIMIT $maxRows");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</small>
<br><br>
<div>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Name, Zone, Address, State, Country, Status  FROM branch ORDER BY Name ASC LIMIT $maxRows") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/branch_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">ADDRESS</th>
<th style="font-size:8px">ZONE</th>
<th style="font-size:8px">STATE</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">EDIT</th>
<th style="font-size:8px">DELETE</th>
</tr>
<tbody>
<?php
$url = '../data/branch_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->id?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Address?></td>
<td ><?php echo $member->Zone?></td>
<td ><?php echo $member->State?></td>
<td ><?php echo $member->Country?></td>
<td ><?php echo $member->Status?></td>
<td ><a href="#modal-dialog" class="invks" data-bs-toggle="modal" id="<?php echo $member->id?>">
<i class="fa fa-edit"></i> Edit</a>
</td>
<td ><a href="#" class="indel" id="<?php echo $member->id?>" style="color:red;"><i class="fa fa-trash"></i> Remove</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>



<?php
}
?>









<!-- #modal-dialog -->
<div class="modal" id="modal-dialog">
<div class="modal-dialog modal-dialog-centered modal-sm">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Branch Update Form</h4>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
<form action="" method="post" id="uploadForm">
<div class="row">
<div class="col-sm-6">
<label>Branch Name</label>
<input type="text" hidden class="form-control form-control-md" required="required" name="id" id="stid" placeholder="Enter ID">
<input type="text" class="form-control form-control-md" required="required" name="rl" id="branchname" placeholder="Enter Branch Name">
</div>
<div class="col-sm-6">
<label>Branch State</label>
<input type="text" class="form-control form-control-md" required="required" name="ro" id="branchstate" placeholder="Enter Branch State">
</div>
</div>
<label>Zone</label><i style="color:red"> [ Please re-select the branch zone ]</i>
<select class="selectpicker form-control" data-style="py-0" name="zn" required="required">
<option value="" id="brz"><span id="branch"></span></option>
<?php
include '../config/db.php';
$Query = "SELECT id, Name FROM zone WHERE Status = 'Activated' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$row = mysqli_fetch_array($result);
$bri= $row['id'];// zone id
$name= $row['Name'];// zone name
?>
<option value="<?php echo $bri; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
<br>
<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Update Branch</button>
</form>
</div>
</div>
</div>
</div>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.invks').on('click', function() {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'edit_branch_json.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
$('#stid').val(data.branchId);
$('#branchname').val(data.branchName);
$('#branchstate').val(data.branchState);
$('#branchZone').val(data.branchZone);
$('#brz').val(data.branchZoneid);
$('#branch').text(data.branchZone);
}
});
}else{
alert ("🚫" + data);
}
});
});
</script>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.indel').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this branch record from database";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'branch_delete_json.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Branch Deleted Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The branch has been deleted from database</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
loadup();
}, 4000);
}
});
}else{
alert ("🚫" + data);
}
}
});
});
</script>

<script type="text/javascript">
function loadup()  {
$.ajax({
method: "POST",
url: "load_branch_json.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
$("#modal-dialog").modal('hide');
$("#please").show();
$.ajax({
url: "update_branch_json.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){ 
if(data==1){
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Branch Updated Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The branch has been updated</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
loadup();
}, 3000);
}else{
alert(data);
$("#please").hide();
}
},
error: function(){
}
});
}));
});
</script>