<?php
//updating loan officer in union
include('../config/db.php') ;
include '../config/user_session.php';
$d = date('Y-m-d');
$id = intval($_POST['id']);
$Query = "SELECT * FROM register WHERE id='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$ll = $row['Location'];
unlink($ll);
// deleting client info
$Query = "DELETE FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);

$Query = "SELECT * FROM gaurantors WHERE Regis_id='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$gll = $row['Location'];
$iddm = $row['ID_Image'];
unlink($gll);
unlink($iddm);
// deleting guarantor info
$Query = "DELETE FROM gaurantors WHERE Regis_id = '$id'";
$result = mysqli_query($con, $Query);
// deleting verification info
$Query = "SELECT * FROM verify WHERE Reg_id='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$vll = $row['F_Image'];
unlink($vll);
// deleting verification info
$Query = "DELETE FROM verify WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// approve loan
$Query = "DELETE FROM aprove WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// disbursed loan
$Query = "DELETE FROM disburse WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// schedule
$Query = "DELETE FROM schedule WHERE Regs_id = '$id'";
$result = mysqli_query($con, $Query);
// history
$Query = "DELETE FROM history WHERE Register_id = '$id'";
$result = mysqli_query($con, $Query);
// repayments 
$Query = "DELETE FROM repayments WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// savings history
$Query = "DELETE FROM save WHERE Register_id = '$id'";
$result = mysqli_query($con, $Query);
// savings acct
$Query = "DELETE FROM savings WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// gaurantor
$Query = "DELETE FROM gaurantors WHERE Regis_id = '$id'";
$result = mysqli_query($con, $Query);
// fee
$Query = "DELETE FROM fee WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// cancel
$Query = "DELETE FROM cancel WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// closed savings
$Query = "DELETE FROM closed_saving WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
//credit
$Query = "DELETE FROM credit WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// loan cancel
$Query = "DELETE FROM loan_cancel WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// other request
$Query = "DELETE FROM other_request WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// recovery
$Query = "DELETE FROM recover WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
//refund
$Query = "DELETE FROM refund WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// saving upfront
$Query = "DELETE FROM saving_upfront WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// savings repayment
$Query = "DELETE FROM saving_rep WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// transfer
$Query = "DELETE FROM transfers WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
// withdraw
$Query = "DELETE FROM withdraw WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
mysqli_close($con);
?>