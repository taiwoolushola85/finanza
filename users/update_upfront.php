<?php
//if the add button has been clicked
include('../config/db.php') ;
include('../config/user_session.php') ;
$id = $_POST['id']; // reg id
$types = $_POST['type']; // type
$up = str_replace(array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['up']); // 
$ins = str_replace(array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['ins']); // 
$form = str_replace(array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['form']); // 
$card = str_replace(array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['card']); // 

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
$type = $row['Upfront_Types'];
$loan_status = $row['Loan_Status'];

//

if($type == 'Deduction'){
$path = "No Reciept"; // or ''

// checking if record already exist
$Query = "SELECT * FROM fee WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){


// just update
$query  = "UPDATE fee SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE Reg_id = '$id'";
$result = mysqli_query($con, $query);
//
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}


}else{

// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$ins', '$form', '$card', 'Paid', '$d', '$s', '$tl', '$na',
'$d', '$type', '$path', 'Waiting For Confirmation')";
$result = mysqli_query($con, $query);
//
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);

//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}


}







}else if($type == 'Monie Point Payment'){

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
echo "Reciept size is too large to upload to the server, please crop the image before uploading..";
exit();
}
if (!empty($Image_Name)) {
$path = "../reciept/".$id.$Image_Name;
if(move_uploaded_file($ImageName,$path)){
// move image
}else{
echo "Failed to upload image to the server.!";
}
} else {
$path = "No Reciept"; // or ''
}

// checking if record already exist
$Query = "SELECT * FROM fee WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){

$query  = "UPDATE fee SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE Reg_id = '$id'";
$result = mysqli_query($con, $query);
// just update record
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}


}else{
// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$ins', '$form', '$card', 'Paid', '$d', '$s', '$tl', '$na',
'$d', '$type', '$path', 'Waiting For Confirmation')";
$result = mysqli_query($con, $query);
//
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}




}else{
$path = "No Reciept"; // or ''

///checking if record already exist
$Query = "SELECT * FROM fee WHERE Reg_id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
//
$query  = "UPDATE fee SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE Reg_id = '$id'";
$result = mysqli_query($con, $query);
//
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);

//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}


}else{

// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$ins', '$form', '$card', 'Paid', '$d', '$s', '$tl', '$na', '$d',
'$type', '$path', 'Waiting For Confirmation')";
$result = mysqli_query($con, $query);
//
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);
//
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}


}

?>