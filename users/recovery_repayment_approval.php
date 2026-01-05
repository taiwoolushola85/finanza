<?php
include '../config/db.php';
$d = date('Y-m-d');
$rowCount = count($_POST["id"]);
for($i=0;$i<$rowCount;$i++) {
$id = $_POST["id"][$i] ;
$result = mysqli_query($con, "SELECT * FROM recover WHERE id='" . $_POST["id"][$i] . "'");
$row[$i]= mysqli_fetch_array($result);
$idd = $row[$i]['id'];
$repno = $row[$i]['Repayment_No'];
$reg = $row[$i]['Reg_id'];
$amt = $row[$i]['Amount'];
$dis = $row[$i]['Disbursement_No'];
$ln = $row[$i]['Loan_Account_No'];
$sn = $row[$i]['Saving_Account_No'];
$tran = $row[$i]['Transaction_id'];
$dp = $row[$i]['Date_Pay'];
$tix = $row[$i]['Time_Pay'];
$pm = $row[$i]['Payment_Method'];
$location = $row[$i]['Reciept'];
$us = $row[$i]['User'];
$usid = $row[$i]['User_id'];
$rand = rand();
// selecting repayments info
$result = mysqli_query($con, "SELECT * FROM repayments WHERE id ='$repno'");
$row[$i]= mysqli_fetch_array($result);
$idx = $row[$i]['id'];
$vrt = $row[$i]['Account_Number'];
$dis = $row[$i]['Disbursement_No'];
$tr = $row[$i]['Transaction_id'];
$ln = $row[$i]['Loan_Account_No'];
$sn = $row[$i]['Savings_Account_No'];
$fn = $row[$i]['Firstname'];
$md = $row[$i]['Middlename'];
$lnm = $row[$i]['Lastname'];
$fll = $fn." ". $md. " ". $lnm;
$un = $row[$i]['Unions'];
$cu_id = $row[$i]['Union_id'];
$pr_name = $row[$i]['Product'];
$pr_id = $row[$i]['Product_id'];
$tm = $row[$i]['Team_Leader'];
$ofn = $row[$i]['Officer_Name'];
$tmn = $row[$i]['Team_Name'];
$br_name = $row[$i]['Branch'];
$br_id = $row[$i]['Branch_id'];
$la = $row[$i]['Loan_Amount'];
$fr = $row[$i]['Frequency'];
$rt = $row[$i]['Rate'];
$du = $row[$i]['Duration'];
$tim = $row[$i]['Team_id'];
$exp_amt = $row[$i]['Expected_Amount'];
$int_amt = $row[$i]['Interest_Amt'];
$reg = $row[$i]['Reg_id'];
$total_loan = $row[$i]['Total_Loan'];
$bal = $row[$i]['Total_Bal'];// balance
$ph = $row[$i]['Phone'];
$alert = $row[$i]['Alert'];
$d = date('Y-m-d');
$ss = date ('h:m:sa');
$mth = date ('M');
$yrs = date ('Y');
$rand = rand();


// updating recover table
$sql = "UPDATE recover SET Status = 'Paid', Approved_By = '$na' WHERE id='$id'";
$result = mysqli_query($con, $sql);

// updating payment
$sql ="UPDATE repayments SET Paid = Paid + $amt, Total_Bal = Total_Bal - $amt, Signed_Date = '$d', Last_Amount = '$amt', Transaction_Date = '$d'
WHERE id = '$repno'";
$result = mysqli_query($con, $sql);
// inserting history
$query  = "INSERT INTO history (Session_id, Notification_id, Rep_id, Virtual_No, Disbursement_No, Register_id, Repayment_id, Loan_Account_No, Transaction_id, 
Saving_Account_No, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch,
Branch_Code, Status, User, User_id, Team_Leader, Team_Name, Officer_Name, Date_Paid, Time_Paid, Team_id, Interest_Amt, Expected_Amount, Total_Loan, Location, 
Balance, Phone, Payment_Method, Alert, Post_Method, Reciept_No, Reciept_Status, Posting_Status, Months, Years)
VALUES ('NA', 'NA', '$repno', '$vrt', '$dis', '$reg', '$idx', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$amt', '0', '$du', '$fr', '$rt',
'$pr_name', '$pr_id', '$br_name', '$br_id', 'Paid', '$us', '$usid', '$tm', '$tmn', '$ofn', '$dp', '$tix', '$tim', '$int_amt', '$exp_amt', '$total_loan', '$location',
'$bal', '$ph', '$pm', '$alert', 'Recovery Posting', 'No Reciept', 'NA', 'Successfull', '$mth', '$yrs')";
$result = mysqli_query($con, $query);
// update schedule table
$result = mysqli_query($con, "UPDATE schedule SET Amount_Paid = '$amt', Savings = '0', Date_Paid='$dp', Payment_Status = 'Paid', Payment_Method = 'Recovery Method' 
WHERE Regs_id = '$reg' AND Payment_Status = 'Outstanding' ORDER BY id ASC LIMIT 1");

if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}

?>