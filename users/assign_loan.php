<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id'];// repayment id
$of = $_POST['of'];// recovery officer id 
//
$Query = "SELECT * FROM users WHERE id='$of'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$usd_ids = $row['id'];
$Users = $row['Username'];
$nas = $row['Name'];
//
$Query = "SELECT * FROM repayments WHERE id = '$id' AND Recovery_Username = '$Users' AND Recovery_Name = '$nas'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
//
$Query = "UPDATE repayments SET Recovery_Username = '$Users', Recovery_Name = '$nas', Recovery_Status = 'Yes' WHERE id='$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>