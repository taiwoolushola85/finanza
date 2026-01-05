<?php
include '../config/db.php';
$savid = $_POST['id']; // user id
$am = $_POST['am']; //  amount to withdraw
$bl = $_POST['bl']; //  savings bal
$loan = $_POST['ln']; //  loan account no
$bnk = $_POST['bnk']; //  bank
$acct = $_POST['acct']; //  account no
$actname = $_POST['actname']; //  account name
$reason = $_POST['reason']; //  reason
$balance = $_POST['bal']; //  saving balance
$result = mysqli_query($con, "SELECT * FROM savings WHERE id = '$savid'");
$row= mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$lon = $row['Loan_Account_No'];
$sav = $row['Savings_Account_No'];
$tr = $row['Transaction_id'];
$fn = $row['Firstname'];
$md = $row['Middlename'];
$ln = $row['Lastname'];
$la = $row['Loan_Amount'];
$un = $row['Unions'];
$un_id = $row['Union_id'];
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
$act_bvn = $row['Client_BVN'];
$d = date('Y-m-d');
// avoid double insert
$Query = "SELECT * FROM withdraw WHERE Saving_Account_No = '$sav' AND Status != 'Paid'";
$result = mysqli_query($con, $Query);
$counts = mysqli_num_rows($result);
if($counts != 0){
echo 6;
exit();
}

if($am > $balance){
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
`Status`, `Date_Withdraw`, `Account_No`, `Account_Name`, `Bank`, `BVN`, `Reason`) 
VALUES ('$reg_id', '$lon', '$sav', '$tr', '$fn', '$md', '$ln', '$un', '$un_id', '$la', '$am', '$us', '$us_id', '$tm', '$ofn', '$tnm', '$br', '$br_id', '$pr', 
'$pr_id', '$tm_id','Processing', '$d', '$acct', '$actname', '$bnk', '$act_bvn', '$reason')";
if (mysqli_query($con, $sql)) {
echo 4;
}else{
 echo("Error description: " . mysqli_error($con));
}
?>