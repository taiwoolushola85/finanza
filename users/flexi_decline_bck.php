<?php
include '../config/db.php';
foreach ($_POST['id'] as $id) {
// checking reciept
$Query = "SELECT Location FROM flexi_history WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$location = $row['Location'];
unlink($location);
$sql = "DELETE FROM flexi_history WHERE id = '$id'";
$result = mysqli_query($con, $sql);
}
mysqli_close($con);
?>
	