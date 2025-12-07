<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id']; // reg id
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
$path = "../id/" .$id."".$Image_Name;
if(move_uploaded_file($ImageName,$path)){
// updating  register info
$Query = "UPDATE gaurantors SET ID_Image='$path' WHERE Regis_id='$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}else{
echo("Error description: " . mysqli_error($con));
}
?>