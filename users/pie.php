<?php
include('../config/db.php');
include '../config/user_session.php';
$data[] = array('Name','No');
$Query = "SELECT id, Product_Name, 
(SELECT COALESCE(SUM(Total_Loan), 0) FROM repayments WHERE User = '$User' AND Product= Product_Name) AS `onb`
FROM product WHERE  Status='Activated'";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
$records = $rows['onb'];
$pr = $rows['Product_Name'];
$data[] = array($pr,(int)$records);

}
}
///$data = array($data);			
echo json_encode($data);
mysqli_close($con);
?>