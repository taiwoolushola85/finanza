<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$up = $row['Upfront'];
$in = $row['Inssurance'];
$cd = $row['Card'];
$fm = $row['Form'];
echo json_encode(array("regId"=>$ids,"upFront"=>$up,"inSsrance"=>$in,"carD"=>$cd,"forM"=>$fm));

}else{

}
?>