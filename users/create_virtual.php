<?php
include('../config/db.php') ;
$d = date('Y-m-d');
include '../config/user_session.php';
$vrt = trim($_POST['vrt']); // virtual acct
$bvn = trim($_POST['bvn']);// bvn number
$d = date('Y-m-d');
$s = date('h:m:sa');
// check if virtual account already exit
$Query = "SELECT * FROM repayments WHERE Account_Number = '$vrt' ";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
//
$Query = "UPDATE repayments SET Account_Number = '$vrt' WHERE BVN ='$bvn'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE savings SET Virtual_Account = '$vrt' WHERE Client_BVN ='$bvn'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
?>