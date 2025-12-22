<?php
include('../confif/db.php') ;
include_once '../config/user_session.php';
$regid = $_POST['regid']; // reg id
$id = $_POST['id'];
$sv = $_POST['sv'];
$tr = $_POST['tr'];// loan acct
$req_type = $_POST['typ'];// request type
//
$Query = "DELETE FROM loan_cancel WHERE Request_id = '$id'";
$result= mysqli_query($con, $Query);
//
$Query = "DELETE FROM other_request WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>