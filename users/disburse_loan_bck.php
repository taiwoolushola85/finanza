<?php
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST["id"]);// id
$dn = trim($_POST["dis"]);// disbursement no
$lon = trim($_POST["lon"]);// saving account no
$clbv  = trim($_POST['bv']);// Client BNV no
$sku  = trim($_POST['vrt']);// virtual acct
//$sku  = trim($_POST["sku"]);// Client virtual account
$result = mysqli_query($con, "SELECT * FROM register WHERE id='$id'");
$row= mysqli_fetch_array($result);
$regid = $row['id']; // client registration id and also Loan Account number 
$fn = $row['Firstname']; 
$md = $row['Middlename']; 
$ln = $row['Lastname']; 
$name = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; 
$la = $row['Loan_Amount']; 
$br = $row['Branch']; 
$br_id = $row['Branch_id']; 
$lo = $row['Location']; 
$un = $row['Unions']; 
$bv = $row['BVN']; 
$client_type = $row['Loan_Status']; 
$rat = $row['Rate']; 
$ph = $row['Phone']; 
$em = $row['Education']; 
$dur = $row['Frequency'];// weekly
$ad = $row['Address']; 
$un_id = $row['Union_id']; 
$pr = $row['Product']; 
$pr_id = $row['Product_id']; 
$us = $row['User']; 
$user_id = $row['User_id']; 
$tl = $row['Team_Leader']; 
$of = $row['Officer_Name']; 
$tn = $row['Team_Name']; 
$ten = $row['Tenure']; // duration
$rt = $row['Rate']; 
$up = $row['Upfront']; 
$gn = $row['Gender']; 
$under = $row['Underwriter']; 
$tms_id = $row['Team_id']; 
$inter = $row['Interest_Amt']; 
$dg_reg = $row['Date_Reg']; 
$bnk = $row['Bank']; 
$act = $row['Account_No']; 
$act_na = $row['Account_Name']; 
$ttn = $row['Total_Loan']; 
$bu = $row['Business']; 
$rep_amt = $row['Repayment_Amt']; 
$map_id = $row['Map_id']; 
$repayment_day = $row['Repayment_Day']; //repayment day
$int = $row['Interest_Amt']; // interest amt
$re_am = $row['Repayment_Amt']; /// repayment amt 
$tll = $row['Total_Loan']; // total loan
$loanamt = number_format($row['Loan_Amount'],2); 
$d = date('Y-m-d');
$s = date('h:m:sa');
$rand = rand(10, 100000000);
$mth = date('M');
$yrs = date('Y');
$kl = number_format($ttn,2);// total loan to sms
$k_int = number_format($int,2);
$k_rep = number_format($rep_amt,2);
$loan_amount = number_format($la,2);
// CHECK IF DISBURSEMENT NO ALREADY EXIST
$Query = "SELECT Disbursement_No FROM repayments WHERE Disbursement_No = '$dn' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
// checking if loan account already exist
$Query = "SELECT Loan_Account_No FROM repayments WHERE Loan_Account_No = '$lon' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 2;
exit();
}

//
$Query = "SELECT * FROM repayments WHERE Reg_id = '$id' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 3;
exit();
}
?>

