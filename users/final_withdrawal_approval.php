<?php
//updating loan officer in union
include('../config/db.php') ;
include '../config/user_session.php';
$d = date('Y-m-d');
$id = $_POST['id'];// request id
$amt = $_POST['amt'];// amount paid
$sa = $_POST['sv'];// saving account
$lon = $_POST['ln'];// loan account no
$d = date('Y-m-d');
$s = date('h:m:sa');
$mth = date('M');
$yrs = date('Y');
//
$result = mysqli_query($con, "SELECT * FROM withdraw WHERE id='$id'");
$rows = mysqli_fetch_array($result);
$reg_id = $rows['id'];
$name = $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname']; 

//
$Query = "UPDATE withdraw SET Status = 'Paid', Management_Approve = '$na', Payment_By='$na', Payment_Date='$d' WHERE id = '$id'";
$result = mysqli_query($con, $Query);
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status ='Paid' AND Saving_Account = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status ='Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status ='Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status ='Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status ='Paid' AND Saving_Account_No = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status ='Paid' AND  Reciever_Account = '$sa'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$bal = $pmd - $pmw - $pmr - $pmtr + $pmc;
//
$Query = "UPDATE repayments SET Savings_Bal = '$bal' WHERE Savings_Account_No = '$sa'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE savings SET Balance = '$bal' WHERE Savings_Account_No = '$sa'";
$result = mysqli_query($con, $Query);
// statment of account
$sql = "INSERT INTO bank_account (Ref_No, Transaction_Type, Description, Opening_Balance, Debit, Credit, Transaction_By, Status, Months, Years, TNX_Date, TNX_Time) 
VALUES ('$id', 'DR', 'Saving withdrawal by $name', '-', '$amt', '-',  '$na', 'Successfull', '$mth', '$yrs', '$d', '$s')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>