<?php
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
foreach ($_POST['id'] as $id) {
$result = mysqli_query($con, "SELECT id, Amount, Savings, Firstname, Middlename, Lastname, Transaction_id, Repayment_id,
Saving_Account_No, User, Date_Paid FROM history WHERE id='$id'");
$row= mysqli_fetch_array($result);
$amt = $row['Amount'];
$name = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; 
$sav = $row['Savings'];
$tr = $row['Transaction_id'];
$rep_id = $row['Repayment_id'];
$sn = $row['Saving_Account_No'];
$fr = $row['Frequency'];
$us = $row['User'];
$dp = $row['Date_Paid'];// date paid
$d = date('Y-m-d');
$s = date('h-m-sa');
$mth = date('M');
$yrs = date('Y');
//
$result = mysqli_query($con, "UPDATE history SET Status = 'Paid' WHERE id = '$id'");
// updating payment
$result = mysqli_query($con, "UPDATE repayments SET Paid = Paid + $amt, Total_Bal = Total_Bal - $amt, Savings_Bal = Savings_Bal + $sav, Last_Amount = '$amt',
Transaction_Date = '$dp', Signed_Date = '$d' WHERE Transaction_id = '$tr' AND Status = 'Active'");
//
$result = mysqli_query($con, "UPDATE savings SET Balance = Balance + $sav, Last_Payment_Date = '$dp', Last_Amount = '$sav', Repayments_id = '$rep_id'  
WHERE Savings_Account_No = '$sn' AND User = '$us' AND Status = 'Active'");
//
$result = mysqli_query($con, "UPDATE save SET Status = 'Paid' WHERE History_id = '$id'");
// updating schedule
$result = mysqli_query($con, "UPDATE schedule SET Amount_Paid = '$amt', Savings = '$sav', Date_Paid = '$dp', Payment_Status = 'Paid', Payment_Method = 'Direct Method' 
WHERE Transaction_id = '$tr' AND Payment_Status = 'Outstanding' AND Expected_Date = '$dp' ORDER BY Expected_Date ASC LIMIT 1");
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>