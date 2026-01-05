<?php
include '../config/db.php';
include '../config/user_session.php';
$id = intval($_POST['id']);// registration id
$fee = $_POST['type'];// fee type
$repday = $_POST['repday'];// repayment day
$un = $_POST['un'];// union id
$pr = $_POST['pr'];// product id
$ten = $_POST['ten'];// tenure
$lum = $_POST['lum'];// loan amount
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
//processing based on frequency
if($frq == 'Daily'){
// expected repayment
$dd = $lum + 0; // the intererst is 0
$dailyrep_amt = $lum / $ten;// repayment amt
$dailyrnd_rep = round($dailyrep_amt);// rounding up repayment amt
// total loan balance
$dailyt_loan = $lum + 0;
$dailyrnd_tloan = round($dailyt_loan);// rounding up total loan
// Calculate the upfront interest
$rr = 100 / $rt;
$upfront_interest = $lum / $rr;// interest amt
// Calculate the inssurance percentage
$inssurance = ($lum * $ins) / 100;
// getting union id for registration
$Query = "SELECT * FROM groups WHERE id='$un'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$un_id = $row['id'];
$un_name = $row['Name'];
// inserting the customer information
$sql = "INSERT INTO register (Virtual_Account, Firstname, Middlename, Lastname, Address, Education, Phone, Gender, Branch, Years, Birthday_Month, Maritial_Status,
Branch_id, State, Town, Location, Product, Product_id, Tenure, Frequency, Rate, Unions, Union_id, Loan_Amount, Bank, Account_Name, Account_No, BVN, Document,
Document_No, Business, Biz_Type, Biz_State, Start_Date, Cash_Flow, Biz_Address, Biz_Owner, Shop_Owner, Date_Reg, Time_Reg, Status, User, User_id, Team_Leader,
Team_id, Officer_Name, Team_Name, Map_id, Verification_Status, Interest_Amt, Monthly_Interest, Repayment_Amt, Total_Loan, Upfront, Inssurance, Form, Card,
Upfront_Types, Schedule_Status, Application_Status, Saving_Type, Repayment_Day, Loan_Status, Months, Year_Booked, Stage) 
VALUES ('$vrt', '$fn', '$mn', '$ln', '$ad', '$education', '$ph', '$gn', '$brss', '$age', '$date_month', '$ms', '$brss_id', '$st1', '$ct1', '$img', '$pr_name', '$pr',
'$tens', '$frq, '$rt', '$un_name', '$un_id', '$lum', '$bnk', '$ann', '$an', '$bv', '$doc', '$docn', '$bsn', '$bt', '$st', '$sd', '0', '$add', '$owner', 
'$sh', '$d', '$s', 'Waiting For Verification', '$User', '$usd_id', '$tlm', '$tm_id', '$ofn', '$tmn', '$map_id', 'Waiting', '0', '0', '$dailyrnd_rep', 
'$dailyrnd_tloan', '$upfront_interest', '$inssurance', '500', '1000', 
'$fee', 'Not Confirmed', 'Registered', 'Express Savings', '$repday', 'Existing Client', '$mth', '$yrs', '2')";
$result= mysqli_query($con, $sql);
$last_id = mysqli_insert_id($con);// last insert id
// gaurantor information
$sql = "INSERT INTO gaurantors (Firstname, Middlename, Lastname, Phone, Address, Relationship, Gender, Location, Date_Reg, Time_Reg, User, User_id, Team_Leader, 
Officer_Name, Team_Name, Team_id, Status, Regis_id, ID_No, ID_Type, ID_Image, Client_BVN, Client_Name, Gaurantor_BVN, Occupation) 
VALUES ('$fn2', '$mn2', '$ln2', '$ph2', '$ad2', '$re2', '$gn2', '$imgs', '$d', '$s', '$User', '$usd_id', '$tlm', '$ofn', '$tmn', '$tm_id', 'Active', '$last_id', 
'$id_no2', '$id_type2', '-', '$bv', '$fll', '$nin', '$occupation')";
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
    
