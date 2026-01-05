<?php
//if the add button has been clicked
include('../config/db.php') ;
include '../config/user_session.php';
$id = $_POST['id']; // id of the application
$deposit = $_POST['deposit']; // deposit amount
$path = $_POST['reciept']; // path of the reciept image
$reci = "Invalid";// refrence number
$d = date('Y-m-d');
$s = date('h:m:sa');
$Query = "SELECT * FROM flexi_reg WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$flexid = $row['id'];
$lok = $row['Location'];
$sur = $row['Surname'];
$fn = $row['Firstname'];
$other = $row['Othername'];
$bv = $row['Client_BVN'];
$pl = $row['Plan'];
$plid = $row['Plan_id'];
$fr = $row['Frequency'];
$int = $row['Interest'];
$du = $row['Duration'];
$br = $row['Branch'];
$brid = $row['Branch_Code'];
$ofn = $row['Officer_Name'];
$tm = $row['Team_Leader'];
$tn = $row['Team_Name'];
$us = $row['User'];
$usd = $row['User_id'];
$tmid = $row['Team_id'];

// creating flexi account
$query  = "INSERT INTO flexi_account (Flexi_id, Flexi_Account_No, Surname, Firstname, Othername, Plan, Branch, Branch_id, Frequency, Duration, Interest, Deposit_Amt, 
Withdraw_Amt, Total_Bal, Date_Start, Status, Location, User, User_id, Team_Leader, Officer_Name, Team_Name, Team_id, BVN, Payment_Status, Roll_over)
VALUES ('$flexid', '100$flexid', '$sur', '$fn', '$other', '$pl', '$br', '$brid', '$fr', '$du', '0', '$deposit', '0', '$deposit', '$d', 'Active', '$lok', '$us', 
'$usd', '$tm', '$ofn', '$tn', '$tmid', '$bv', 'Active', 'NA')";
$result = mysqli_query($con, $query);
// Deposit first payment
$query = "INSERT INTO flexi_history (Flexi_Reg, Flexi_Account, Surname, Firstname, Othername, Branch, Branch_No, Plan, Amount, User, User_id, Officer_Name, 
Team_Leader, Team_Name, Status, Date_Paid, Time_Paid, Payment_Method, Location,  Posting_Method) 
VALUES ('$flexid', '100$flexid', '$sur', '$fn', '$other', '$br', '$brid', '$pl', '$deposit', '$us', '$usd', '$ofn', '$tm', '$tn', 'Paid', '$d', '$s', 'Monie Point',
'$path', 'System Posting')";
$result = mysqli_query($con, $query);
// updating  info
$Query = "UPDATE flexi_reg SET Status = 'Active' WHERE id='$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>