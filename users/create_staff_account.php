<?php
//DB Connection
include '../config/db.php';
$nm = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['nm']); // name
$gr = $_POST['gr'];//user group id
$br = $_POST['br'];// branch id
$em = $_POST['em'];// email
$st = $_POST['st'];// city
$gen = $_POST['gen'];// gender
$ph = $_POST['ph'];// phone no
$ad = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['ad']); // address
$staffid = $_POST['staffid'];//staff id
// getting branch info
$Query = "SELECT * FROM branch WHERE id = '$br'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$br_id = $row['id'];
$br_name = $row['Name'];
$zn_name = $row['Zone'];
$zn_id = $row['Zone_id'];
$cnt = $row['Country'];
// getting role info
$Query = "SELECT * FROM role WHERE id = '$gr'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$rol_id = $row['id'];
$gr_name = $row['Name'];
$cat = $row['Categorys'];
//image uploading
//Customer image upload
$imagename = $_FILES['Pic']['name'];
$source = $_FILES['Pic']['tmp_name'];
$path = "../img/".$imagename;
move_uploaded_file($source, $path);

$imagepath = $imagename;
$save = "../img/" . $imagepath; //This is the new file you saving
$file = "../img/" . $imagepath; //This is the original file

list($width, $height) = getimagesize($file); 

$tn = imagecreatetruecolor($width, $height);

//$image = imagecreatefromjpeg($file);
$info = getimagesize($path);
if ($info['mime'] == 'image/jpeg'){
  $image = imagecreatefromjpeg($file);
}elseif ($info['mime'] == 'image/gif'){
  $image = imagecreatefromgif($file);
}elseif ($info['mime'] == 'image/png'){
  $image = imagecreatefrompng($file);
}

imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height);
imagejpeg($tn, $save, 50);
/*
$email = "$em";
$fin = "Finazza App";  
$eee = "noreply.com";
$subject = "USER LOGIN DETAILS";
$message = "Username: $us \n Password: $ps";
$to = "$email"; // user email
$header = "From: " . $fin . "<". $eee.">\r\n";
$mails = mail($to,$subject,$message,$header);
*/

// checking if username already taken
$Query = "SELECT * FROM users WHERE Email = '$em' OR Staff_ID = '$staffid'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
if($gr_name == 'Loan Officers'){
$sql="INSERT INTO `users` (`Staff_ID`, `Name`, `Username`, `Password`, `Email`, `Gender`, `Role_id`, `User_Group`, `Role_Categorys`, `Usertype`, `Checks`, 
`Status`, `Branch`, `Branch_id`, `Location`, `User`, `Phone`, `Address`, `Active`, `Town`, `Pin`, `Access_Code`, `Mapped`, `Zone`, `Zone_id`, `Country`, `Sale_Target`)
VALUES ('$staffid', '$nm', 'NA', 'NA', '$em', '$gen', '$rol_id', '$gr_name', '$cat', 'User',  '0', 'Deactivate', '$br_name', '$br_id', '$path', 'Admin', '$ph', '$ad', 
'Offline', '$st', 'NA', 'NA', 'No', '$zn_name', '$zn_id', '$cnt', '0')";
$row = mysqli_query($con, $sql);
if($row == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}else{
$sql="INSERT INTO `users` (`Staff_ID`, `Name`, `Username`, `Password`, `Email`, `Gender`, `Role_id`, `User_Group`, `Role_Categorys`, `Usertype`, `Checks`,
`Status`, `Branch`, `Branch_id`, `Location`, `User`, `Phone`, `Address`, `Active`, `Town`, `Pin`, `Access_Code`, `Mapped`, `Zone`, `Zone_id`, `Country`, `Sale_Target`)
VALUES ('$staffid', '$nm', 'NA', 'NA', '$em', '$gen', '$rol_id', '$gr_name', '$cat', 'User', '0', 'Deactivate', '$br_name', '$br_id', '$path', 'Admin', '$ph', '$ad', 
'Offline', '$st', 'NA', 'NA', 'Not Required', '$zn_name', '$zn_id', '$cnt', 'NA')";
$row = mysqli_query($con, $sql);
if($row == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}
?>
