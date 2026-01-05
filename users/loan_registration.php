<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$bv = trim($_POST['bvn']);// client bvn
$fn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['sn']); // surname
$mn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['fn']); // firstname
$ln = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['ln']); //nlastname
$ad = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ad']); // address
$union = $_POST['un'];// union
$education = $_POST['ed'];// education
$ph = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ph']);// phone
$img = $_POST['img'];// client image
$imgs = $_POST['imgs'];// gaurantor image
$gn = $_POST['gn'];// gender
$age = $_POST['db']; //date of birth
$repday = $_POST['repday']; //repayment day
$ms = $_POST['ms']; //marital status
// client id type
$doc = $_POST['doc'];
$docn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['docn']);
// contact info
$st1 = $_POST['sta']; // customer state
$ct1 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['cit']); // customer town
// business info
$bsn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['bsn']); // bussiness name
$bt = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['bt']);// bussiness type
$st = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['st2']); // bussiness state
$sd = $_POST['sd']; // bussiness start date
$add = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ad2']); // bussiness address
$sh = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['sh']);// shop ownership
$owner = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['owner']);
//guarantor info
$nin = trim($_POST['nin']);// guarantor nin
$fn2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['surname2']);// guarantor first name
$mn2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['firstname2']); // guarantor middle name
$ln2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['lastname2']); // guarantor lastname
$occupation = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['occupation']); // guarantor occupation
$ph2 = $_POST['phone2']; //guarantor phone
$ad2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['address3']);// guarantor addres
$re2 = $_POST['relationship'];// relationship
$gn2 = $_POST['gender3'];// guarantor gender
$remark = $_POST['remark'];// comment
$id_no2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['idno']);// id card no
$id_type2 = $_POST['idtype'];// id card type
$date_month = date("M", strtotime($age));
$rand = rand();
// other info
$d = date('Y-m-d');// date
$s = date('h:m:sa');// time
$mth = date('M');// time
$yrs = date('Y');// time
//checking if all filed has been filled
if(empty($bv) || empty($fn) || empty($mn) || empty($ln) || empty($ad) || empty($union) || empty($education) || empty($ph) || empty($gn) || empty($age) || empty($ms) 
|| empty($doc) || empty($docn) || empty($st1) || empty($ct1) || empty($bsn) || empty($bt) || empty($st) || empty($sd) || empty($add) || empty($sh) || empty($owner) 
|| empty($nin) || empty($fn2) || empty($mn2) || empty($ln2) || empty($occupation) || empty($ph2) || empty($ad2) || empty($re2) || empty($gn2) || empty($remark)
|| empty($id_no2) || empty($id_type2) || empty($img)){
echo 1;
exit();
}else{
// getting team leader info
$Query = "SELECT * FROM mapping WHERE Loan_Officer='$user'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$map_id = $row['id'];
$off_id = $row['Officer_id'];
$tm_id = $row['Team_id'];
$ofn = $row['Officer_Name'];
$tmn = $row['Team_Name'];
$tlm = $row['Team_Leader'];
$br = $row['Branch'];
$ffu = $fn ." ".  $mn ." ". $ln; // guarantor full name
// client full name
$fll = $fn." ".$mn." ".$ln; 
// getting union id for registration
$Query = "SELECT * FROM groups WHERE id='$union'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$un_id = $row['id'];
$un_name = $row['Name'];
// inserting the customer information
$sql = "INSERT INTO register (Virtual_Account, Firstname, Middlename, Lastname, Address, Education, Phone, Gender, Branch, Years, Birthday_Month, Maritial_Status,
Branch_id, State, Town, Location, Product, Product_id, Tenure, Frequency, Rate, Unions, Union_id, Loan_Amount, Bank, Account_Name, Account_No, BVN, Document,
Document_No, Business, Biz_Type, Biz_State, Start_Date, Cash_Flow, Biz_Address, Biz_Owner, Shop_Owner, Date_Reg, Time_Reg, Status, User, User_id, Team_Leader,
Team_id, Officer_Name, Team_Name, Map_id, Verification_Status, Interest_Amt, Monthly_Interest, Repayment_Amt, Total_Loan, Upfront, Inssurance, Form, Card,
Schedule_Status, Application_Status, Saving_Type, Repayment_Day, Loan_Status, Months, Year_Booked, Stage) 
VALUES ('NA', '$fn', '$mn', '$ln', '$ad', '$education', '$ph', '$gn', '$brss', '$age', '$date_month', '$ms', '$brss_id', '$st1', '$ct1', '$img', '-', '-',
'-', '-', '-', '$un_name', '$un_id', '0', '-', '-', '-', '$bv', '$doc', '$docn', '$bsn', '$bt', '$st', '$sd', '-', '$add', '$owner', 
'$sh', '$d', '$s', 'Under Review', '$User', '$usd_id', '$tlm', '$tm_id', '$ofn', '$tmn', '$map_id', 'Waiting', '0', '0', '0', '0', '0', '0', '0', '0', 
'Not Confirmed', 'Registered', 'Express Savings', '$repday', 'New Client', '$mth', '$yrs', '1')";
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
VALUES ('$last_id', '$bv', '$fll', '$remark', '$d', '$s', '$na', '$gr', 'Registration Stage')";
$result= mysqli_query($con, $sql);

if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>