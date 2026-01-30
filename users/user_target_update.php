<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id']; // username id
$target = $_POST['target'];
// updating  info
$Query = "UPDATE users SET Sale_Target = '$target' WHERE id = '$id'";
$result= mysqli_query($con, $Query); 
//
$Query = "UPDATE mapping SET Target = '$target' WHERE Officer_id = '$id'";
$result= mysqli_query($con, $Query); 
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>