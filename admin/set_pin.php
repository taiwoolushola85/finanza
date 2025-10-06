<?php
//if the add button has been clicked
include '../config/db.php';
$id = $_POST['id'];//admin id
$pin = $_POST['pin'];//Getting the pin
$d = date('Y-m-d');
$s = date('h:m:sa');
// Update the pin in the database
$Query = "UPDATE users SET Checks='1', Pin = '$pin' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if (mysqli_query($con, $Query)) {
echo 1;
}else {
echo("Error description: " . mysqli_error($con));
}
?>