<?php
//if the add button has been clicked
include '../config/db.php';
$id = $_POST['id'];// payment id
$lon = $_POST['lon'];// loan acct no
$amt = $_POST['am'];// amoun
$Query = "SELECT * FROM history WHERE id='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$dp = $row['Date_Paid'];
$loan = $row['Loan_Account_No'];
$reg = $row['Register_id'];
$tr = $row['Transaction_id'];
// updating history
$Query = "UPDATE history SET Amount = '$amt' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
//
$sql = "SELECT SUM(Amount) AS lm FROM history WHERE Status = 'Paid' AND Transaction_id = '$tr'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$his = $data['lm'];
//
$Query = "UPDATE repayments SET Paid ='$his', Total_Bal = Total_Loan - $his WHERE Transaction_id = '$tr' ";
$result= mysqli_query($con, $Query);
// updating schedule
$Query = "UPDATE schedule SET Amount_Paid = '$amt' WHERE Date_Paid = '$dp' AND Transaction_id = '$tr'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>