<?php
$type = $_POST['type'];
if($type == '1' ){
include 'cancelled_loan_report.php';
}else if($type == '2'){
include 'closed_loan_report.php';
}else if($type == '3'){
include 'overview_loan_report.php';
}else if($type == '4'){
include 'collection_report.php';
}else if($type == '5'){
include 'disbursement_report.php';
}else if($type == '6'){
include '';
}else if($type == '7'){
include 'loan_performace.php';
}else if($type == '8'){
include 'credit_officer_performance_report.php';
}else if($type == '9'){
include 'repayment_collection_report.php';
}else if($type == '10'){
include 'upfront_payment_report.php';
}else if($type == '11'){
include 'saving_deposit_report.php';
}else if($type == '12'){
include 'customer_saving_report.php';
}else if($type == '13'){
include 'callover_report.php';
}else if($type == '14'){
include 'gaurantor_report.php';
}else if($type == '16'){
include 'team_lead_performance_report.php';
}
?>