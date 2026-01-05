<?php 
include '../config/db.php';
$bvn = $_POST['bvn'];
$repid = $_POST['repid'];
$regid = $_POST['regid'];
$lon = $_POST['lon'];
$dis = $_POST['dis'];
$d = date('Y-m-d');
$s = date('H:i:s');
//
$result = mysqli_query($con, "SELECT * FROM repayments WHERE id = '$repid'");
$row= mysqli_fetch_array($result);
$id = $row['id'];//
$sku = $row['Account_Number'];//
$sav = $row['Savings_Account_No'];//
$tr = $row['Transaction_id'];//
$fn = $row['Firstname'];//
$md = $row['Middlename'];//
$ln = $row['Lastname'];//
$gn = $row['Gender'];//
$la = $row['Loan_Amount'];//
$un = $row['Unions'];//
$un_id = $row['Union_id'];//
$ph = $row['Phone'];//
$us = $row['User'];//
$user_id = $row['User_id'];//
$tl = $row['Team_Leader'];//
$of = $row['Officer_Name'];//
$tn = $row['Team_Name'];//
$br = $row['Branch'];//
$br_id = $row['Branch_id'];//
$tms_id = $row['Team_id'];//
$pr = $row['Product'];//
$pr_id = $row['Product_id'];//
$fr = $row['Frequency'];//
$ten = $row['Duration'];//
$map_id = $row['Map_id'];//
//
$result = mysqli_query($con, "SELECT * FROM register WHERE id='$regid'");
$rows = mysqli_fetch_array($result);
$reg_id = $rows['id'];
$ad = $rows['Address'];//

//
$Query = "SELECT * FROM savings WHERE Loan_Account_No = '$lon'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}

// inserting savings info
$sql = "INSERT INTO savings (Repayments_id, Virtual_Account, Disbursement_No, Transaction_id, Loan_Account_No, Savings_Account_No, Firstname,
Middlename, Lastname, Gender, Loan_Amount, Unions, Union_id, Savings_Paid, Phone, Address, User, User_id, Team_Leader, Officer_Name, Team_Name, Branch, Branch_id, 
Date_Opend, Time_Open, Status, Reg_id, Team_id, Withdraw_Savings, Savings_Repayment, Savings_Transfer, Savings_Upfront, Savings_Recieved, Balance, Client_BVN, 
Closed_By, Last_Payment_Date, Last_Amount, Product, Frequency, Duration, Map_id, Product_id)
VALUE('$id', '$sku', '$dis', 'tr', '$lon', '$sav', '$fn', '$md', '$ln', '$gn', '$la', '$un', '$un_id', '0', '$ph', '$ad', '$us', '$user_id', 
'$tl', '$of', '$tn', '$br', '$br_id', '$d', '$s', 'Active', '$regid', '$tms_id', '0', '0', '0', '0', '0', '0', '$bvn', 'Null', '$d', '0', '$pr', '$fr', '$ten', 
'$map_id', '$pr_id')";
$result= mysqli_query($con, $sql);

if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
?>