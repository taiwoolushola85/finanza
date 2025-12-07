<?php
// onboarding process
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// client reg id
//$fn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['sn']); // surname
//$mn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['fn']); // firstname
//$ln = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['ln']); //nlastname
$ad = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ad']); // address
$education = $_POST['ed'];// education
//$ph = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ph']);// phone
//$gn = $_POST['gn'];// gender
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
//$nin = trim($_POST['nin']);// guarantor nin
//$fn2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['surname2']);// guarantor first name
//$mn2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['firstname2']); // guarantor middle name
//$ln2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['lastname2']); // guarantor lastname
$occupation = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['occupation']); // guarantor occupation
//$ph2 = $_POST['phone2']; //guarantor phone
$ad2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['address3']);// guarantor addres
$re2 = $_POST['relationship'];// relationship
//$gn2 = $_POST['gender3'];// guarantor gender
$remark = $_POST['remark'];// comment
$id_no2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['idno']);// id card no
$id_type2 = $_POST['idtype'];// id card type
// updating the customer information
$sql = "UPDATE register SET Address = '$ad', Education = '$education',  Maritial_Status = '$ms', Document = '$doc', Document_Type = '$docn', Repayment_Day = '$repday',
State = '$st1', Town = '$ct1', Business = '$bsn', Biz_Type = '$bt', Biz_State = '$st', Start_Date = '$sd', Biz_Address = '$add', Biz_Owner = '$owner',
Shop_Owner = '$sh' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
// gaurantor information
$sql = "UPDATE gaurantors SET Address = '$ad2', Relationship = '$re2', ID_Type = '$id_type2', ID_No = '$id_no2' WHERE Regis_id = '$id' ";
$result= mysqli_query($con, $sql);
// comment record
$sql = "UPDATE comment SET Comment = '$remark' WHERE Reg_No = '$id' ";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>