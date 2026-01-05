<?php
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");

include '../config/db.php';

$st = $_POST['st'] ?? '';
$en = $_POST['en'] ?? '';
$br = $_POST['br'] ?? '';

$branchFilter = "";
if (!empty($br)) {
    $branchFilter = " AND Branch_id = '".mysqli_real_escape_string($con, $br)."' ";
}
?>

<div class="card">
<div class="card-body">
<div class="row">

<div class="col-sm-3"><b style="font-size:11px">Start Date: <?= $st ?></b></div>
<div class="col-sm-3"><b style="font-size:11px">End Date: <?= $en ?></b></div>

<div class="col-sm-3">
<b style="font-size:11px">Branch:
<?php
if (empty($br)) {
    echo "All";
} else {
    $q = mysqli_query($con,"SELECT Name FROM branch WHERE id='$br'");
    $r = mysqli_fetch_assoc($q);
    echo $r['Name'];
}
?>
</b>
</div>

<?php
// ================= TOTALS QUERY =================
$sqlTotals = "
SELECT 
    SUM(Loan_Amount) AS loan,
    SUM(Upfront) AS upfront,
    SUM(Inssurance) AS ins,
    SUM(Form) AS form,
    SUM(Card) AS card,
    COUNT(*) AS total
FROM register
WHERE Status!='Cancelled'
AND Upfront_Status='Paid'
AND Date_Paid BETWEEN '$st' AND '$en'
$branchFilter
";

$tot = mysqli_fetch_assoc(mysqli_query($con,$sqlTotals));
?>

<div class="col-sm-3"><b style="font-size:11px">Total Principal: <?= number_format($tot['loan'],2) ?></b></div>
<div class="col-sm-3"><b style="font-size:11px">Total Upfront: <?= number_format($tot['upfront'],2) ?></b></div>
<div class="col-sm-3"><b style="font-size:11px">Insurance: <?= number_format($tot['ins'],2) ?></b></div>
<div class="col-sm-3"><b style="font-size:11px">Form: <?= number_format($tot['form'],2) ?></b></div>
<div class="col-sm-3"><b style="font-size:11px">Card: <?= number_format($tot['card'],2) ?></b></div>
<div class="col-sm-3"><b style="font-size:11px">Records: <?= $tot['total'] ?></b></div>

</div>

<br>
<button class="btn btn-info btn-sm" onclick="tableToCSV()">Download Data</button>
<br><br>

<?php
// ================= DATA QUERY =================
$sql = "
SELECT Reciever_Name,Firstname,Middlename,Lastname,Branch,Product,
Loan_Amount,Upfront,Inssurance,Form,Card,Officer_Name,Date_Paid,Upfront_Status
FROM register
WHERE Status!='Cancelled'
AND Upfront_Status='Paid'
AND Date_Paid BETWEEN '$st' AND '$en'
$branchFilter
ORDER BY id ASC
";

$result = mysqli_query($con,$sql);
?>

<div class="table-responsive" style="overflow: auto; height:300px;">
            <table >
                <thead>
                    <tr style="font-size:9px;">
<th>POSTED BY</th>
<th>CLIENT</th>
<th>BRANCH</th>
<th>PRODUCT</th>
<th>PRINCIPAL</th>
<th>UPFRONT</th>
<th>INSURANCE</th>
<th>FORM</th>
<th>CARD</th>
<th>OFFICER</th>
<th>DATE</th>
<th>STATUS</th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?= $row['Reciever_Name'] ?></td>
<td style="text-transform:uppercase">
<?= $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'] ?>
</td>
<td><?= $row['Branch'] ?></td>
<td><?= $row['Product'] ?></td>
<td><?= number_format($row['Loan_Amount'],2) ?></td>
<td><?= number_format($row['Upfront'],2) ?></td>
<td><?= number_format($row['Inssurance'],2) ?></td>
<td><?= number_format($row['Form'],2) ?></td>
<td><?= number_format($row['Card'],2) ?></td>
<td><?= $row['Officer_Name'] ?></td>
<td><?= $row['Date_Paid'] ?></td>
<td><?= $row['Upfront_Status'] ?></td>
</tr>
<?php } ?>

</tbody>
</table>
</div>

</div>
</div>

<script>
function tableToCSV() {
    let csv = [];
    document.querySelectorAll("table tr").forEach(row => {
        let cols = row.querySelectorAll("td,th");
        let rowData = [];
        cols.forEach(col => rowData.push(col.innerText));
        csv.push(rowData.join(","));
    });

    let blob = new Blob([csv.join("\n")], { type: "text/csv" });
    let a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = "Onboarding_fee.csv";
    a.click();
}
</script>
