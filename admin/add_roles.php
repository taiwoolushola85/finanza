<?php
include '../config/db.php';
$gr = $_POST['gr'];
$check = $_POST['na'];
$tas = $_POST['ta'];
$ct = $_POST['ct'];
$na = '';
for($i=0;$i<count($check);$i++){
$chk = $check[$i];
for($a=0;$a<count($tas);$a++){
$tab = $tas[$a];
$nam = str_replace( array( '\'', '"', ',' , ';', '<', '>','_' ), ' ', $chk);
$sql = "INSERT INTO control(Tab, role, Role_Categorys, Groups, Name) VALUES ('$tab', '$chk', '$ct', '$gr', '$nam')";
$result = mysqli_query($con, $sql);
}
}
mysqli_close($con);
?>