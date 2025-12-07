<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT id, Product_id, Product, Tenure, Rate, Inssurance, Frequency FROM product_list WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$prid = $row['Product_id'];
$pr = $row['Product'];
$ten = $row['Tenure'];
$rt = $row['Rate'];
$in = $row['Inssurance'];
$fr = $row['Frequency'];
echo json_encode(array("productId"=>$ids, "productNo"=>$prid, "productName"=>$pr, "productTenure"=>$ten, "productRate"=>$rt, "productIns"=>$in, "productFrequency"=>$fr));

}else{

}
mysqli_close($con);
?>