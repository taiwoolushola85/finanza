<?php
//if the add button has been clicked
include '../config/db.php';
$id = $_POST['spayid'];// payment id
$amt = $_POST['sv'];// amount
//
$Query = "UPDATE save SET Savings = '$amt' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>