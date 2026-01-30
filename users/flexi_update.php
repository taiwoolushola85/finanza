<?php 
include '../config/db.php';
$id = $_GET['id'];
$Query = "SELECT id, Flexi_Account_No, Total_Bal FROM flexi_account WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];
$sv = $row['Flexi_Account_No'];
$bl = $row['Total_Bal'];
// savings history
$sql = "SELECT SUM(Amount) AS lm FROM flexi_history WHERE Status = 'Paid' AND Flexi_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount) AS lm FROM flexi_withdraw WHERE Status = 'Paid' AND Flexi_Accounts = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];

// getting total balance
$bal = $pmd - $pmw;
if($bl == $bal){
// do nothing
}else{
$Query = "UPDATE flexi_account SET Total_Bal = '$bal' WHERE Flexi_Account_No = '$sv'";
$result= mysqli_query($con, $Query);
}
?>
