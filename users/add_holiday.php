<?php
include '../config/db.php';
$date = $_POST['holiday'];// holiday date
$dis = $_POST['dis'];// discription
$Query = "SELECT * FROM holidays WHERE Holiday_Date = '$date'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}else{
//
$sql = "INSERT INTO holidays (Holiday_Date, Discription) 
VALUES ('$date', '$dis')";
if (mysqli_query($con, $sql)) {
echo 2;
}else {
echo("Error description: " . mysqli_error($con));
}
}
?>