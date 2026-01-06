<?php
//if the add button has been clicked
include('../config/db.php') ;
include('../config/user_session.php') ;
$id = $_POST['id']; // reg id
$types = $_POST['type']; // type
$remark = $_POST['remark']; // 

$d = date('Y-m-d');
$s = date('h:m:sa');
$rand = uniqid();
//
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$vrt = $row['Virtual_Account'];
$name = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
$fn = $row['Firstname'];
$ln = $row['Lastname'];
$md = $row['Middlename'];
$bv = $row['BVN'];
$la = $row['Loan_Amount'];
$tm_id = $row['Team_id'];
$tm = $row['Team_Leader'];
$un = $row['Unions'];
$un_id = $row['Union_id'];
$br = $row['Branch'];
$br_id = $row['Branch_id'];
$pr = $row['Product'];
$pr_id = $row['Product_id'];
$int = $row['Interest_Amt'];
$rp = $row['Repayment_Amt'];
$tl = $row['Total_Loan'];
$up = $row['Upfront'];
$in = $row['Inssurance'];
$cd = $row['Card'];
$fm = $row['Form'];
$type = $row['Upfront_Types'];
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
$Query = "UPDATE register SET Virtual_Account = '$accountnumber', Status = 'Ready For Review', Approved_By = '$na', Stage = '3' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
//
// uploading reciept
$Image_Name = addslashes($_FILES['Pic']['name']);
$ImageName= $_FILES['Pic']['tmp_name'];
$Imagesize =  $_FILES['Pic']['size'];
$size =  getimagesize($ImageName);
$width = $size[0];
$height = $size[1];
//echo "$width x $height";
$imgsize=filesize($ImageName);
//if image is less than 75KB
if($imgsize > 1895674){
echo("Error description: " . mysqli_error($con));
exit();
}
if (!empty($Image_Name)) {
$path = "../reciept/".$id.$Image_Name;
if(move_uploaded_file($ImageName,$path)){
// move image
}else{
echo("Error description: " . mysqli_error($con));// failed to move reciept
}
} else {
$path = "No Reciept"; // or ''c
}
// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$in', '$fm', '$cd', 'Paid', '$d', '$s', '$tl', '$na', '$d',
'$type', '$path', 'Waiting For Confirmation')";
$result = mysqli_query($con, $query);
//
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$id', '$bv', '$name', '$remark', '$d', '$s', '$na', '$gr', 'Team Lead Stage')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}




}else{

// existing client

$Query = "UPDATE register SET Virtual_Account = '$vrt', Status = 'Ready For Review', Approved_By = '$na', Stage = '3' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
//
// uploading reciept
$Image_Name = addslashes($_FILES['Pic']['name']);
$ImageName= $_FILES['Pic']['tmp_name'];
$Imagesize =  $_FILES['Pic']['size'];
$size =  getimagesize($ImageName);
$width = $size[0];
$height = $size[1];
//echo "$width x $height";
$imgsize=filesize($ImageName);
//if image is less than 75KB
if($imgsize > 1895674){
echo("Error description: " . mysqli_error($con));
exit();
}
if (!empty($Image_Name)) {
$path = "../reciept/".$id.$Image_Name;
if(move_uploaded_file($ImageName,$path)){
// move image
}else{
echo("Error description: " . mysqli_error($con));// failed to move reciept
}
} else {
$path = "No Reciept"; // or ''
}
// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$in', '$fm', '$cd', 'Paid', '$d', '$s', '$tl', '$na', '$d',
'$type', '$path', 'Waiting For Confirmation')";
$result = mysqli_query($con, $query);
//
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$id', '$bv', '$name', '$remark', '$d', '$s', '$na', '$gr', 'Team Lead Stage')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}

?>