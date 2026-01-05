<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
echo json_encode(array("regId"=>$ids));
}else{
//
}
?>