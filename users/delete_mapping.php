<?php
include '../config/db.php';
$id = $_GET['id'];// id
//
$sql = "DELETE FROM mapping WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>