<?php
include '../config/db.php';
include '../config/user_session.php';
$id = $_POST['id']; // account id
$amt = $_POST['amt']; // amount to withdraw
$acct = $_POST['acct']; // account no
$actname = $_POST['actname']; // account name
$bnk = $_POST['bnk']; // bank name
$reason = $_POST['reason']; // reason for withdrawal
$balance = $_POST['bal']; // balance
$d = date('Y-m-d');
$s = date('h:m:sa');
$result = mysqli_query($con, "SELECT * FROM flexi_account WHERE id ='$id' ");
$row= mysqli_fetch_array($result);
$id = $row['id'];
$flexid = $row['Flexi_id'];
$lok = $row['Location'];
$fan = $row['Flexi_Account_No'];
$sur = $row['Surname'];
$fn = $row['Firstname'];
$other = $row['Othername'];
$fullx = $row['Surname']. " ".$row['Firstname']. " ".$row['Othername'];
$pl = $row['Plan'];
$fr = $row['Frequency'];
$int = $row['Interest'];
$du = $row['Duration'];
$br = $row['Branch'];
$brid = $row['Branch_id'];
$st = $row['Status'];
$ofn = $row['Officer_Name'];
$tn = $row['Team_Name'];
$tm = $row['Team_Leader'];
$sv = $row['Flexi_Account_No'];
$bl = $row['Total_Bal'];
$us = $row['User'];
$usd = $row['User_id'];
$dp = $row['Deposit_Amt'];
$ds = $row['Date_Start'];

//
$Query = "SELECT * FROM flexi_withdraw WHERE Flexi_Accounts = '$fan' AND Status != 'Paid'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}

//checking if amount is more than balance
if($amt > $balance){
echo 2;
exit();    
}
//inserting history
$sql = "INSERT INTO flexi_withdraw (Flexi_id, Flexi_Accounts, Name, Branch, Branch_id, Amount, Date_Withdraw, Time_Withdraw, Status, Officer_Name, User, User_id,
Team_Leader, Approved_By, Date_Approved, Payment_By, Bank, Account_Name, Account_No, Reason) 
VALUES ('$flexid', '$fan', '$fullx', '$br', '$brid', '$amt', '$d', '$s', 'Processing', '$ofn', '$us', '$usd', '$tm', 'Null', 'Null', 'Null', '$bnk', '$actname',
'$acct', '$reason')";
if (mysqli_query($con, $sql)) {
echo 3;
}else{
echo("Error description: " . mysqli_error($con));
}
?>