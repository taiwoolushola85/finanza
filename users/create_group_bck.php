<?php
include '../config/db.php';
include '../config/user_session.php';
$gr = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", "&"), '', $_POST['gr']);// group name
$d = date('Y-m-d');
$s = date('h:m:sa');
//getting mapping record between co and bm
$Query = "SELECT * FROM mapping WHERE Loan_Officer='$User'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$off_id = $row['Officer_id'];
$tm_id = $row['Team_id'];
$ofn = $row['Officer_Name'];
$tmn = $row['Team_Name'];
$tlm = $row['Team_Leader'];
// checking if group name already exist
$Query = "SELECT * FROM groups WHERE Name = '$gr' ";
$result = mysqli_query($con, $Query);
$data = mysqli_num_rows($result);
if($data != 0){
echo 1;
exit();
}else{
$sql = "INSERT INTO groups (Name, Branch, User, Team_Leader, Officer_Name, Team_Name, Officer_id, Team_id, Branch_id, Date_Register, Status) 
VALUES ('$gr', '$brss', '$User', '$tlm', '$ofn', '$tmn', '$off_id', '$tm_id', '$brss_id', '$d', 'Waiting For Approval' )";
$result = mysqli_query($con, $sql);
if ($result == true) {
echo 2;
}else {
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>