<?php
include_once '../config/db.php';
$id =$_POST['id'];// roel id
$rl =$_POST['rl']; // role name
$ro =$_POST['ro']; // category
$d = date('Y-m-d');
$s = date('h:m:sa');
//updating user role table
$sql = "UPDATE role SET Name = '$rl', Categorys = '$ro' WHERE id = '$id'";
$result  = mysqli_query($con, $sql);
// updating users table 
$sql = "UPDATE users SET User_Group = '$rl', Role_Categorys = '$ro' WHERE Role_id = '$id'";
$result  = mysqli_query($con, $sql);
if ($result == true) {
echo 1;
}else {
echo("Error description: " . mysqli_error($con));
}
?>
