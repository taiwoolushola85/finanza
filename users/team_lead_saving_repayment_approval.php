<?php
//updating loan officer in union
include('../config/db.php') ;
include '../config/user_session.php';
$id = $_POST['id'];
$Query = "SELECT * FROM saving_rep WHERE id ='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$ffn = $row['Firstname'];
$lln = $row['Lastname'];
$Query = "UPDATE saving_rep SET Status = 'Waiting For Approval', Team_Approve='$na' WHERE id = '$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>