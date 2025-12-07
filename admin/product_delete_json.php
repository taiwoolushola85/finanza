<?php
include '../config/db.php';
$id = $_POST['id'];
// getting product id
$Query = "SELECT id, Product_id FROM product_list WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pid = $row['id'];// product list id
$pro_id = $row['Product_id'];// product id
// delete product from product table
$Query = "DELETE FROM product WHERE id='$pro_id'";
$result = mysqli_query($con, $Query);
// deleting product from product list table
$Query = "DELETE FROM product_list WHERE id='$id'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>