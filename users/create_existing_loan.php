<?php
include '../config/db.php';
include '../config/user_session.php';
$id = intval($_POST['id']);// registration id
$fee = $_POST['type'];// fee type
$repday = $_POST['repday'];// repayment day
$un = $_POST['un'];// union id
$pr = $_POST['pr'];// product id
$ten = $_POST['ten'];// tenure
$lums = $_POST['lum'];// loan amount
$bnk = $_POST['bn'];// bank
$an = $_POST['an'];// account no
$ann = $_POST['ann']; //account name
$nin = $_POST['nin'];// nin
// gaurantor info
$fn2 = $_POST['surname2'];//surname
$mn2 = $_POST['firstname2'];// firstname
$ln2 = $_POST['lastname2'];// lastname
$ph2 = $_POST['phone2'];// phone
$ad2 = $_POST['address3'];// address
$occupation = $_POST['occupation'];// occupation
$re2 = $_POST['relationship'];// relationship
$gn2 = $_POST['gender3'];// gender
$id_type2 = $_POST['idtype'];// id type
$id_no2 = $_POST['idno'];// id no
$imgs = $_POST['imgs'];// image
$remark = $_POST['remark'];// remark
// validating input
$missing = [];
$fields = [
    'id'=>'Registration ID', 
    'type'=>'Fee Type', 
    'repday'=>'Repayment Day',
    'un'=>'Union', 
    'pr'=>'Product', 
    'ten'=>'Tenure', 
    'lum'=>'Loan Amount',
    'bn'=>'Bank Name', 
    'an'=>'Account Number', 
    'ann'=>'Account Name', 
    'nin'=>'NIN',
    'surname2'=>'Guarantor Surname', 
    'firstname2'=>'Guarantor First Name',
    'lastname2'=>'Guarantor Last Name', 
    'phone2'=>'Guarantor Phone',
    'address3'=>'Guarantor Address', 
    'occupation'=>'Guarantor Occupation',
    'relationship'=>'Relationship', 
    'gender3'=>'Guarantor Gender',
    'idtype'=>'Guarantor ID Type', 
    'idno'=>'Guarantor ID Number', 
    'imgs'=>'Guarantor Image', 
    'remark'=>'Remark'
];

foreach($fields as $key => $name) {
if(empty(trim($_POST[$key] ?? ''))) $missing[] = $name;
}

if($missing) {
echo "You missed the following filed: " . implode(', ', $missing);
exit();
}

//getting other info
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$vrt = $row['Virtual_Account'];
$fn = $row['Firstname'];
$mn = $row['Middlename'];
$ln = $row['Lastname'];
$ad = $row['Address'];
$education = $row['Education'];
$gn = $row['Gender'];
$ph = $row['Phone'];
$age = $row['Years'];
$date_month = $row['Birthday_Month'];
$ms = $row['Maritial_Status'];
$st1 = $row['State'];
$ct1 = $row['Town'];
$img = $row['Location'];
$bv = $row['BVN'];
$doc = $row['Document'];
$docn = $row['Document_No'];
$bsn = $row['Business'];
$bt = $row['Biz_Type'];
$st = $row['Biz_State'];
$sd = $row['Start_Date'];
$add = $row['Biz_Address'];
$owner = $row['Biz_Owner'];
$sh = $row['Shop_Owner'];
$fll = $fn ." ".  $mn ." ". $ln; //  full name

// other info
$d = date('Y-m-d');// date
$s = date('h:m:sa');// time
$mth = date('M');// time
$yrs = date('Y');// time

// getting loan product for registration
$Query = "SELECT Product, Rate, Frequency, Inssurance, Tenure FROM product_list WHERE Product_id = '$pr' AND Tenure = '$ten'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pr_name = $row['Product'];
$rt = $row['Rate'];
$frq = $row['Frequency'];
$ins = $row['Inssurance'];
$tens = $row['Tenure'];

