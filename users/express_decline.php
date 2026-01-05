<?php
include '../config/db.php';
foreach ($_POST['id'] as $id) {
// checking reciept
$Query = "SELECT Reciept FROM save WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$location = $row['Reciept'];
unlink($location);
//
$sql = "DELETE FROM save WHERE id = '$id'";
$result = mysqli_query($con, $sql);

}
mysqli_close($con);
?>
	