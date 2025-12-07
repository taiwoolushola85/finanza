<?php
session_start();
include '../config/db.php';
extract($_POST);
if (empty($ps)) {
echo 1;
}else{
$id = $_POST['id'];// user id
$us = $_POST['us'];// username
$bck = $_POST['bck'];// resume location
// checking the if login is correct
$sql ="SELECT * FROM users WHERE Username = '$us' AND Password = '$ps' AND id = '$id'";
$result=mysqli_query($con,$sql); 
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
if (mysqli_num_rows($result) === 1) {
$idd = $row['id'];
$name = $row['Name'];
$User = $row['Username'];
$type = $row['Usertype'];
$Status = $row['Status'];
$chk = $row['Checks'];

// check if user is admin
if($type == 'Admin'){
$_SESSION["Username"] = $User;
$_SESSION["Name"] = $name;
$_SESSION['login_time'] = time();
echo "$bck";

}elseif($type == 'User'){
$_SESSION["Username"] = $User;
$_SESSION["Name"] = $name;
$_SESSION['login_time'] = time();
echo "$bck";

}elseif($type == 'User' && $Status == 'Deactivated'){
echo 4;

} else {
echo 5;

}

}else{
echo 6;
}
}
?>