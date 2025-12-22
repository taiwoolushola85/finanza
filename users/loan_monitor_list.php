<?php
// Sanitize inputs
// Sanitize and validate inputs
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? max(0, (int)$_POST['maxRows']) : 0;

// Database connection
include '../config/db.php';
?>

<small><b>Total Record: 
<?php 
$count_query = "SELECT COUNT(*) as total FROM repayments WHERE Status = 'Active'";
$result = mysqli_query($con, $count_query);
$row = mysqli_fetch_assoc($result);
echo $row['total'];
?>
</b></small>

<div style="float:right">
<a href="moni.php">
<button type="button" class="btn btn-outline-primary btn-sm" style="float:right; margin:5px;"><i class="fa fa-download"></i> 
Export Data
</button>
</a>
</div>
<br clear="all">

<div style="overflow-y:auto; height:350px">
<?php
// Main query with proper escaping
$base_query = "SELECT 
r.id, r.Disbursement_No, r.Loan_Account_No, r.Firstname, r.Middlename, r.Lastname, 
r.Branch, r.Phone, r.Product, r.Total_Loan, r.Paid, r.Total_Bal, r.Expected_Amount, 
r.Officer_Name, r.Date_Disbursed, r.Maturity_Date,
reg.Account_No AS Account,
reg.BVN AS Bvn,
reg.Bank AS Bank,
reg.Years AS Dob,
reg.Address AS Address,
reg.Biz_Type AS Biz,
reg.Biz_Address AS Biz_ad,
g.Firstname AS fn,
g.Middlename AS mn,
g.Lastname AS ln,
g.Phone AS Phones,
g.Address AS Gaddress
FROM repayments r
LEFT JOIN register reg ON r.Reg_id = reg.id
LEFT JOIN gaurantors g ON r.Reg_id = g.Regis_id
WHERE r.Status = 'Active'";

// Determine query based on conditions
if (!empty($search)) {
// Search query with proper escaping
$search_term = mysqli_real_escape_string($con, $search);
$query = $base_query . " AND (
reg.BVN LIKE '%{$search_term}%' OR
r.Firstname LIKE '%{$search_term}%' OR
r.Lastname LIKE '%{$search_term}%' OR
r.Middlename LIKE '%{$search_term}%' OR
r.Phone LIKE '%{$search_term}%' OR
r.Branch LIKE '%{$search_term}%' OR
r.Officer_Name LIKE '%{$search_term}%' OR
r.Loan_Account_No LIKE '%{$search_term}%' OR
r.Disbursement_No LIKE '%{$search_term}%'
)";
$json_file = '../data/all_monitor_search.json';
} elseif ($maxRows > 0 && $maxRows != 10) {
// All records without limit
$query = $base_query;
$json_file = '../data/monitor_book.json';
} else {
// Default: limited to 12 records
$query = $base_query . " LIMIT 10000";
$json_file = '../data/monitor_book.json';
}

$query .= "";
// Execute query
$result = mysqli_query($con, $query);
if (!$result) {
die("Query Error: " . mysqli_error($con));
}

// Store results in array
$results = array();
while ($row = mysqli_fetch_assoc($result)) {
$results[] = $row;
}

// Save to JSON file
if (!is_dir('data')) {
mkdir('data', 0755, true);
}
$fp = fopen($json_file, 'w');
fwrite($fp, json_encode($results));
fclose($fp);

mysqli_close($con);
?>

<div id="table-container" style="height:340px; overflow-y:auto;">
<table >
<thead>
<tr style="font-size:8px;">
<th>DISBURSEMENT NO</th>
<th>LOAN ACCT</th>
<th>NAME</th>
<th>BRANCH</th>
<th>PHONE</th>
<th>PRODUCT</th>
<th>TOTAL LOAN</th>
<th>AMT PAID</th>
<th>BALANCE</th>
<th>EXPD AMT</th>
<th>CREDIT OFFICER</th>
<th>DATE DISBURSED</th>
<th>MATURITY DATE</th>
<th>ACCOUNT NO</th>
<th>BVN</th>
<th>BANK</th>
<th>DATE OF BIRTH</th>
<th>ADDRESS</th>
<th>BUSINESS TYPE</th>
<th>BUSINESS ADDRESS</th>
<th>GUARANTOR NAME</th>
<th>GUARANTOR PHONE</th>
<th>GUARANTOR ADDRESS</th>
</tr>
</thead>
<tbody>
<?php
if (file_exists($json_file)) {
$data = file_get_contents($json_file);
$json = json_decode($data);
if ($json && count($json) > 0) {
foreach ($json as $member) {
?>
<tr style="font-size:8px">
<td><?php echo htmlspecialchars($member->Disbursement_No ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Loan_Account_No ?? ''); ?></td>
<td style="text-transform:capitalize">
<?php echo htmlspecialchars(trim(($member->Firstname ?? '') . " " . ($member->Middlename ?? '') . " " . ($member->Lastname ?? ''))); ?>
</td>
<td><?php echo htmlspecialchars($member->Branch ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Phone ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Product ?? ''); ?></td>
<td><?php echo number_format($member->Total_Loan ?? 0, 2); ?></td>
<td><?php echo number_format($member->Paid ?? 0, 2); ?></td>
<td><?php echo number_format($member->Total_Bal ?? 0, 2); ?></td>
<td><?php echo number_format($member->Expected_Amount ?? 0, 2); ?></td>
<td><?php echo htmlspecialchars($member->Officer_Name ?? ''); ?></td>
<td><?php echo !empty($member->Date_Disbursed) ? date("d-M-Y", strtotime($member->Date_Disbursed)) : ''; ?></td>
<td><?php echo !empty($member->Maturity_Date) ? date("d-M-Y", strtotime($member->Maturity_Date)) : ''; ?></td>
<td><?php echo htmlspecialchars($member->Account ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Bvn ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Bank ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Dob ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Address ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Biz ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Biz_ad ?? ''); ?></td>
<td><?php echo htmlspecialchars(trim(($member->fn ?? '') . " " . ($member->mn ?? '') . " " . ($member->ln ?? ''))); ?></td>
<td><?php echo htmlspecialchars($member->Phones ?? ''); ?></td>
<td><?php echo htmlspecialchars($member->Gaddress ?? ''); ?></td>
</tr>
<?php
}
} else {
echo '<tr><td colspan="23" style="text-align:center;">No records found</td></tr>';
}
}
?>
</tbody>
</table>
</div>
</div>
