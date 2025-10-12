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
$result = mysqli_query($con, "SELECT COUNT(*) FROM users");
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
$result = mysqli_query($con, "SELECT id, Staff_ID, Name, Branch, User_Group, Email, Phone, Country, Location, Status FROM users ORDER BY Name ASC LIMIT 10") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/staff_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div  id="table-container" style="height:280px;">
<table>
<thead>
<tr>
<th style="font-size:8px">IMAGE</th>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">ROLE</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/staff_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><img data-trigger-img src="<?php echo $member->Location?>" class="rounded me-2" height="20" width="20"></td>
<td ><?php echo $member->Staff_ID?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Phone?></td>
<td ><?php echo $member->User_Group?></td>
<td ><?php echo $member->Email?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo $member->Country?></td>
<td ><?php echo $member->Status?></td>
<td >
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" id="<?php echo $member->id?>">
<button type="submit" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
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
$result = mysqli_query($con, "SELECT COUNT(*) FROM users WHERE Name LIKE '%$search%' OR Staff_ID LIKE '%$search%' ORDER BY Name ASC LIMIT $maxRows");
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
$result = mysqli_query($con, "SELECT id, Staff_ID, Name, Branch, User_Group, Email, Phone, Country, Location, Status FROM users  WHERE Name LIKE '%$search%' OR Staff_ID LIKE '%$search%'
ORDER BY Name ASC LIMIT $maxRows") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/staff_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div  id="table-container" style="height:280px;">
<table>
<thead>
<tr>
<th style="font-size:8px">IMAGE</th>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">ROLE</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/staff_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px" onclick="window.location.href='view_user.php?id=<?php echo $member->id?>' " style="cursor: pointer;">
<td ><img data-trigger-img src="<?php echo $member->Location?>" class="w-40 rounded me-2" height="20"></td>
<td ><?php echo $member->Staff_ID?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Phone?></td>
<td ><?php echo $member->User_Group?></td>
<td ><?php echo $member->Email?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo $member->Country?></td>
<td ><?php echo $member->Status?></td>
<td >
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" id="<?php echo $member->id?>">
<button type="submit" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
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
$result = mysqli_query($con, "SELECT COUNT(*) FROM users WHERE Name LIKE '%$search%' OR Staff_ID LIKE '%$search%'");
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
$result = mysqli_query($con, "SELECT id, Staff_ID, Name, Branch, User_Group, Email, Phone, Country, Location, Status FROM users  WHERE Name LIKE '%$search%' OR Staff_ID LIKE '%$search%'
ORDER BY Name ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/staff_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div  id="table-container" style="height:280px;">
<table>
<thead>
<tr>
<th style="font-size:8px">IMAGE</th>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">ROLE</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/staff_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px" onclick="window.location.href='view_user.php?id=<?php echo $member->id?>' " style="cursor: pointer;">
<td ><img data-trigger-img src="<?php echo $member->Location?>" class="w-40 rounded me-2" height="20"></td>
<td ><?php echo $member->Staff_ID?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Phone?></td>
<td ><?php echo $member->User_Group?></td>
<td ><?php echo $member->Email?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo $member->Country?></td>
<td ><?php echo $member->Status?></td>
<td >
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" id="<?php echo $member->id?>">
<button type="submit" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
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
$result = mysqli_query($con, "SELECT COUNT(*) FROM users ORDER BY Name ASC LIMIT $maxRows");
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
$result = mysqli_query($con, "SELECT id, Staff_ID, Name, Branch, User_Group, Email, Username, Phone, Country, Location, Status FROM users  ORDER BY Name ASC LIMIT $maxRows") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/staff_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div  id="table-container" style="height:280px;">
<table>
<thead>
<tr>
<th style="font-size:8px">IMAGE</th>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">ROLE</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/staff_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px" onclick="window.location.href='view_user.php?id=<?php echo $member->id?>' " style="cursor: pointer;">
<td ><img data-trigger-img src="<?php echo $member->Location?>" class="w-40 rounded me-2" height="20"></td>
<td ><?php echo $member->Staff_ID?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Phone?></td>
<td ><?php echo $member->User_Group?></td>
<td ><?php echo $member->Email?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo $member->Country?></td>
<td ><?php echo $member->Status?></td>
<td >
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" id="<?php echo $member->id?>">
<button type="submit" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
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



<script>
// to show data on a modal box
$(document).ready(function() {
$('.invks').on('click', function() {
$("#updateModal").hide();
$("#view").show();
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'view_account.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
setTimeout(function(){
$("#updateModal").show();
$("#view").hide();
$('#profile').html(data);
}, 1000);
}
});
}else{
alert (data)
}
});
});
</script>