<?php
include_once '../config/db.php';

/* Validate POST */
$st = $_POST['st'] ?? null;
$en = $_POST['en'] ?? null;

if (!$st || !$en) {
    die("Invalid date range");
}

/* COUNT RECORDS */
$stmt = $con->prepare("
    SELECT COUNT(*) AS overs 
    FROM repayments 
    WHERE Date_Disbursed BETWEEN ? AND ? 
    AND Status != 'Cancelled'
");
$stmt->bind_param("ss", $st, $en);
$stmt->execute();
$countResult = $stmt->get_result()->fetch_assoc();
$over = $countResult['overs'];
$stmt->close();

/* MAIN DATA QUERY */
$stmt = $con->prepare("
    SELECT 
        r.Loan_Account_No,
        r.Firstname,
        r.Middlename,
        r.Lastname,
        r.BVN,
        r.Phone,
        r.Branch,
        r.Loan_Amount,

        reg.Address AS Address,

        g.Firstname AS fn,
        g.Lastname AS ln,
        g.Phone AS Phones,
        g.Address AS Gaddress

    FROM repayments r

    LEFT JOIN register reg 
        ON reg.id = r.Reg_id

    LEFT JOIN gaurantors g 
        ON g.Regis_id = r.Reg_id

    WHERE r.Date_Disbursed BETWEEN ? AND ?
      AND r.Status != 'Cancelled'

    ORDER BY r.Firstname ASC
");

$stmt->bind_param("ss", $st, $en);
$stmt->execute();
$result = $stmt->get_result();

?>


<div class="row">
    <div class="col-sm-10">
        <b style="font-size:11px">Total Record: <?= $over ?></b>
    </div>
    <div class="col-sm-2">
        <button type="button"
            class="btn btn-info btn-sm"
            onclick="exportTableToExcel()"
            style="float:right">
            Download Data
        </button>
    </div>
</div>

<br>

<div style="overflow:auto;height:300px">
<div class="table-responsive">

<div class="table-responsive" style="overflow: auto; height:300px;">
            <table >
                <thead>
                    <tr style="font-size:9px;">
    <th>LOAN ACCOUNT</th>
    <th>CLIENT BVN</th>
    <th>CLIENT NAME</th>
    <th>BRANCH</th>
    <th>CLIENT PHONE</th>
    <th>LOAN AMOUNT</th>
    <th>CLIENT ADDRESS</th>
    <th>GUARANTOR NAME</th>
    <th>GUARANTOR PHONE</th>
    <th>GUARANTOR ADDRESS</th>
</tr>
</thead>

<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['Loan_Account_No']) ?></td>
    <td><?= htmlspecialchars($row['BVN']) ?></td>
    <td style="text-transform:uppercase">
        <?= htmlspecialchars($row['Firstname']." ".$row['Middlename']." ".$row['Lastname']) ?>
    </td>
    <td><?= htmlspecialchars($row['Branch']) ?></td>
    <td><?= htmlspecialchars($row['Phone']) ?></td>
    <td><?= number_format($row['Loan_Amount'], 2) ?></td>
    <td><?= htmlspecialchars($row['Address']) ?></td>
    <td><?= htmlspecialchars($row['fn']." ".$row['ln']) ?></td>
    <td><?= htmlspecialchars($row['Phones']) ?></td>
    <td><?= htmlspecialchars($row['Gaddress']) ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>
</div>


<?php
$stmt->close();
$con->close();
?>

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script>
function exportTableToExcel() {
    const table = document.getElementById('demo1');
    const wb = XLSX.utils.table_to_book(table, { sheet: "Data" });
    XLSX.writeFile(wb, "Guarantor_Schedule_Report.xlsx");
}
</script>
