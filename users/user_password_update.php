<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id']; // username id
$password = $_POST['psd'];// password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// updating  info
$Query = "UPDATE users SET Password='$hashedPassword' WHERE id = '$id'";
$result= mysqli_query($con, $Query); 
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>