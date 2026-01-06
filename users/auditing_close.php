<?php 
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$id = $_POST['id'];
$Query = "SELECT Reg_id, id, Total_Loan, User, Transaction_id, Paid, BVN, Maturity_Date, Total_Bal, Officer_Name,
(SELECT COALESCE(SUM(Amount), 0) FROM history WHERE Register_id = Reg_id AND Status = 'Paid') AS `Total_Paid`
FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$reg = $row['Reg_id'];
$balance = $row['Total_Bal'];
$tr = $row['Transaction_id'];
$tot = $row['Total_Loan'];
$pd = $row['Total_Paid'];
$officer = $row['Officer_Name'];
$bv = $row['BVN'];
$us = $row['User'];
//
if($tot == $pd){
// repayment
$Query = "UPDATE repayments SET Confirmed_Status = 'Valid Outstanding', Status = 'Closed', Reason = 'All Payment Made', Date_Closed = '$d', Closed_By = '$na' 
WHERE id = '$id'";
$result= mysqli_query($con, $Query);

//
$Query = "UPDATE savings SET Repayments_id = '$id' WHERE Reg_id = '$reg'";
$result= mysqli_query($con, $Query);

// repayment schedule
$Query = "UPDATE schedule SET Payment_Status = 'Loan Closed', Date_Paid = 'No Date', Expected_Date = '-', Status = 'Loan Closed' WHERE Regs_id = '$reg' 
AND Payment_Status = 'Outstanding' ";
$result= mysqli_query($con, $Query);

// registered
$Query = "UPDATE register SET Status = 'Loan Closed', Application_Status = 'Loan Cleared' WHERE id = '$reg'";
$result= mysqli_query($con, $Query);

// guarantor
$Query = "UPDATE gaurantors SET Status = 'Loan Closed' WHERE Regis_id = '$reg' ";
$result= mysqli_query($con, $Query);

if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}else{
echo 1;
exit();
}
?>