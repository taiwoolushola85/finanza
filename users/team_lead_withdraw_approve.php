<?php
//updating loan officer in union
include('../config/db.php') ;
include '../config/user_session.php';
$d = date('Y-m-d');
$id = $_POST['id'];// request id
//
$Query = "UPDATE withdraw SET Status = 'Waiting For Approval', Team_Approve = '$na' WHERE id = '$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>