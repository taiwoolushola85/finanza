<?php
include '../config/db.php';
$r_id = $_POST['id']; // user id
$sav = $_POST['sav']; // savings account no
$am = $_POST['am']; //  amount to withdraw
$bl = $_POST['bl']; //  savings bal
$loan = $_POST['ln']; //  loan account no
$result = mysqli_query($con, "SELECT * FROM repayments WHERE Loan_Account_No = '$loan'");
$row= mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$lon = $row['Loan_Account_No'];
$sa = $row['Savings_Account_No'];
$tr = $row['Transaction_id'];
$fn = $row['Firstname'];
$md = $row['Middlename'];
$ln = $row['Lastname'];
$un = $row['Unions'];
$un_id = $row['Union_id'];
$la = $row['Total_Loan'];
$us = $row['User'];
$us_id = $row['User_id'];
$tm = $row['Team_Leader'];
$ofn = $row['Officer_Name'];
$tnm = $row['Team_Name'];
$br = $row['Branch'];
$br_id = $row['Branch_id'];
$pr = $row['Product'];
$pr_id = $row['Product_id'];
$tm_id = $row['Team_id'];
// getting bank info
$result = mysqli_query($con, "SELECT * FROM register WHERE id='$reg_id'");
$row= mysqli_fetch_array($result);
$bnk = $row['Bank'];
$act_no = $row['Account_No'];
$act_nm = $row['Account_Name'];
$act_bvn = $row['BVN'];

$d = date('Y-m-d');
// avoid double insert
$Query = "SELECT * FROM withdraw WHERE Saving_Account_No = '$sav' AND Status != 'Paid'";
$result = mysqli_query($con, $Query);
$counts = mysqli_num_rows($result);
if($counts != 0){
echo 6;
exit();
}

if($am > $bl){
echo 1;
exit();
}
if($am == 0){
echo 2;
exit();
}
//
$sql = "INSERT INTO withdraw (`Reg_id`, `Loan_Account_No`, `Saving_Account_No`, `Transaction_id`, `Firstname`, `Middlename`, `Lastname`, `Unions`, `Union_id`, 
`Loan_Amount`, `Amount_Withdraw`, `User`, `User_id`, `Team_Leader`, `Officer_Name`, `Team_Name`, `Branch`, `Branch_id`, `Product`, `Product_id`, `Team_id`, 
`Status`, `Date_Withdraw`, `Account_No`, `Account_Name`, `Bank`, `BVN`) 
VALUES ('$reg_id','$lon','$sa','$tr','$fn','$md','$ln','$un','$un_id','$la','$am','$us','$us_id','$tm','$ofn','$tnm','$br','$br_id','$pr','$pr_id','$tm_id',
'Processing','$d','$act_no','$act_nm','$bnk','$act_bvn')";
if (mysqli_query($con, $sql)) {
echo 4;
}else{
echo 5;
exit();
}
?>