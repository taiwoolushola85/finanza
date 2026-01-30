<?php
//if the add button has been clicked
include('../config/db.php');
include '../config/user_session.php';
$repid = $_POST['id'];// rep id
$la = $_POST['la'];// loan account no
$lom = $_POST['us'];// loan officers username
$grid = $_POST['gr'];// group id
$reg = $_POST['reg'];// register id
$vrt = $_POST['vrt'];// virtual account
//
$Query = "SELECT * FROM users WHERE Username = '$lom'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$user_id = $row['id'];
$us_name = $row['Name'];
$us_br = $row['Branch'];
$brid = $row['Branch_id'];
$Query = "SELECT * FROM groups WHERE id = '$grid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$un_id = $row['id'];
$group = $row['Name'];
$un_zer = $row['User'];
$Query = "SELECT * FROM mapping WHERE Loan_Officer = '$lom'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$tm = $row['Team_Leader'];
$tn = $row['Team_Name'];
$tm_ids = $row['Team_id'];
//
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$la'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row == 0){
echo 1;
exit();
}

// updating loan acct
$Query = "UPDATE repayments SET User = '$lom', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Unions = '$group', Union_id = '$un_id', 
Officer_Name = '$us_name', Branch = '$us_br', Branch_id = '$brid', Team_id = '$tm_ids' WHERE Loan_Account_No = '$la'";
$result= mysqli_query($con, $Query);
// updating savings acct
$Query = "UPDATE savings SET User = '$lom', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Unions = '$group', Union_id = '$un_id', 
Officer_Name = '$us_name', Branch = '$us_br', Branch_id = '$brid', Team_id = '$tm_ids' WHERE Loan_Account_No = '$la'";
$result= mysqli_query($con, $Query);
// schedule 
$Query = "UPDATE schedule SET User = '$lom', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Unions = '$group', Union_id = '$un_id', 
Officer_Name = '$us_name', Branch = '$us_br', Branch_id = '$brid' WHERE Loan_Account_No = '$la'";
$result= mysqli_query($con, $Query);
// history
$Query = "UPDATE history SET User = '$lom', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Unions = '$group', Union_Code = '$un_id', 
Officer_Name = '$us_name', Branch = '$us_br', Branch_Code = '$brid', Team_id = '$tm_ids' WHERE Loan_Account_No = '$la'";
$result= mysqli_query($con, $Query);
// save
$Query = "UPDATE save SET User = '$lom', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Unions = '$group', Union_Code ='$un_id', 
Officer_Name = '$us_name', Branch = '$us_br', Branch_Code = '$brid', Team_id = '$tm_ids' WHERE Loan_Account_No = '$la'";
$result= mysqli_query($con, $Query);
// register
$Query = "UPDATE register SET User ='$lom', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Unions = '$group', Union_id = '$un_id',  
Officer_Name = '$us_name', Branch = '$us_br', Branch_id = '$brid', Team_id = '$tm_ids' WHERE id ='$reg'";
$result= mysqli_query($con, $Query);
//guarantor
$Query = "UPDATE gaurantors SET User = '$lom', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$us_name', Team_id = '$tm_ids' 
WHERE Regis_id = '$reg'";
$result= mysqli_query($con, $Query);
// notification
$Query = "UPDATE nip_notifications SET User = '$lom', User_id = '$user_id', Team_Leader = '$tm', Team_Name = '$tn', Officer_Name = '$us_name', Team_id = '$tm_ids'
WHERE craccount = '$vrt'";
$result= mysqli_query($con, $Query);
//
if($result == true){
echo 2;
}else{
//echo 8;
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>