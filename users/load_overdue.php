

<?php
// Sanitize inputs
$d = date('Y-m-d');
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? intval($_POST['maxRows']) : 0;

// Database connection
include '../config/db.php';
?>

<div class="row">
<div class="col-sm-3">
<small><b>Total: 
<?php 
$count_query = "SELECT COUNT(*) as total FROM repayments WHERE Status = 'Active' AND ? > Maturity_Date";
$stmt = mysqli_prepare($con, $count_query);
mysqli_stmt_bind_param($stmt, "s", $d);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
echo $row['total'];
mysqli_stmt_close($stmt);
?>
</b></small>
</div>
<div class="col-sm-3">
<b>Total Loan Amt: <span id="totalLoan"></span></b>
</div>
<div class="col-sm-3">
<b>Total Outstanding: <span id="totalOutstanding"></span></b>
</div>
<div class="col-sm-3">
<b>Total Overdue: <span id="totalOverdue"></span></b>
</div>
<div class="col-sm-3">
</div>
</div>
<br>
<button type="button" class="btn btn-outline-primary btn-sm btn-flat" style="float:right; margin:5px" onclick="exportTableToExcel()">
<i class="fa fa-download"></i> Export Data
</button>
<br clear="all">

<!-- Include SheetJS library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<div style="overflow-y:auto; height:370px">
<?php
// Build query based on conditions
$base_query = "SELECT id, Disbursement_No, Loan_Account_No, Firstname, Middlename, Lastname, Branch, Phone, Product, Total_Loan, Paid, Total_Bal, Expected_Amount, 
Maturity_Status, Status, Savings_Bal, Frequency, Officer_Name, Date_Disbursed, Maturity_Date, Duration 
FROM repayments WHERE Status = 'Active' AND ? > Maturity_Date";

// Determine query based on conditions
if (!empty($search)) {
    // Search query
$search_term = "%{$search}%";
$query = $base_query . " AND (
Firstname LIKE ? OR 
Lastname LIKE ? OR 
Middlename LIKE ? OR 
Phone LIKE ? OR 
Branch LIKE ? OR 
Officer_Name LIKE ? OR 
Loan_Account_No LIKE ? OR 
Disbursement_No LIKE ?
) ORDER BY Firstname ASC";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "sssssssss", $d, $search_term, $search_term, $search_term, 
$search_term, $search_term, $search_term, $search_term, $search_term);
$json_file = '../data/all_expired_search.json';
} elseif ($maxRows > 0 && $maxRows != 10) {
// All records
$query = $base_query . " ORDER BY Firstname ASC";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $d);
$json_file = '../data/all_expired_book.json';
} else {
// Limited to 12 records
$query = $base_query . " ORDER BY Firstname ASC LIMIT 12";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $d);
$json_file = '../data/expired_book.json';
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (!$result) {
die("Query Error: " . mysqli_error($con));
}

// Store results in array
$results = array();
while ($row = mysqli_fetch_assoc($result)) {
$results[] = $row;
}

// Save to JSON file
if (!is_dir('../data')) {
mkdir('../data', 0755, true);
}
$fp = fopen($json_file, 'w');
fwrite($fp, json_encode($results));
fclose($fp);

mysqli_stmt_close($stmt);
mysqli_close($con);

