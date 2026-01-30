<?php 
include '../config/db.php';
$id = $_POST['id'];// admin id
// admin image upload
$imagenameg = $_FILES['Pic']['name'];
$sourceg = $_FILES['Pic']['tmp_name'];
$pathxg = "../img/".$id."_".$imagenameg;
move_uploaded_file($sourceg, $pathxg);

$imagepathg = $imagenameg;
$saveg = "../img/" . $imagepathg; //This is the new file you saving
$fileg = "../img/" . $imagepathg; //This is the original file

list($width, $height) = getimagesize($fileg); 

$tng = imagecreatetruecolor($width, $height);

//$imageg = imagecreatefromjpeg($fileg);
$infog = getimagesize($pathxg);
if ($infog['mime'] == 'image/jpeg'){
  $imageg = imagecreatefromjpeg($fileg);
}elseif ($infog['mime'] == 'image/gif'){
  $imageg = imagecreatefromgif($fileg);
}elseif ($infog['mime'] == 'image/png'){
  $imageg = imagecreatefrompng($fileg);
}

imagecopyresampled($tng, $imageg, 0, 0, 0, 0, $width, $height, $width, $height);
imagejpeg($tng, $saveg, 40);

$Query = "UPDATE users SET Location= '$pathxg' WHERE id='$id'";
$result= mysqli_query($con, $Query);
if($result){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
?>