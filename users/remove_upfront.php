<?php
include '../config/db.php';
$id = $_POST['id'];// reg id
$Query = "DELETE FROM fee WHERE id = '$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>