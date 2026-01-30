<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id']; // username id
// updating  info
$Query = "UPDATE users SET Checks = '0', Pin = 'NA', Login_Attempts = '0' WHERE id ='$id'";
$result= mysqli_query($con, $Query); 
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>