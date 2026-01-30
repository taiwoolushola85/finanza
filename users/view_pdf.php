<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM document WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$idd = $row['id'];
$lo = $row['Location'];
echo json_encode(array("depId"=>$idd, "imageUrl"=>$lo));
?>

<?php
}else{
///echo 1;
//echo "<small style='color:red; font-size:12px'>User registration no not found..</small>";
}
?>