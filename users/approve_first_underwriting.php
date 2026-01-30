<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
$remark = $_POST['remark'];// remark
$d = date('Y-m-d');
$s = date('h:m:sa');
//
$Query = "SELECT id, Virtual_Account, Firstname, Middlename, Lastname, BVN, Loan_Status FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$fll = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
$bv = $row['BVN'];
$vrt = $row['Virtual_Account'];
$loan_status = $row['Loan_Status'];


//
if($loan_status == 'New Client'){

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
$Query = "UPDATE register SET Virtual_Account = '$accountnumber', Status = 'Ready For Disbursement', Underwriter = '$na' WHERE id = '$id'";
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

}else{
//
$Query = "UPDATE register SET Virtual_Account = '$vrt', Status = 'Ready For Disbursement', Underwriter = '$na' WHERE id = '$id'";
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

}
mysqli_close($con);
?>