<?php 
if($client_type == 'New Client'){
?>

<?php
if($dur == 'Daily'){
//
$result = mysqli_query($con, "UPDATE register SET Disbursed_By = '$na', Date_Disbursed = '$d', Status = 'Disbursed' WHERE id = '$id' ");
// maturity date
$result = mysqli_query($con, "SELECT Expected_Date FROM schedule WHERE Regs_id = '$id' ORDER BY id DESC LIMIT 1");
$row= mysqli_fetch_array($result);
$def = $row['Expected_Date'];
//
$result = mysqli_query($con, "SELECT Expected_Date FROM schedule WHERE Regs_id = '$id' AND Payment_Status = 0 ORDER BY id ASC LIMIT 1");
$row= mysqli_fetch_array($result);
$pay = $row['Expected_Date'];
//updating loan schedule
$result = mysqli_query($con, "UPDATE schedule SET Disbursement_No = '$dn', Status = 'Disbursed', Transaction_id = '1010$id', Loan_Account_No = '$lon', 
Savings_Account_No = '2000$id' WHERE Regs_id = '$id' ");

// inserting for repayments
$query = "INSERT INTO repayments (Account_Number, Disbursement_No, Firstname, Middlename, Lastname, Phone, Gender, Transaction_id, Loan_Account_No, Savings_Account_No,
Loan_Amount, Unions, Union_id, Product, Frequency, Product_id, BVN, Rate, Duration, User, User_id, Team_Leader, Branch, Branch_id, Approved_By, Date_Disbursed, 
Time_Disbursed, Officer_Name, Team_Name, Status, Transaction_Date, Last_Amount, Location, Months, Reg_id, Expected_Amount, Interest_Amt, Paid, Savings_Bal, Total_Bal,
Underwiter, Disbursed_By, Team_id, Maturity_Date, Date_Reg, Total_Loan, Next_Payment_Date, Map_id, Maturity_Status, Recovery_Status, Alert, Years, Client_Type, Repayment_Day)
VALUE('$sku', '$dn', '$fn', '$md', '$ln', '$ph', '$gn', '1010$id', '$lon', '2000$id', '$la', '$un', '$un_id', '$pr', '$dur', '$pr_id', '$bv', '$rat',
'$ten', '$us', '$user_id', '$tl', '$br', '$br_id', '$na', '$d', '$s', '$of', '$tn', 'Active', '$d', '0', '$lo', '$mth', '$id', '$re_am', '$int', '0', '0', '$tll',
'$under', '$na', '$tms_id', '$def', '$dg_reg', '$ttn', '$pay', '$map_id', 'Runing', 'No', 'Enabled', '$yrs', '$client_type', '$repayment_day')";
$result = mysqli_query($con, $query);
$last_id = mysqli_insert_id($con);

// inserting savings info
$result = mysqli_query($con, "INSERT INTO savings (Repayments_id, Virtual_Account, Disbursement_No, Transaction_id, Loan_Account_No, Savings_Account_No, Firstname,
Middlename, Lastname, Gender, Loan_Amount, Unions, Union_id, Savings_Paid, Phone, Address, User, User_id, Team_Leader, Officer_Name, Team_Name, Branch, Branch_id, 
Date_Opend, Time_Open, Status, Reg_id, Team_id, Withdraw_Savings, Savings_Repayment, Savings_Transfer, Savings_Upfront, Savings_Recieved, Balance, Client_BVN, 
Closed_By, Last_Payment_Date, Last_Amount, Product, Frequency, Duration, Map_id, Product_id)
VALUE('$last_id', '$sku', '$dn', '1010$id', '$lon', '2000$id', '$fn', '$md', '$ln', '$gn', '$la', '$un', '$un_id', '0', '$ph', '$ad', '$us', '$user_id', 
'$tl', '$of', '$tn', '$br', '$br_id', '$d', '$s', 'Active', '$id', '$tms_id', '0', '0', '0', '0', '0', '0', '$bv', 'Null', '$d', '0', '$pr', '$dur', '$ten', 
'$map_id', '$pr_id')");

// statment of account
$sql = "INSERT INTO bank_account (Ref_No, Transaction_Type, Description, Opening_Balance, Debit, Credit, Transaction_By, Status, Months, Years, TNX_Date, TNX_Time) 
VALUES ('$last_id', 'DR', 'Loan disbursement from Market Moni Limited to $name', '-', '$la', '-',  '$na', 'Successfull', '$mth', '$yrs', '$d', '$s')";
$result= mysqli_query($con, $sql);

if($result == true){
echo 4;
}else{
echo("Error description: " . mysqli_error($con));
}



}else{
// new client weekly or months
$result = mysqli_query($con, "UPDATE register SET Disbursed_By = '$na', Status = 'Disbursed' WHERE id = '$id' ");
// maturity date
$result = mysqli_query($con, "SELECT * FROM schedule WHERE Regs_id = '$id' ORDER BY id DESC LIMIT 1");
$row= mysqli_fetch_array($result);
$def = $row['Expected_Date'];

//
$result = mysqli_query($con, "SELECT Expected_Date FROM schedule WHERE Regs_id = '$id' AND Payment_Status = 0 ORDER BY id ASC LIMIT 1");
$row= mysqli_fetch_array($result);
$pay = $row['Expected_Date'];

//updating loan schedule
$result = mysqli_query($con, "UPDATE schedule SET Disbursement_No = '$dn', Status = 'Disbursed', Transaction_id = '1010$id', Loan_Account_No = '$lon', 
Savings_Account_No = '2000$id' WHERE Regs_id = '$id' ");

// inserting for repayments
$query = "INSERT INTO repayments (Account_Number, Disbursement_No, Firstname, Middlename, Lastname, Phone, Gender, Transaction_id, Loan_Account_No, Savings_Account_No,
Loan_Amount, Unions, Union_id, Product, Frequency, Product_id, BVN, Rate, Duration, User, User_id, Team_Leader, Branch, Branch_id, Approved_By, Date_Disbursed, 
Time_Disbursed, Officer_Name, Team_Name, Status, Transaction_Date, Last_Amount, Location, Months, Reg_id, Expected_Amount, Interest_Amt, Paid, Savings_Bal, Total_Bal,
Underwiter, Disbursed_By, Team_id, Maturity_Date, Date_Reg, Total_Loan, Next_Payment_Date, Map_id, Maturity_Status, Recovery_Status, Alert, Years, Client_Type, Repayment_Day)
VALUE('$sku', '$dn', '$fn', '$md', '$ln', '$ph', '$gn', '1010$id', '$lon', '2000$id', '$la', '$un', '$un_id', '$pr', '$dur', '$pr_id', '$bv', '$rat',
'$ten', '$us', '$user_id', '$tl', '$br', '$br_id', '$na', '$d', '$s', '$of', '$tn', 'Active', '$d', '0', '$lo', '$mth', '$id', '$re_am', '$int', '0', '0', '$tll',
'$under', '$na', '$tms_id', '$def', '$dg_reg', '$ttn', '$pay', '$map_id', 'Runing', 'No', 'Enabled', '$yrs', '$client_type', '$repayment_day')";
$result = mysqli_query($con, $query);
$last_id = mysqli_insert_id($con);

// inserting savings info
$result = mysqli_query($con, "INSERT INTO savings (Repayments_id, Virtual_Account, Disbursement_No, Transaction_id, Loan_Account_No, Savings_Account_No, Firstname,
Middlename, Lastname, Gender, Loan_Amount, Unions, Union_id, Savings_Paid, Phone, Address, User, User_id, Team_Leader, Officer_Name, Team_Name, Branch, Branch_id,
Date_Opend, Time_Open, Status, Reg_id, Team_id, Withdraw_Savings, Savings_Repayment, Savings_Transfer, Savings_Upfront, Savings_Recieved, Balance, Client_BVN, 
Closed_By, Last_Payment_Date, Last_Amount, Product, Frequency, Duration, Map_id, Product_id)
VALUE('$last_id', '$sku', '$dn', '1010$id', '$lon', '2000$id', '$fn', '$md', '$ln', '$gn', '$la', '$un', '$un_id', '$up', '$ph', '$ad', '$us', '$user_id', 
'$tl', '$of', '$tn', '$br', '$br_id', '$d', '$s', 'Active', '$id', '$tms_id', '0', '0', '0', '0', '0', '$up', '$bv', 'Null', '$d', '$up', '$pr', '$dur', '$ten', 
'$map_id', '$pr_id')");

// deposit for savings
$result = mysqli_query($con, "INSERT INTO save (Session_No, History_id, Reps_id, Virtual_Acct, Disbursement_No, Register_id, Repayment_id, Savings_id, 
Loan_Account_No, Transaction_id, Saving_Account, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Savings, Duration, Frequency, Rate, 
Loan_Type, Product_id, Branch, Branch_Code, Status, User, User_id, Team_Leader, Officer_Name, Team_Name, Date_Paid, Time_Paid, Team_id, Payment_Method, 
Posting_Method, Months, Years)
VALUE('NA','$last_id', '$last_id', '$sku', '$dn', '$id', '$last_id', '$id$id', '$lon', '1010$id', '2000$id', '$fn', '$md', '$ln', '$un', '$un_id', '$la', '$up', 
'$ten', '$dur', '$rt', '$pr', '$pr_id', '$br', '$br_id', 'Paid', '$us', '$user_id', '$tl', '$of', '$tn', '$d', '$s', '$tms_id', 'System Payment', 'Initial Deposit',
'$mth', '$yrs')");

// statment of account
$sql = "INSERT INTO bank_account (Ref_No, Transaction_Type, Description, Opening_Balance, Debit, Credit, Transaction_By, Status, Months, Years, TNX_Date, TNX_Time) 
VALUES ('$last_id', 'DR', 'Loan disbursement from Market Moni Limited to $name', '-', '$la', '-',  '$na', 'Successfull', '$mth', '$yrs', '$d', '$s')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 4;
}else{
echo("Error description: " . mysqli_error($con));
}

}
?>



