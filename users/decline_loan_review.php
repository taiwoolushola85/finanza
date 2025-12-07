<?php 
include '../config/db.php';
include '../config/user_session.php';
$id = $_GET['id'];// reg id
$sql = "UPDATE register SET Status = 'Declined', Stage = '1' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
?>