<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
//
$Query = "DELETE FROM register WHERE id = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM schedule WHERE Regs_id = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM fee WHERE Reg_id = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM comment WHERE Reg_No = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM document WHERE Reg_ID = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>