<?php
include '../config/db.php';
// Validate and cast ID (assuming it's numeric)
$id = intval($_POST['id']);
$d = date('Y-m-d');
$s = date('h:m:s');
// updating info
$sql = "DELETE FROM flexi_reg WHERE id = '$id'";
if (mysqli_query($con, $sql)) {
echo 1;
}else {
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>