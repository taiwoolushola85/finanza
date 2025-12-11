<?php
//if the add button has been clicked
include('../config/db.php');
include_once '../config/user_session.php';
$lom = $_POST['lo'];// loan officers
$group_id = $_POST['gr'];// group
$d = date('Y-m-d');
$s = date('h:m:sa');
$Query = "SELECT * FROM users WHERE Username = '$lom'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$user_id = $row['id'];
$us_name = $row['Username'];
$us_br = $row['Branch'];
$brid = $row['Branch_id'];
$Query = "SELECT * FROM groups WHERE id = '$group_id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$un_id = $row['id'];
$group = $row['Name'];
$offnn = $row['Officer_Name'];
$offnn_uz = $row['User'];
$offnn_id = $row['Officer_id'];
$Query = "SELECT * FROM mapping WHERE Loan_Officer = '$lom'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$tm = $row['Team_Leader'];
$tn = $row['Team_Name'];
$off = $row['Officer_Name'];
$tm_id = $row['Team_id'];
$of_id = $row['Officer_id'];
// inserting union info
$Query = "UPDATE groups SET User = '$us_name', Officer_id = '$user_id', Team_id = '$tm_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$off', 
Branch = '$us_br', Branch_id = '$brid' WHERE id = '$un_id'";
$result= mysqli_query($con, $Query);
// updating repayment
$Query = "UPDATE repayments SET User = '$us_name', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$off', Branch = '$us_br', 
Branch_id = '$brid' WHERE Union_id = '$un_id'";
$result= mysqli_query($con, $Query);
// updating savings
$Query = "UPDATE savings SET User = '$us_name', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$off', Branch = '$us_br', 
Branch_id = '$brid' WHERE Union_id = '$un_id'";
$result= mysqli_query($con, $Query);
// overdeu
$Query = "UPDATE overdue SET User = '$us_name', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$off', Branch = '$us_br', 
Branch_id = '$brid' WHERE Union_id = '$un_id'";
$result= mysqli_query($con, $Query);
// history
$Query = "UPDATE history SET User = '$us_name', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$off', Branch = '$us_br', 
Branch_Code = '$brid' WHERE Union_Code = '$un_id'";
$result= mysqli_query($con, $Query);
// save
$Query = "UPDATE save SET User = '$us_name', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$off', Branch = '$us_br', 
Branch_Code = '$brid' WHERE Union_Code = '$un_id'";
$result= mysqli_query($con, $Query);
// register
$Query = "UPDATE register SET User = '$us_name', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$off', Branch = '$us_br', 
Branch_id = '$brid' WHERE Union_id = '$un_id'";
$result= mysqli_query($con, $Query);
//portfolio transfer record
$sql = "INSERT INTO portfolio (New, Old, Initiated_By, Date_Transfer, Time_Transfer, Status, Types, Groups, Sender_id, Reciever_id, Sender_Username, Reciever_Username) 
VALUES ('$off', '$offnn', '$na', '$d', '$s', 'Done', 'Group Portfolio', '$group', '$offnn_id', '$user_id', '$offnn_uz', '$us_name')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>