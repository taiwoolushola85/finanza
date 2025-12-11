<?php
//if the add button has been clicked
include('../config/db.php') ;
$tm = $_POST['tm'];/// team leader username
$la = $_POST['la'];// loan officer username
// getting mapping id
$Query = "SELECT * FROM mapping WHERE Loan_Officer = '$la'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];//mapping id
// getting loan officer info
$Query = "SELECT * FROM users WHERE Username = '$la'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$of_idd = $row['id'];// loan officer id
$lnn = $row['Name'];// loan officer name
// getting team leader info
$Query = "SELECT * FROM users WHERE Username = '$tm' ";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$tnn = $row['Name'];// team leader name
$tnn_id = $row['id'];// team leader id
$branch = $row['Branch'];// branch
$branch_id = $row['Branch_id'];// branch id
// update tables

$Query = "UPDATE mapping SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', Loan_Officer = '$la', Team_id = '$tnn_id', Officer_id = '$of_idd', 
Branch = '$branch', Branch_id = '$branch_id' WHERE id = '$idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE repayments SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_id = '$branch_id'  WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE savings SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_id = '$branch_id' WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE groups SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', Officer_id = '$of_idd',
Branch = '$branch', Branch_id = '$branch_id' WHERE Officer_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE register SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_id = '$branch_id' WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE gaurantors SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd' 
WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
$Query = "UPDATE history SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_Code = '$branch_id'  WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE save SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_Code = '$branch_id'  WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE aprove SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_id = '$branch_id'  WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
$Query = "UPDATE disburse SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_id = '$branch_id'  WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE flexi_account SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_id = '$branch_id' WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE flexi_history SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', User_id = '$of_idd',
Branch = '$branch', Branch_No = '$branch_id'  WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE flexi_reg SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', Team_id = '$tnn_id', User_id = '$of_idd',
Branch = '$branch', Branch_Code = '$branch_id' WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
//
$Query = "UPDATE process_fee SET Officer_Name = '$lnn', Team_Name = '$tnn', Team_Leader = '$tm', User = '$la', User_id = '$of_idd',
Branch = '$branch', Branch_Code = '$branch_id' WHERE User_id = '$of_idd'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>