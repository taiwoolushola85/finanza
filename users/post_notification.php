<?php
// Database configuration
include '../config/db.php';
include '../config/user_session.php';
$sessionid = $_POST['sessionid'];// session id
$notid = str_replace( array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['notid']);// notification id
$repid = str_replace( array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['repid']);//repayment id
$rep_amt = str_replace( array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['amt']);//repayment amount
$d =  $_POST['date'];//repayment date
//
// Sanitize and handle empty input for amount deposited
$am = isset($_POST['am']) ? str_replace(array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['am']) : 0;

// Sanitize and handle empty input for savings deposited
$sa = isset($_POST['sa']) ? str_replace(array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['sa']) : 0;

// Convert to float to ensure numeric addition
$am = floatval($am);
$sa = floatval($sa);

// Calculate total repayment
$total_rep = $am + $sa;


$mth = date('M');
$yrs = date('Y');
// avoid zero input in repayment
if($am == "0" && $sa == "0"){
echo 20;
exit();
}

//
if($total_rep != $rep_amt){
echo 7;
exit();
}
$result = mysqli_query($con, "SELECT * FROM repayments WHERE id='$repid' AND Status = 'Active'");

if ($result && mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result); // safer than fetch_array
$id = $row['id'];
$virtual_acct = $row['Account_Number'];
$dis = $row['Disbursement_No'];
$tr = $row['Transaction_id'];
$ln = $row['Loan_Account_No'];
$sn = $row['Savings_Account_No'];
$fn = $row['Firstname'];
$md = $row['Middlename'];
$lnm = $row['Lastname'];
$fll = trim("$fn $md $lnm");
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
$int_amt = $du != 0 ? round($row['Interest_Amt'] / $du, 2) : 0; // avoid division by zero
$reg = $row['Reg_id'];
$total_loan = $row['Total_Loan'];
$bal = $row['Total_Bal']; // balance
$ph = $row['Phone'];
$alert = $row['Alert'];
$maturity = $row['Maturity_Date'];
$ss = date('h:i:sa');
$date = date('Y-m-d');
$rand = rand();
$ran = uniqid();

// Make sure $am is numeric
$am = isset($am) ? floatval($am) : 0;
$nxt_bal = $total_loan - $am;
} else {
// No repayment info found
echo "The customer you are try to post for did not have an active loan to recieve this payment.! Please check..";
exit;
}


// check if notification id is duplicate
$result = mysqli_query($con, "SELECT * FROM history WHERE Session_id = '$sessionid'");
$row = mysqli_num_rows($result);
if($row != 0){
echo 2;
exit();
}

// checking for double posting
$result = mysqli_query($con, "SELECT * FROM history WHERE Transaction_id='$tr' AND Status != 'Paid' AND User = '$User'");
$row = mysqli_num_rows($result);
if($row != 0){
echo 9;
exit();
}

