<?php
include '../config/db.php';
$id = $_POST['id'];// registration id
$type = $_POST['type'];// deduction type
$pr = $_POST['pr']; //product id
$ten = $_POST['ten']; //tenure
$lum = $_POST['lum']; //loan amount
$bnk = $_POST['bn']; //bank
$acct_no = $_POST['an']; // account no
$acct_name = $_POST['ann']; // account name
// getting loan product for registration
$Query = "SELECT Product, Rate, Frequency, Inssurance FROM product_list WHERE Product_id='$pr' AND Tenure = '$ten'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pr_name = $row['Product'];
$rt = $row['Rate'];
$frq = $row['Frequency'];
$ins = $row['Inssurance'];
//checking if all filed has been filled
if(empty($type) || empty($pr) || empty($ten) || empty($lum) || empty($bnk) || empty($acct_no) || empty($acct_name)){
echo 1;
exit();
}else{
if($frq == 'Daily'){
// expected repayment
$dd = $lum + 0; // the intererst is 0
$dailyrep_amt = $lum / $ten;// repayment amt
$dailyrnd_rep = round($dailyrep_amt);// rounding up repayment amt
// total loan balance
$dailyt_loan = $lum + 0;
$dailyrnd_tloan = round($dailyt_loan);// rounding up total loan
// Calculate the upfront interest
$rr = 100 / $rt;
$upfront_interest = $lum / $rr;// interest amt
// Calculate the inssurance percentage
$inssurance = ($lum * $ins) / 100;
// inserting the customer information
$sql = "UPDATE register SET Product = '$pr_name', Product_id = '$pr', Tenure = '$ten', Frequency = '$frq', Rate = '$rt', Loan_Amount = '$lum', Bank = '$bnk',
Account_Name = '$acct_name', Account_No = '$acct_no', Interest_Amt = '0', Monthly_Interest = '0', Repayment_Amt = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan',
Upfront = '$upfront_interest', Inssurance = '$inssurance', Form = '500', Card = '1000', Upfront_Types  = '$type', Status = 'Waiting For Verification' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 2;
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
// Calculate the upfront interest
$upfront_saving = ($lum * $rt) / 100;
// Calculate the inssurance percentage
$inssurance = ($lum * $ins) / 100;
//monthly interest
$monthly_intrest = $rnds_int / $ten;
// inserting the customer information
$sql = "UPDATE register SET Product = '$pr_name', Product_id = '$pr', Tenure = '$ten', Frequency = '$frq', Rate = '$rt', Loan_Amount = '$lum', Bank = '$bnk',
Account_Name = '$acct_name', Account_No = '$acct_no', Interest_Amt = '$rnds_int', Monthly_Interest = '$monthly_intrest', Repayment_Amt = '$rnd_rep', 
Total_Loan = '$rnd_tloan', Upfront = '$upfront_saving', Inssurance = '$inssurance', Form = '500', Card = '1000', Upfront_Types  = '$type' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}
}
mysqli_close($con);
?>