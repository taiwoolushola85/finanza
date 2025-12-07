<?php
include_once '../config/db.php';
$id =$_POST['id'];// roel id
$branchname =$_POST['rl']; // branch name
$state =$_POST['ro']; // state
$zone =$_POST['zn']; // zone id
// getting zone name and id
$Query = "SELECT id, Name FROM zone WHERE id = '$zone'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$zoneid = $row['id'];
$zonename = $row['Name'];
$d = date('Y-m-d');
$s = date('h:m:sa');
// update query
$sql = "UPDATE branch SET Name = '$branchname', State = '$state', Zone = '$zonename', Zone_id = '$zoneid' WHERE id = '$id'";
$result  = mysqli_query($con, $sql);
if ($result == true) {
echo 1;
}else {
echo("Error description: " . mysqli_error($con));
}
?>
