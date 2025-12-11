<?php
//if the add button has been clicked
include('../config/db.php') ;
include '../config/user_session.php';
$from = $_POST['fr'];// sender
$to = $_POST['to'];// reciever
$ty = $_POST['types'];// types
$d = date('Y-m-d');
$s = date('H:m:sa');
///from
$Query = "SELECT * FROM users WHERE id ='$from'"; 
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$user_id = $row['id'];
$fr_name = $row['Name'];
$us_name = $row['Username'];
$us_br = $row['Branch'];
$brid = $row['Branch_id'];

//to
$Query = "SELECT * FROM users WHERE id ='$to'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$ruser_id = $row['id'];
$to_name = $row['Name'];
$rus_name = $row['Username'];
$rus_br = $row['Branch'];
$rbrid = $row['Branch_id'];

// getting the reciever team leader
$Query = "SELECT * FROM mapping WHERE Officer_id ='$to'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$rmap = $row['id'];
$tm = $row['Team_Leader'];
$tn = $row['Team_Name'];
$off = $row['Officer_Name'];
$tm_id = $row['Team_id'];
$of_id = $row['Officer_id'];
/*
// checking if the portfolio already belong to the loan officer
if ($from == $to){
echo 1;
exit();
}
*/
if($ty == 'All'){
// inserting union info
$Query = "UPDATE groups SET User='$rus_name', Officer_id='$ruser_id', Team_id='$tm_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// updating repayment 
$Query = "UPDATE repayments SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// updating savings
$Query = "UPDATE savings SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// overdeu
$Query = "UPDATE overdue SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// history
$Query = "UPDATE history SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_Code = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// save
$Query = "UPDATE save SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Branch_Code = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// schedule
$Query = "UPDATE schedule SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// register
$Query = "UPDATE register SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
//flexi account
$Query = "UPDATE flexi_account SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_id='$tm_id', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// flexi history
$Query = "UPDATE flexi_history SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_No = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
//flexi registration
$Query = "UPDATE flexi_reg SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_id='$tm_id', Map_id = '$rmap', Team_Name='$tn', Officer_Name='$off',
Branch = '$rus_br', Branch_Code = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
//process fee
$Query = "UPDATE process_fee SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_Code = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// remitance
$Query = "UPDATE remitance SET User ='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Payee = '$off' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// notification
$Query = "UPDATE nip_notifications SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Team_id = '$tm_id' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
//portfolio transfer record
$sql = "INSERT INTO portfolio (New, Old, Initiated_By, Date_Transfer, Time_Transfer, Status, Types, Groups, Sender_id, Reciever_id, Sender_Username, Reciever_Username) 
VALUES ('$to_name', '$fr_name', '$na', '$d', '$s', 'Done', 'All Portfolio', 'All Group', '$user_id', '$ruser_id', '$us_name', '$rus_name')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}

}elseif($ty == 'Loan'){

// inserting union info
$Query = "UPDATE groups SET User='$rus_name', Officer_id='$ruser_id', Team_id='$tm_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// updating repayment 
$Query = "UPDATE repayments SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// updating savings
$Query = "UPDATE savings SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// overdeu
$Query = "UPDATE overdue SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// history
$Query = "UPDATE history SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_Code = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// save
$Query = "UPDATE save SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Branch_Code = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// schedule
$Query = "UPDATE schedule SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// register
$Query = "UPDATE register SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// remitance
$Query = "UPDATE remitance SET User ='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Payee = '$off' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// notification
$Query = "UPDATE nip_notifications SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Team_id = '$tm_id' WHERE User ='$us_name'";
//portfolio transfer record
$sql = "INSERT INTO portfolio (New, Old, Initiated_By, Date_Transfer, Time_Transfer, Status, Types, Groups, Sender_id, Reciever_id, Sender_Username, Reciever_Username) 
VALUES ('$to_name', '$fr_name', '$na', '$d', '$s', 'Done', 'Loan Portfolio', 'All Group', '$user_id', '$ruser_id', '$us_name', '$rus_name')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}


}elseif($ty == 'Flexi'){
//flexi account
$Query = "UPDATE flexi_account SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_id='$tm_id', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_id = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// flexi history
$Query = "UPDATE flexi_history SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_No = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
//flexi registration
$Query = "UPDATE flexi_reg SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_id='$tm_id', Map_id = '$rmap', Team_Name='$tn', Officer_Name='$off',
Branch = '$rus_br', Branch_Code = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
//process fee
$Query = "UPDATE process_fee SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br', 
Branch_Code = '$rbrid' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// remitance
$Query = "UPDATE remitance SET User ='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Payee = '$off' WHERE User ='$us_name'";
$result= mysqli_query($con, $Query);
// notification
$Query = "UPDATE nip_notifications SET User='$rus_name', User_id='$ruser_id', Team_Leader='$tm', Team_Name='$tn', Officer_Name='$off', Branch = '$rus_br',
Team_id = '$tm_id' WHERE User ='$us_name'";
//portfolio transfer record
$sql = "INSERT INTO portfolio (New, Old, Initiated_By, Date_Transfer, Time_Transfer, Status, Types, Groups, Sender_id, Reciever_id, Sender_Username, Reciever_Username) 
VALUES ('$to_name', '$fr_name', '$na', '$d', '$s', 'Done', 'Flexi Portfolio', 'All Group', '$user_id', '$ruser_id', '$us_name', '$rus_name')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}

}else{
echo 4;
}
mysqli_close($con);
?>