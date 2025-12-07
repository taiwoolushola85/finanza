<?php
include '../config/db.php';
foreach ($_POST['id'] as $id) {
// checking reciept
$Query = "SELECT Location FROM history WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$location = $row['Location'];
unlink($location);
$sql = "DELETE FROM history WHERE id = '$id'";
$result = mysqli_query($con, $sql);
// deleting data from saving
$sql = "DELETE FROM save WHERE History_id = '$id'";
$result = mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
} 
}
mysqli_close($con);
?>
	