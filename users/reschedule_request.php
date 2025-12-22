<?php 
include '../config/db.php';
include '../config/user_session.php';
$repid = $_POST['repid'];// rep id
$lum = $_POST['amt'];// loan amount
$pr = $_POST['pr'];// product id
$ten = $_POST['ten'];// tenure
$rt = $_POST['int'];// new interest rate
$pd = $_POST['pd'];// amount paid
$d = date('Y-m-d');
$s = date('h:m:sa');
//
$Query = "SELECT Product, Frequency FROM product_list WHERE Product_id='$pr'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pr_name = $row['Product'];
$frq = $row['Frequency'];
//
if($frq == 'Daily'){
// expected repayment
$dd = $lum + 0; // the intererst is 0
$dailyrep_amt = $lum / $ten;// repayment amt
$dailyrnd_rep = round($dailyrep_amt);// rounding up repayment amt
// total loan balance
$dailyt_loan = $lum + 0;
$dailyrnd_tloan = round($dailyt_loan);// rounding up total loan
// inserting the customer information
$sql = "UPDATE repayments SET Product = '$pr_name', Product_id = '$pr', Duration = '$ten', Frequency = '$frq', Rate = '$rt', Loan_Amount = '$lum',
Total_Bal = $lum - $pd, Interest_Amt = '0', Expected_Amount = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan', Reschedule_Status = 'Yes' WHERE id = '$repid'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}else{
// interest
$rr = 100 / $rt;
$in_amt = $lum / $rr;// interest amt
$rnds_int = round($in_amt); /// rounding up interest amount
// expected repayment
$dd = $lum + $in_amt; 
$rep_amt = $lum/$ten + $rnds_int;// repayment amt
$rnd_rep = round($rep_amt);// rounding up repayment amt
// total loan balance
$t_loan = $lum + ($rnds_int * $ten);
$rnd_tloan = round($t_loan);// rounding up total loan
//
$total_int = $rnds_int * $ten;
//monthly interest
$monthly_intrest = $rnds_int / $ten;
// inserting the customer information
$sql = "UPDATE repayments SET Product = '$pr_name', Product_id = '$pr', Duration = '$ten', Frequency = '$frq', Rate = '$rt', Loan_Amount = '$lum',
Total_Bal = $lum - $pd, Interest_Amt = '$rnds_int',  Expected_Amount = '$rnd_rep', Total_Loan = '$rnd_tloan', Reschedule_Status = 'Yes' WHERE id = '$repid'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}
?>