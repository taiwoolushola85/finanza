<?php
//if the add button has been clicked
include '../config/db.php';
$id = $_POST['id'];// reg id
$up = $_POST['up'];// upfront
$in = $_POST['in'];// inssurance
$cd = $_POST['cd'];// card
$fm = $_POST['fm'];// form
//
$Query = "SELECT Frequency FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$fr = $row['Frequency'];
if($fr == 'Daily'){
// updating register
$Query = "UPDATE register SET Upfront ='$up', Inssurance = '$in', Card = '$cd', Form = '$fm' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
// updating fee
$Query = "UPDATE fee SET Upfront ='$up', Inssurance = '$in', Card = '$cd', Form = '$fm' WHERE Reg_id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}else{
// updating register
$Query = "UPDATE register SET Upfront ='$up', Inssurance = '$in', Card = '$cd', Form = '$fm' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
// updating fee
$Query = "UPDATE fee SET Upfront ='$up', Inssurance = '$in', Card = '$cd', Form = '$fm' WHERE Reg_id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>