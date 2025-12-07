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
// generating virtual account
function generateVirtualAccountNumber($length = 10) {
// Ensure length is at least 4 (prefix + 1 digit)
if ($length < 4) {
$length = 10;
}
$prefix = '614';
$remainingLength = $length - strlen($prefix);
// Generate random digits for the remaining length
$randomDigits = '';
for ($i = 0; $i < $remainingLength; $i++) {
$randomDigits .= mt_rand(0, 9);
}
return $prefix . $randomDigits;
}
// Generate a single 10-digit account number
$accountnumber = generateVirtualAccountNumber();
//
$Query = "UPDATE register SET Virtual_Account = '$accountnumber', Status = 'Ready For Review', Approved_By = '$na', Stage = '3' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
// 
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$id', '$bvn', '$name', '$remark', '$d', '$s', '$na', '$gr', 'Team Lead Stage')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>