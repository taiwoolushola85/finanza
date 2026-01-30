<?php
include '../config/db.php';
include '../config/user_session.php';
$userData = count($_POST["id"]);
if ($userData > 0) {
for ($i=0; $i < $userData; $i++) {
$id= $_POST['id'][$i];
$reg= $_POST['reg'][$i];
$bv = $_POST['bv'][$i];
$an = $_POST['full'][$i];
$la = $_POST['la'][$i];
$int = $_POST['tt'][$i];
$pt = $_POST['pt'][$i];
$exp = $_POST['exp_date'][$i];
$fn = $_POST['fn'][$i];
$ln = $_POST['ln'][$i];
$mn = $_POST['mn'][$i];
$ph = $_POST['ph'][$i];
$int_amt = $_POST['int_amt'][$i];
$re_amt = $_POST['re_amt'][$i];
$day = $_POST['day'][$i];
$dis = $_POST['dis'][$i];
$loan = $_POST['loan'][$i];
$tr = $_POST['tr'][$i];
$sa = $_POST['sa'][$i];
// inserting repayment schedule record
$query  = "INSERT INTO schedule (Disbursement_No, Regs_id, Firstname, Middlename, Lastname, Phone, BVN, Account_Name, Loan_Amount, Interest, Expecting_Amount, 
Expected_Date, Amount_Paid, Savings, Status, Loan_Type, Loan_Account_No, Transaction_id, Savings_Account_No, Payment_Status, Date_Paid, Payment_Method, Repayment_Day)
VALUES ('$dis', '$reg', '$fn', '$mn', '$ln', '$ph', '$bv', '$an', '$la', '$int_amt', '$re_amt', '$exp', '0', '0', 'Disbursed', '$pt', '$loan', '$tr',
'$sa', 'Outstanding', '-', 'Null', '$day')";
$result = mysqli_query($con, $query);
if($result != true){
echo("Error description: " . mysqli_error($con));
}else{

}
}
}

mysqli_close($con);
?>
