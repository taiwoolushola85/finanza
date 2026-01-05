<?php
include('../config/db.php');
include '../config/user_session.php';
$d = date('Y-m-d');
$data[] = array('Product_Name','Frequency');
$Query = "SELECT id, Product_Name, 
(SELECT COALESCE(SUM(Total_Bal), 0) FROM repayments WHERE Product = Product_Name AND Status='Active' AND '$d' > Maturity_Date) AS `onb`
FROM product WHERE Status='Activated'";
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
?>