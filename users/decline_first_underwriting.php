<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
//
$Query = "UPDATE register SET Status = 'Waiting For Verification' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM comment WHERE Reg_No = '$id' AND User_Role = 'Credit Analyst' ORDER BY id DESC LIMIT 1";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM verify WHERE Reg_id = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM document WHERE Reg_ID = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM reason WHERE RegNO = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>