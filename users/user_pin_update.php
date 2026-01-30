<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id']; // username id
$pin = $_POST['pin'];
// updating  info
$Query = "UPDATE users SET Checks = '1', Pin = '$pin' WHERE id = '$id'";
$result= mysqli_query($con, $Query); 
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>