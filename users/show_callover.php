<br>
<?php
// ===================== HEADERS =====================
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include_once '../config/db.php';

// ===================== INPUTS =====================
$st = mysqli_real_escape_string($con, $_POST['st'] ?? '');
$en = mysqli_real_escape_string($con, $_POST['en'] ?? '');
$br = $_POST['br'] ?? '';
$ty = $_POST['ty'] ?? '';
?>


<!-- ===================== FILTER SUMMARY ===================== -->
<div class="row">
<div class="col-sm-3"><b style="font-size:11px">Start Date: <?= htmlspecialchars($st) ?></b></div>
<div class="col-sm-3"><b style="font-size:11px">End Date: <?= htmlspecialchars($en) ?></b></div>
<div class="col-sm-3">
<b style="font-size:11px">Branch:
<?php
if (empty($br)) {
    echo "All";
} else {
    $q = mysqli_query($con,"SELECT Name FROM branch WHERE id='".(int)$br."'");
    $r = mysqli_fetch_assoc($q);
    echo htmlspecialchars($r['Name'] ?? 'Unknown');
}
?>
</b>
</div>
<div class="col-sm-3"><b style="font-size:11px">Transaction Type: <?= htmlspecialchars($ty) ?></b></div>
</div>



<?php
// ===================== LOGIC =====================
$whereBranchHistory = empty($br) ? "" : " AND Branch_Code='".(int)$br."' ";
$whereBranchFee     = empty($br) ? "" : " AND Branch_id='".(int)$br."' ";
$whereBranchRecover = empty($br) ? "" : " AND Branch_id='".(int)$br."' ";
$whereBranchFlexi   = empty($br) ? "" : " AND Branch_No='".(int)$br."' ";

