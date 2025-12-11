<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_GET['id']; //  group id
//deleting fee payment
$Query = "DELETE FROM groups WHERE id='$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>