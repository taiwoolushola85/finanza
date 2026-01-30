<?php
// Database configuration
include '../config/db.php';
include '../config/user_session.php';
$not_id = str_replace( array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['notid']);// notification id
$amt = str_replace( array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['amt']);// amount
$sav = str_replace( array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['sav']);// active saving account
$mth = date('M');
$yrs = date('Y');
//
$result = mysqli_query($con, "SELECT * FROM repayments WHERE Savings_Account_No ='$sav'");
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
$int_amt = round($row['Interest_Amt']/$row['Duration']);
$reg = $row['Reg_id'];
$total_loan = $row['Total_Loan'];
$bal = $row['Total_Bal'];// balance
$ph = $row['Phone'];
$alert = $row['Alert'];
$maturity = $row['Maturity_Date'];
$d = date('Y-m-d');
$ss = date('h:m:sa');
$rand = rand();
$ran = uniqid();
/*
// checking if you have made posting for that date
$result = mysqli_query($con, "SELECT * FROM save WHERE Transaction_id='$tr' AND Status = 'Paid' AND Date_Paid = '$d' ORDER BY id DESC LIMIT 1");
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
*/
// saving record
$query  = "INSERT INTO save (History_id, Virtual_Acct, Reps_id, Disbursement_No, Register_id, Repayment_id, Savings_id, Loan_Account_No, Transaction_id, 
Saving_Account, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch, Branch_Code, 
Reciept, Status, User, User_id, Team_Leader, Officer_Name, Team_Name, Date_Paid, Time_Paid, Team_id, Payment_Method, Posting_Method, Months, Years)
VALUES ('$not_id', '$virtaul_acct', '$id', '$dis', '$reg', '$id', '$rand', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$amt', '$du', '$fr',
'$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', 'Paid With Repayment', 'Paid', '$us', '$us_id', '$tm', '$ofn', '$tmn', '$d',  '$ss',  '$tim', 'Wema Bank', 
'Virtual Posting', '$mth', '$yrs')";
$result = mysqli_query($con, $query);
if($result == true){
//updating repayments
$result = mysqli_query($con, "UPDATE repayments SET Savings_Bal = Savings_Bal + $amt WHERE Transaction_id='$tr'");
// updating saving
$result = mysqli_query($con, "UPDATE savings SET Balance = Balance + $amt, Last_Payment_Date = '$d', Last_Amount = '$amt', Repayments_id = '$id'  
WHERE Savings_Account_No = '$sav' AND Status = 'Active'");
// updating notification status
$Query = "UPDATE nip_notifications SET Status = 'Notification Used' WHERE id ='$not_id' ";
$result = mysqli_query($con, $Query);
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>