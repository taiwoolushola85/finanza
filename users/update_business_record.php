<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id']; // id
$bns = $_POST['bns'];
$bts = $_POST['bts'];
$sess = $_POST['sess'];
$sds = $_POST['sds'];
$bas = $_POST['bas'];
$bow = $_POST['bow'];
$sh = $_POST['sh'];
// updating  info
$Query = "UPDATE register SET Business='$bns', Biz_Type='$bts', Biz_State='$sess', Start_Date='$sds', Biz_Address='$bas', Biz_Owner = '$bow', 
Shop_Owner = '$sh' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>