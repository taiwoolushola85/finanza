<?php
include_once '../config/db.php';
$prid = $_POST['prid'];// product id
$id = $_POST['id'];// product list id
$pr = $_POST['pr']; // product name
$ten = $_POST['ten']; // tenure
$in = $_POST['in']; // inssurance
$rt = $_POST['rt']; // rate
$fr = $_POST['fr']; // frequency
// update query
$sql = "UPDATE product_list SET Product = '$pr', Tenure = '$ten', Inssurance= '$in', Rate = '$rt', Frequency = '$fr' WHERE id = '$id'";
$result  = mysqli_query($con, $sql);
//
$sql = "UPDATE product SET Product_Name = '$pr', Frequency = '$fr' WHERE id = '$prid'";
$result  = mysqli_query($con, $sql);
if ($result == true) {
echo 1;
}else {
echo("Error description: " . mysqli_error($con));
}
?>
