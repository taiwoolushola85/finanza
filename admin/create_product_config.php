<?php
include '../config/db.php';
$prid = $_POST['pro'];// product id
$ten = $_POST['ten'];// product tenure
$int = $_POST['int'];// interest
$ins = $_POST['ins'];// inssurance
$d = date('Y-m-d');
$s = date('h:m:s');
//getting product name
$Query = "SELECT * FROM product WHERE id='$prid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$name = $row['Product_Name'];
$fr = $row['Frequency'];
//check if product already exist
$Query = "SELECT * FROM product_list WHERE Product = '$name' AND Tenure = '$ten'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
$sql = "INSERT INTO product_list (Product_id, Product, Frequency, Tenure, Rate, Inssurance, Count, Date_Config, Time_Config) 
VALUES ('$prid', '$name', '$fr', '$ten', '$int', '$ins', '0', '$d', '$s')";
if (mysqli_query($con, $sql)) {
echo 2;
}else {
echo("Error description: " . mysqli_error($con));
}
?>