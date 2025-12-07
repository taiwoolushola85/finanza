<?php 
include '../config/db.php';
include '../config/user_session.php';
$id = $_GET['id'];// reg id
//
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$stage = $row['Stage'];
if($stage == '1'){
//
$sql = "UPDATE register SET Status ='Under Review' WHERE id = '$id' ";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}else if($stage == '2'){
//
$sql = "UPDATE register SET Status = 'Waiting For Verification' WHERE id = '$id' ";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}else if($stage == '3'){
//
$sql = "UPDATE register SET Status ='Pending' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}else if($stage == '4'){
//
$sql = "UPDATE register SET Status ='' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}else{



}
?>