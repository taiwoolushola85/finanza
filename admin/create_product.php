<?php
include '../config/db.php';
$name = $_POST['name'];// product name
$fre = $_POST['fre'];// frequency
$d = date('Y-m-d');
$s = date('h:m:s');
//check if product already exist
$Query = "SELECT * FROM product WHERE Product_Name = '$name'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
$sql = "INSERT INTO product (Product_Name, Frequency, Status, User, Date_Register, Time_Register) 
VALUES ('$name', '$fre', 'Activated', 'Admin', '$d', '$s')";
if (mysqli_query($con, $sql)) {
echo 2;
}else {
echo("Error description: " . mysqli_error($con));
}
?>