// getting team leader info
$Query = "SELECT * FROM mapping WHERE Loan_Officer = '$User'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$map_id = $row['id'];
$off_id = $row['Officer_id'];
$tm_id = $row['Team_id'];
$ofn = $row['Officer_Name'];
$tmn = $row['Team_Name'];
$tlm = $row['Team_Leader'];
$br = $row['Branch'];
// getting union id for registration
$Query = "SELECT * FROM groups WHERE id='$un'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$un_id = $row['id'];
$un_name = $row['Name'];
//
//
if($frq == 'Daily'){
$dd = $lums + 0; // the intererst is 0
$repayment_amt = $lums / $ten;// repayment amt
$round_repayment = round($repayment_amt);// rounding up repayment amt
// total loan balance
$total_loan = $lums + 0;
$rnd_total_loan = round($total_loan);// rounding up total loan

// inserting the customer information
$sql = "INSERT INTO register (Virtual_Account, Firstname, Middlename, Lastname, Address, Education, Phone, Gender, Branch, Years, Birthday_Month, Maritial_Status,
Branch_id, State, Town, Location, Product, Product_id, Tenure, Frequency, Rate, Unions, Union_id, Loan_Amount, Bank, Account_Name, Account_No, BVN, Document,
Document_No, Business, Biz_Type, Biz_State, Start_Date, Cash_Flow, Biz_Address, Biz_Owner, Shop_Owner, Date_Reg, Time_Reg, Status, User, User_id, Team_Leader,
Team_id, Officer_Name, Team_Name, Map_id, Verification_Status, Interest_Amt, Monthly_Interest, Repayment_Amt, Total_Loan, Upfront, Inssurance, Form, Card,
Upfront_Types, Schedule_Status, Application_Status, Saving_Type, Repayment_Day, Loan_Status, Months, Year_Booked, Approval_Type) 
VALUES ('$vrt', '$fn', '$mn', '$ln', '$ad', '$education', '$ph', '$gn', '$brss', '$age', '$date_month', '$ms', '$brss_id', '$st1', '$ct1', '$img', '$pr_name ', '$pr',
'$tens', '$frq', '$rt', '$un_name', '$un_id', '$lums', '$bnk', '$ann', '$an', '$bv', '$doc', '$docn', '$bsn', '$bt', '$st', '$sd', '0', '$add', '$owner', 
'$sh', '$d', '$s', 'Under Review', '$User', '$usd_id', '$tlm', '$tm_id', '$ofn', '$tmn', '$map_id', 'Waiting', '0', '0', '$round_repayment', '$rnd_total_loan', 
'0', '0', '0', '0', '$fee', 'Not Confirmed', 'Registered', 'Express Savings', '$repday', 'Existing Client',
'$mth', '$yrs', 'NA')";
$result= mysqli_query($con, $sql);
$last_id = mysqli_insert_id($con);// last insert id
// gaurantor information
$sql = "INSERT INTO gaurantors (Firstname, Middlename, Lastname, Phone, Address, Relationship, Gender, Location, Date_Reg, Time_Reg, User, User_id, Team_Leader, 
Officer_Name, Team_Name, Team_id, Status, Regis_id, ID_No, ID_Type, ID_Image, Client_BVN, Client_Name, Gaurantor_BVN, Occupation) 
VALUES ('$fn2', '$mn2', '$ln2', '$ph2', '$ad2', '$re2', '$gn2', '$imgs', '$d', '$s', '$User', '$usd_id', '$tlm', '$ofn', '$tmn', '$tm_id', 'Active', '$last_id', 
'$id_no2', '$id_type2', 'NA', '$bv', '$fll', '$nin', '$occupation')";
$result= mysqli_query($con, $sql);
//comment box
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$last_id', '$bv', '$fll', '$remark', '$d', '$s', '$na', '$gr', 'Review Stage')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}


}else{
$rr = 100 / $rt;
$interest_amount = $lums / $rr;// interest amt
$round_interest = round($interest_amount); /// rounding up interest amount
// expected repayment
$expected_amount = $lums + $interest_amount; 
$repayment_amount = $expected_amount / $ten;// repayment amt
$round_repayment = round($repayment_amount);// rounding up repayment amt
// total loan balanceRepayment_Day
$total_loan = $lums + $interest_amount;
$round_total_loan = round($total_loan);// rounding up total loan
$int_per_repayment = round($round_interest/$ten);

// inserting the customer information
$sql = "INSERT INTO register (Virtual_Account, Firstname, Middlename, Lastname, Address, Education, Phone, Gender, Branch, Years, Birthday_Month, Maritial_Status,
Branch_id, State, Town, Location, Product, Product_id, Tenure, Frequency, Rate, Unions, Union_id, Loan_Amount, Bank, Account_Name, Account_No, BVN, Document,
Document_No, Business, Biz_Type, Biz_State, Start_Date, Cash_Flow, Biz_Address, Biz_Owner, Shop_Owner, Date_Reg, Time_Reg, Status, User, User_id, Team_Leader,
Team_id, Officer_Name, Team_Name, Map_id, Verification_Status, Interest_Amt, Monthly_Interest, Repayment_Amt, Total_Loan, Upfront, Inssurance, Form, Card,
Upfront_Types, Schedule_Status, Application_Status, Saving_Type, Repayment_Day, Loan_Status, Months, Year_Booked, Approval_Type) 
VALUES ('$vrt', '$fn', '$mn', '$ln', '$ad', '$education', '$ph', '$gn', '$brss', '$age', '$date_month', '$ms', '$brss_id', '$st1', '$ct1', '$img', '$pr_name ', '$pr',
'$tens', '$frq', '$rt', '$un_name', '$un_id', '$lums', '$bnk', '$ann', '$an', '$bv', '$doc', '$docn', '$bsn', '$bt', '$st', '$sd', '0', '$add', '$owner', 
'$sh', '$d', '$s', 'Under Review', '$User', '$usd_id', '$tlm', '$tm_id', '$ofn', '$tmn', '$map_id', 'Waiting', '$round_interest', '$int_per_repayment', 
'$round_repayment', '$round_total_loan', '0', '0', '0', '0', '$fee', 'Not Confirmed', 'Registered', 'Express Savings', '$repday', 'Existing Client',
'$mth', '$yrs', 'NA')";
$result= mysqli_query($con, $sql);
$last_id = mysqli_insert_id($con);// last insert id
// gaurantor information
$sql = "INSERT INTO gaurantors (Firstname, Middlename, Lastname, Phone, Address, Relationship, Gender, Location, Date_Reg, Time_Reg, User, User_id, Team_Leader, 
Officer_Name, Team_Name, Team_id, Status, Regis_id, ID_No, ID_Type, ID_Image, Client_BVN, Client_Name, Gaurantor_BVN, Occupation) 
VALUES ('$fn2', '$mn2', '$ln2', '$ph2', '$ad2', '$re2', '$gn2', '$imgs', '$d', '$s', '$User', '$usd_id', '$tlm', '$ofn', '$tmn', '$tm_id', 'Active', '$last_id', 
'$id_no2', '$id_type2', 'NA', '$bv', '$fll', '$nin', '$occupation')";
$result= mysqli_query($con, $sql);
//comment box
$sql = "INSERT INTO comment (Reg_No, BVN_No, Name, Comment, Date_Comment, Time_Comment, Comment_By, User_Role, Comment_Level) 
VALUES ('$last_id', '$bv', '$fll', '$remark', '$d', '$s', '$na', '$gr', 'Review Stage')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}
mysqli_close($con);
?>