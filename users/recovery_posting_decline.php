<?php
include '../config/db.php';
foreach ($_POST['id'] as $id) {
// checking reciept
$Query = "SELECT Reciept FROM recover WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$location = $row['Reciept'];
unlink($location);
$sql = "DELETE FROM recover WHERE id = '$id'";
$result = mysqli_query($con, $sql);
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
} 
}
mysqli_close($con);
?>
	