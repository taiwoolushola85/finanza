<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id'];// user id
$username = $_POST['us'];// username
$password = $_POST['ps'];// password
// checking if login exist
$Query = "SELECT * FROM users WHERE Username = '$username'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
// updating login info
$Query = "UPDATE users SET Username = '$username', Password = '$password' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>