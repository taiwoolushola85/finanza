<?php
//if the add button has been clicked
include('../config/db.php') ;
include('../config/user_session.php') ;
$id = $_POST['id']; // reg id
$types = $_POST['type']; // type
$remark = $_POST['remark']; // 
$up = str_replace(array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['up']);// 
$ins = str_replace(array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['ins']);
$form = str_replace(array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['form']); // 
$card = str_replace(array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['card']); // 
$fee = $up + $ins + $form + $card;//

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
//
$Query = "UPDATE register SET Status = 'Ready For Underwriting' WHERE id = '$id'";
$result= mysqli_query($con, $Query);

// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$ins', '$form', '$card', 'Paid', '$d', '$s', '$tl', '$na',
'$d','$type', '$path', 'Waiting For Confirmation')"; 
$result = mysqli_query($con, $query);
//
if($result == true){
echo 1;
//
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);
//
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$id', '$bv', '$name', '$remark', '$d', '$s', '$na', '$gr', 'Team Lead Stage')";
$result= mysqli_query($con, $sql);

}else{
echo("Error description: " . mysqli_error($con));
}




}else if($type == 'Monie Point Payment'){

    
//
$Query = "UPDATE register SET Status = 'Ready For Underwriting' WHERE id = '$id'";
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
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$ins', '$form', '$card', 'Paid', '$d', '$s', '$tl', '$na', 
'$d', '$type', '$path', 'Waiting For Confirmation')";
$result = mysqli_query($con, $query);
//
if($result == true){
echo 1;
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);
//
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$id', '$bv', '$name', '$remark', '$d', '$s', '$na', '$gr', 'Team Lead Stage')";
$result= mysqli_query($con, $sql);
}else{
echo("Error description: " . mysqli_error($con));
}




}else if($type == 'Saving For Upfront'){

$Query = "SELECT id, Savings_Account_No, Balance, Loan_Account_No FROM savings WHERE Client_BVN = '$bv' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$idd = $rows['id'];
$sv = $rows['Savings_Account_No'];
$lon = $rows['Loan_Account_No'];
$bl = $rows['Balance'];
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status = 'Paid' AND Saving_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status = 'Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status = 'Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status = 'Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status = 'Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status = 'Paid' AND Reciever_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$bal = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;
$Query = "UPDATE repayments SET Savings_Bal = '$bal' WHERE Savings_Account_No = '$sv'";
$result= mysqli_query($con, $Query);
$Query = "UPDATE savings SET Savings_Paid = '$pmd', Balance = '$bal', Withdraw_Savings = '$pmw', Savings_Repayment = '$pmr', Savings_Transfer = '$pmtr', 
Savings_Upfront = '$pmu', Savings_Recieved = '$pmc' WHERE Savings_Account_No = '$sv'";
$result= mysqli_query($con, $Query);

//
if($bal < $fee){
echo "Insufficient balance in customer saving account.! please make a deposit to the saving account to proceed.";
exit();
}else{
$path = "No Reciept"; // or ''
//
$Query = "UPDATE register SET Status = 'Ready For Underwriting' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$ins', '$form', '$card', 'Paid', '$d', '$s', '$tl', '$na', '$d',
'$type', '$path', 'Waiting For Confirmation')";
$result = mysqli_query($con, $query);
//
if($result == true){
echo 1;
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);
//
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$id', '$bv', '$name', '$remark', '$d', '$s', '$na', '$gr', 'Team Lead Stage')";
$result= mysqli_query($con, $sql);
}else{
echo("Error description: " . mysqli_error($con));
}
}


}else{
$path = "No Reciept"; // or ''
//
$Query = "UPDATE register SET Status = 'Ready For Underwriting' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
// keeping payment record
$query  = "INSERT INTO fee (Reg_id, Firstname, Middlename, Lastname, Product, Product_id, Branch, Branch_id, Loan_Amount, Interest, Expected, Upfront, Inssurance,
Form, Card, Status, Date_Paid, Time_Paid, Total_Loan, Approved_By, Date_Approved, Payment_Method, Reciept, Reciept_Status)
VALUES ('$regid', '$fn', '$md', '$ln', '$pr', '$pr_id', '$br', '$br_id', '$la', '$int', '$rp', '$up', '$ins', '$form', '$card', 'Paid', '$d', '$s', '$tl', '$na', '$d',
'$type', '$path', 'Waiting For Confirmation')";
$result = mysqli_query($con, $query);
//
if($result == true){
echo 1;
$query  = "UPDATE register SET Upfront = '$up', Inssurance = '$ins', Form = '$form', Card = '$card' WHERE id = '$id'";
$result = mysqli_query($con, $query);
//
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$id', '$bv', '$name', '$remark', '$d', '$s', '$na', '$gr', 'Team Lead Stage')";
$result= mysqli_query($con, $sql);
}else{
echo("Error description: " . mysqli_error($con));
}

}

?>