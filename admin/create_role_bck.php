<?php
include_once '../config/db.php';
$rl=$_POST['rl'];
$ro=$_POST['ro'];
$d = date('Y-m-d');
$s = date('h:m:sa');
$sql = "INSERT INTO role (Name, Categorys, Date_Register, Time_Register, Status) 
VALUES ('$rl', '$ro', '$d', '$s', 'Active')";
if (mysqli_query($con, $sql)) {
echo 1;
}else {
echo("Error description: " . mysqli_error($con));
}
?>
