<?php
// Database configuration
include '../config/db.php';
$regid = $_POST["id"];
$am = $_POST["am"];
$rand = mt_rand(1000, 100000);
// repayment info
$result = mysqli_query($con, "SELECT * FROM repayments WHERE Reg_id='$regid'");
$row= mysqli_fetch_array($result);
$id = $row['id'];
$virtaul_acct = $row['Account_Number'];
$dis = $row['Disbursement_No'];
$tr = $row['Transaction_id'];
$ln = $row['Loan_Account_No'];
$sn = $row['Savings_Account_No'];
$fn = $row['Firstname'];
$md = $row['Middlename'];
$lnm = $row['Lastname'];
$fll = $fn." ". $md. " ". $lnm;
$un = $row['Unions'];
$cu_id = $row['Union_id'];
$pr_name = $row['Product'];
$pr_id = $row['Product_id'];
$us = $row['User'];
$us_id = $row['User_id'];
$tm = $row['Team_Leader'];
$ofn = $row['Officer_Name'];
$tmn = $row['Team_Name'];
$br_name = $row['Branch'];
$br_id = $row['Branch_id'];
$la = $row['Loan_Amount'];
$fr = $row['Frequency'];
$rt = $row['Rate'];
$du = $row['Duration'];
$tim = $row['Team_id'];
$exp_amt = $row['Expected_Amount'];
$int_amt = $row['Interest_Amt'];
$reg = $row['Reg_id'];
$total_loan = $row['Total_Loan'];
$bal = $row['Total_Bal'];// balance
$ph = $row['Phone'];
$alert = $row['Alert'];
$d = $row['Date_Disbursed'];
$ss = date('h:m:sa');
// saving record
$query  = "INSERT INTO save (Session_No, History_id, Reps_id, Disbursement_No, Register_id, Repayment_id, Savings_id, Loan_Account_No, Transaction_id, Saving_Account,
Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch, Branch_Code, Reciept, Status, 
User, User_id, Team_Leader, Officer_Name, Team_Name, Date_Paid, Time_Paid, Team_id, Payment_Method, Posting_Method)
VALUES ('NA', 'NA', '$id', '$dis', '$reg', '$id', '$rand', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$am', '$du', '$fr', '$rt', '$pr_name',
'$pr_id', '$br_name', '$br_id', 'Reciept Uploaded', 'Paid', '$us', '$us_id', '$tm', '$ofn', '$tmn', '$d', '$ss', '$tim', 'System Posting', 'Initial Deposit')";
$result = mysqli_query($con, $query);
//
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status = 'Paid' AND Saving_Account = '$sn'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status = 'Paid' AND Saving_Account_No = '$sn'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status = 'Paid' AND Saving_Account_No = '$sn'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status = 'Paid' AND Saving_Account_No = '$sn'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status = 'Paid' AND Saving_Account_No = '$sn'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status = 'Paid' AND Reciever_Account = '$sn'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$bal = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;
//
$Query = "UPDATE repayments SET Savings_Bal = '$bal' WHERE Savings_Account_No = '$sn'";
$result= mysqli_query($con, $Query);
//updating savings balance
$Query = "UPDATE savings SET Savings_Paid = '$pmd', Balance = '$bal', Withdraw_Savings = '$pmw', Savings_Repayment = '$pmr', Savings_Transfer = '$pmtr', 
Savings_Upfront = '$pmu', Savings_Recieved = '$pmc' WHERE Savings_Account_No = '$sn'";
$result= mysqli_query($con, $Query);


if($result == true){
echo 1;
}else{
echo("Error Description:" .mysqli_error($con));
}
mysqli_close($con);
?>