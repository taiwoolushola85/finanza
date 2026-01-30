<?php
include '../config/db.php';
$id = $_POST['id'];// reg id
//
$result = mysqli_query($con, "SELECT Upfront, Inssurance, Form, Card FROM register WHERE id ='$id'");
$row= mysqli_fetch_array($result);
$up = $row['Upfront'];
$ins = $row['Inssurance'];
$form = $row['Form'];
$card = $row['Card'];

$Query = "UPDATE fee SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card', Status = 'Paid', Reciept_Status = 'Reciept Confirmed' WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card', Upfront_Status = 'Paid', Reciever_Name = '$na' WHERE id = '$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>