<?php
session_start();
include './config/db.php';
$id = $_POST['usd_id'];// username id
$pin = $_POST['pin'];// pin 
$sql="SELECT * FROM users WHERE Pin = '$pin' WHERE id ='$id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$user = $row['Username'];
$Usertype = $row['Usertype'];
// check if user is admin
if($Usertype == 'Admin' && $user == $id){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
header("Location: ./admin/index.php");
}elseif($Usertype == 'User' && $user == $id){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
header("Location:./users/home.php");
}else{
header('location:authentication.php?Id=1');
}
?>