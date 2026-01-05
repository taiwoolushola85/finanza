<?php
include '../config/db.php';

/* ---------- Helper Sanitizer ---------- */
function clean($value) {
    return trim(preg_replace('/[^a-zA-Z0-9\s]/', '', $value));
}

/* ---------- Collect & Sanitize Inputs ---------- */
$fn   = clean($_POST['fn'] ?? '');
$sn   = clean($_POST['sn'] ?? '');
$ln   = clean($_POST['ln'] ?? '');
$ph   = clean($_POST['ph'] ?? '');
$ha   = clean($_POST['ha'] ?? '');
$bv   = preg_replace('/\D/', '', $_POST['bvn'] ?? '');
$ba   = clean($_POST['ba'] ?? '');
$ms   = clean($_POST['ms'] ?? '');
$bnk  = clean($_POST['bnk'] ?? '');
$ac   = clean($_POST['ac'] ?? '');
$an   = clean($_POST['an'] ?? '');
$pl   = clean($_POST['pl'] ?? '');
$fr   = clean($_POST['fr'] ?? '');
$ty   = clean($_POST['ty'] ?? '');
$dn   = clean($_POST['dn'] ?? '');
$nsu  = clean($_POST['nsu'] ?? '');
$nfn  = clean($_POST['nfn'] ?? '');
$no   = clean($_POST['no'] ?? '');
$re   = clean($_POST['re'] ?? '');
$na   = clean($_POST['na'] ?? '');
$ph2  = clean($_POST['ph2'] ?? '');
$ocu  = clean($_POST['ocu'] ?? '');
$nat  = clean($_POST['nat'] ?? '');
$stog = clean($_POST['stog'] ?? '');
$gen  = clean($_POST['gen'] ?? '');
$card  = clean($_POST['card'] ?? '');
$ini  = clean($_POST['ini'] ?? '');

$user = mysqli_real_escape_string($con, $_POST['user'] ?? '');
$img  = mysqli_real_escape_string($con, $_POST['img'] ?? '');

/* ---------- Date & Time ---------- */
$d = date('Y-m-d');
$s = date('h:m:sa');

/* ---------- Get User Info ---------- */
$userQ = mysqli_query($con, "SELECT * FROM users WHERE Username='$user'");
if (mysqli_num_rows($userQ) == 0) {
    echo 0;
    exit;
}
$userRow = mysqli_fetch_assoc($userQ);

$usd_id  = $userRow['id'];
$User    = $userRow['Username'];
$brss    = $userRow['Branch'];
$brss_id = $userRow['Branch_id'];

/* ---------- Get Mapping Info ---------- */
$mapQ = mysqli_query($con, "SELECT * FROM mapping WHERE Loan_Officer='$User'");
if (mysqli_num_rows($mapQ) == 0) {
    echo "No mapping found for this user.";
    exit;
}
$mapRow = mysqli_fetch_assoc($mapQ);

$map_id = $mapRow['id'];
$tm_id  = $mapRow['Team_id'];
$ofn    = $mapRow['Officer_Name'];
$tmn    = $mapRow['Team_Name'];
$tlm    = $mapRow['Team_Leader'];

/* ---------- Check BVN Duplicate ---------- */
$chk = mysqli_query($con, "SELECT id FROM flexi_reg WHERE Client_BVN = '$bv'");
if (mysqli_num_rows($chk) > 0) {
echo 1; // BVN exists
exit;
}


/* ---------- Insert Record ---------- */
$sql = "INSERT INTO flexi_reg (Surname, Firstname, Othername, Phone, Gender, Address, Client_BVN, Biz_Address, Marital_Status, Bank, Account_No, Account_Name,
Plan, Frequency, Interest, Duration, ID_Type, ID_No, NOK_Surname, NOK_Firstname, NOK_Othername, Relationship, NOK_Phone, NOK_Address, User, User_id, Team_Leader,
Team_id, Officer_Name, Team_Name, Map_id, Branch, Branch_Code, Plan_id, Status, Location, Date_Reg, Time_Reg, Deposit_Amt, Interest_Amt, Total_Saving, Occupation,
Nationality, State_Of_Origin, Application_Status) VALUES ('$sn', '$fn','$ln', '$ph','$gen','$ha','$bv','$ba','$ms','$bnk','$ac','$an','$pl','$fr', '0', '-', '$ty',
'$dn', '$nsu', '$nfn', '$no', '$re', '$ph2', '$na', '$User', '$usd_id', '$tlm', '$tm_id', '$ofn', '$tmn', '$map_id', '$brss', '$brss_id', 'NA', 'Processing', 
'$img', '$d', '$s', '$ini', '0', '$ini', '$ocu', '$nat', '$stog', 'Registered')";
$result = mysqli_query($con, $sql);
$last_id = mysqli_insert_id($con);// Get last inserted ID
// Upload Reciept Picture
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
echo "Image size is too large. Maximum size is 1.8MB";
exit();
}else{
$path = "../reciept/".$last_id."".$Image_Name;
move_uploaded_file($ImageName,$path);
//
$sql = "INSERT INTO process_fee (Flex_id, Surname, Firstname, Othername, Branch, Branch_Code, Plan, Card, Deposit, Location, User, User_id, Officer_Name, Team_Leader,
Team_Name, Status, Date_Reg, Time_Reg, Payment_Method) 
VALUES ('$last_id', '$sn', '$fn', '$ln', '$brss', '$brss_id', '$pl', '$card', '$ini', '$path', '$User', '$usd_id', '$ofn', '$tlm', '$tmn', 'Paid', '$d', '$s',
'Monie Point')";
$result = mysqli_query($con, $sql);
}
if ($result == true) {
echo 2; // success
} else {
echo mysqli_error($con);
}

mysqli_close($con);
?>
