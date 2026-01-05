<?php
//updating loan officer in union
include('../config/db.php') ;
include '../config/user_session.php';
$id = $_POST['id'];
$d = date("Y-m-d");
//
$Query = "UPDATE flexi_withdraw SET Status = 'Approved', Approved_By = '$na', Date_Approved = '$d' WHERE id = '$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>