<?php 
include '../config/db.php';
$id = $_GET['id'];
$Query = "SELECT id, Loan_Amount, Rate, Tenure, Frequency, Product_id, Loan_Status FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$reg = $row['id'];
$lum = $row['Loan_Amount'];
$rt = $row['Rate'];
$ten = $row['Tenure'];
$frq = $row['Frequency'];
$pr = $row['Product_id'];
$lst = $row['Loan_Status'];
//
$Query = "SELECT Inssurance FROM product_list WHERE Product_id='$pr' AND Tenure = '$ten'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$ins = $rows['Inssurance'];

//
if($frq == 'Daily'){
// expected repayment
// expected repayment
$dd = $lum + 0; // the intererst is 0
$dailyrep_amt = $lum / $ten;// repayment amt
$dailyrnd_rep = round($dailyrep_amt);// rounding up repayment amt
// total loan balance
$dailyt_loan = $lum + 0;
$dailyrnd_tloan = round($dailyt_loan);// rounding up total loan
// Calculate the upfront interest
//
$upfront = round($lum * $rt / 100);
$inssurance = round($lum * $ins / 100);

if($lst == 'Existing Client'){
// inserting the customer information
$sql = "UPDATE register SET Loan_Amount = '$lum', Interest_Amt = '0', Monthly_Interest = '0', Repayment_Amt = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan',
Upfront = '$upfront', Inssurance = '$inssurance', Form = '500', Card = '0' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}

}else{

// inserting the customer information
$sql = "UPDATE register SET Loan_Amount = '$lum', Interest_Amt = '0', Monthly_Interest = '0', Repayment_Amt = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan',
Upfront = '$upfront', Inssurance = '$inssurance', Form = '500', Card = '1000' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}

}



}else{
// interest
// interest
$rr = 100 / $rt;
$in_amt = $lum / $rr;// interest amt
$rnds_int = round($in_amt); /// rounding up interest amount
// expected repayment
$dd = $lum + $in_amt; 
$rep_amt = $dd / $ten;// repayment amt
$rnd_rep = round($rep_amt);// rounding up repayment amt
// total loan balanceRepayment_Day
$t_loan = $lum + $in_amt;
$rnd_tloan = round($t_loan);// rounding up total loan
$int_per_repayment = round($rnds_int/$ten);
//
$upfront = round($lum * $rt / 100);
$inssurance = round($lum * $ins / 100);


if($lst == 'Existing Client'){

// inserting the customer information
$sql = "UPDATE register SET Loan_Amount = '$lum', Interest_Amt = '$rnds_int', Monthly_Interest = '$int_per_repayment', Repayment_Amt = '$rnd_rep', 
Total_Loan = '$rnd_tloan', Upfront = '$upfront', Inssurance = '$inssurance', Form = '500', Card = '0' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
//echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}

}else{

// inserting the customer information
$sql = "UPDATE register SET Loan_Amount = '$lum', Interest_Amt = '$rnds_int', Monthly_Interest = '$int_per_repayment', Repayment_Amt = '$rnd_rep', 
Total_Loan = '$rnd_tloan', Upfront = '$upfront', Inssurance = '$inssurance', Form = '500', Card = '1000' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
//echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
    
}

}

?>