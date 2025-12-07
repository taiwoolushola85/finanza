<?php
//if the add button has been clicked
include('../config/db.php') ;
include('../config/user_session.php') ;
$id = $_POST['id']; // reg id
$d = date('Y-m-d');
$s = date('h:m:sa');
$rand = uniqid();
// getting other info
$Query = "SELECT Firstname, Middlename, Lastname, BVN FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$fullname = $row['Firstname']." ".$row['Middlename']."".$row['Lastname'];
$bvn = $row['BVN'];
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
$path = "../business/" .$id."".$Image_Name;
if(move_uploaded_file($ImageName,$path)){
//
$sql = "SELECT COUNT(*) AS overs FROM verify WHERE Reg_id = '$id'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$totalbiz = $data['overs'];
if($totalbiz >= 3){
echo 1;
exit();
}else{
// updating  register info
$Query = "INSERT INTO verify (Reg_id, Name, Bvn, F_Image, Status, Comment_By, Date_Comment, Time_Verify, User) 
VALUES ('$id', '$fullname', '$bvn', '$path', 'Verified', '$na',  '$d', '$s', '$User')";
$result= mysqli_query($con, $Query);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}
}else{
echo("Error description: " . mysqli_error($con));
exit();
}
?>