<?php
// Database configuration
require '../config/db.php';
require '../config/user_session.php';

// Validate and sanitize inputs
if (!isset($_POST["id"]) || !isset($_POST["tba"]) || !isset($_POST['am']) || !isset($_POST['sa'])) {
echo json_encode(['status' => 'error', 'code' => 1, 'message' => 'Missing required fields']);
exit();
}

$id = mysqli_real_escape_string($con, $_POST["id"]);
$toba = mysqli_real_escape_string($con, $_POST["tba"]); // loan balance
$am = str_replace(array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['am']); // amount deposited
$sa = str_replace(array("#", "'", ";", "/", "-", "@", "_", ","), '', $_POST['sa']); // savings deposited
$recipt_no = "Not Valid"; // reference no
$mth = date('M');
$yrs = date('Y');

// Validate numeric inputs
if (!is_numeric($am) || !is_numeric($sa) || !is_numeric($toba)) {
echo json_encode(['status' => 'error', 'code' => 2, 'message' => 'Invalid amount format']);
exit();
}
// Avoid zero input in repayment
if ($am == "0") {
echo 1;
exit();
}

// Avoid zero input in savings
if ($sa == "0") {
echo 2;
exit();
}

// Use prepared statement to fetch customer data
$result = mysqli_query($con, "SELECT * FROM repayments WHERE id='$id'");
$row= mysqli_fetch_array($result);
// Extract customer data
$id = $row['id'];
$virtaul_acct = $row['Account_Number'];
$dis = $row['Disbursement_No'];
$tr = $row['Transaction_id'];
$ln = $row['Loan_Account_No'];
$sn = $row['Savings_Account_No'];
$fn = $row['Firstname'];
$md = $row['Middlename'];
$lnm = $row['Lastname'];
$fll = $fn . " " . $md . " " . $lnm;
$un = $row['Unions'];
$cu_id = $row['Union_id'];
$pr_name = $row['Product'];
$pr_id = $row['Product_id'];
$us = $row['User'];
$us_id = $row['User_id'];
$tm = $row['Team_Leader'];
$ofn = $row['Officer_Name'];
$tmn = $row['Team_Name'];
$br_name = $row['Branch'];
$br_id = $row['Branch_id'];
$la = $row['Loan_Amount'];
$fr = $row['Frequency'];
$rt = $row['Rate'];
$du = $row['Duration'];
$tim = $row['Team_id'];
$exp_amt = $row['Expected_Amount'];
$int_amt = round($row['Interest_Amt'] / $row['Duration']);
$reg = $row['Reg_id'];
$total_loan = $row['Total_Loan'];
$bal = $row['Total_Bal']; // balance
$ph = $row['Phone'];
$alert = $row['Alert'];
$maturity = $row['Maturity_Date'];
$nxt_bal = $total_loan - $am;
$d = date('Y-m-d');
$ss = date('h:i:sa');
$rand = rand();
$ran = uniqid();

