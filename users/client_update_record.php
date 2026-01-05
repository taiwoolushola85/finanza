<?php
//if the add button has been clicked
include('../config/db.php') ;
$repid = $_POST['repid']; // repayment id
$id = $_POST['id']; // reg id
$lon = $_POST['lon']; // Loan account no
$vrt = $_POST['vrt']; // virtual acct
$dis = $_POST['dis']; // Disbursement no
$fn = $_POST['fn'];// firstname
$ln = $_POST['ln'];// lastname
$md = $_POST['md'];// middlename
$bv = $_POST['bv'];// bvn no
$ph = $_POST['ph'];// phone no
$ed = $_POST['ed'];// education
$gn = $_POST['der'];// gender
$ad = $_POST['ad'];// address
$bn = $_POST['bn'];// bank name
$ac = $_POST['ac'];// account no
$an = $_POST['an'];// account name
$db = $_POST['db'];// date of birth
$ms = $_POST['ms'];// maritail status
$do = $_POST['do'];// document type
$dno = $_POST['dno'];// document no
$sta = $_POST['sta'];// client state
$tw = $_POST['tw'];// client town
//$lga = $_POST['lga'];// client lga
$tr = $_POST['tr'];// transaction id
$sv = $_POST['siv'];// savings acct no
$full = $fn." ".$md." ".$ln;// full name
// updating  repayment info
$Query = "UPDATE repayments SET Account_Number = '$vrt', Firstname='$fn', Middlename='$md', Lastname='$ln', Loan_Account_No ='$lon', Disbursement_No = '$dis', 
Transaction_id = '$tr', Savings_Account_No = '$sv',  BVN = '$bv', Phone = '$ph', Gender = '$gn' WHERE id = '$repid'";
$result= mysqli_query($con, $Query);
// updateing register info
$Query = "UPDATE register SET Firstname='$fn', Middlename='$md', Lastname='$ln',  BVN='$bv', Phone='$ph', Education='$ed', Address='$ad', Bank='$bn', Account_No='$ac',
Account_Name='$an', Document = '$do', Document_No = '$dno', Years = '$db', Maritial_Status = '$ms', Gender = '$gn', State = '$sta' WHERE id='$id'";
$result= mysqli_query($con, $Query);
// updating gaurantor
$Query = "UPDATE gaurantors SET Client_BVN='$bv', Client_Name = '$full'  WHERE Regis_id='$id'";
$result= mysqli_query($con, $Query);
// updating repayment schedule
$Query = "UPDATE schedule SET Firstname='$fn', Middlename='$md', Lastname='$ln', Loan_Account_No ='$lon', Disbursement_No = '$dis', BVN = '$bv', Phone = '$ph', 
Transaction_id = '$tr', Savings_Account_No = '$sv'  WHERE Regs_id='$id'";
$result= mysqli_query($con, $Query);
// updating savings
$Query = "UPDATE savings SET Virtual_Account = '$vrt', Transaction_id = '$tr', Savings_Account_No = '$sv', Firstname='$fn', Middlename='$md', Lastname='$ln',
Loan_Account_No ='$lon', Disbursement_No = '$dis', Client_BVN = '$bv', Phone = '$ph', Gender = '$gn', Address = '$ad' WHERE Reg_id='$id'";
$result= mysqli_query($con, $Query);
// updating history
$Query = "UPDATE history SET Virtual_No = '$vrt', Transaction_id = '$tr', Saving_Account_No = '$sv', Firstname='$fn', Middlename='$md', Lastname='$ln', 
Loan_Account_No ='$lon', Disbursement_No = '$dis' WHERE Register_id='$id'";
$result= mysqli_query($con, $Query);
// updating save
$Query = "UPDATE save SET Virtual_Acct = '$vrt', Transaction_id = '$tr', Saving_Account = '$sv',  Firstname='$fn', Middlename='$md', Lastname='$ln', 
Loan_Account_No ='$lon', Disbursement_No = '$dis' WHERE Register_id='$id'";
$result= mysqli_query($con, $Query);
// updating disburse
$Query = "UPDATE disburse SET Transaction_id = '$tr', Savings_Account_No = '$sv', Firstname='$fn', Middlename='$md', Lastname='$ln', Loan_Account_No ='$lon',
Disbursement_No = '$dis' WHERE Reg_id='$id'";
$result= mysqli_query($con, $Query);
//updating verified
$Query = "UPDATE verify SET Name='$full', Bvn = '$bv' WHERE Reg_id = '$id'";
$result= mysqli_query($con, $Query);
// updating aprove
$Query = "UPDATE aprove SET Firstname='$fn', Middlename='$md', Lastname='$ln', Phone ='$ph', Bank_Name = '$bn', Account_No='$ac', Account_Name='$an', BVN = '$bv' 
WHERE Reg_id='$id'";
$result= mysqli_query($con, $Query);
//bvn validate
$Query = "UPDATE validate SET BVN = '$bv' WHERE BVN ='$bv'";
$result= mysqli_query($con, $Query);
//updating notification
$Query = "UPDATE nip_notifications SET craccount = '$vrt' WHERE Rep_id ='$repid'";
$result= mysqli_query($con, $Query);
if($result == 1){
echo 1;
}else{
echo "Error: ". mysqli_error($con);
}
mysqli_close($con);
?>