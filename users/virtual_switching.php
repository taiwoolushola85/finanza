<?php
include('../config/db.php') ;
$d = date('Y-m-d');
include '../config/user_session.php';
$old = trim($_POST['old']); // closed virtual acct
$new = trim($_POST['new']);// active virtual acct
$bvn = trim($_POST['bvn']);// bvn number
$d = date('Y-m-d');
$s = date('h:m:sa');
//
$result = mysqli_query($con, "SELECT id, User, User_id, Officer_Name, Team_Name, Team_Leader, Team_id, Branch FROM repayments 
WHERE Account_Number ='$new' AND Status = 'Active' ORDER BY id DESC LIMIT 1");
$rows = mysqli_fetch_array($result);
$repid = $rows['id'];
$ofn = $rows['Officer_Name'];
$uzers = $rows['User'];
$uzerid = $rows['User_id'];
$team_name = $rows['Team_Name'];
$team_leader = $rows['Team_Leader'];
$teamid = $rows['Team_id'];
$branch = $rows['Branch'];
/*
// check if merging already exit
$Query = "SELECT * FROM repayments WHERE Account_Number = '$new' AND Status = 'Closed'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 2;
exit();
}
*/
//
$Query = "UPDATE nip_notifications SET craccount = '$new', Rep_id = '$repid', User = '$uzers', User_id = '$uzerid', Officer_Name= '$ofn', Team_Leader = '$team_leader', 
Team_Name = '$team_name', Team_id = '$teamid', Branch = '$branch' WHERE craccount ='$old'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE repayments SET Account_Number = '$new' WHERE BVN ='$bvn'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE savings SET Virtual_Account = '$new' WHERE Client_BVN ='$bvn'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE history SET Virtual_No = '$new' WHERE Virtual_No ='$old'";
$result = mysqli_query($con, $Query);
//
$Query = "UPDATE save SET Virtual_Acct = '$new' WHERE Virtual_Acct ='$old'";
$result = mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
?>