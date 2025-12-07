<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id'];// user id
$gr = $_POST['gr']; // group user id
//
$Query = "SELECT * FROM role WHERE id ='$gr'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$nm = $row['Name'];
$Categorys = $row['Categorys'];
// updating info
$Query = "UPDATE users SET User_Group ='$nm', Role_Categorys = '$Categorys' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
?>