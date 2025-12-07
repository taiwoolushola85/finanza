<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
//
$Query = "UPDATE register SET Status = 'Pending', Stage = '3' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM comment WHERE Reg_No = '$id' AND User_Role = 'Team Leaders' ORDER BY id DESC LIMIT 1";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>