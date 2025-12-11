<?php
//updating loan officer in union
include('../config/db.php');
$id = $_POST['id'];
//
$Query = "DELETE FROM withdraw WHERE id = '$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>