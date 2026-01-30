<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "UPDATE nip_notifications SET Status = 'Waiting For Approval' WHERE id = '$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>
