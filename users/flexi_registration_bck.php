<?php
include 'db.php';
$fn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['fn']);
$sn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['sn']);
$ln = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ln']);
$ph = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ph']);
$ha = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ha']);
$bv = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['bv']);
$ba = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ba']);
$ms = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ms']);
$bnk = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['bnk']);
$ac = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ac']);
$an = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['an']);
$pl = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['pl']);
$fr = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['fr']);
$ty = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ty']);
$dn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['dn']);
$nsu = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['nsu']);
$nfn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['nfn']);
$no = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['no']);
$re = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['re']);
$na = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['na']);
$ph2 = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ph2']);
$ocu = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ocu']);
$nat = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['nat']);
$stog = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['stog']);
$gen = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['gen']);
$user = $_POST['user'];

$d = date('Y-m-d');
$s = date('h:m:s');
// getting user info
$Query = "SELECT * FROM users WHERE Username='$user'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$usd_id = $row['id'];
$User = $row['Username'];
$brss = $row['Branch'];
$brss_id = $row['Branch_id'];

//getting mapping info
$Query = "SELECT * FROM mapping WHERE Loan_Officer='$User'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$map_id = $row['id'];
$off_id = $row['Officer_id'];
$tm_id = $row['Team_id'];
$ofn = $row['Officer_Name'];
$tmn = $row['Team_Name'];
$tlm = $row['Team_Leader'];
$br = $row['Branch'];
// getting saving plan info for registration
$Query = "SELECT * FROM flexi WHERE id='$pl'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pr_id = $row['id'];
$pl_name = $row['Name'];
$rt = $row['Interest'];
$ten = $row['Duration'];
$frq = $row['Frequency'];

$sql = "INSERT INTO flexi_reg (Surname, Firstname, Othername, Phone, Gender, Address, Client_BVN, Biz_Address, Marital_Status, Bank, Account_No, Account_Name, Plan,
Frequency, Interest, Duration, ID_Type ,ID_No, NOK_Surname, NOK_Firstname, NOK_Othername, Relationship, NOK_Phone, NOK_Address, User, User_id, Team_Leader, Team_id,
Officer_Name, Team_Name, Map_id, Branch, Branch_Code, Plan_id, Status, Location, Date_Reg, Time_Reg, Deposit_Amt, Interest_Amt, Total_Saving, Occupation, Nationality,
State_Of_Origin, Application_Status) 
VALUES ('$sn', '$fn', '$ln', '$ph', '$gen', '$ha', '$bv', '$ba', '$ms', '$bnk', '$ac', '$an', '$pl_name', '$frq', '$rt', '$ten', '$ty', '$dn', '$nsu', '$nfn', '$no',
'$re', '$ph2', '$na', '$User', '$usd_id', '$tlm', '$tm_id', '$ofn', '$tmn', '$map_id', '$brss', '$brss_id', '$pr_id', 'Processing', 'Null', '$d', '$s', '0', '0', '0',
'$ocu', '$nat', '$stog', 'Registered')";
if (mysqli_query($con, $sql)) {
echo 1;
}else {
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>