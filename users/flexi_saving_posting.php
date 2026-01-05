<?php
// Database configuration
include '../config/db.php';
include '../config/user_session.php';
$id = intval($_POST["id"]);
$toba = $_POST["tba"]; // loan balance
$sa = str_replace( array("#", "'", ";", "/", "-", "@", "_",  ","), '',$_POST['sa']);// savings deopsited
$recipt_no = "Not Valid"; // reference no
//////$d = $_POST["dt"]; // payment date

// avoid zero input in savings
if($sa == "0"){
echo 21;
exit();
}

$result = mysqli_query($con, "SELECT * FROM flexi_account WHERE id='$id'");
$row= mysqli_fetch_array($result);
$id = $row['id'];
$flexid = $row['Flexi_id'];
$acct = $row['Flexi_Account_No'];
$fn = $row['Surname'];
$md = $row['Firstname'];
$lnm = $row['Othername'];
$fll = $fn." ". $md. " ". $lnm;
$pr_name = $row['Plan'];
$br = $row['Branch'];
$brid = $row['Branch_id'];
$us = $row['User'];
$us_id = $row['User_id'];
$tm = $row['Team_Leader'];
$ofn = $row['Officer_Name'];
$tmn = $row['Team_Name'];
$fr = $row['Frequency'];
$tim = $row['Team_id'];
$d = date('Y-m-d');
$ss = date('h:m:sa');
$mth = date('M');
$yrs = date('Y');
$rand = rand();
$ran = uniqid();

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
$result = mysqli_query($con, "SELECT * FROM flexi_history WHERE Flexi_Account = '$acct' AND User = '$User' AND Status = 'Paid' AND Date_Paid = '$d'
AND Posting_Method = 'Basic Posting' ORDER BY id DESC LIMIT 1");
$row = mysqli_num_rows($result);
if($row != 0){
echo 4;
exit();
}

// checking for double posting for savings
$result = mysqli_query($con, "SELECT * FROM flexi_history WHERE Flexi_Account = '$acct' AND Status != 'Paid' AND User = '$User' AND Posting_Method = 'Basic Posting'");
$row = mysqli_num_rows($result);
if($row != 0){
echo 8;
exit();
}




if (empty($sa)){
// do nothing

}else{
// saving record
$query  = "INSERT INTO flexi_history (Flexi_Reg, Flexi_Account, Surname, Firstname, Othername, Branch, Branch_No, Plan, Amount, User, User_id, Officer_Name, 
Team_Leader, Team_Name, Status, Date_Paid, Time_Paid, Payment_Method, Location, Posting_Method)
VALUES ('$flexid', '$acct', '$fn', '$md', '$lnm', '$br', '$brid', '$pr_name', '$sa', '$us', '$us_id', '$ofn', '$tm', '$tmn', 'Waiting For Approval', '$d', '$ss',
'Monie Point', '$path', 'Basic Posting')";
$result = mysqli_query($con, $query);
if($result == true){
echo 15;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>