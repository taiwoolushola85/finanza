<?php
include '../config/db.php';
include '../config/user_session.php';
$bvn = $_POST['bvn'];
// checking if client exist
$Query = "SELECT * FROM register WHERE BVN = '$bvn' AND Status != 'Disbursed' AND Application_Status = 'Registered'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
// checking if customer has active loan
$Query = "SELECT * FROM repayments WHERE BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 2;
exit();
}
//checking bvn in blacklist
$Query = "SELECT * FROM blacklist WHERE BVN = '$bvn' AND Status = 'Approved'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 3;
exit();
}
// checking if gaurantor has been used
$Query = "SELECT * FROM gaurantors WHERE Gaurantor_BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 4;
exit();
}
// do existing registration
$Query = "SELECT * FROM register WHERE BVN = '$bvn'";
$result = mysqli_query($con, $Query);
$rows = mysqli_num_rows($result);
if($rows != 0){
echo 5;
exit();
}
?>