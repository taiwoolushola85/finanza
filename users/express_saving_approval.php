<?php
include '../config/db.php';
include '../config/user_session.php';
foreach ($_POST['id'] as $id) {
$result = mysqli_query($con, "SELECT id, Reps_id, Firstname, Middlename, Lastname, User, Savings, Saving_Account, Transaction_id, Loan_Account_No 
FROM save WHERE id = '$id'");
$row= mysqli_fetch_array($result);
$idd = $row['id'];
$rep_id = $row['Reps_id'];
$us = $row['User'];
$sav = $row['Savings'];
$name = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; 
$sn = $row['Saving_Account'];
$tr = $row['Transaction_id'];
$ln = $row['Loan_Account_No'];
$d = date('Y-m-d');
$s = date('h-m-sa');
$mth = date('M');
$yrs = date('Y');
//updating info
$result = mysqli_query($con, "UPDATE save SET Status = 'Paid', Reps_id = '$rep_id' WHERE id = '$id'");
$result = mysqli_query($con, "UPDATE repayments SET Savings_Bal = Savings_Bal + $sav WHERE Savings_Account_No='$sn'");
$result = mysqli_query($con, "UPDATE savings SET Balance = Balance + $sav, Last_Payment_Date = '$d', Last_Amount = '$sav', Repayments_id = '$rep_id'  
WHERE Savings_Account_No='$sn'");
//
$sql = "INSERT INTO bank_account (Ref_No, Transaction_Type, Description, Opening_Balance, Debit, Credit, Transaction_By, Status, Months, Years, TNX_Date, TNX_Time) 
VALUES ('$idd', 'CR', 'savings deposit from $name', '-', '-', '$sav', '$na', 'Successfull', '$mth', '$yrs', '$d', '$s')";
$result= mysqli_query($con, $sql);

if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
} 
}
mysqli_close($con);
?>