// Receipt uploading with compression
$path = "";
if (isset($_FILES['Pic']) && $_FILES['Pic']['error'] == 0) {
$allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
$file_type = $_FILES['Pic']['type'];
if (!in_array($file_type, $allowed_types)) {
echo json_encode(['status' => 'error', 'code' => 6, 'message' => 'Invalid file type. Only JPG, PNG, GIF allowed']);
exit();
}
$ImageName = $_FILES['Pic']['tmp_name'];
$Imagesize = $_FILES['Pic']['size'];

// Check if image is less than 5MB before compression
if ($Imagesize > 5242880) {
echo 3;
exit();
}
    
// Get image extension
$image_info = getimagesize($ImageName);
$image_type = $image_info[2];

// Create image resource based on type
switch ($image_type) {
case IMAGETYPE_JPEG:
$source = imagecreatefromjpeg($ImageName);
break;
case IMAGETYPE_PNG:
$source = imagecreatefrompng($ImageName);
break;
case IMAGETYPE_GIF:
$source = imagecreatefromgif($ImageName);
break;
default:
echo json_encode(['status' => 'error', 'code' => 6, 'message' => 'Unsupported image type']);
exit();
}
if ($source === false) {
echo json_encode(['status' => 'error', 'code' => 5, 'message' => 'Failed to process image']);
exit();
}
    
// Get original dimensions
$width = imagesx($source);
$height = imagesy($source);
    
// Set maximum dimensions
$max_width = 1200;
$max_height = 1200;
 
// Calculate new dimensions while maintaining aspect ratio
if ($width > $max_width || $height > $max_height) {
$ratio = min($max_width / $width, $max_height / $height);
$new_width = round($width * $ratio);
$new_height = round($height * $ratio);
} else {
$new_width = $width;
$new_height = $height;
}
    
// Create new image with new dimensions
$destination = imagecreatetruecolor($new_width, $new_height);
  
// Preserve transparency for PNG and GIF
if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
imagealphablending($destination, false);
imagesavealpha($destination, true);
$transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
imagefilledrectangle($destination, 0, 0, $new_width, $new_height, $transparent);
}
   
