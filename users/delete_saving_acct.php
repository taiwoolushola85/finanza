<?php 
include '../config/db.php';
$id = $_GET['id'];
//
$sql = "DELETE FROM savings WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>