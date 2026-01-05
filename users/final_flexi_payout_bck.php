<?php
//updating loan officer in union
include('../config/db.php') ;
include '../config/user_session.php';
$id = $_POST['id'];
//
$amt_query = "SELECT Amount, Flexi_Accounts FROM flexi_withdraw WHERE id = '$id'";
$amt_result = mysqli_query($con, $amt_query);
$amt_row = mysqli_fetch_array($amt_result);
$amt = $amt_row['Amount'];
//deduct from flexi account
$acct = $amt_row['Flexi_Accounts'];// get flexi account number
//
$Query = "UPDATE flexi_withdraw SET Status = 'Paid', Payment_By = '$na' WHERE id = '$id'";
$result = mysqli_query($con, $Query);
//get saving balance
//
$sql = "SELECT COALESCE(SUM(Amount), 0) AS lm FROM flexi_history WHERE Flexi_Account = '$acct' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$flex = mysqli_fetch_assoc($result);
$pm = $flex['lm'];
//
$sql = "SELECT COALESCE(SUM(Amount), 0) AS lm FROM flexi_withdraw WHERE Flexi_Accounts = '$acct' AND Status = 'Paid'";
$result=mysqli_query($con,$sql);
$fles = mysqli_fetch_assoc($result);
$pmt = $fles['lm'];

$tot = $pm - $pmt;

$Query = "UPDATE flexi_account SET Deposit_Amt = '$pm', Withdraw_Amt = '$pmt', Total_Bal = '$tot' WHERE Flexi_Account_No = '$acct'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>