<?php 
include '../config/db.php';
include '../config/user_session.php';
$id = $_GET['id'];// reg id
$sql = "UPDATE register SET Status ='Approved', Stage = '2' WHERE id = '$id' ";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
?>