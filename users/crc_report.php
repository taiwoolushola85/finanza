<?php 
$type = $_GET['type'];
$bvn = $_GET['bvn'];
?>

<?php
if($type == "Basic"){
?>





<script>
$(document).ready(function() {
var bvn = <?php echo $bvn; ?>;
$("#loaders").show();
$.ajax({
url: 'https://api.creditchek.africa/v1/credit/crc',
type: 'GET',
data: {
bvn: bvn
},
headers: {
'token': '5Gy5jXFNPWLnBnVeGDxylnL5oqorcdC+nVrCZI31Kxt1z2DFqN4sCUvnuN0hBX8h',
'Content-Type': 'application/json'
},
success: function(response) {
$("#loaders").hide();
if (response.status && response.data) {
displayCRCTable(response.data);
} else {
$('#report').html('<p style="color: red;">No data found</p>');
$("#loaders").hide();
}
},
error: function(xhr, status, error) {
let errorMsg = 'An error occurred during verification';
try {
const errorResponse = JSON.parse(xhr.responseText);
errorMsg = errorResponse.message || errorMsg;
} catch(e) {
errorMsg = `Status: ${xhr.status} - ${error}`;
}
displayErrorResult(errorMsg);
},
});
function displayCRCTable(data) {
alert("CRC Verification Successfull..");
$("#loaders").hide();
var html = '<div id="pdfContent" style="font-family: Arial, sans-serif; font-size: 12px;">';
// Header
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Credit Collectors Data</td><td style="padding: 8px; border: 1px solid #000;">' + data.score.crcReportOrderNumber + '</td></tr>';
html += '</table><br>';
// Customer Multiple Details
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="4" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Customer Multiple Details</td></tr>';
html += '<tr><td colspan="4" style="padding: 8px; border: 1px solid #000; font-weight: bold;">No Data Found</td></tr>';
html += '</table><br>';
// Customer Details (Demographics)
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="4" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Customer Details (Demographics)</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 25%;">Full Name</td><td style="padding: 8px; border: 1px solid #000; width: 25%;">' + data.name + '</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 25%;">Gender</td><td style="padding: 8px; border: 1px solid #000; width: 25%;">' + data.gender + '</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Date of Birth</td><td style="padding: 8px; border: 1px solid #000;">' + data.dateOfBirth + '</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Nationality</td><td style="padding: 8px; border: 1px solid #000;">Nigeria</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Address</td><td style="padding: 8px; border: 1px solid #000;">' + (data.address !== 'null' ? data.address : 'NG NIGERIA') + '</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Telephone Number (01)</td><td style="padding: 8px; border: 1px solid #000;">234</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold;"></td><td style="padding: 8px; border: 1px solid #000;"></td><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Telephone Number (02)</td><td style="padding: 8px; border: 1px solid #000;">9</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold;"></td><td style="padding: 8px; border: 1px solid #000;"></td><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Application Viability Score</td><td style="padding: 8px; border: 1px solid #000;">NA</td></tr>';
html += '</table><br>';
// Means of Identification
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 33%;">Means of Identification</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 33%;">Identifier Value (Number)</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 34%;">Expiry Date</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Bank Verification Number</td><td style="padding: 8px; border: 1px solid #000;">' + data.bvn + '</td><td style="padding: 8px; border: 1px solid #000;">ND</td></tr>';
html += '</table><br>';
// Credit Overview
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="2" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Credit Overview</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 70%;">Indicator</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 30%; text-align: center;">Value</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Maximum number of days overdue in the last 12 months</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">' + data.score.maxNoOfDays + '</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Maximum number of facilities overdue in the last 12 months</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">0</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Number of inquiries in the last 12 months</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">58</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Number of Dishonour Cheques</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">0</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Number of Suit Filed</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">0</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Number of Guaranteed Loans</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">0</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">First Credit Reported Date</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">' + data.score.lastReportedDate + '</td></tr>';
html += '</table><br>';
// Summary Of Performance
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="7" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Summary Of Performance</td></tr>';
html += '<tr style="background-color: #f0f0f0;">';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Institution Name</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Facilities Count</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Performing Facilities</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Non Performing Facilities</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Approved Amount</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Account Balance</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Overdue Amount</td>';
html += '</tr>';
// You can add institution data here if available in the API response
html += '<tr><td colspan="7" style="padding: 8px; border: 1px solid #000; text-align: center;">Data not available in current API response</td></tr>';
html += '</table><br>';
// Classification of Active Accounts by Institution Type
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="7" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Classification of Active Accounts by Institution Type</td></tr>';
html += '<tr style="background-color: #f0f0f0;">';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Institution Type</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">No of Accounts</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Currency</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Approved Amount</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Outstanding Balance</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Amount Overdue</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Legal Action Taken</td>';
html += '</tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Micro Lenders</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">' + data.score.totalNoOfLoans + '</td><td style="padding: 8px; border: 1px solid #000;">NGN</td><td style="padding: 8px; border: 1px solid #000; text-align: right;">₦' + Number(data.score.totalBorrowed).toLocaleString() + '</td><td style="padding: 8px; border: 1px solid #000; text-align: right;">₦' + Number(data.score.totalOutstanding).toLocaleString() + '</td><td style="padding: 8px; border: 1px solid #000; text-align: right;">₦' + Number(data.score.totalOverdue).toLocaleString() + '</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">ND</td></tr>';
html += '</table><br>';
// Summary Statistics
html += '<div style="background-color: #f0f0f0; padding: 15px; border: 2px solid #000; margin-top: 20px; color:black">';
html += '<h3 style="margin: 0 0 10px 0; color: #FF8C00;">Summary Statistics</h3>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Institutions:</strong> ' + data.score.totalNoOfInstitutions + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Loans:</strong> ' + data.score.totalNoOfLoans + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Active Loans:</strong> ' + data.score.totalNoOfActiveLoans + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Closed Loans:</strong> ' + data.score.totalNoOfClosedLoans + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Delinquent Facilities:</strong> ' + data.score.totalNoOfDelinquentFacilities + '</p>';
html += '<p style="margin: 5px 0;"><strong>Last Reported Date:</strong> ' + data.score.lastReportedDate + '</p>';
html += '<p style="margin: 5px 0;"><strong>Report Order Number:</strong> ' + data.score.crcReportOrderNumber + '</p>';
html += '</div>';
html += '</div>';
$('#report').html(html);
$('#downloadPdf').show();
}
function displayErrorResult(message) {
$("#loaders").hide();
alert('Verification Error: ' + message);
}

});
</script>



<?php 
}else if($type == "Premium"){
?>

<script>
$(document).ready(function() {
var bvn = <?php echo $bvn; ?>;
$("#loaders").show();
$.ajax({
url: 'https://api.creditchek.africa/v1/credit/crc-premium',
type: 'GET',
data: {
bvn: bvn
},
headers: {
'token': '5Gy5jXFNPWLnBnVeGDxylnL5oqorcdC+nVrCZI31Kxt1z2DFqN4sCUvnuN0hBX8h',
'Content-Type': 'application/json'
},
success: function(response) {
$("#loaders").hide();
if (response.status && response.data) {
displayCRCPremiumTable(response.data);
} else {
$("#loaders").hide();
$('#report').html('<p style="color: red;">No data found</p>');
}
},
error: function(xhr, status, error) {
$("#loaders").hide();
$('#report').html('<p style="color: red;">Error: ' + error + '</p>');
}
});
function displayCRCPremiumTable(data) {
alert("CRC Premium Verification Successful..");
$("#loaders").hide();
var html = '<div id="pdfContent" style="font-family: Arial, sans-serif; font-size: 12px;">';
// Header
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Credit Collectors Data (Premium)</td><td style="padding: 8px; border: 1px solid #000;">' + data.score.crcReportOrderNumber + '</td></tr>';
html += '</table><br>';
// Customer Multiple Details
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="4" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Customer Multiple Details</td></tr>';
html += '<tr><td colspan="4" style="padding: 8px; border: 1px solid #000; font-weight: bold;">No Data Found</td></tr>';
html += '</table><br>';
// Customer Details (Demographics)
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="4" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Customer Details (Demographics)</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 25%;">Full Name</td><td style="padding: 8px; border: 1px solid #000; width: 25%;">' + data.name + '</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 25%;">Gender</td><td style="padding: 8px; border: 1px solid #000; width: 25%;">' + data.gender + '</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Date of Birth</td><td style="padding: 8px; border: 1px solid #000;">' + data.dateOfBirth + '</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Nationality</td><td style="padding: 8px; border: 1px solid #000;">Nigeria</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Address</td><td style="padding: 8px; border: 1px solid #000;">' + (data.address !== 'null' ? data.address : 'NG NIGERIA') + '</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">BVN</td><td style="padding: 8px; border: 1px solid #000;">' + data.bvn + '</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Customer ID</td><td style="padding: 8px; border: 1px solid #000;">' + data.customerId + '</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Application Viability Score</td><td style="padding: 8px; border: 1px solid #000;">NA</td></tr>';
html += '</table><br>';
// Means of Identification
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 33%;">Means of Identification</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 33%;">Identifier Value (Number)</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 34%;">Expiry Date</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Bank Verification Number</td><td style="padding: 8px; border: 1px solid #000;">' + data.bvn + '</td><td style="padding: 8px; border: 1px solid #000;">ND</td></tr>';
html += '</table><br>';
// Credit Overview
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="2" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Credit Overview</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 70%;">Indicator</td><td style="padding: 8px; border: 1px solid #000; font-weight: bold; width: 30%; text-align: center;">Value</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Maximum number of days overdue in the last 12 months</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">' + (data.score.maxNoOfDays || '0') + '</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Total number of facilities overdue in the last 12 months</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">' + (data.score.totalNoOfOverdueAccounts || '0') + '</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Number of inquiries in the last 12 months</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">' + (data.score.creditEnquiries ? data.score.creditEnquiries.length : '0') + '</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Number of Dishonour Cheques</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">0</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Number of Suit Filed</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">0</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Number of Guaranteed Loans</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">0</td></tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">First Credit Reported Date</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">' + data.score.lastReportedDate + '</td></tr>';
html += '</table><br>';
// Summary Of Performance
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="7" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Summary Of Performance</td></tr>';
html += '<tr style="background-color: #f0f0f0;">';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Institution Name</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Facilities Count</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Performing Facilities</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Non Performing Facilities</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Approved Amount</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Account Balance</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Overdue Amount</td>';
html += '</tr>';
if (data.score.loanPerformance && data.score.loanPerformance.length > 0) {
data.score.loanPerformance.forEach(function(loan) {
html += '<tr>';
html += '<td style="padding: 8px; border: 1px solid #000;">' + loan.loanProvider + '</td>';
html += '<td style="padding: 8px; border: 1px solid #000; text-align: center;">' + loan.loanCount + '</td>';
html += '<td style="padding: 8px; border: 1px solid #000; text-align: center;">' + loan.noOfPerformingLoans + '</td>';
html += '<td style="padding: 8px; border: 1px solid #000; text-align: center;">' + loan.noOfNonPerformingLoans + '</td>';
html += '<td style="padding: 8px; border: 1px solid #000; text-align: right;">' + loan.loanAmount + '</td>';
html += '<td style="padding: 8px; border: 1px solid #000; text-align: right;">' + loan.outstandingBalance + '</td>';
html += '<td style="padding: 8px; border: 1px solid #000; text-align: right;">' + loan.overdueAmount + '</td>';
html += '</tr>';
});
} else {
html += '<tr><td colspan="7" style="padding: 8px; border: 1px solid #000; text-align: center;">Data not available in current API response</td></tr>';
}
html += '</table><br>';
// Classification of Active Accounts by Institution Type
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="7" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Classification of Active Accounts by Institution Type</td></tr>';
html += '<tr style="background-color: #f0f0f0;">';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Institution Type</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">No of Accounts</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Currency</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Approved Amount</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Outstanding Balance</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Amount Overdue</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Legal Action Taken</td>';
html += '</tr>';
html += '<tr><td style="padding: 8px; border: 1px solid #000;">Micro Lenders</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">' + data.score.totalNoOfLoans + '</td><td style="padding: 8px; border: 1px solid #000;">NGN</td><td style="padding: 8px; border: 1px solid #000; text-align: right;">₦' + Number(data.score.totalBorrowed).toLocaleString() + '</td><td style="padding: 8px; border: 1px solid #000; text-align: right;">₦' + Number(data.score.totalOutstanding).toLocaleString() + '</td><td style="padding: 8px; border: 1px solid #000; text-align: right;">₦' + Number(data.score.totalOverdue).toLocaleString() + '</td><td style="padding: 8px; border: 1px solid #000; text-align: center;">ND</td></tr>';
html += '</table><br>';
// Detailed Loan History
if (data.score.loanHistory && data.score.loanHistory.length > 0) {
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="10" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Detailed Loan History</td></tr>';
html += '<tr style="background-color: #f0f0f0; font-size: 10px;">';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Loan Provider</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Account No.</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Type</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Loan Amount</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Outstanding</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Disbursed</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Maturity</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Performance</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Collateral</td>';
html += '<td style="padding: 6px; border: 1px solid #000; font-weight: bold;">Reported</td>';
html += '</tr>';
data.score.loanHistory.forEach(function(loan) {
html += '<tr style="font-size: 10px;">';
html += '<td style="padding: 6px; border: 1px solid #000;">' + loan.loanProvider + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + loan.accountNumber + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + loan.type + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + loan.currency + ' ' + Number(loan.loanAmount).toLocaleString() + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + Number(loan.outstandingBalance).toLocaleString() + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + (loan.disbursedDate || 'N/A') + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + (loan.maturityDate || 'N/A') + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + loan.performanceStatus + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + loan.collateral + '</td>';
html += '<td style="padding: 6px; border: 1px solid #000;">' + loan.dateReported + '</td>';
html += '</tr>';
});
html += '</table><br>';
}
// Credit Enquiries
if (data.score.creditEnquiries && data.score.creditEnquiries.length > 0) {
html += '<table style="width:100%; border-collapse: collapse; border: 2px solid #000;">';
html += '<tr><td colspan="3" style="background-color: #FF8C00; color: white; padding: 8px; font-weight: bold; border: 1px solid #000;">Credit Enquiries</td></tr>';
html += '<tr style="background-color: #f0f0f0;">';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Loan Type</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Institution Type</td>';
html += '<td style="padding: 8px; border: 1px solid #000; font-weight: bold;">Date</td>';
html += '</tr>';
data.score.creditEnquiries.forEach(function(enquiry) {
html += '<tr>';
html += '<td style="padding: 8px; border: 1px solid #000;">' + enquiry.loanType + '</td>';
html += '<td style="padding: 8px; border: 1px solid #000;">' + enquiry.institutionType + '</td>';
html += '<td style="padding: 8px; border: 1px solid #000;">' + enquiry.date + '</td>';
html += '</tr>';
});
html += '</table><br>';
}
// Summary Statistics
html += '<div style="background-color: #f0f0f0; padding: 15px; border: 2px solid #000; margin-top: 20px; color:black">';
html += '<h3 style="margin: 0 0 10px 0; color: #FF8C00;">Summary Statistics</h3>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Institutions:</strong> ' + data.score.totalNoOfInstitutions + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Loans:</strong> ' + data.score.totalNoOfLoans + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Active Loans:</strong> ' + data.score.totalNoOfActiveLoans + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Closed Loans:</strong> ' + data.score.totalNoOfClosedLoans + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Performing Loans:</strong> ' + data.score.totalNoOfPerformingLoans + '</p>';
html += '<p style="margin: 5px 0;"><strong>Total Number of Delinquent Facilities:</strong> ' + data.score.totalNoOfDelinquentFacilities + '</p>';
html += '<p style="margin: 5px 0;"><strong>Highest Loan Amount:</strong> ₦' + Number(data.score.highestLoanAmount).toLocaleString() + '</p>';
html += '<p style="margin: 5px 0;"><strong>Last Reported Date:</strong> ' + data.score.lastReportedDate + '</p>';
html += '<p style="margin: 5px 0;"><strong>Report Order Number:</strong> ' + data.score.crcReportOrderNumber + '</p>';
html += '</div>';
html += '</div>';
html += '<br>';
html += '<br>';
html += '<br>';
$('#report').html(html);
$('#downloadPdf').show();
}
});
</script>



<?php 
}else{
echo "<span style='color:red'>Invalid CRC Type Selected</span>"; 
}
?>