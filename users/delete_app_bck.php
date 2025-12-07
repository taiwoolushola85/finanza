<?php
include '../config/db.php';
$id = $_POST['id'];// registration id
//
$sql = "DELETE FROM register WHERE id = '$id'";
$result= mysqli_query($con, $sql);
//
$sql = "DELETE FROM comment WHERE Reg_No = '$id'";
$result= mysqli_query($con, $sql);
//
$sql = "DELETE FROM gaurantors WHERE Regis_id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>