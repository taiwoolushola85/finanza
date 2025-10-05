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
$result = mysqli_query($con, "SELECT id, Staff_ID, Name, Branch, Email, Username, Password, Location, Status FROM users ORDER BY Name ASC LIMIT 10") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/users_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div  id="table-container" style="height:400px;">
<table>
<thead>
<tr>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">USERNAME</th>
<th style="font-size:8px">PASSWORD</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/users_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->Staff_ID?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Email?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo $member->Username?></td>
<td ><?php echo $member->Password?></td>
<td ><?php echo $member->Status?></td>
<td >
<a href="view_user.php?id=<?php echo $member->id?>">
<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Detail</button></a>
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
$result = mysqli_query($con, "SELECT id, Staff_ID, Name, Branch, Email, Username, Password, Location, Status FROM users  WHERE Name LIKE '%$search%' OR Staff_ID LIKE '%$search%'
ORDER BY Name ASC LIMIT $maxRows") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/users_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div  id="table-container" style="height:400px;">
<table>
<thead>
<tr>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">USERNAME</th>
<th style="font-size:8px">PASSWORD</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/users_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->Staff_ID?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Email?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo $member->Username?></td>
<td ><?php echo $member->Password?></td>
<td ><?php echo $member->Status?></td>
<td >
<a href="view_user.php?id=<?php echo $member->id?>">
<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Detail</button></a>
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
$result = mysqli_query($con, "SELECT id, Staff_ID, Name, Branch, Email, Username, Password, Location, Status FROM users  WHERE Name LIKE '%$search%' OR Staff_ID LIKE '%$search%'
ORDER BY Name ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/users_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div  id="table-container" style="height:400px;">
<table>
<thead>
<tr>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">USERNAME</th>
<th style="font-size:8px">PASSWORD</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/users_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->Staff_ID?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Email?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo $member->Username?></td>
<td ><?php echo $member->Password?></td>
<td ><?php echo $member->Status?></td>
<td >
<a href="view_user.php?id=<?php echo $member->id?>">
<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Detail</button></a>
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
$result = mysqli_query($con, "SELECT id, Staff_ID, Name, Branch, Email, Username, Password, Location, Status FROM users  ORDER BY Name ASC LIMIT $maxRows") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/users_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div  id="table-container" style="height:400px;">
<table>
<thead>
<tr>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">USERNAME</th>
<th style="font-size:8px">PASSWORD</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/users_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->Staff_ID?></td>
<td style="text-transform:capitalize"><?php echo $member->Name?></td>
<td ><?php echo $member->Email?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo $member->Username?></td>
<td ><?php echo $member->Password?></td>
<td ><?php echo $member->Status?></td>
<td >
<a href="view_user.php?id=<?php echo $member->id?>">
<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Detail</button></a>
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
