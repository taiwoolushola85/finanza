<?php
// onboarding process
//if the add button has been clicked
include '../config/db.php';
$rep_id = $_POST['id'];// repayment id
$reg_id = $_POST['reg'];// registration id
$lum = $_POST['lum']; // loan amount
$pd = $_POST['pd']; // lamount paid
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
$dd = $lum + 0; // the intererst is 0
// total loan balance
$dailyt_loan = $lum + 0;
$dailyrnd_tloan = round($dailyt_loan);// rounding up total loan
//
$dailyrep_amt = $dailyrnd_tloan / $ten;// repayment amt
$dailyrnd_rep = round($dailyrep_amt);// rounding up repayment amt
//
//update repayments
$sql = "UPDATE repayments SET  Product = '$pr_name', Product_id = '$pr_id', Duration = '$ten', Frequency = '$frq',	Rate = '$rt', Interest_Amt = '0',
Loan_Amount = '$lum', Expected_Amount = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan', Total_Bal = Total_Loan - $pd WHERE id = '$rep_id'";
$result= mysqli_query($con, $sql);

//update savings
$sql = "UPDATE savings SET Product = '$pr_name', Product_id = '$pr_id', Duration = '$ten', Frequency = '$frq', Loan_Amount = '$lum' WHERE Repayments_id = '$rep_id'";
$result= mysqli_query($con, $sql);

// update register 
$sql = "UPDATE register SET  Product = '$pr_name', Product_id = '$pr_id', Tenure = '$ten', Frequency = '$frq', Rate = '$rt', Interest_Amt = '0',
Monthly_Interest = '0', Loan_Amount = '$lum', Repayment_Amt = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan' WHERE id = '$reg_id'";
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
// total loan balanceRepayment_Day
$t_loan = $lum + $in_amt;
$rnd_tloan = round($t_loan);// rounding up total loan
// expected repayment
$rep_amt = $rnd_tloan / $ten;// repayment amt
$rnd_rep = round($rep_amt);// rounding up repayment amt
//monthly interest
$monthly_intrest = round($rnds_int / $ten);
// inserting the customer information
///UPDATING REPAYMENTS
$sql = "UPDATE repayments SET Product = '$pr_name', Product_id = '$pr_id', Duration = '$ten', Frequency = '$frq', Rate = '$rt', Interest_Amt = '$rnds_int', 
Loan_Amount = '$lum', Expected_Amount = '$rnd_rep', Total_Loan = '$rnd_tloan', Total_Bal = Total_Loan - $pd WHERE id = '$rep_id'";
$result= mysqli_query($con, $sql);

//update savings
$sql = "UPDATE savings SET Product = '$pr_name', Product_id = '$pr_id', Duration = '$ten', Frequency = '$frq', Loan_Amount = '$lum' WHERE Repayments_id = '$rep_id'";
$result= mysqli_query($con, $sql);
//
$sql = "UPDATE register SET Product = '$pr_name', Product_id = '$pr_id', Tenure = '$ten', Frequency = '$frq', Rate = '$rt', Interest_Amt = '$rnds_int', 
Monthly_Interest = '$monthly_intrest', Loan_Amount = '$lum', Repayment_Amt = '$rnd_rep', Total_Loan = '$rnd_tloan' WHERE id = '$reg_id'";
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