<?php
include '../config/db.php';   
$d = date('Y-m-d');    
$s = date('h:m:sa'); 
//
$bank = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ","), '', $_POST['bnk']);// bank name
$code = $_POST['code'];// bank code
// checking if bank name exist
$Query = "SELECT * FROM bank WHERE Bank_Name = '$bank'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
echo 1;
exit();
}
// inserting bank detail
$sql = "INSERT INTO bank (Bank_Name, Bank_Code, Date_Created, Time_Created) 
VALUES ('$bank', '$code', '$d', '$s')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
?>