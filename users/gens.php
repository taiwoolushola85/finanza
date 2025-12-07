<?php 
include '../config/db.php';
$id = $_GET['id'];
$Query = "SELECT id,Savings_Account_No,Balance,Loan_Account_No FROM savings WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];
$sv = $row['Savings_Account_No'];
$lon = $row['Loan_Account_No'];
$bl = $row['Balance'];
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status ='Paid' AND Saving_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status ='Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status ='Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status ='Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status ='Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status ='Paid' AND Reciever_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$bal = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;
if($bal == $bl){
// do nothing
}else{
//updating saving balance
$Query = "UPDATE repayments SET Savings_Bal = '$bal' WHERE Savings_Account_No = '$sv'";
$result= mysqli_query($con, $Query);
//updating savings balance
$Query = "UPDATE savings SET Balance = '$bal' WHERE Savings_Account_No = '$sv'";
$result= mysqli_query($con, $Query);
}
?>