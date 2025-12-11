<?php
//if the add button has been clicked
include('../config/db.php') ;
$reg = $_POST['id'];// reg id
$usid = $_POST['usid'];// user id
$gr = $_POST['gr'];// group id
// getting branch info
$Query = "SELECT * FROM register WHERE id = '$reg'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$brid = $row['Branch_id'];
$uid = $row['User_id'];
// getting user info
$Query = "SELECT id, Name, Username, Branch,Branch_id FROM users WHERE id = '$usid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$user_id = $row['id'];
$us_name = $row['Name'];
$uzer = $row['Username'];
$us_br = $row['Branch'];
$bi = $row['Branch_id'];
// getting mapping info
$Query = "SELECT id, Team_Name, Team_Leader, Team_id FROM mapping WHERE Loan_Officer = '$uzer'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$map_id = $row['id'];
$tm = $row['Team_Leader'];
$tn = $row['Team_Name'];
$tn_id = $row['Team_id'];
// getting group
$Query = "SELECT id, Name FROM groups WHERE id = '$gr'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$grid = $row['id'];
$grname = $row['Name'];

// updating tables
$Query = "UPDATE register SET User = '$uzer', User_id = '$user_id', Officer_Name = '$us_name', Team_Leader = '$tm', Team_Name = '$tn', Map_id = '$map_id', 
Team_id = '$tn_id', Branch = '$us_br', Branch_id = '$bi', Unions = '$grname', Union_id = '$grid' WHERE id='$reg'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE schedule SET User='$uzer', User_id = '$user_id', Officer_Name = '$us_name', Team_Leader = '$tm', Team_Name = '$tn', Team_id = '$tn_id', 
Branch = '$us_br', Branch_id = '$bi' WHERE Reg_id='$reg'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE repayments SET User = '$uzer', User_id = '$user_id', Officer_Name = '$us_name', Team_Leader = '$tm', Team_Name = '$tn', Map_id = '$map_id', 
Team_id = '$tn_id', Branch = '$us_br', Branch_id = '$bi', Unions = '$grname', Union_id = '$grid' WHERE Reg_id = '$reg'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE gaurantors SET User = '$uzer', User_id = '$user_id', Officer_Name = '$us_name', Team_Leader = '$tm', Team_Name = '$tn', Team_id = '$tn_id' 
WHERE Regis_id='$reg'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>
