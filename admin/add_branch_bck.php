<?php
include '../config/db.php';
$name = $_POST['nm'];// branch name
$st = $_POST['st'];// branch state
$zn = $_POST['zn'];// zone id
$d = date('Y-m-d');
$s = date('h:m:s');
$Query = "SELECT * FROM branch WHERE Name = '$name'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}else{
// getting zone name
$Query = "SELECT * FROM zone WHERE id ='$zn'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$zone_id = $row['id'];
$zone = $row['Name'];
$sql = "INSERT INTO branch (Name, Address, State, Zone, Zone_id, Country, Status, User, Date_Register, Time_Register) 
VALUES ('$name', '$st', '$st', '$zone', '$zone_id', 'Nigeria', 'Activate', 'Admin', '$d', '$s')";
if (mysqli_query($con, $sql)) {
echo 2;
}else {
echo("Error description: " . mysqli_error($con));
}
}
?>