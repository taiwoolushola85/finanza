<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT id, Firstname, Lastname, Location FROM history WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$fn = $row['Firstname']. " ".$row['Lastname'];
$lo = $row['Location'];
echo json_encode(array("historyId"=>$ids, "fullName"=>$fn, "recieptLocation"=>$lo));
}else{

}
mysqli_close($con);
?>