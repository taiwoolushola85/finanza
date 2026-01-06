<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM fee WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$lo = $row['Reciept'];
echo json_encode(array("historyId"=>$ids, "recieptLocation"=>$lo));
}else{
///echo 1;
//echo "<small style='color:red; font-size:12px'>User registration no not found..</small>";
}
mysqli_close($con);
?>