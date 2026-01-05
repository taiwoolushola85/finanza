<?php
include '../config/db.php';
$id = $_POST['id'];
//
$Query = "SELECT id, Saving_Account_No FROM saving_rep WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];
$sv = $row['Saving_Account_No'];
//
$Query = "DELETE FROM saving_rep WHERE id='$id'";
$result = mysqli_query($con, $Query);
//
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status = 'Paid' AND Saving_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status = 'Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status = 'Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status = 'Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status = 'Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status = 'Paid' AND Reciever_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$bal = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;

$Query = "UPDATE repayments SET Savings_Bal = '$bal' WHERE Savings_Account_No = '$sv'";
$result= mysqli_query($con, $Query);
$Query = "UPDATE savings SET Savings_Paid = '$pmd', Balance = '$bal', Withdraw_Savings = '$pmw', Savings_Repayment = '$pmr', Savings_Transfer = '$pmtr', 
Savings_Upfront = '$pmu', Savings_Recieved = '$pmc' WHERE Savings_Account_No = '$sv'";
$result= mysqli_query($con, $Query);

if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>