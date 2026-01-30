<div style="display:none;">
<?php
// Sanitize and validate inputs
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? max(0, (int)$_POST['maxRows']) : 12;
?>
</div>
<small><b>Total Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?></b>
</small>
<div style="float:right">
<a href="export_loan_monitor.php">
<button type="button" hidden class="btn btn-outline-primary btn-sm" style="float:right; margin:5px; display:block">
Download Data
</button>
</a>
<button class="btn btn-outline-primary btn-sm" onclick="tableToCSV('Loan_Monitor.csv')">Download CSV</button>
</div>
<br><br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");

include '../config/db.php';

/**
 * OPTIMIZATION STRATEGY:
 * 1. LEFT JOIN: Replaces 12 subqueries with 1 unified scan.
 * 2. mysqli_fetch_all: Transfers data from MySQL to PHP in a single C-level memory block.
 * 3. file_put_contents: Atomic file writing is faster than manual stream handling.
 */

$sql = "SELECT 
            r.id, r.Disbursement_No, r.Loan_Account_No, r.Firstname, r.Middlename, r.Lastname, 
            r.Branch, r.Phone, r.Product, r.Total_Loan, r.Paid, r.Savings_Bal, r.Total_Bal, 
            r.Expected_Amount, r.Officer_Name, r.Date_Disbursed, r.Maturity_Date,
            reg.Account_No AS Account, 
            reg.BVN AS Bvn, 
            reg.Bank, 
            reg.Years AS Dob, 
            reg.Address, 
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
        WHERE r.Status = 'Active' 
        ORDER BY r.Firstname ASC";

$result = mysqli_query($con, $sql);

if ($result) {
    // Fetch all results as an associative array at once
    $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    // Fast, atomic write to JSON
    file_put_contents('../data/monitor_book.json', json_encode($results));
    
    mysqli_free_result($result);
}

mysqli_close($con);
?>
<div id="table-container" >
<table id="reportTable">
<thead>
<tr style="font-size:8px">
<th >DISBURSEMENT NO</th>
<th >LOAN ACCT</th>
<th >NAME</th>
<th >BRANCH</th> 
<th >PHONE</th> 
<th >PRODUCT</th> 
<th >TOTAL LOAN</th> 
<th >AMT PAID</th> 
<th >BALANCE</th> 
<th >SAVINGS</th> 
<th >EXPD AMT</th> 
<th >LOAN OFFICER</th> 
<th >DATE DISBURSED</th> 
<th >MATURITY DATE</th> 
<th >ACCOUNT NO</th> 
<th >BVN</th> 
<th >BANK</th> 
<th >DATE OF BIRTH</th> 
<th >ADDRESS</th> 
<th >BUSINESS TYPE</th> 
<th >BUSINESS ADDRESS</th> 
<th >GUARANTOR NAME</th> 
<th >GUARANTOR PHONE</th> 
<th >GUARANTOR ADDRESS</th> 
</tr>
<tbody>
<?php
$url = '../data/monitor_book.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td><?php echo $member->Disbursement_No?></td>
<td><?php echo $member->Loan_Account_No?></td>
<td style="text-transform:uppercase"><?php echo $member->Firstname." ". $member->Middlename." ".$member->Lastname?></td>
<td><?php echo $member->Branch?></td>
<td><?php echo $member->Phone?></td>
<td><?php echo $member->Product?></td>
<td><?php echo number_format($member->Total_Loan,2)?></td>
<td><?php echo number_format($member->Paid,2)?></td>
<td><?php echo number_format($member->Total_Bal,2)?></td>
<td><?php echo number_format($member->Savings_Bal,2)?></td>
<td><?php echo number_format($member->Expected_Amount,2)?></td>
<td><?php echo $member->Officer_Name?></td>
<td ><?php echo date("d-M-Y", strtotime($member->Date_Disbursed))?></td>
<td ><?php echo date("d-M-Y", strtotime($member->Maturity_Date))?></td>
<td><?php echo $member->Account?></td>
<td><?php echo $member->Bvn?></td>
<td><?php echo $member->Bank?></td>
<td><?php echo $member->Dob?></td>
<td><?php echo $member->Address?></td>
<td><?php echo $member->Biz?></td>
<td><?php echo $member->Biz_ad?></td>
<td><?php echo $member->fn?></td>
<td><?php echo $member->Phones?></td>
<td><?php echo $member->Gaddress?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>

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
