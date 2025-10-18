<?php
include '../config/db.php';
$rl=$_POST['rl'];
$ro=$_POST['ro'];
$d = date('Y-m-d');
$s = date('h:m:sa');
//check if role already exist
$Query = "SELECT * FROM role WHERE Name = '$rl'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
//inserting new role info
$sql = "INSERT INTO role (Name, Categorys, Date_Register, Time_Register, Status) 
VALUES ('$rl', '$ro', '$d', '$s', 'Active')";
if (mysqli_query($con, $sql)) {
echo 2;
}else {
echo("Error description: " . mysqli_error($con));
}
?>