// interest
$rr = 100 / $rt;
$in_amt = $lum / $rr;// interest amt
$rnds_int = round($in_amt); /// rounding up interest amount
// expected repayment
$dd = $lum + $in_amt; 
$rep_amt = $lum/$ten + $rnds_int;// repayment amt
$rnd_rep = round($rep_amt);// rounding up repayment amt
// total loan balance
$t_loan = $lum + ($rnds_int * $ten);
$rnd_tloan = round($t_loan);// rounding up total loan
//
$total_int = $rnds_int * $ten;
// Calculate the upfront interest
$upfront_saving = ($lum * $rt) / 100;
// Calculate the inssurance percentage
$inssurance = ($lum * $ins) / 100;
//monthly interest
$monthly_intrest = $total_int / $ten;

// getting union id for registration
$Query = "SELECT * FROM groups WHERE id = '$un'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$un_id = $row['id'];
$un_name = $row['Name'];
// inserting the customer information
$sql = "INSERT INTO register (Virtual_Account, Firstname, Middlename, Lastname, Address, Education, Phone, Gender, Branch, Years, Birthday_Month, Maritial_Status,
Branch_id, State, Town, Location, Product, Product_id, Tenure, Frequency, Rate, Unions, Union_id, Loan_Amount, Bank, Account_Name, Account_No, BVN, Document,
Document_No, Business, Biz_Type, Biz_State, Start_Date, Cash_Flow, Biz_Address, Biz_Owner, Shop_Owner, Date_Reg, Time_Reg, Status, User, User_id, Team_Leader,
Team_id, Officer_Name, Team_Name, Map_id, Verification_Status, Interest_Amt, Monthly_Interest, Repayment_Amt, Total_Loan, Upfront, Inssurance, Form, Card,
Upfront_Types, Schedule_Status, Application_Status, Saving_Type, Repayment_Day, Loan_Status, Months, Year_Booked, Stage) 
VALUES ('$vrt', '$fn', '$mn', '$ln', '$ad', '$education', '$ph', '$gn', '$brss', '$age', '$date_month', '$ms', '$brss_id', '$st1', '$ct1', '$img', '$pr_name', '$pr',
'$tens', '$frq', '$rt', '$un_name', '$un_id', '$lum', '$bnk', '$ann', '$an', '$bv', '$doc', '$docn', '$bsn', '$bt', '$st', '$sd', '0', '$add', '$owner', 
'$sh', '$d', '$s', 'Waiting For Verification', '$User', '$usd_id', '$tlm', '$tm_id', '$ofn', '$tmn', '$map_id', 'Waiting', '$total_int', '$monthly_intrest', 
'$rnd_rep', '$rnd_tloan', '$upfront_saving', '$inssurance', '500', '1000', 
'$fee', 'Not Confirmed', 'Registered', 'Express Savings', '$repday', 'Existing Client', '$mth', '$yrs', '2')";
$result= mysqli_query($con, $sql);
$last_id = mysqli_insert_id($con);// last insert id
// gaurantor information
$sql = "INSERT INTO gaurantors (Firstname, Middlename, Lastname, Phone, Address, Relationship, Gender, Location, Date_Reg, Time_Reg, User, User_id, Team_Leader, 
Officer_Name, Team_Name, Team_id, Status, Regis_id, ID_No, ID_Type, ID_Image, Client_BVN, Client_Name, Gaurantor_BVN, Occupation) 
VALUES ('$fn2', '$mn2', '$ln2', '$ph2', '$ad2', '$re2', '$gn2', '$imgs', '$d', '$s', '$User', '$usd_id', '$tlm', '$ofn', '$tmn', '$tm_id', 'Active', '$last_id', 
'$id_no2', '$id_type2', '-', '$bv', '$fll', '$nin', '$occupation')";
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