<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id']; // reg id
$type = $_POST['type']; // type
$d = date('Y-m-d');
$s = date('h:m:sa');
// updating  register info
$Query = "UPDATE register SET Upfront_Types = '$type' WHERE id='$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
?>