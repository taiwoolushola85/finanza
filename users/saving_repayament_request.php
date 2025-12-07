<?php
include '../config/db.php';
$r_id = $_POST['id']; // user id
$sav = $_POST['sav']; // savings account no
$amt = $_POST['amt']; //  amount to withdraw
$acct = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['acct']);// client active loan no for the reciever
$bl = round($_POST['bl']); //  savings bal
$loan = $_POST['ln']; //  client sender loan account no
// details of the loan account holder to recieves savings as repayments [reciever]
$result = mysqli_query($con, "SELECT * FROM repayments WHERE Loan_Account_No = '$acct'");
$row= mysqli_fetch_array($result);
$rep_id = $row['id'];
$regis_id = $row['Reg_id'];
$loan_acct = $row['Loan_Account_No'];
$sact = $row['Savings_Account_No'];
$tran = $row['Transaction_id'];
$frt = $row['Firstname'];
$mid = $row['Middlename'];
$las = $row['Lastname'];
$uns = $row['Unions'];
$uns_id = $row['Union_id'];
$loan_amt = $row['Total_Loan'];
$loan_bal = $row['Total_Bal'];
$usr = $row['User'];
$usr_id = $row['User_id'];
$tem = $row['Team_Leader'];
$offn = $row['Officer_Name'];
$tnem = $row['Team_Name'];
$brb = $row['Branch'];
$brb_id = $row['Branch_id'];
$prt = $row['Product'];
$prt_id = $row['Product_id'];
$tem_id = $row['Team_id'];

/// details of the savings account holder [sender]
$result = mysqli_query($con, "SELECT * FROM repayments WHERE Loan_Account_No = '$loan'");
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
$d = date('Y-m-d');
// check if loan account is active
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$acct' AND Status = 'Closed'";
$result = mysqli_query($con, $Query);
$rowk = mysqli_num_rows($result);
if($rowk != 0){
echo 9;
exit();
}
// if loan acct entered is invalid
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$acct'";
$result = mysqli_query($con, $Query);
$invalid = mysqli_num_rows($result);
if($invalid == 0){
echo 3;
exit();
}
// avoid double insert
$Query = "SELECT * FROM saving_rep WHERE Saving_Account_No = '$sav' AND Status != 'Paid'";
$result = mysqli_query($con, $Query);
$counts = mysqli_num_rows($result);
if($counts != 0){
echo 6;
exit();
}

if($amt > $bl){
echo 1;
exit();
} 
if($amt == 0){
echo 2;
exit();
} 
//
$sql = "INSERT INTO `saving_rep` (`Reg_id`,`Loan_Account_No`,`Saving_Account_No`,`Transaction_id`,`Firstname`,`Middlename`,`Lastname`,`Unions`,`Union_id`,`Loan_Amount`,
`Amount`,`User`,`User_id`,`Team_Leader`,`Officer_Name`,`Team_Name`,`Branch`,`Branch_id`,`Product`,`Product_id`,`Team_id`,`Status`,`Date_Sent`,`Repayment_id`,`Reciever_Loan_No`,
`Reciever_Transaction_id`,`Reciever_Savings_No`,`Reciever_Reg_id`,`Receiver_Total_Loan`,`Reciever_Balance`) 
VALUES ('$reg_id','$lon','$sa','$tr','$fn','$md','$ln','$un','$un_id','$la','$amt','$us','$us_id','$tm','$ofn','$tnm','$br','$br_id','$pr','$pr_id','$tm_id',
'Processing','$d','$rep_id','$loan_acct','$tran','$sact','$regis_id','$loan_amt','$loan_bal')";
$result = mysqli_query($con, $sql);
if ($result == true) {
echo 4;
}else {
echo("Error description: " . mysqli_error($con));
exit();
}
?>
