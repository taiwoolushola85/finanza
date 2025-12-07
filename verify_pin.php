<?php
session_start();
include './config/db.php';
$user_id = $_POST['usd_id'];// username id
$auth1 = $_POST['auth1'];// pin 1
$auth2 = $_POST['auth2'];// pin 2
$auth3 = $_POST['auth3'];// pin 3
$auth4 = $_POST['auth4'];// pin 4
$pin = $auth1."".$auth2."".$auth3."".$auth4;// combination pin
$sql="SELECT Username, Usertype FROM users WHERE Pin = '$pin' AND id ='$user_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$uzerid = $row['id']; // username id
$user = $row['Username'];// username
$Usertype = $row['Usertype'];// usertype
// check if user is admin
if($Usertype == 'Admin' &&  $id == $id){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
header("Location: ./admin/index.php");
}elseif($Usertype == 'User' &&  $id == $id){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
header("Location:./users/home.php");
}else{
header('location:authentication.php?Id=1');
}
?>