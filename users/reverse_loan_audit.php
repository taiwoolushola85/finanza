<?php 
include '../config/db.php';
$d = date('Y-m-d');
$id = $_POST['id'];
$Query = "SELECT id, Total_Loan,
(SELECT COALESCE(SUM(Amount), 0) FROM history WHERE Register_id = Reg_id AND Status = 'Paid') AS `Total_Paid`
FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$repid = $row['id'];
$tot = $row['Total_Loan'];
$pd = $row['Total_Paid'];
$balance = $tot - $pd;
// repayment
$Query = "UPDATE repayments SET Paid = '$pd', Total_Bal = '$balance', Status = 'Active' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
?>