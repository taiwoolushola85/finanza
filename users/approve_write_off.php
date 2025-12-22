<?php
include('../config/db.php') ;
include '../config/user_session.php';
$d = date('Y-m-d');
//
$regid = $_POST['reg_id'];// reg id
$repid = $_POST['repid'];
$id = $_POST['id'];
$snd = $_POST['snd'];
$re = $_POST['re'];// reason
$tr = $_POST['tr'];// loan acct
$req_type = $_POST['typ'];// request type
$Query = "SELECT * FROM other_request WHERE id='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$off = $row['Firstname'];
$lln = $row['Lastname'];
$reg_id = $row['Reg_id'];
//
$Query = "UPDATE other_request SET Status='Approved', Approved_By = '$na' WHERE id='$id'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE loan_cancel SET Status='Approved', Approved_By = '$na' WHERE Reg_id='$reg_id'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE repayments SET Status='Cancelled', Reason = '$re', Requested_By = '$snd', Cancelled_By = '$na', Date_Cancelled = '$d' WHERE Reg_id='$reg_id' ";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE register SET Status='Cancelled', Application_Status = 'Loan Cleared' WHERE id='$reg_id'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE disburse SET Status='Cancelled' WHERE Reg_id='$reg_id'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE gaurantors SET Status='Cancelled' WHERE Regis_id ='$reg_id'";
$result= mysqli_query($con, $Query);
// repayment schedule
$Query = "DELETE FROM schedule WHERE Regs_id = '$reg_id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM bank_account WHERE Ref_No = '$repid'";
$result= mysqli_query($con, $Query);
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>