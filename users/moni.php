<?php  
include '../config/db.php';
// Use LEFT JOINs instead of subqueries for better performance
$sql = "SELECT 
    r.`Reg_id`, 
    r.`Disbursement_No`,
    r.`Loan_Account_No`,
    r.`Firstname`,
    r.`Middlename`,
    r.`Lastname`,
    r.`Gender`,
    r.`Branch`,
    r.`Unions`,
    r.`Phone`,
    r.`Product`,
    r.`Frequency`,
    r.`Duration`,
    r.`Loan_Amount`,
    r.`Interest_Amt`,
    r.`Paid`, 
    r.`Total_Bal`,  
    r.`Expected_Amount`, 
    r.`Savings_Bal`, 
    r.`Last_Amount`, 
    r.`Transaction_Date`, 
    r.`Officer_Name`, 
    r.`Date_Disbursed`, 
    r.`Maturity_Date`,
    reg.`Account_No` AS `Account`,
    reg.`BVN` AS `Bvns`,
    reg.`Bank` AS `Banks`,
    reg.`Years` AS `Dobs`,
    reg.`Address` AS `Addresss`,
    reg.`Biz_Type` AS `Bizs`,
    reg.`Biz_Address` AS `Biz_ads`,
    CONCAT_WS(' ', g.`Firstname`, g.`Middlename`, g.`Lastname`) AS `Guarantor_Name`,
    g.`Phone` AS `Guarantor_Phone`,
    g.`Address` AS `Guarantor_Address`
FROM `repayments` r
LEFT JOIN `register` reg ON r.Reg_id = reg.id
LEFT JOIN `gaurantors` g ON r.Reg_id = g.Regis_id
WHERE r.Status = 'Active'
ORDER BY r.Firstname ASC";  

$setRec = mysqli_query($con, $sql);  

if (!$setRec) {
    die("Query Error: " . mysqli_error($con));
}

// Column headers
$columnHeader = array(
    "REG NO",
    "DISBURSEMENT NO",
    "LOAN ACCOUNT NO",
    "FIRST NAME",
    "MIDDLENAME",
    "LASTNAME",
    "GENDER",
    "BRANCH",
    "GROUP",
    "CLIENT PHONE",
    "PRODUCT",
    "FREQUENCY",
    "DURATION",
    "PRINCIPAL AMOUNT",
    "INTEREST AMOUNT",
    "PAID AMOUNT",
    "OUTSTANDING",
    "EXPECTED AMOUNT",
    "SAVINGS BALANCE",
    "LAST AMOUNT PAID",
    "LAST PAYMENT DATE",
    "LOAN OFFICER",
    "DATE DISBURSED",
    "MATURITY DATE",
    "ACCOUNT NO",
    "BVN",
    "BANK",
    "DATE OF BIRTH",
    "CLIENT ADDRESS",
    "BUSINESS TYPE",
    "BUSINESS ADDRESS",
    "GUARANTOR NAME",
    "GUARANTOR PHONE",
    "GUARANTOR ADDRESS"
);

// Prepare data
$excelData = array();
$excelData[] = $columnHeader;

while ($rec = mysqli_fetch_assoc($setRec)) {  
    $rowData = array(
        $rec['Reg_id'] ?? '',
        $rec['Disbursement_No'] ?? '',
        $rec['Loan_Account_No'] ?? '',
        $rec['Firstname'] ?? '',
        $rec['Middlename'] ?? '',
        $rec['Lastname'] ?? '',
        $rec['Gender'] ?? '',
        $rec['Branch'] ?? '',
        $rec['Unions'] ?? '',
        $rec['Phone'] ?? '',
        $rec['Product'] ?? '',
        $rec['Frequency'] ?? '',
        $rec['Duration'] ?? '',
        $rec['Loan_Amount'] ?? '',
        $rec['Interest_Amt'] ?? '',
        $rec['Paid'] ?? '',
        $rec['Total_Bal'] ?? '',
        $rec['Expected_Amount'] ?? '',
        $rec['Savings_Bal'] ?? '',
        $rec['Last_Amount'] ?? '',
        $rec['Transaction_Date'] ?? '',
        $rec['Officer_Name'] ?? '',
        $rec['Date_Disbursed'] ?? '',
        $rec['Maturity_Date'] ?? '',
        $rec['Account'] ?? '',
        $rec['Bvns'] ?? '',
        $rec['Banks'] ?? '',
        $rec['Dobs'] ?? '',
        $rec['Addresss'] ?? '',
        $rec['Bizs'] ?? '',
        $rec['Biz_ads'] ?? '',
        $rec['Guarantor_Name'] ?? '',
        $rec['Guarantor_Phone'] ?? '',
        $rec['Guarantor_Address'] ?? ''
    );
    
    $excelData[] = $rowData;
}

mysqli_close($con);

// Generate filename with timestamp
$filename = "Loan_Monitor_" . date('Y-m-d_His') . ".xls";

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");  
header("Content-Disposition: attachment; filename=\"$filename\"");  
header("Pragma: no-cache");  
header("Expires: 0");

// Output Excel content
$output = fopen('php://output', 'w');

foreach ($excelData as $row) {
    // Properly format cells for Excel
    $formattedRow = array_map(function($value) {
        // Clean the value
        $value = str_replace(array("\r", "\n", "\t"), ' ', $value);
        // Wrap in quotes if contains comma or special characters
        if (strpos($value, ',') !== false || strpos($value, '"') !== false) {
            $value = '"' . str_replace('"', '""', $value) . '"';
        }
        return $value;
    }, $row);
    
    echo implode("\t", $formattedRow) . "\n";
}

fclose($output);
exit;
?>