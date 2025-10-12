<?php
//DB Connection
include '../config/db.php';
$userid = $_POST['id'];//user id
$nm = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['nm']); // name
$gr = $_POST['gr'];//user group id
$br = $_POST['br'];// branch id
$em = $_POST['em'];// email
$st = $_POST['st'];// city
$gender = $_POST['gender'];// gender
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

// checking if email or staff id already taken
$Query = "SELECT id, Email, Staff_ID FROM users WHERE id = '$userid'";
$result = mysqli_query($con, $Query);
$data = mysqli_fetch_array($result);
$uzer_id = $data['id'];
$email = $data['Email'];
$staff_id = $data['Staff_ID'];
if($staff_id == $staffid && $email == $em && $uzer_id == $userid){
// confirmation is correct
}else{
echo 1;// email or staff id belong to another staff
exit();
}
//loan officer
if($gr_name == 'Loan Officers'){
$sql = "UPDATE users SET Staff_ID = '$staffid', Name = '$nm', Email = '$em', Gender = '$gender', Role_id = '$rol_id', User_Group = '$gr_name', Role_Categorys = '$cat',
Usertype = 'User', Branch = '$br_name', Branch_id = '$br_id', Location = '$path', Phone= '$ph', Address = '$ad', Town = '$st' WHERE id = '$userid'";
$row = mysqli_query($con, $sql);
if($row == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
// team leader update
}else if($gr_name == 'Team_Leader'){
$sql = "UPDATE users SET Staff_ID = '$staffid', Name = '$nm', Email = '$em', Gender = '$gender', Role_id = '$rol_id', User_Group = '$gr_name', Role_Categorys = '$cat',
Usertype = 'User', Branch = '$br_name', Branch_id = '$br_id', Location = '$path', Phone= '$ph', Address = '$ad', Town = '$st' WHERE id = '$userid'";
$row = mysqli_query($con, $sql);
if($row == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
// admin
}else if($gr_name == 'Admin'){
$sql = "UPDATE users SET Staff_ID = '$staffid', Name = '$nm', Email = '$em', Gender = '$gender', Role_id = '$rol_id', User_Group = '$gr_name', Role_Categorys = '$cat',
Usertype = 'Admin', Branch = '$br_name', Branch_id = '$br_id', Location = '$path', Phone= '$ph', Address = '$ad', Town = '$st' WHERE id = '$userid'";
$row = mysqli_query($con, $sql);
if($row == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
//other users
}else{
$sql = "UPDATE users SET Staff_ID = '$staffid', Name = '$nm', Email = '$em', Gender = '$gender', Role_id = '$rol_id', User_Group = '$gr_name', Role_Categorys = '$cat',
Usertype = 'User', Branch = '$br_name', Branch_id = '$br_id', Location = '$path', Phone= '$ph', Address = '$ad', Town = '$st' WHERE id = '$userid'";
$row = mysqli_query($con, $sql);
if($row == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}
?>
