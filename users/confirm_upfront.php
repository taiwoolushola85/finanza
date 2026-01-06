<?php
include '../config/db.php';
$id = $_POST['id'];// reg id
$Query = "UPDATE fee SET Reciept_Status = 'Reciept Confirmed' WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE register SET Upfront_Status = 'Paid' WHERE id = '$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>