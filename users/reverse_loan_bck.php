<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
//
$Query = "UPDATE register SET Status = 'Ready For Underwriting' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM schedule WHERE Regs_id = '$id'";
$result= mysqli_query($con, $Query);
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>