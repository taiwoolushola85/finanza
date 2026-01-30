<?php
include '../config/db.php';
foreach ($_POST['id'] as $id) {
//
$sql = "DELETE FROM nip_notifications WHERE id = '$id'";
$result = mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
} 
}
mysqli_close($con);
?>
	