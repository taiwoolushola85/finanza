<?php
include '../config/db.php';
include '../config/user_session.php';
$id =$_POST['id'];
$re =$_POST['re']; //  reason
$result = mysqli_query($con, "SELECT * FROM repayments WHERE id='$id'");
$row= mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$dis = $row['Disbursement_No'];
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
$pd = $row['Paid'];
$sin = $row['Total_Bal'];
$dd = $row['Date_Disbursed'];
$sb = $row['Savings_Bal'];

$d = date('Y-m-d');
$s = date('H:m:sa');
$Query = "SELECT * FROM other_request WHERE Reg_id = '$reg_id' AND Status != 'Approved'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}else{
$sql = "INSERT INTO other_request (Reg_id, Firstname, Middlename, Lastname, Branch, Sender, Date_Request, Request_Type, Status, Approved_By, Reason, Officer_Name, 
Team_Name) VALUES ('$reg_id', '$fn', '$md', '$ln', '$br', '$na', '$d', 'Close Loan Account', 'Waiting For Approval', '', '$re', '$ofn', '$tnm')";
$result = mysqli_query($con, $sql);
$last_id = mysqli_insert_id($con);// last insert id
//
$sql = "INSERT INTO loan_cancel (Request_id, Disbursement_No, Reg_id, Firstname, Middlename, Lastname, Branch, Product, Unions, Union_id, Loan_Amount, Paid, Balance, 
Savings_Bal, Start_Date, Requested_By, Date_Cancelled, Reason, Officer_Name, Team_Name, Status, Loan_Account_No, Transaction_id, Savings_Account_No, User_id, 
Team_id, User, Team_Leader) VALUES ('$last_id', '$dis', '$reg_id', '$fn', '$md', '$ln', '$br', '$pr', '$un', '$un_id', '$la', '$pd', '$sin', '$sb', '$dd', '$na', '$d', '$re',
'$ofn', '$tnm', 'Waiting For Approval', '$lon', '$tr', '$sa', '$us_id', '$tm_id', '$us', '$tm')";
$result = mysqli_query($con, $sql);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>