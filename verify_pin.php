<?php
session_start();
include './config/db.php';
$user_id = $_POST['usd_id'];// username id
$pin = $_POST['pin'];// pin 
$sql="SELECT Username, Usertype FROM users WHERE Pin = '$pin' AND id ='$user_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$id = $row['id']; // username id
$user = $row['Username'];// username
$Usertype = $row['Usertype'];// usertype
// check if user is admin
if($Usertype == 'Admin' &&  $id == $id){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
header("Location: ./admin/index.php");
}elseif($Usertype == 'User' &&  $id == $id){
$_SESSION["id"] = $userid;
$_SESSION["Username"] = $user;
header("Location:./users/home.php");
}else{
header('location:authentication.php?Id=1');
}
?>