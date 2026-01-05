<?php
// Database configuration
include '../config/db.php';
include '../config/user_session.php';
$id = $_POST["id"];
$toba = $_POST["tba"]; // loan balance
$sa = str_replace( array("#", "'", ";", "/", "-", "@", "_",  ","), '',$_POST['sa']);// savings deopsited
$recipt_no = "Not Valid"; // reference no
//////$d = $_POST["dt"]; // payment date

// avoid zero input in savings
if($sa == "0"){
echo 21;
exit();
}

$result = mysqli_query($con, "SELECT * FROM savings WHERE id='$id'");
$row= mysqli_fetch_array($result);
$id = $row['id'];
$virtual_acct = $row['Virtual_Account'];
$dis = $row['Disbursement_No'];
$tr = $row['Transaction_id'];
$ln = $row['Loan_Account_No'];
$sn = $row['Savings_Account_No'];
$fn = $row['Firstname'];
$md = $row['Middlename'];
$lnm = $row['Lastname'];
$fll = $fn." ". $md. " ". $lnm;
$un = $row['Unions'];
$cu_id = $row['Union_id'];
$pr_name = $row['Product'];
$pr_id = $row['Product_id'];
$us = $row['User'];
$us_id = $row['User_id'];
$tm = $row['Team_Leader'];
$ofn = $row['Officer_Name'];
$tmn = $row['Team_Name'];
$br_name = $row['Branch'];
$br_id = $row['Branch_id'];
$la = $row['Loan_Amount'];
$fr = $row['Frequency'];
$du = $row['Duration'];
$tim = $row['Team_id'];
$reg = $row['Reg_id'];
$ph = $row['Phone'];
$d = date('Y-m-d');
$ss = date('h:m:sa');
$mth = date('M');
$yrs = date('Y');
$rand = rand();
$ran = uniqid();
//
$Query = "SELECT Rate FROM product_list WHERE Product_id = '$pr_id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$rt = $row['Rate'];
// reciept uploading
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
echo 7;
exit();
}else{
$path = "../reciept/".$ran."".$Image_Name;
move_uploaded_file($ImageName,$path);
}


// checking if you have made posting for that date
$result = mysqli_query($con, "SELECT * FROM save WHERE Transaction_id='$tr' AND User = '$User' AND Status = 'Paid' AND Date_Paid = '$d'
AND Posting_Method = 'Basic Posting' ORDER BY id DESC LIMIT 1");
$row = mysqli_num_rows($result);
if($row != 0){
echo 4;
exit();
}

// checking for double posting for savings
$result = mysqli_query($con, "SELECT * FROM save WHERE Transaction_id='$tr' AND Status != 'Paid' AND User = '$User' AND Posting_Method = 'Basic Posting'");
$row = mysqli_num_rows($result);
if($row != 0){
echo 8;
exit();
}




if (empty($sa)){
// do nothing

}else{
// saving record
$query  = "INSERT INTO save (Session_No, History_id, Virtual_Acct, Reps_id, Disbursement_No, Register_id, Repayment_id, Savings_id, Loan_Account_No, Transaction_id, 
Saving_Account, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch, Branch_Code, 
Reciept, Status, User, User_id, Team_Leader, Officer_Name, Team_Name, Date_Paid, Time_Paid, Team_id, Payment_Method, Posting_Method, Months, Years)
VALUES ('NA', '$id', '$virtual_acct', '$id', '$dis', '$reg', '$id', '$rand', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$sa', '$du', '$fr', 
'$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', '$path', 'Waiting For Approval', '$us', '$us_id', '$tm', '$ofn', '$tmn', '$d',  '$ss',  '$tim', 
'Monie Point', 'Basic Posting', '$mth', '$yrs')";
$result = mysqli_query($con, $query);
if($result == true){
echo 15;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>