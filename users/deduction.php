<?php
include '../config/db.php';
include '../config/user_session.php';
$savid = $_POST['sav']; // saving id
$regno = $_POST['regid']; // id
$amount = $_POST['amt']; // amount
//
$result = mysqli_query($con, "SELECT * FROM savings WHERE id ='$savid'");
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
$us = $row['User'];
$us_id = $row['User_id'];
$tm = $row['Team_Leader'];
$ofn = $row['Officer_Name'];
$tnm = $row['Team_Name'];
$br = $row['Branch'];
$br_id = $row['Branch_id'];
$tm_id = $row['Team_id'];
$d = date('Y-m-d');
$ss = date('H:m:sa');
//getting balance 
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status = 'Paid' AND Saving_Account = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status = 'Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status = 'Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status = 'Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status = 'Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status = 'Paid' AND Reciever_Account = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];

// getting total balance
$balance = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;
//
if($amount > $balance){
echo 1;
exit();
}else{
//

$sql = "INSERT INTO saving_upfront (Reg_id, Loan_Account_No, Saving_Account_No, Transaction_id, Firstname, Middlename, Lastname, Unions, Union_id,
Loan_Amount, Amount, User, User_id, Team_Leader, Officer_Name, Team_Name, Branch, Branch_id, Product, Product_id, Team_id, Status, Date_Sent, New_Reg) 
VALUES ('$reg_id', '$lon', '$sa', '$tr', '$fn', '$md', '$ln', '$un', '$un_id', 'NA', '$amount', '$us', '$us_id', '$tm', '$ofn', '$tnm', '$br', '$br_id', 'NA', 'NA', 
'$tm_id', 'Paid', '$d', '$regno')";
$result = mysqli_query($con, $sql);
//
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status = 'Paid' AND Saving_Account = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status = 'Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status = 'Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status = 'Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status = 'Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status = 'Paid' AND Reciever_Account = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];

// getting total balance
$bal = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;
$Query = "UPDATE repayments SET Savings_Bal = '$bal' WHERE Savings_Account_No = '$sa'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE savings SET Savings_Paid = '$pmd', Balance = '$bal', Withdraw_Savings = '$pmw', Savings_Repayment = '$pmr', Savings_Transfer = '$pmtr', 
Savings_Upfront = '$pmu', Savings_Recieved = '$pmc' WHERE Savings_Account_No = '$sa'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE fee SET Reciept_Status = 'Reciept Confirmed', Payment_Method = 'Saving For Upfront' WHERE Reg_id = '$regno'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE register SET Upfront_Status = 'Paid', Reciever_Name = '$na', Date_Paid = '$d', Time_Paid = '$ss' WHERE id = '$regno'";
$result= mysqli_query($con, $Query);
if ($result == true) {
echo 2;
}else {
echo("Error description: " . mysqli_error($con));
}

}
?>
