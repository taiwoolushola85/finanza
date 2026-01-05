<?php
// onboarding process
//if the add button has been clicked
include '../config/db.php';
$reg_id = $_POST['id'];// registration id
$lum = $_POST['lum']; // loan amount
$pr = $_POST['pr']; // loan product id
$tenure = $_POST['ten']; // loan product tenure
// getting loan product for registration
$Query = "SELECT * FROM product_list WHERE Product_id = '$pr' AND Tenure = '$tenure'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$prid = $row['id'];
$pr_id = $row['Product_id'];
$pr_name = $row['Product'];
$rt = $row['Rate'];
$ten = $row['Tenure'];
$frq = $row['Frequency'];
$ins = $row['Inssurance'];

// checking if product is  daily
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
// update register 
$sql = "UPDATE register SET  Product = '$pr_name', Product_id = '$pr_id', Tenure = '$ten', Frequency = '$frq', Rate = '$rt', Interest_Amt = '0', 
Loan_Amount = '$lum', Repayment_Amt = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan', Upfront = '$upfront_interest', Inssurance = '$inssurance',
Form = '500', Card = '1000' WHERE id = '$reg_id'";
$result= mysqli_query($con, $sql);

// update schedule
$sql = "UPDATE schedule SET Loan_Type = '$frq', Interest = '0', Expecting_Amount = '$dailyrnd_rep',
Loan_Amount = '$lum' WHERE Regs_id = '$reg_id'";
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
// Calculate the upfront interest
$upfront_saving = ($lum * $rt) / 100;
// Calculate the inssurance percentage
$inssurance = ($lum * $ins) / 100;
//monthly interest
$monthly_intrest = $rnds_int / $ten;
// inserting the customer information
$sql = "UPDATE register SET Product = '$pr_name', Product_id = '$pr_id', Tenure = '$ten', Frequency = '$frq', Rate = '$rt', Interest_Amt = '$rnds_int', 
Loan_Amount = '$lum', Repayment_Amt = '$rnd_rep', Total_Loan = '$rnd_tloan', Upfront = '$upfront_saving', Inssurance = '$inssurance', Form = '500',
Card = '1000' WHERE id = '$reg_id'";
$result= mysqli_query($con, $sql);

// update schedule
$sql = "UPDATE schedule SET Loan_Type = '$frq', Interest = '$rnds_int', Loan_Amount = '$lum', Expecting_Amount = '$rnd_rep'
WHERE Regs_id = '$reg_id'";
$result= mysqli_query($con, $sql);

if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}
?>