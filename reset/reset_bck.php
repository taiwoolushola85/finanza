<?php
//if the add button has been clicked
include('../config/db.php') ;
$username = $_POST['user'];// username
$password = $_POST['pass'];// password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// checking if username is valid
$Query = "SELECT Username FROM users WHERE Username = '$username'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row == 0){
echo 1;
exit();
}
// updating login info
$Query = "UPDATE users SET Password = '$hashedPassword' WHERE Username = '$username'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>