<?php
/* ================= HEADERS ================= */
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
exit;
}

include '../config/db.php';
include '../config/user_session.php';

/* ================= INPUTS ================= */
$search  = trim($_POST['search'] ?? '');
$maxRows = (int)($_POST['maxRows'] ?? 0);
$searchLike = "%{$search}%";

/* ================= BASE WHERE ================= */
$where = "(Status = ? OR Status = ?)";
$params = ['Active', 'Ready For Auditing'];
$types  = "ss";

/* ================= SEARCH ================= */
if ($search !== '') {
$where .= "AND (
BVN LIKE ? OR Account_Number LIKE ? OR Loan_Account_No LIKE ?
OR Disbursement_No LIKE ? OR Transaction_id LIKE ?
OR Savings_Account_No LIKE ? OR Unions LIKE ?
OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?
)
AND Status != 'Disbursed'";

for ($i = 0; $i < 10; $i++) {
$params[] = $searchLike;
$types .= "s";
}
}

/* ================= COUNT QUERY ================= */
$countSql = "SELECT COUNT(*) AS total FROM repayments WHERE $where";
$stmt = $con->prepare($countSql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

/* ================= DATA QUERY ================= */
$dataSql = "SELECT id, Loan_Account_No, Firstname, Middlename, Lastname, BVN, Product, Branch, Phone, Total_Loan, Paid, Total_Bal, Savings_Bal, Expected_Amount,
Officer_Name, Maturity_Status, Date_Disbursed, Maturity_Date FROM repayments WHERE $where ORDER BY id ASC";

$dataParams = $params;
$dataTypes  = $types;

if ($maxRows > 0) {
$dataSql .= " LIMIT ?";
$dataParams[] = $maxRows;
$dataTypes .= "i";
}

$stmt = $con->prepare($dataSql);
$stmt->bind_param($dataTypes, ...$dataParams);
$stmt->execute();
$result = $stmt->get_result();

/* ================= FETCH ================= */
$results = [];
while ($row = $result->fetch_assoc()) {
$results[] = $row;
}

$stmt->close();
$con->close();
?>


<div class="row">
<div class="col-sm-10">
<small>
Total Record: <?php echo htmlspecialchars($total); ?>
</small>
</div>
<div class="col-sm-2">
<button type="button" class="btn btn-outline-primary btn-sm btn-flat w-100" onclick="tableToExcel()"><i class="fa fa-download"></i> Export Data Excel</button>
<script type="text/javascript">
function tableToExcel() {
// Get the table element (adjust selector to match your table)
let table = document.querySelector('table');
// Convert table to workbook
let workbook = XLSX.utils.table_to_book(table, {sheet: "Expired Loans"});
// Generate Excel file and trigger download
XLSX.writeFile(workbook, "loan_book.xlsx");
}
</script>
</div>
</div>

<br>

<?php if (empty($results) && !empty($search)): ?>
<?php elseif (empty($results)): ?>
<i class="fas fa-info-circle"></i> No records available at this time.
<br><br>
<?php endif; ?>

<div id="table-container" style="height:340px;">
<table id="expiredLoansTable" style="font-size: 8px;">
<thead>
<tr>
<th style="font-size:8px">LOAN ACCT</th>
<th style="font-size:8px">BVN</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">PRODUCT</th>
<th style="font-size:8px">TOTAL LOAN</th>
<th style="font-size:8px">PAID</th>
<th style="font-size:8px">OUTSTANDING</th>
<th style="font-size:8px">SAVINGS</th>
<th style="font-size:8px">EXPECTED AMT</th>
<th style="font-size:8px">CREDIT OFFICER</th>
<th style="font-size:8px">DATE DISBURSED</th>
<th style="font-size:8px">DATE EXPIRED</th>
<th style="font-size:8px">LAST PAYMENT DATE</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
if (!empty($results)) {
foreach($results as $member) {
// Escape output for XSS protection
$vrt = htmlspecialchars($member['Loan_Account_No'], ENT_QUOTES, 'UTF-8');
$bvn = htmlspecialchars($member['BVN'], ENT_QUOTES, 'UTF-8');
$firstname = htmlspecialchars($member['Firstname'], ENT_QUOTES, 'UTF-8');
$middlename = htmlspecialchars($member['Middlename'], ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($member['Lastname'], ENT_QUOTES, 'UTF-8');
$ph = htmlspecialchars($member['Phone'], ENT_QUOTES, 'UTF-8');
$branch = htmlspecialchars($member['Branch'], ENT_QUOTES, 'UTF-8');
$product = htmlspecialchars($member['Product'], ENT_QUOTES, 'UTF-8');
$totalloan = htmlspecialchars($member['Total_Loan'], ENT_QUOTES, 'UTF-8');
$paid = htmlspecialchars($member['Paid'], ENT_QUOTES, 'UTF-8');
$saving = htmlspecialchars($member['Savings_Bal'], ENT_QUOTES, 'UTF-8');
$exp = htmlspecialchars($member['Expected_Amount'], ENT_QUOTES, 'UTF-8');
$totalbal = htmlspecialchars($member['Total_Bal'], ENT_QUOTES, 'UTF-8');
$datedisburse = htmlspecialchars($member['Date_Disbursed'], ENT_QUOTES, 'UTF-8');
$maturitydate = htmlspecialchars($member['Maturity_Date'], ENT_QUOTES, 'UTF-8');
$status = htmlspecialchars($member['Maturity_Status'], ENT_QUOTES, 'UTF-8');
$ofn = htmlspecialchars($member['Officer_Name'], ENT_QUOTES, 'UTF-8');
$lst = htmlspecialchars($member['Transaction_Date'], ENT_QUOTES, 'UTF-8');
$id = (int)$member['id'];
?>
<tr style="font-size:8px">
<td><?php echo $vrt; ?></td>
<td><?php echo $bvn; ?></td>
<td style="text-transform:capitalize"><?php echo "$firstname $middlename $lastname"; ?></td>
<td><?php echo $ph; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $product; ?></td>
<td><?php echo number_format((float)$totalloan, 2); ?></td>
<td><?php echo number_format((float)$paid, 2); ?></td>
<td><?php echo number_format((float)$totalbal, 2); ?></td>
<td><?php echo number_format((float)$saving, 2); ?></td>
<td><?php echo number_format((float)$exp, 2); ?></td>
<td><?php echo $ofn; ?></td>
<td><?php echo $datedisburse; ?></td>
<td><?php echo $maturitydate; ?></td>
<td><?php echo $lst; ?></td>
<td><?php echo $status; ?></td>
</tr>
<?php
}
} else {
echo '<tr><td colspan="20" style="text-align:center; font-size:10px; padding: 10px;">No matching records</td></tr>';
}
?>
</tbody>
</table>
</div>

