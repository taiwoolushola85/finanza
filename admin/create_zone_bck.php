<?php
//DB Connection
include '../config/db.php';
$d = date('Y-m-d');
$s = date('h:m:sa');
$zn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), ' ', $_POST['zn']); // zone name
// checking if username already taken
$Query = "SELECT * FROM zone WHERE Name = '$zn'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}

$sql="INSERT INTO `zone`(`Name`, `Date_Create`, `Time_Create`, `Status`)
VALUES ('$zn', '$d', '$s', 'Activated')";
$row = mysqli_query($con, $sql);
if($row == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
?>
