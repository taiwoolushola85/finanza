<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT id, sessionid, amount, Rep_id, craccount, craccountname, tnxdate, Image FROM nip_notifications WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$sec_id = $row['sessionid'];
$amt = $row['amount'];
$acct_name = $row['craccountname'];
$repid = $row['Rep_id'];
$acct_no = $row['craccount'];
$date = $row['tnxdate'];
$img = $row['Image'];
echo json_encode(array("notId"=>$ids, "notAmt"=>$amt, "notName"=>$acct_name, "repID"=>$repid, "notAcct"=>$acct_no, "notSession"=>$sec_id, "notDate"=>$date, "notImg"=>$img));
}else{
//
}
mysqli_close($con);
?>