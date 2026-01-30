<?php 
include '../config/db.php';
include '../config/user_session.php';
$id = $_GET['id'];// reg id
$sql = "DELETE FROM register WHERE id = '$id'";
$result= mysqli_query($con, $sql);
//
$sql = "DELETE FROM comment WHERE Reg_No = '$id'";
$result= mysqli_query($con, $sql);
//
$sql = "DELETE FROM reason WHERE RegNo = '$id'";
$result= mysqli_query($con, $sql);
//
$sql = "DELETE FROM verify WHERE Reg_id = '$id'";
$result= mysqli_query($con, $sql);
//
$sql = "DELETE FROM document WHERE Reg_ID = '$id'";
$result= mysqli_query($con, $sql);
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
?>