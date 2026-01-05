<?php
include '../config/db.php';
include '../config/user_session.php';

$d = date('Y-m-d');

// Validate that $_POST['id'] exists and is an array
if (!isset($_POST['id']) || !is_array($_POST['id'])) {
die('Invalid request');
}

foreach ($_POST['id'] as $id) {
// Sanitize input to prevent SQL injection
$id = mysqli_real_escape_string($con, $id);
// Fetch flexi history record
$result = mysqli_query($con, "SELECT id, Flexi_Account, Amount, Surname, Firstname, User, Date_Paid FROM flexi_history WHERE id = '$id'");
if (!$result || mysqli_num_rows($result) == 0) {
continue; // Skip if record not found
}
    
$row = mysqli_fetch_array($result);
$amt = $row['Amount'];
$name = $row['Surname'] . " " . $row['Firstname']; 
$acct = mysqli_real_escape_string($con, $row['Flexi_Account']);
$us = $row['User'];
$dp = $row['Date_Paid'];
  
// Update flexi_history status to 'Paid'
mysqli_query($con, "UPDATE flexi_history SET Status = 'Paid' WHERE id = '$id'");
  
// Get total paid deposits
$sql = "SELECT COALESCE(SUM(Amount), 0) AS lm FROM flexi_history WHERE Flexi_Account = '$acct' AND Status = 'Paid'";
$result = mysqli_query($con, $sql);
$flex = mysqli_fetch_assoc($result);
$pm = $flex['lm'];
    
// Get total paid withdrawals
$sql = "SELECT COALESCE(SUM(Amount), 0) AS lm FROM flexi_withdraw WHERE Flexi_Accounts = '$acct' AND Status = 'Paid'";
$result = mysqli_query($con, $sql);
$fles = mysqli_fetch_assoc($result);
$pmt = $fles['lm'];
    
// Calculate total balance
$tot = $pm - $pmt;
    
// Update flexi_account with new deposit amount and balance
mysqli_query($con, "UPDATE flexi_account SET Deposit_Amt = '$pm', Withdraw_Amt = '$pmt', Total_Bal = '$tot' WHERE Flexi_Account_No = '$acct' AND Status = 'Active'");
}

mysqli_close($con);
?>