// Resize image
imagecopyresampled($destination, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
 /*   
// Create directory if it doesn't exist
if (!file_exists('reciept')) {
mkdir('reciept', 0755, true);
}
*/ 
// Generate filename
$file_extension = image_type_to_extension($image_type, false);
$filename = $ran . "_" . $d . "." . $file_extension;
$path = "../reciept/" . $filename;
    
// Save compressed image
switch ($image_type) {
case IMAGETYPE_JPEG:
imagejpeg($destination, $path, 75); // 75% quality
break;
case IMAGETYPE_PNG:
imagepng($destination, $path, 6); // Compression level 6 (0-9)
break;
case IMAGETYPE_GIF:
imagegif($destination, $path);
break;
}
/*
// Free memory
imagedestroy($source);
imagedestroy($destination);
*/
} else {
echo json_encode(['status' => 'error', 'code' => 22, 'message' => 'Receipt image is required']);
exit();
}
// checking if you have made posting for that date
$result = mysqli_query($con, "SELECT * FROM history WHERE Transaction_id='$tr' AND User = '$User' AND Status = 'Paid' AND Date_Paid = '$d' 
AND Posting_Status  = 'Denied' ORDER BY id DESC LIMIT 1");
$row = mysqli_num_rows($result);
if($row != 0){
echo 4;
exit();
}


// checking for double posting
$result = mysqli_query($con, "SELECT * FROM history WHERE Transaction_id='$tr' AND Status != 'Paid' AND User = '$User'");
$row = mysqli_num_rows($result);
if($row != 0){
echo 5;
exit();
}

// checking if you have made posting for that date
$result = mysqli_query($con, "SELECT * FROM save WHERE Transaction_id='$tr' AND User = '$User' AND Status = 'Paid' AND Date_Paid = '$d'
AND Posting_Method = 'Basic Posting' ORDER BY id DESC LIMIT 1");
$row = mysqli_num_rows($result);
if($row != 0){
echo 6;
exit();
}

// checking for double posting for savings
$result = mysqli_query($con, "SELECT * FROM save WHERE Transaction_id='$tr' AND Status != 'Paid' AND User = '$User' AND Posting_Method = 'Basic Posting'");
$row = mysqli_num_rows($result);
if($row != 0){
echo 7;
exit();
}

// Checking if amount entered is greater than balance
if ($am > $toba) {
echo 8;
exit();
}

if (empty($am) && empty($sa)) {
// Do nothing
} elseif (empty($am)) {
echo 9;
exit();
} elseif (empty($sa)) {
// If only saving input is empty
$query  = "INSERT INTO history (Session_id, Notification_id, Virtual_No, Rep_id, Disbursement_No, Register_id, Repayment_id, Loan_Account_No, Transaction_id, 
Saving_Account_No, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch, 
Branch_Code, Status, User, User_id, Team_Leader, Team_Name, Officer_Name, Date_Paid, Time_Paid, Team_id, Interest_Amt, Expected_Amount, Total_Loan, Location, 
Balance, Phone, Payment_Method, Alert, Post_Method, Reciept_No, Reciept_Status, Posting_Status, Months, Years)
VALUES ('NA', 'NA', '$virtaul_acct', '$id', '$dis', '$reg', '$id', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$am', '0', '$du', '$fr', 
'$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', 'Waiting For Approval', '$us', '$us_id', '$tm', '$tmn', '$ofn', '$d', '$ss', '$tim', '$int_amt', '$exp_amt',
'$total_loan', '$path', '$nxt_bal', '$ph', 'Monie Point', '$alert', 'Basic Posting', '$recipt_no', 'Denied', 'Successfull', '$mth', '$yrs')";
$result = mysqli_query($con, $query);
$last_id = mysqli_insert_id($con);// last insert id
if ($result == true) {
echo 10;
} else {
echo "Error: " . mysqli_error($con);
}
mysqli_stmt_close($stmt);
    
} else {
// If all inputs are correct
if (trim($_POST['am']) != '' && trim($_POST['sa']) != '') {
$query  = "INSERT INTO history (Session_id, Notification_id, Virtual_No, Rep_id, Disbursement_No, Register_id, Repayment_id, Loan_Account_No, Transaction_id, 
Saving_Account_No, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch,
Branch_Code, Status, User, User_id, Team_Leader, Team_Name, Officer_Name, Date_Paid, Time_Paid, Team_id, Interest_Amt, Expected_Amount,Total_Loan,Location,Balance,Phone,Payment_Method,Alert,Post_Method,Reciept_No,Reciept_Status,Posting_Status,Months,Years)
VALUES ('NA', 'NA', '$virtaul_acct', '$id', '$dis', '$reg', '$id', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$am', '$sa', '$du', '$fr', 
'$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', 'Waiting For Approval', '$us', '$us_id', '$tm', '$tmn', '$ofn', '$d', '$ss', '$tim', '$int_amt', '$exp_amt', 
'$total_loan', '$path', '$nxt_bal', '$ph', 'Monie Point', '$alert', 'Basic Posting', '$recipt_no', 'Denied', 'Successfull', '$mth', '$yrs')";
$result = mysqli_query($con, $query);
$last_id = mysqli_insert_id($con);// last insert id
// saving record
$query  = "INSERT INTO save (Session_No, History_id, Virtual_Acct, Reps_id, Disbursement_No,  Register_id, Repayment_id, Savings_id, Loan_Account_No, Transaction_id, 
Saving_Account, Firstname, Middlename, Lastname, Unions, Union_Code, Loan_Amount, Savings, Duration, Frequency, Rate, Loan_Type, Product_id, Branch, Branch_Code, 
Reciept, Status, User, User_id, Team_Leader, Officer_Name, Team_Name, Date_Paid, Time_Paid, Team_id, Payment_Method, Posting_Method, Months, Years)
VALUES ('NA', '$last_id', '$virtaul_acct', '$id', '$dis', '$reg', '$id', '$rand', '$ln', '$tr', '$sn', '$fn', '$md', '$lnm', '$un', '$cu_id', '$la', '$sa', '$du', '$fr', 
'$rt', '$pr_name', '$pr_id', '$br_name', '$br_id', 'Paid With Repayment', 'Waiting For Approval', '$us', '$us_id', '$tm', '$ofn', '$tmn', '$d',  '$ss',  '$tim',
'Monie Point', 'Basic Posting', '$mth', '$yrs')";
$result = mysqli_query($con, $query);
if ($result == true) {
echo 10;
} else {
echo "Error: " . mysqli_error($con);
}
}
}
mysqli_close($con);
?>