// checking if you have made posting for that date
$result = mysqli_query($con, "SELECT * FROM save WHERE Transaction_id='$tr' AND User = '$User' AND Status != 'Paid' AND Posting_Method = 'Basic Posting' 
ORDER BY id DESC LIMIT 1");
$row = mysqli_num_rows($result);
if($row != 0){
echo 4;
exit();
}


// checking if amount enter is greater than balance
if ($am > $bal){
echo 11;
exit();
}


if ($am == "0" && $am == "0"){
// do nothing
echo 13;
/// if only amount input are empty
}elseif ($am == "0") {
echo 14;
exit();
/*
// saving record
$query  = "INSERT INTO save (History_id,Virtual_Acct,Reps_id,Disbursement_No,Register_id,Repayment_id,Savings_id,Loan_Account_No,Transaction_id,Saving_Account,Firstname,Middlename,Lastname,Unions,Union_Code,
Loan_Amount,Savings,Duration,Frequency,Rate,Loan_Type,Product_id,Branch,Branch_Code,Status,User,User_id,Team_Leader,Officer_Name,Team_Name,Date_Paid,Time_Paid,Team_id,
Payment_Method,Posting_Method)
VALUES ('','$virtaul_acct','$id','$dis','$reg','$id','$rand','$ln','$tr','$sn','$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$sa','$du','$fr','$rt','$pr_name', '$pr_id', '$br_name','$br_id',
'Waiting For Approval', '$us', '$us_id', '$tm', '$ofn', '$tmn', '$d',  '$ss',  '$tim', 'Wema Bank', 'Basic Posting')";
$result = mysqli_query($con, $query);
if($result == true){
echo 15;
}else{
echo("Error description: " . mysqli_error($con));
}
*/
// if only saving input are empty
}elseif ($sa == "0") {
$query  = "INSERT INTO history (Session_id, Notification_id, Virtual_No, Rep_id, Disbursement_No, Register_id, Repayment_id, Loan_Account_No, Transaction_id,
Saving_Account_No, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch,
Branch_Code, Status, User, User_id, Team_Leader, Team_Name, Officer_Name, Date_Paid, Time_Paid, Team_id, Interest_Amt, Expected_Amount, Total_Loan, Location,
Balance, Phone, Payment_Method, Alert, Post_Method, Reciept_No, Reciept_Status, Posting_Status, Months, Years)
VALUES ('$sessionid', '$notid', '$virtual_acct', '$id', '$dis', '$reg', '$id', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$am', '0', '$du', 
'$fr', '$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', 'Waiting For Approval', '$us', '$us_id', '$tm', '$tmn', '$ofn', '$d', '$ss', '$tim', '$int_amt', 
'$exp_amt', '$total_loan', 'Invalid', '$nxt_bal', '$ph', 'Wema Bank', '$alert', 'Basic Posting', 'Invalid', 'Denied', 'Denied', '$mth', '$yrs')";
$result = mysqli_query($con, $query);
if($result == true){ 
echo 15;
}else{
echo("Error description: " . mysqli_error($con));
}

}else{
// if all input are correct
if (trim($_POST['am'] != "0") && trim($_POST['sa'] != "0")) {
$query  = "INSERT INTO history (Session_id, Notification_id, Virtual_No, Rep_id, Disbursement_No, Register_id, Repayment_id, Loan_Account_No, Transaction_id,
Saving_Account_No, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch,
Branch_Code, Status, User, User_id, Team_Leader, Team_Name, Officer_Name, Date_Paid, Time_Paid, Team_id, Interest_Amt, Expected_Amount, Total_Loan, Location,
Balance, Phone, Payment_Method, Alert, Post_Method, Reciept_No, Reciept_Status, Posting_Status, Months, Years)
VALUES ('$sessionid', '$notid', '$virtual_acct', '$id', '$dis', '$reg', '$id', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$am', '$sa',
'$du', '$fr', '$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', 'Waiting For Approval', '$us', '$us_id', '$tm', '$tmn', '$ofn', '$d', '$ss', '$tim', '$int_amt', 
'$exp_amt', '$total_loan', 'Invalid', '$nxt_bal', '$ph', 'Wema Bank', '$alert', 'Basic Posting', 'Invalid', 'Denied', 'Denied', '$mth', '$yrs')";
$result = mysqli_query($con, $query);
$last_id = mysqli_insert_id($con);// last insert id
// saving record
$query  = "INSERT INTO save (Session_No, History_id, Virtual_Acct, Reps_id, Disbursement_No, Register_id, Repayment_id, Savings_id, Loan_Account_No, Transaction_id, 
Saving_Account, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch, Branch_Code, 
Reciept, Status, User, User_id, Team_Leader, Officer_Name, Team_Name, Date_Paid, Time_Paid, Team_id, Payment_Method, Posting_Method, Months, Years)
VALUES ('$sessionid', '$last_id', '$virtaul_acct', '$id', '$dis', '$reg', '$id', '$rand', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$sa', '$du', '$fr', 
'$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', 'Paid With Repayment', 'Waiting For Approval', '$us', '$us_id', '$tm', '$ofn', '$tmn', '$d',  '$ss',  '$tim', 
'Wema Bank', 'Basic Posting', '$mth', '$yrs')";
$result = mysqli_query($con, $query);

if($result == true){
echo 15;
}else{
echo("Error description: " . mysqli_error($con));
}
}
}
mysqli_close($con);
?>