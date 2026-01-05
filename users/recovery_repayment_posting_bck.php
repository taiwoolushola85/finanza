<?php
include '../config/db.php';
include '../config/user_session.php';
$id =$_POST['id'];// repayment id
$amt =$_POST['am']; //  amount recovered
$tbl =$_POST['tba']; //  total bal
$rec = "Not Valid"; //  reciept no
$ran = uniqid();
$d = date('Y-m-d');
$mth = "Monie Point";
//
$Image_Name = addslashes($_FILES['Pic']['name']);
$ImageName= $_FILES['Pic']['tmp_name'];
$Imagesize =  $_FILES['Pic']['size'];
$size =  getimagesize($ImageName);
$width = $size[0];
$height = $size[1];
//echo "$width x $height";
$imgsize=filesize($ImageName);
//if image is less than 1.8MB
if($imgsize > 1895674){
echo 1;
exit();
}else{
$path = "../reciept/".$id."".$ran."".$Image_Name;
move_uploaded_file($ImageName,$path);
}

$Query = "SELECT * FROM repayments WHERE id='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$dis = $row['Disbursement_No'];
$ln = $row['Loan_Account_No'];
$sv = $row['Savings_Account_No'];
$tr = $row['Transaction_id'];
$full = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
$br = $row['Branch'];
$lams = $row['Loan_Amount'];
$un = $row['Unions'];
$pr = $row['Product'];
$ofn = $row['Officer_Name'];
$tnm = $row['Team_Name'];
$tbl = $row['Total_Bal'];
$sbl = $row['Savings_Bal'];
$un_id = $row['Union_id'];
$br_id = $row['Branch_id'];
$d = date('Y-m-d');
$s = date('H:m:sa');
// if amount is greater than balance
if($amt > $tbl){
echo 2;
exit();
}
// checking if you have made posting for that date
$result = mysqli_query($con, "SELECT * FROM recover WHERE Transaction_id='$tr' AND User = '$User' AND Status = 'Paid' AND Date_Pay = '$d' ORDER BY id DESC LIMIT 1");
$row = mysqli_num_rows($result);
if($row != 0){
echo 3;
exit();
}

// checking for double posting
$result = mysqli_query($con, "SELECT * FROM recover WHERE Transaction_id='$tr' AND Status != 'Paid' AND User = '$User'");
$row = mysqli_num_rows($result);
if($row != 0){
echo 4;
exit();
}
// inserting electronin recovery
$sql = "INSERT INTO recover (Repayment_No, Reg_id, Loan_Account, Disbursement_No, Savings_Account, Name, Branch, Amount, Unions, Product, Status, Date_Pay,
Time_Pay, Recovery_Name, User_id, Officer_Name, Team_Name, Loan_Bal, Saving_Bal, Payment_Method, Reciept, User, Union_id, Branch_id, Transaction_id, Loan_Amount,
Reciept_Status, Reciept_No)
VALUES ('$id', '$reg_id', '$ln', '$dis', '$sv', '$full', '$br', '$amt', '$un', '$pr', 'Waiting For Approval', '$d', '$s', '$na', '$usd_id', '$ofn', '$tnm', '$tbl',
'$sbl', '$mth', '$path', '$User', '$un_id', '$br_id', '$tr', '$lams', 'Denied', '$rec')";
$result = mysqli_query($con, $sql);
if($result == true){
echo 5;
}else{
echo("Error description: " . mysqli_error($con));
}
?>