<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
//
$Query = "UPDATE register SET Status = 'Waiting For Verification', Stage = '2' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
//
$Query = "DELETE FROM comment WHERE Reg_No = '$id'  ORDER BY id DESC LIMIT 1";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM verify WHERE Reg_id = '$id'";
$result= mysqli_query($con, $Query);
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>