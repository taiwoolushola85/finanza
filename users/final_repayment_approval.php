<?php
//updating loan officer in union
include('../config/db.php') ;
include '../config/user_session.php';
$d = date('Y-m-d');
$request_id = $_POST['id'];
$sbl = $_POST['bal'];// current saving balance
$lon = $_POST['lon'];//  reciever loan acct
$sa = $_POST['sv'];// sender saving account
$amt = $_POST['amt'];// amount to be paid
$tbl = $_POST['tbl'];// loan balance
if($amt > $tbl){
echo 1;
exit();
}else if($amt > $sbl){
echo 2;
exit();
}else{
// inserting into history table
$result = mysqli_query($con, "SELECT * FROM repayments WHERE Loan_Account_No = '$lon' AND Status = 'Active'");
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
$d = date('Y-m-d');
$ss = date('h:m:sa');
$yrs = date('Y');
$mth = date('M');
$rand = rand();
$ran = uniqid();

// saving for repayment request
$Query = "UPDATE saving_rep SET Status = 'Paid', Management_Approve = '$na', Date_Approved = '$d' WHERE id = '$request_id'";
$result = mysqli_query($con, $Query);
// inserting into history table
$Query  = "INSERT INTO history (Session_id, Notification_id, Rep_id, Virtual_No, Disbursement_No, Register_id, Repayment_id, Loan_Account_No,
Transaction_id, Saving_Account_No, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Amount, Savings, Duration, Frequency, Rate, Loan_Type,
Product_id, Branch, Branch_Code, Status, User, User_id, Team_Leader, Team_Name, Officer_Name, Date_Paid, Time_Paid, Team_id, Interest_Amt, Expected_Amount, 
Total_Loan, Location, Balance, Phone, Payment_Method, Payment_Status, Alert, Post_Method, Reciept_No, Reciept_Status, Posting_Status, Months, Years)
VALUES ('NA', 'NA', '$id', '$virtaul_acct', '$dis', '$reg', '$id', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$amt', '0', 
'$du', '$fr', '$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', 'Paid', '$us', '$us_id', '$tm', '$tmn', '$ofn', '$d', '$ss', '$tim', '$int_amt', '$exp_amt',
'$total_loan', 'No Reciept', '$bal', '$ph', 'Saving For Repayment', 'Payment Confirmed', '$alert', 'System Posting', 'No Reciept No', 'Denied', 'Denied', '$mth',
'$yrs')";
$result = mysqli_query($con, $Query);
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status ='Paid' AND Saving_Account = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status ='Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status ='Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status ='Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status ='Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status ='Paid' AND Reciever_Account = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$bal = ($pmd - $pmw - $pmr - $pmtr) + $pmc;
//
$Query = "UPDATE repayments SET Savings_Bal = '$bal' WHERE Savings_Account_No = '$sa'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE savings SET Balance = '$bal', Savings_Repayment = '$pmr' WHERE Savings_Account_No = '$sa'";
// updating reciever schedule 
$Query = "UPDATE schedule SET Amount_Paid = '$amt', Savings = '0', Payment_Status = 'Paid', Date_Paid = '$d', Payment_Method = 'Savings Method' 
WHERE Transaction_id = '$tr' AND Payment_Status = 'Outstanding' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>