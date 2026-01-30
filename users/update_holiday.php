<?php
include_once '../config/db.php';
$id =$_POST['id'];// holiday id
$holiday =$_POST['rl']; // holiday date
$dis =$_POST['dis']; // discription
// update query
$sql = "UPDATE holidays SET Holiday_Date = '$holiday', Discription = '$dis' WHERE id = '$id'";
$result  = mysqli_query($con, $sql);
if ($result == true) {
echo 1;
}else {
echo("Error description: " . mysqli_error($con));
}
?>
