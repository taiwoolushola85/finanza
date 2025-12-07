<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
$remark = trim($_POST['remark']);// remark
$d = date('Y-m-d');
$s = date('h:m:sa');
//
$Query = "SELECT id, Firstname, Middlename, Lastname, BVN FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$fll = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
$bv = $row['BVN'];
//
$Query = "UPDATE register SET Status = 'Ready For Underwriting', Stage = '4' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
//comment box
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$regid', '$bv', '$fll', '$remark', '$d', '$s', '$na', '$gr', 'Underwriting Stage')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>