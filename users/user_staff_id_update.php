<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id']; // username id
$stid = $_POST['stid'];
// updating  info
$Query = "UPDATE users SET Staff_ID = '$stid' WHERE id = '$id'";
$result= mysqli_query($con, $Query); 
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>