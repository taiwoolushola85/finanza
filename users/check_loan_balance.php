<?php 
// update sme 
include '../config/db.php';
$id = $_GET['id'];// repayment id
//
$Query = "SELECT Reg_id, id, Total_Loan, Paid, Total_Bal,
(SELECT COALESCE(SUM(Amount), 0) FROM history WHERE Register_id = Reg_id AND Status = 'Paid') AS `Amt_Paid`
FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pd = $row['Paid'];// paid from repayment
$amt = $row['Amt_Paid'];// paid from history
$tloan = $row['Total_Loan'];
$bal = $row['Total_Bal'];
//
if($amt == $pd){
//
}else{
$Query = "UPDATE repayments SET Paid = '$amt', Total_Bal = Total_Loan - $amt WHERE id = '$id'";
$result= mysqli_query($con, $Query);
}
?>