<?php 
}else{

    
if($dur == 'Daily'){

// existing client daily
$result = mysqli_query($con, "UPDATE register SET Disbursed_By = '$na', Status = 'Disbursed' WHERE id ='$id' ");
// maturity date
$result = mysqli_query($con, "SELECT * FROM schedule WHERE Regs_id = '$id' ORDER BY id DESC LIMIT 1");
$row= mysqli_fetch_array($result);
$def = $row['Expected_Date'];

//
$result = mysqli_query($con, "SELECT Expected_Date FROM schedule WHERE Regs_id = '$id' AND Payment_Status = 0 ORDER BY id ASC LIMIT 1");
$row= mysqli_fetch_array($result);
$pay = $row['Expected_Date'];

//updating loan schedule
$result = mysqli_query($con, "UPDATE schedule SET Disbursement_No = '$dn', Status = 'Disbursed', Transaction_id = '1010$id', Loan_Account_No = '$lon', 
Savings_Account_No = '2000$id' WHERE Regs_id = '$id' ");

//getting the old saving account
$result = mysqli_query($con, "SELECT id, Client_BVN, Savings_Account_No FROM savings WHERE Client_BVN = '$clbv' ORDER BY id DESC LIMIT 1");
$row= mysqli_fetch_array($result);
$saving_id = $row['id'];
$sva = $row['Savings_Account_No'];

// inserting for repayments
$query = "INSERT INTO repayments (Account_Number, Disbursement_No, Firstname, Middlename, Lastname, Phone, Gender, Transaction_id, Loan_Account_No, Savings_Account_No,
Loan_Amount, Unions, Union_id, Product, Frequency, Product_id, BVN, Rate, Duration, User, User_id, Team_Leader, Branch, Branch_id, Approved_By, Date_Disbursed, 
Time_Disbursed, Officer_Name, Team_Name, Status, Transaction_Date, Last_Amount, Location, Months, Reg_id, Expected_Amount, Interest_Amt, Paid, Savings_Bal, Total_Bal,
Underwiter, Disbursed_By, Team_id, Maturity_Date, Date_Reg, Total_Loan, Next_Payment_Date, Map_id, Maturity_Status, Recovery_Status, Alert, Years, Client_Type, Repayment_Day)
VALUE('$sku', '$dn', '$fn', '$md', '$ln', '$ph', '$gn', '1010$id', '$lon', '$sva', '$la', '$un', '$un_id', '$pr', '$dur', '$pr_id', '$bv', '$rat',
'$ten', '$us', '$user_id', '$tl', '$br', '$br_id', '$na', '$d', '$s', '$of', '$tn', 'Active', '$d', '0', '$lo', '$mth', '$id', '$re_am', '$int', '0', '$balance',
'$tll', '$under', '$na', '$tms_id', '$def', '$dg_reg', '$ttn', '$pay', '$map_id', 'Runing', 'No', 'Enabled', '$yrs', '$client_type', '$repayment_day')";
$result = mysqli_query($con, $query);
$last_id = mysqli_insert_id($con);

// updating savings deposit
$result = mysqli_query($con, "UPDATE save SET  Virtual_Acct = '$sku', Disbursement_No= '$dn', Transaction_id = '1010$id',
Loan_Account_No = '$lon', Saving_Account = '$sva', User = '$us', User_id = '$user_id', Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', 
Team_id = '$tms_id', Unions ='$un', Union_Code = '$un_id', Loan_Type = '$pr', Product_id = '$pr_id', Frequency = '$dur', Duration = '$ten', Branch = '$br', 
Branch_Code = '$br_id' WHERE Saving_Account ='$sva'");


// updating savings transfer
$result = mysqli_query($con, "UPDATE transfers SET Transaction_id = '1010$id', Loan_Account_No = '$lon', Saving_Account_No = '$sva', User = '$us', 
User_id = '$user_id', Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Product = '$pr', 
Product_id = '$pr_id', Branch = '$br', Branch_id = '$br_id' WHERE Saving_Account_No ='$sva'");


// updating savings transfer
$result = mysqli_query($con, "UPDATE saving_upfront SET Transaction_id = '1010$id', Loan_Account_No = '$lon', Saving_Account_No = '$sva', User = '$us', 
User_id = '$user_id', Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Product = '$pr', 
Product_id = '$pr_id', Branch = '$br', Branch_id = '$br_id' WHERE Saving_Account_No ='$sva'");


// updating savings repayment
$result = mysqli_query($con, "UPDATE saving_rep SET Transaction_id = '1010$id', Loan_Account_No = '$lon', Saving_Account_No = '$sva', User = '$us', 
User_id = '$user_id', Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Product = '$pr', 
Product_id = '$pr_id', Branch = '$br', Branch_id = '$br_id' WHERE Saving_Account_No ='$sva'");


// updating savings credit
$result = mysqli_query($con, "UPDATE credit SET Reciever_Loan_Acct = '$lon', Reciever_Account = '$sva', User = '$us', User_id = '$user_id', Officer_Name = '$of', 
Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Branch = '$br', Branch_id = '$br_id' WHERE Reciever_Account ='$sva'");


// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status = 'Paid' AND Saving_Account = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status = 'Paid' AND Saving_Account_No = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status = 'Paid' AND Saving_Account_No = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status = 'Paid' AND Saving_Account_No = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status = 'Paid' AND Saving_Account_No = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status = 'Paid' AND Reciever_Account = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$balance = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;

// update saving info
$result = mysqli_query($con, "UPDATE savings SET Virtual_Account = '$sku', Repayments_id = '$last_id', Reg_id = '$id', Disbursement_No= '$dn', 
Transaction_id = '1010$id', Loan_Account_No = '$lon', Savings_Account_No = '$sva', User = '$us', User_id = '$user_id', Officer_Name = '$of', Balance = '$balance',
Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Product = '$pr', Product_id = '$pr_id', Frequency = '$dur',
Duration = '$ten', Client_BVN = '$bv', Branch = '$br', Branch_id = '$br_id', Savings_Paid = '$pmd', Balance = '$balance', Withdraw_Savings = '$pmw', 
Savings_Repayment = '$pmr', Savings_Transfer = '$pmtr', Savings_Upfront = '$pmu', Savings_Recieved = '$pmc' WHERE Savings_Account_No ='$sva'");


// statment of account
$sql = "INSERT INTO bank_account (Ref_No, Transaction_Type, Description, Opening_Balance, Debit, Credit, Transaction_By, Status, Months, Years, TNX_Date, TNX_Time) 
VALUES ('$last_id', 'DR', 'Loan disbursement from Market Moni Limited to $name', '-', '$la', '-',  '$na', 'Successfull', '$mth', '$yrs', '$d', '$s')";
$result= mysqli_query($con, $sql);


if($result == true){
echo 4;
}else{
echo("Error description: " . mysqli_error($con));
}


}else{

// existing client weekly or monthly
$result = mysqli_query($con, "UPDATE register SET Disbursed_By = '$na', Status = 'Disbursed' WHERE id='$id' ");
// maturity date
$result = mysqli_query($con, "SELECT * FROM schedule WHERE Regs_id = '$id' ORDER BY id DESC LIMIT 1");
$row= mysqli_fetch_array($result);
$def = $row['Expected_Date'];

//
$result = mysqli_query($con, "SELECT Expected_Date FROM schedule WHERE Regs_id = '$id' AND Payment_Status = 0 ORDER BY id ASC LIMIT 1");
$row= mysqli_fetch_array($result);
$pay = $row['Expected_Date'];

//updating loan schedule
$result = mysqli_query($con, "UPDATE schedule SET Disbursement_No = '$dn', Status = 'Disbursed', Transaction_id = '1010$id', Loan_Account_No = '$lon', 
Savings_Account_No = '2000$id' WHERE Regs_id = '$id' ");

//getting the old saving account
$result = mysqli_query($con, "SELECT id, Client_BVN, Savings_Account_No FROM savings WHERE Client_BVN = '$clbv' ORDER BY id DESC LIMIT 1");
$row= mysqli_fetch_array($result);
$saving_id = $row['id'];
$sva = $row['Savings_Account_No'];

// inserting for repayments
$query = "INSERT INTO repayments (Account_Number, Disbursement_No, Firstname, Middlename, Lastname, Phone, Gender, Transaction_id, Loan_Account_No, Savings_Account_No,
Loan_Amount, Unions, Union_id, Product, Frequency, Product_id, BVN, Rate, Duration, User, User_id, Team_Leader, Branch, Branch_id, Approved_By, Date_Disbursed, 
Time_Disbursed, Officer_Name, Team_Name, Status, Transaction_Date, Last_Amount, Location, Months, Reg_id, Expected_Amount, Interest_Amt, Paid, Savings_Bal, Total_Bal,
Underwiter, Disbursed_By, Team_id, Maturity_Date, Date_Reg, Total_Loan, Next_Payment_Date, Map_id, Maturity_Status, Recovery_Status, Alert, Years, Client_Type, Repayment_Day)
VALUE('$sku', '$dn', '$fn', '$md', '$ln', '$ph', '$gn', '1010$id', '$lon', '$sva', '$la', '$un', '$un_id', '$pr', '$dur', '$pr_id', '$bv', '$rat',
'$ten', '$us', '$user_id', '$tl', '$br', '$br_id', '$na', '$d', '$s', '$of', '$tn', 'Active', '$d', '0', '$lo', '$mth', '$id', '$re_am', '$int', '0', '$balance',
'$tll', '$under', '$na', '$tms_id', '$def', '$dg_reg', '$ttn', '$pay', '$map_id', 'Runing', 'No', 'Enabled', '$yrs', '$client_type', '$repayment_day')";
$result = mysqli_query($con, $query);
$last_id = mysqli_insert_id($con);

// deposit for savings
$result = mysqli_query($con, "INSERT INTO save (Session_No, History_id, Reps_id, Virtual_Acct, Disbursement_No, Register_id, Repayment_id, Savings_id, 
Loan_Account_No, Transaction_id, Saving_Account, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Savings, Duration, Frequency, Rate, 
Loan_Type, Product_id, Branch, Branch_Code, Status, User, User_id, Team_Leader, Officer_Name, Team_Name, Date_Paid, Time_Paid, Team_id, Payment_Method, 
Posting_Method, Months, Years)
VALUE('NA','$last_id', '$last_id', '$sku', '$dn', '$id', '$last_id', '$id$id', '$lon', '10010$id', '$sva', '$fn', '$md', '$ln', '$un', '$un_id', '$la', '$up', 
'$ten', '$dur', '$rt', '$pr', '$pr_id', '$br', '$br_id', 'Paid', '$us', '$user_id', '$tl', '$of', '$tn', '$d', '$s', '$tms_id', 'System Payment', 'Initial Deposit',
'$mth', '$yrs')");


// updating savings deposit
$result = mysqli_query($con, "UPDATE save SET  Virtual_Acct = '$sku', Disbursement_No= '$dn', Transaction_id = '1010$id',
Loan_Account_No = '$lon', Saving_Account = '$sva', User = '$us', User_id = '$user_id', Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', 
Team_id = '$tms_id', Unions ='$un', Union_Code = '$un_id', Loan_Type = '$pr', Product_id = '$pr_id', Frequency = '$dur', Duration = '$ten', Branch = '$br', 
Branch_Code = '$br_id' WHERE Saving_Account ='$sva'");

// updating savings transfer
$result = mysqli_query($con, "UPDATE transfers SET Transaction_id = '1010$id', Loan_Account_No = '$lon', Saving_Account_No = '$sva', User = '$us', 
User_id = '$user_id', Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Product = '$pr', 
Product_id = '$pr_id', Branch = '$br', Branch_id = '$br_id' WHERE Saving_Account_No ='$sva'");


// updating savings transfer
$result = mysqli_query($con, "UPDATE saving_upfront SET Transaction_id = '1010$id', Loan_Account_No = '$lon', Saving_Account_No = '$sva', User = '$us', 
User_id = '$user_id', Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Product = '$pr', 
Product_id = '$pr_id', Branch = '$br', Branch_id = '$br_id' WHERE Saving_Account_No ='$sva'");


// updating savings repayment
$result = mysqli_query($con, "UPDATE saving_rep SET Transaction_id = '1010$id', Loan_Account_No = '$lon', Saving_Account_No = '$sva', User = '$us', 
User_id = '$user_id', Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Product = '$pr', 
Product_id = '$pr_id', Branch = '$br', Branch_id = '$br_id' WHERE Saving_Account_No ='$sva'");


// updating savings credit
$result = mysqli_query($con, "UPDATE credit SET Reciever_Loan_Acct = '$lon', Reciever_Account = '$sva', User = '$us', User_id = '$user_id', Officer_Name = '$of', 
Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Branch = '$br', Branch_id = '$br_id' WHERE Reciever_Account ='$sva'");



// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status = 'Paid' AND Saving_Account = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status = 'Paid' AND Saving_Account_No = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status = 'Paid' AND Saving_Account_No = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status = 'Paid' AND Saving_Account_No = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status = 'Paid' AND Saving_Account_No = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status = 'Paid' AND Reciever_Account = '$sva'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$balance = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;


// update saving info
$result = mysqli_query($con, "UPDATE savings SET Savings_Paid = Savings_Paid + $up, Virtual_Account = '$sku', Repayments_id = '$last_id', Reg_id = '$id',
Disbursement_No= '$dn', Transaction_id = '1010$id', Loan_Account_No = '$lon', Savings_Account_No = '$sva', User = '$us', User_id = '$user_id', Balance = '$balance',
Officer_Name = '$of', Team_Leader = '$tl', Team_Name = '$tn', Team_id = '$tms_id', Unions ='$un', Union_id = '$un_id', Product = '$pr', Product_id = '$pr_id',
Frequency = '$dur', Duration = '$ten', Client_BVN = '$bv', Branch = '$br', Branch_id = '$br_id', Savings_Paid = '$pmd', Balance = '$balance', 
Withdraw_Savings = '$pmw', Savings_Repayment = '$pmr', Savings_Transfer = '$pmtr', Savings_Upfront = '$pmu', Savings_Recieved = '$pmc' 
WHERE Savings_Account_No = '$sva'");

// statment of account
$sql = "INSERT INTO bank_account (Ref_No, Transaction_Type, Description, Opening_Balance, Debit, Credit, Transaction_By, Status, Months, Years, TNX_Date, TNX_Time) 
VALUES ('$last_id', 'DR', 'Loan disbursement from Market Moni Limited to $name', '-', '$la', '-',  '$na', 'Successfull', '$mth', '$yrs', '$d', '$s')";
$result= mysqli_query($con, $sql);

if($result == true){
echo 4;
}else{
echo("Error description: " . mysqli_error($con));
}

}


}
?>