// Helper function to calculate tenure metrics
function calculateTenureMetrics($member, $d) {
$metrics = array();
if ($member->Frequency == 'Daily') {
$now = time();
$start_date = strtotime($member->Date_Disbursed);
$days_diff = round(($now - $start_date) / (60 * 60 * 24));
$metrics['used'] = $days_diff . " Days";
$metrics['remaining'] = ($member->Duration > $days_diff) 
? round($member->Duration - $days_diff) . " Days" 
: "Exceeded";
$metrics['expected_due'] = ($member->Duration > $days_diff)
? round($member->Expected_Amount * $days_diff)
: $member->Total_Loan;
$metrics['overdue_amt'] = ($member->Duration > $days_diff)
? ($member->Expected_Amount * $days_diff) - $member->Paid
: $member->Total_Bal;
$metrics['overdue_days'] = ($member->Duration > $days_diff)
? round((($member->Expected_Amount * $days_diff) - $member->Paid) / $member->Expected_Amount) . " Days"
: round($member->Total_Bal / $member->Expected_Amount) . " Days";
} elseif ($member->Frequency == 'Weekly') {
$date1 = new DateTime($member->Date_Disbursed);
$date2 = new DateTime($d);
$weeks_used = round($date1->diff($date2)->days / 7);
$metrics['used'] = $weeks_used . " Weeks";
$metrics['remaining'] = ($member->Duration > $weeks_used)
? round($member->Duration - $weeks_used) . " Weeks"
: "Exceeded";
$metrics['expected_due'] = ($weeks_used == 0) ? 0 : (
($member->Duration > $weeks_used)
? round($member->Expected_Amount * $weeks_used)
: $member->Total_Loan
);
$metrics['overdue_amt'] = ($weeks_used == 0) ? 0 : (
($member->Duration > $weeks_used)
? ($member->Expected_Amount * $weeks_used) - $member->Paid
: $member->Total_Bal
);
$metrics['overdue_days'] = ($weeks_used == 0) ? "0 Weeks" : (
($member->Duration > $weeks_used)
? round((($member->Expected_Amount * $weeks_used) - $member->Paid) / $member->Expected_Amount) . " Weeks"
: round($member->Total_Bal / $member->Expected_Amount) . " Weeks"
);
} else { // Monthly
$date1 = new DateTime($member->Date_Disbursed);
$date2 = new DateTime($d);
$months_used = round($date1->diff($date2)->days / 30);
$metrics['used'] = $months_used . " Months";
$metrics['remaining'] = ($member->Duration > $months_used)
? round($member->Duration - $months_used) . " Months"
: "Exceeded";
$metrics['expected_due'] = ($months_used == 0) ? 0 : (
($member->Duration > $months_used)
? round($member->Expected_Amount * $months_used)
: $member->Total_Loan
);
$metrics['overdue_amt'] = ($months_used == 0) ? 0 : (
($member->Duration > $months_used)
? ($member->Expected_Amount * $months_used) - $member->Paid
: $member->Total_Bal
);
$metrics['overdue_days'] = ($months_used == 0) ? "0 Months" : (
($member->Duration > $months_used)
? round((($member->Expected_Amount * $months_used) - $member->Paid) / $member->Expected_Amount) . " Months"
: round($member->Total_Bal / $member->Expected_Amount) . " Months"
);
}
return $metrics;
}
?>

<div id="table-container" style="height:370px;">
<table id="myTable">
<thead>
<tr style="font-size:8px">
<th>DISBURSEMENT NO</th>
<th>LOAN ACCT</th>
<th>NAME</th>
<th>BRANCH</th>
<th>PHONE</th>
<th>PRODUCT</th>
<th>LOAN AMT</th>
<th>AMT PAID</th>
<th>OUTSTANDING</th>
<th>EXPD AMT</th>
<th>SAVINGS</th>
<th>REPAYMENT %</th>
<th>TENURE</th>
<th>TENURE USED</th>
<th>TENURE REMAIN</th>
<th>EXPECTED DUE AMT</th>
<th>OVERDUE AMT</th>
<th>OVERDUE DAY</th>
<th>CREDIT OFFICER</th>
<th>DATE DISBURSED</th>
<th>DUE DATE</th>
<th>STATUS</th>
</tr>
</thead>
<tbody>
<?php
if (file_exists($json_file)) {
$data = file_get_contents($json_file);
$json = json_decode($data);
if ($json && count($json) > 0) {
foreach ($json as $member) {
$metrics = calculateTenureMetrics($member, $d);
$repayment_percent = ($member->Total_Loan > 0) 
? round(($member->Paid / $member->Total_Loan) * 100) 
: 0;
?>
<tr style="font-size:8px">
<td><?php echo htmlspecialchars($member->Disbursement_No ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Loan_Account_No ?? ''); ?></td>
<td style="text-transform:uppercase">
<?php echo htmlspecialchars(trim(($member->Firstname ?? '') . " " . ($member->Middlename ?? '') . " " . ($member->Lastname ?? ''))); ?>
</td>
<td><?php echo htmlspecialchars($member->Branch ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Phone ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Product ?? ''); ?></td>
<td><?php echo number_format($member->Total_Loan ?? 0, 2); ?></td>
<td><?php echo number_format($member->Paid ?? 0, 2); ?></td>
<td><?php echo number_format($member->Total_Bal ?? 0, 2); ?></td>
<td><?php echo number_format($member->Expected_Amount ?? 0, 2); ?></td>
<td><?php echo number_format($member->Savings_Bal ?? 0, 2); ?></td>
<td><?php echo $repayment_percent; ?>%</td>
<td><?php echo htmlspecialchars($member->Duration ?? ''); ?></td>
<td><?php echo $metrics['used']; ?></td>
<td><?php echo $metrics['remaining']; ?></td>
<td><?php echo number_format($metrics['expected_due'], 2); ?></td>
<td><?php echo number_format($metrics['overdue_amt'], 2); ?></td>
<td><?php echo $metrics['overdue_days']; ?></td>
<td><?php echo htmlspecialchars($member->Officer_Name ?? ''); ?></td>
<td><?php echo !empty($member->Date_Disbursed) ? date("d-M-Y", strtotime($member->Date_Disbursed)) : ''; ?></td>
<td><?php echo !empty($member->Maturity_Date) ? date("d-M-Y", strtotime($member->Maturity_Date)) : ''; ?></td>
<td style="color:red">Overdue</td>
</tr>
<?php
}
} else {
echo '<tr><td colspan="22" style="text-align:center;">No overdue loans found</td></tr>';
}
}
?>
</tbody>
</table>
</div>
</div>

