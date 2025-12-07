<?php 
include '../config/db.php';
$bvn = $_POST['bvn'];
// checking if customer has saving account
$Query = "SELECT * FROM flexi_account WHERE BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$rowk = mysqli_num_rows($result);
if($rowk != 0){
echo 1;
exit();
}

/// avoid double registration
$Query = "SELECT * FROM flexi_reg WHERE Client_BVN = '$bv' AND Application_Status = 'Registered'";
$result = mysqli_query($con, $Query);
$roww = mysqli_num_rows($result);
if($roww != 0){
echo 2;
exit();
}

?>