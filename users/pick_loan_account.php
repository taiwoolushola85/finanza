<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$name = $row['Loan_Account_No'];
$bv = $row['BVN'];
echo json_encode(array("loanId"=>$ids, "loanAcct"=>$name, "loanBVN"=>$bv));
}else{
//
}
mysqli_close($con);
?>