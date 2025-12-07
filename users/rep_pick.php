<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT id, Total_Bal, Firstname, Middlename FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$tot = $row['Total_Bal'];
$ann = $row['Firstname']." ".$row['Middlename'];
echo json_encode(array("cusId"=>$ids, "cusBal"=>$tot, "cusName"=>$ann));
}else{

}
mysqli_close($con);
?>