<script>
$(document).ready(function () {
function getColumnTotal(headerText) {
let columnIndex = -1;
let total = 0;
// Find column index by header name
$('#myTable thead th').each(function (index) {
if ($(this).text().trim().toUpperCase() === headerText.toUpperCase()) {
columnIndex = index;
}
});
if (columnIndex === -1) {
console.warn('Column not found:', headerText);
return 0;
}
// Sum column values
$('#myTable tbody tr').each(function () {
let value = $(this).find('td').eq(columnIndex).text();
// Remove commas, currency symbols, spaces
value = value.replace(/[^0-9.-]+/g, '');
total += parseFloat(value) || 0;
});
return total;
}
// Example usage
let overdueTotal = getColumnTotal('OVERDUE AMT');
console.log('Total Overdue:', overdueTotal);
// Display somewhere
//$('#totalOverdue').text(overdueTotal.toLocaleString());
$('#totalOverdue').text(overdueTotal.toFixed(2));
});
</script>


<script>
$(document).ready(function () {
function getColumnTotal(headerText) {
let columnIndex = -1;
let total = 0;
// Find column index by header name
$('#myTable thead th').each(function (index) {
if ($(this).text().trim().toUpperCase() === headerText.toUpperCase()) {
columnIndex = index;
}
});
if (columnIndex === -1) {
console.warn('Column not found:', headerText);
return 0;
}
// Sum column values
$('#myTable tbody tr').each(function () {
let value = $(this).find('td').eq(columnIndex).text();
// Remove commas, currency symbols, spaces
value = value.replace(/[^0-9.-]+/g, '');
total += parseFloat(value) || 0;
});
return total;
}
// Example usage
let outstandingAmt = getColumnTotal('OUTSTANDING');
console.log('Total Outstanding:', outstandingAmt);
// Display somewhere
//$('#totalOverdue').text(overdueTotal.toLocaleString());
$('#totalOutstanding').text(outstandingAmt.toFixed(2));
});
</script>



<script>
$(document).ready(function () {
function getColumnTotal(headerText) {
let columnIndex = -1;
let total = 0;
// Find column index by header name
$('#myTable thead th').each(function (index) {
if ($(this).text().trim().toUpperCase() === headerText.toUpperCase()) {
columnIndex = index;
}
});
if (columnIndex === -1) {
console.warn('Column not found:', headerText);
return 0;
}
// Sum column values
$('#myTable tbody tr').each(function () {
let value = $(this).find('td').eq(columnIndex).text();
// Remove commas, currency symbols, spaces
value = value.replace(/[^0-9.-]+/g, '');
total += parseFloat(value) || 0;
});
return total;
}
// Example usage
let loanAmt = getColumnTotal('LOAN AMT');
console.log('Total Loan Amt:', loanAmt);
// Display somewhere
//$('#totalOverdue').text(overdueTotal.toLocaleString());
$('#totalLoan').text(loanAmt.toFixed(2));
});
</script>



<script type="text/javascript">
function exportTableToExcel() {
const table = document.getElementById('demo1');
const rows = table.querySelectorAll('tr');
const data = [];
// Extract data from table
rows.forEach(row => {
const rowData = [];
const cells = row.querySelectorAll('th, td');
cells.forEach(cell => rowData.push(cell.textContent.trim()));
data.push(rowData);
});
// Create workbook and worksheet
const wb = XLSX.utils.book_new();
const ws = XLSX.utils.aoa_to_sheet(data);
XLSX.utils.book_append_sheet(wb, ws, "Overdue Loans");
// Download with timestamp
const filename = "overdue_loan_report_" + new Date().toISOString().slice(0,10) + ".xlsx";
XLSX.writeFile(wb, filename);
}
</script>