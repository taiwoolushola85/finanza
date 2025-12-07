<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
$remark = $_POST['remark'];// 
$name = $_POST['name'];// 
$bvn = $_POST['bvn'];// 
// other info
$d = date('Y-m-d');// date
$s = date('h:m:sa');// time
//
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$id', '$bvn', '$name', '$remark', '$d', '$s', '$na', '$gr', 'Verification Stage')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
//
$Query = "UPDATE register SET Status = 'Pending', Verification_Status = 'Verified', Verified_By = '$na', Date_Verified = '$d', Stage = '2' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>