// ===================== REPAYMENTS =====================
if ($ty === 'Repayments') {

// Totals
$t1 = mysqli_fetch_assoc(mysqli_query($con,"
SELECT COUNT(*) lm FROM history
WHERE Status='Paid' AND Date_Paid BETWEEN '$st' AND '$en'
AND Post_Method!='Recovery Posting' $whereBranchHistory
"));

$t2 = mysqli_fetch_assoc(mysqli_query($con,"
SELECT SUM(Amount) lm FROM history
WHERE Status='Paid' AND Date_Paid BETWEEN '$st' AND '$en'
AND Post_Method!='Recovery Posting' $whereBranchHistory
"));

$t3 = mysqli_fetch_assoc(mysqli_query($con,"
SELECT SUM(Savings) lm FROM save
WHERE Status='Paid' AND Date_Paid BETWEEN '$st' AND '$en'
AND Posting_Method ='Basic Posting' $whereBranchHistory
"));
?>

<div class="row">
<div class="col-sm-3"><b style="font-size:11px;">Total Records: <?= $t1['lm'] ?></b></div>
<div class="col-sm-3"><b style="font-size:11px;">Total Repayment: <?= number_format($t2['lm'],2) ?></b></div>
<div class="col-sm-3"><b style="font-size:11px;">Total Savings: <?= number_format($t3['lm'],2) ?></b></div>
</div>

<br>
<button class="btn btn-info btn-sm" onclick="tableToCSV('Repayment_Report.csv')">Download CSV</button>

<br><br>

<div class="table-responsive" style="overflow: auto; height:300px;">
            <table >
                <thead>
                    <tr style="font-size:9px;">
<th>LOAN ACCOUNT</th>
<th>NAME</th>
<th>PRODUCT</th>
<th>BRANCH</th>
<th>GROUP</th>
<th>LOAN AMT</th>
<th>REPAYMENT</th>
<th>SAVINGS</th>
<th>EXPECTED</th>
<th>COLLECTED BY</th>
<th>APPROVED BY</th>
<th>PAY METHOD</th>
<th>POST METHOD</th>
<th>STATUS</th>
<th>DATE</th>
</tr>
</thead>
<tbody>

<?php
$q = mysqli_query($con,"
SELECT * FROM history
WHERE Status='Paid'
AND Date_Paid BETWEEN '$st' AND '$en'
AND Post_Method!='Recovery Posting'
$whereBranchHistory
ORDER BY id ASC
");

while ($row = mysqli_fetch_assoc($q)) {
?>
<tr>
<td><?= $row['Loan_Account_No'] ?></td>
<td><?= strtoupper($row['Firstname']." ".$row['Middlename']." ".$row['Lastname']) ?></td>
<td><?= $row['Loan_Type'] ?></td>
<td><?= $row['Branch'] ?></td>
<td><?= $row['Unions'] ?></td>
<td><?= $row['Total_Loan'] ?></td>
<td><?= $row['Amount'] ?></td>
<td><?= $row['Savings'] ?></td>
<td><?= $row['Expected_Amount'] ?></td>
<td><?= $row['Officer_Name'] ?></td>
<td><?= $row['Team_Name'] ?></td>
<td><?= $row['Payment_Method'] ?></td>
<td><?= $row['Post_Method'] ?></td>
<td><?= $row['Status'] ?></td>
<td><?= $row['Date_Paid'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

<?php
// ===================== ONBOARDING =====================
} elseif ($ty === 'Onboarding') {

$sum = mysqli_fetch_assoc(mysqli_query($con,"
SELECT
SUM(Upfront+Inssurance+Form+Card) total
FROM fee
WHERE Status='Paid'
AND Date_Paid BETWEEN '$st' AND '$en'
$whereBranchFee
"));
?>

<b style="font-size:11px;">Total Amount: <?= number_format($sum['total'],2) ?></b>

<br><br>
<button class="btn btn-info btn-sm" onclick="tableToCSV('Onboarding_Report.csv')">Download CSV</button>

<br><br>

<div class="table-responsive" style="overflow: auto; height:300px;">
            <table >
                <thead>
                    <tr style="font-size:9px;">
<th>NAME</th>
<th>BRANCH</th>
<th>PRODUCT</th>
<th>LOAN AMT</th>
<th>UPFRONT</th>
<th>INSURANCE</th>
<th>CARD</th>
<th>FORM</th>
<th>METHOD</th>
<th>DATE</th>
<th>STATUS</th>
</tr>
</thead>
<tbody>

<?php
$q = mysqli_query($con,"
SELECT * FROM fee
WHERE Status='Paid'
AND Date_Paid BETWEEN '$st' AND '$en'
$whereBranchFee
ORDER BY id ASC
");

while ($r = mysqli_fetch_assoc($q)) {
?>
<tr>
<td><?= strtoupper($r['Firstname']." ".$r['Middlename']." ".$r['Lastname']) ?></td>
<td><?= $r['Branch'] ?></td>
<td><?= $r['Product'] ?></td>
<td><?= $r['Loan_Amount'] ?></td>
<td><?= $r['Upfront'] ?></td>
<td><?= $r['Inssurance'] ?></td>
<td><?= $r['Card'] ?></td>
<td><?= $r['Form'] ?></td>
<td><?= $r['Payment_Method'] ?></td>
<td><?= $r['Date_Paid'] ?></td>
<td><?= $r['Status'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

<?php
// ===================== RECOVERY =====================
} elseif ($ty === 'Recovery') {


$sum = mysqli_fetch_assoc(mysqli_query($con,"
SELECT COUNT(*) cnt, SUM(Amount) amt
FROM recover
WHERE Status='Paid'
AND Date_Pay BETWEEN '$st' AND '$en'
$whereBranchRecover
"));
?>

<div class="row">
<div class="col-sm-3">
<b style="font-size:11px;">Total Records: <?= $sum['cnt'] ?> </b>
</div>
<div class="col-sm-3">
<b style="font-size:11px;">Total Amount Recovered: <?= number_format($sum['amt'],2) ?></b>
</div>
</div>

<br><br>
<button class="btn btn-info btn-sm" onclick="tableToCSV('Recovery_Report.csv')">Download CSV</button>

<br><br>

<div class="table-responsive" style="overflow: auto; height:300px;">
            <table >
                <thead>
                    <tr style="font-size:9px;">
<th>LOAN ACCOUNT</th>
<th>NAME</th>
<th>GROUP</th>
<th>BRANCH</th>
<th>PRODUCT</th>
<th>LOAN AMT</th>
<th>RECOVERED</th>
<th>OFFICER</th>
<th>DATE</th>
<th>STATUS</th>
</tr>
</thead>
<tbody>

<?php
$q = mysqli_query($con,"
SELECT * FROM recover
WHERE Status='Paid'
AND Date_Pay BETWEEN '$st' AND '$en'
$whereBranchRecover
ORDER BY id ASC
");

while ($r = mysqli_fetch_assoc($q)) {
?>
<tr>
<td><?= $r['Loan_Account'] ?></td>
<td><?= strtoupper($r['Name']) ?></td>
<td><?= $r['Unions'] ?></td>
<td><?= $r['Branch'] ?></td>
<td><?= $r['Product'] ?></td>
<td><?= $r['Loan_Amount'] ?></td>
<td><?= $r['Amount'] ?></td>
<td><?= $r['Recovery_Name'] ?></td>
<td><?= $r['Date_Pay'] ?></td>
<td><?= $r['Status'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

<?php
// ===================== FLEXI =====================
} elseif ($ty === 'Flexi') {



$sum = mysqli_fetch_assoc(mysqli_query($con,"
SELECT COUNT(*) cnt, SUM(Amount) amt
FROM flexi_history
WHERE Status='Paid'
AND Date_Paid BETWEEN '$st' AND '$en'
AND Posting_Method!='System Posting'
$whereBranchFlexi
"));
?>

<div class="row">
<div class="col-sm-3">
<b style="font-size:11px;">Total Records: <?= $sum['cnt'] ?> </b>
</div>
<div class="col-sm-3">
<b style="font-size:11px;">Total Amount: <?= number_format($sum['amt'],2) ?></b>
</div>
</div>
<br><br>
<button class="btn btn-info btn-sm" onclick="tableToCSV('Flexi_Report.csv')">Download CSV</button>

<br><br>

<div class="table-responsive" style="overflow: auto; height:300px;">
            <table >
                <thead>
                    <tr style="font-size:9px;">
<th>NAME</th>
<th>BRANCH</th>
<th>PLAN</th>
<th>AMOUNT</th>
<th>METHOD</th>
<th>DATE</th>
<th>STATUS</th>
</tr>
</thead>
<tbody>

<?php
$q = mysqli_query($con,"
SELECT * FROM flexi_history
WHERE Status='Paid'
AND Date_Paid BETWEEN '$st' AND '$en'
AND Posting_Method!='System Posting'
$whereBranchFlexi
ORDER BY id ASC
");

while ($r = mysqli_fetch_assoc($q)) {
?>
<tr>
<td><?= strtoupper($r['Surname']." ".$r['Firstname']." ".$r['Othername']) ?></td>
<td><?= $r['Branch'] ?></td>
<td><?= $r['Plan'] ?></td>
<td><?= $r['Amount'] ?></td>
<td><?= $r['Payment_Method'] ?></td>
<td><?= $r['Date_Paid'] ?></td>
<td><?= $r['Status'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

<?php
} else {
    echo "<b style='color:red'>Invalid Transaction Type</b>";
}
?>


<!-- ===================== CSV SCRIPT ===================== -->
<script>
function tableToCSV(filename) {
    let csv = [];
    document.querySelectorAll("#reportTable tr").forEach(row => {
        let cols = row.querySelectorAll("th,td");
        let data = [];
        cols.forEach(col => data.push(col.innerText.replace(/,/g,'')));
        csv.push(data.join(","));
    });

    let blob = new Blob([csv.join("\n")], { type: "text/csv" });
    let a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = filename;
    a.click();
}
</script>
