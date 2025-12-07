<?php
//if the add button has been clicked
include('../config/db.php') ;
include('../config/user_session.php') ;
$id = $_POST['id']; // reg id
$type = $_POST['type']; // type
$d = date('Y-m-d');
$s = date('h:m:sa');
$rand = uniqid();
//
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
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
$path = "../reciept/" .$id."".$Image_Name;
if(move_uploaded_file($ImageName,$path)){
// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$in', '$fm', '$cd', 'Paid', '$d', '$s', '$tl', '$na', '$d',
'$type', '$path', 'Reciept Confirmed')";
$result = mysqli_query($con, $query);
// updating  info
$Query = "UPDATE register SET Upfront = '$up', Inssurance = '$in', Form = '$fm', Card = '$cd', Upfront_Status = 'Paid', Date_Paid = '$d', Time_Paid = '$s',
Reciever_Name = '$na' WHERE id = '$id' ";
$result= mysqli_query($con, $Query);

if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}else{
echo("Error description: " . mysqli_error($con));
exit();
}
?>