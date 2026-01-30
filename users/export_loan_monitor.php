<?php  
include '../config/db.php';
include '../config/user_session.php';
$sql = "SELECT `Reg_id`, `Disbursement_No`,`Loan_Account_No`,`Firstname`,`Middlename`,`Lastname`,`Gender`,`Branch`,`Unions`,`Phone`,`Product`,`Frequency`,Duration,`Loan_Amount`,
`Interest_Amt`,`Paid`, `Total_Bal`,  `Expected_Amount`, `Savings_Bal`, `Last_Amount`, `Transaction_Date`, `Officer_Name`, `Date_Disbursed`, `Maturity_Date`,
(SELECT `Account_No` FROM `register` WHERE id = Reg_id) AS `Account`,
(SELECT `BVN` FROM `register` WHERE id = Reg_id) AS `Bvns`,
(SELECT `Bank` FROM `register` WHERE id = Reg_id) AS `Banks`,
(SELECT `Years` FROM `register` WHERE id = Reg_id) AS `Dobs`,
(SELECT `Address` FROM `register` WHERE id = Reg_id) AS `Addresss`,
(SELECT `Biz_Type` FROM `register` WHERE id = Reg_id) AS `Bizs`,
(SELECT `Biz_Address` FROM `register` WHERE id = Reg_id) AS `Biz_ads`
FROM `repayments` WHERE Status = 'Active'";  
$setRec = mysqli_query($con, $sql);  
$columnHeader = '';  
$columnHeader = "REG NO" . "\t" ."DISBURSEMENT NO" . "\t" . "LOAN ACCOUNT NO" . "\t". "FIRST NAME" . "\t" . "MIDDLENAME" . "\t". "LASTNAME" . "\t".  "GENDER" . "\t".  "BRANCH" . "\t". "GROUP" ."\t". "CLIENT PHONE" ."\t". 
"PRODUCT" . "\t". "FREQUENCY" . "\t".  "DURATION" . "\t". "PRINCIPAL AMOUNT" . "\t".  "INTEREST AMOUNT" . "\t". "PAID AMOUNT" ."\t". "OUTSTANDING" . "\t". "EXPECTED AMOUNT" . "\t". "SAVINGS BALANCE" 
. "\t". "LAST AMOUNT PAID" . "\t". "LAST PAYMENT DATE" . "\t". "LOAN OFFICER" . "\t". "DATE DISBURSED" . "\t". "MATURITY DATE" . "\t". "ACCOUNT NO" . "\t".  "BVN" . "\t". "BANK" . "\t"
. "DATE OF BIRTH" . "\t". "CLIENT ADDRESS" . "\t". "BUSINESS TYPE" . "\t". "BUSINESS ADDRESS" . "\t";  
$setData = '';  
while ($rec = mysqli_fetch_row($setRec)) {  
$rowData = '';  
foreach ($rec as $value) {  
$value = '"' . $value . '"' . "\t";  
$rowData .= $value;  
}  
$setData .= trim($rowData) . "\n";  
}  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=Loan_Monitor.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  
echo ucwords($columnHeader) . "\n" . $setData . "\n";  
 ?> 