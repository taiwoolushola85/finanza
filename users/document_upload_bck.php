<?php
//if the add button has been clicked
include('../config/db.php') ;
include('../config/user_session.php') ;
$id = $_POST['id']; // reg id
$type = $_POST['doc']; // document type
$d = date('Y-m-d');
$s = date('h:m:sa');
// getting other info
$Query = "SELECT Firstname, Middlename, Lastname, BVN FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$fullname = $row['Firstname']." ".$row['Middlename']."".$row['Lastname'];
$bvn = $row['BVN'];
// image uploading
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
}
$path = "../document/" .$id."".$Image_Name;
if(move_uploaded_file($ImageName,$path)){
// uploading document
$sql = "INSERT INTO document (Reg_ID, Name, BVN, Type, Location, Uploaded_By, Date_Upload, Time_Upload) 
VALUES ('$id', '$fullname', '$bvn', '$type', '$path', '$na', '$d', '$s')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}else{
echo("Error description: " . mysqli_error($con));
}
?>