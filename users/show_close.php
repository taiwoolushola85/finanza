<br>
<br>

<?php 
include '../config/db.php';
// Sanitize and validate inputs
$st = mysqli_real_escape_string($con, $_POST['st'] ?? '');
$br = mysqli_real_escape_string($con, $_POST['br'] ?? '');
$ln = mysqli_real_escape_string($con, $_POST['ln'] ?? '');
$en = mysqli_real_escape_string($con, $_POST['en'] ?? '');
$pr = mysqli_real_escape_string($con, $_POST['pr'] ?? '');

// Include database connection once at the top

// Function to get aggregated totals
function getTotals($con, $st, $en, $br = '', $ln = '', $pr = '') {
    $conditions = ["Date_Closed BETWEEN '$st' AND '$en'", "Status = 'Closed'"];
    
    if (!empty($br)) $conditions[] = "Branch_id = '$br'";
    if (!empty($ln)) $conditions[] = "User = '$ln'";
    if (!empty($pr)) $conditions[] = "Product = '$pr'";
    
    $where = implode(" AND ", $conditions);
    
    $totals = [];
    $queries = [
        'principal' => "SELECT SUM(Loan_Amount) AS total FROM repayments WHERE $where",
        'interest' => "SELECT SUM(Interest_Amt) AS total FROM repayments WHERE $where",
        'loan' => "SELECT SUM(Total_Loan) AS total FROM repayments WHERE $where",
        'outstanding' => "SELECT SUM(Total_Bal) AS total FROM repayments WHERE $where",
        'count' => "SELECT COUNT(*) AS total FROM repayments WHERE $where"
    ];
    
    foreach ($queries as $key => $query) {
        $result = mysqli_query($con, $query);
        $data = mysqli_fetch_assoc($result);
        $totals[$key] = $data['total'] ?? 0;
    }
    
    return $totals;
}

// Function to get data for table
function getTableData($con, $st, $en, $br = '', $ln = '', $pr = '') {
    $conditions = ["Date_Closed BETWEEN '$st' AND '$en'", "Status = 'Closed'"];
    
    if (!empty($br)) $conditions[] = "Branch_id = '$br'";
    if (!empty($ln)) $conditions[] = "User = '$ln'";
    if (!empty($pr)) $conditions[] = "Product = '$pr'";
    
    $where = implode(" AND ", $conditions);
    
    $query = "SELECT Firstname, Middlename, Lastname, Phone, Loan_Account_No, Branch, Unions, 
              Product, Loan_Amount, Total_Loan, Total_Bal, Interest_Amt, Date_Disbursed, 
              Maturity_Date, Date_Closed, Officer_Name 
              FROM repayments 
              WHERE $where 
              ORDER BY id ASC";
    
    return mysqli_query($con, $query);
}

// Get branch name if specified
$branch_name = "All";
if (!empty($br)) {
    $result = mysqli_query($con, "SELECT Name FROM branch WHERE id = '$br'");
    $row = mysqli_fetch_array($result);
    $branch_name = $row['Name'] ?? '';
}

// Get loan officer name if specified
$officer_name = "All";
if (!empty($ln)) {
    $result = mysqli_query($con, "SELECT Name FROM users WHERE Username = '$ln'");
    $row = mysqli_fetch_assoc($result);
    $officer_name = $row['Name'] ?? '';
}

$product_name = empty($pr) ? "All" : htmlspecialchars($pr);

// Get totals
$totals = getTotals($con, $st, $en, $br, $ln, $pr);

// Get table data
$result = getTableData($con, $st, $en, $br, $ln, $pr);
$results = [];
while($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

// Determine filename based on filters
$filename = 'repayments_closed';
if (!empty($br) && !empty($ln) && !empty($pr)) {
    $filename = 'product_closed';
} elseif (!empty($br) && !empty($ln)) {
    $filename = 'officer_closed';
} elseif (!empty($br) && !empty($pr)) {
    $filename = 'product_branch_closed';
} elseif (!empty($br)) {
    $filename = 'all_branch_closed';
} elseif (!empty($pr)) {
    $filename = 'product_closed';
} else {
    $filename = 'all_closed';
}

// Save to JSON
$fp = fopen("../data/{$filename}.json", 'w');
fwrite($fp, json_encode($results));
fclose($fp);
?>

<div class="row">
    <div class="col-sm-3">
        <b style="font-size:11px">Start Date: <?php echo htmlspecialchars($st); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">End Date: <?php echo htmlspecialchars($en); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Branch: <?php echo htmlspecialchars($branch_name); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Loan Officer: <?php echo htmlspecialchars($officer_name); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Product: <?php echo $product_name; ?></b>
    </div>
    
    <!-- Totals Section -->
    <div class="col-sm-3">
        <b style="font-size:11px">Total Principal: <?php echo number_format($totals['principal'], 2); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Total Interest Amount: <?php echo number_format($totals['interest'], 2); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Total Loan Amount: <?php echo number_format($totals['loan'], 2); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Total Outstanding: <?php echo number_format($totals['outstanding'], 2); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Total Record: <?php echo number_format($totals['count']); ?></b>
    </div>
</div>

<br>
<button type="button" class="btn btn-info btn-sm btn-flat" onclick="tableToCSV()">Download Data</button>

<script type="text/javascript">
function tableToCSV() {
    let csv_data = [];
    let rows = document.getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let cols = rows[i].querySelectorAll('td,th');
        let csvrow = [];
        
        for (let j = 0; j < cols.length; j++) {
            // Remove HTML tags and escape quotes
            let cellText = cols[j].innerText.replace(/"/g, '""');
            csvrow.push('"' + cellText + '"');
        }
        csv_data.push(csvrow.join(","));
    }
    
    csv_data = csv_data.join('\n');
    downloadCSVFile(csv_data);
}

function downloadCSVFile(csv_data) {
    let CSVFile = new Blob([csv_data], { type: "text/csv" });
    let temp_link = document.createElement('a');
    temp_link.download = "Closed_Loan_<?php echo date('Y-m-d'); ?>.csv";
    temp_link.href = window.URL.createObjectURL(CSVFile);
    temp_link.style.display = "none";
    document.body.appendChild(temp_link);
    temp_link.click();
    document.body.removeChild(temp_link);
}
</script>

<br><br>

<div class="table-responsive" style="overflow: auto; height:300px;">
            <table >
                <thead>
                    <tr style="font-size:9px;">
                <th scope="col">CLIENT NAME</th>
                <th scope="col">PHONE</th>
                <th scope="col">LOAN OFFICER</th>
                <th scope="col">LOAN NUMBER</th>
                <th scope="col">BRANCH</th>
                <th scope="col">GROUP</th>
                <th scope="col">PRODUCT</th>
                <th scope="col">PRINCIPAL</th>
                <th scope="col">INTEREST</th>
                <th scope="col">TOTAL LOAN</th>
                <th scope="col">OUTSTANDING</th>
                <th scope="col">DISBURSEMENT DATE</th>
                <th scope="col">MATURITY DATE</th>
                <th scope="col">DATE CLOSED</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($results as $member): ?>
            <tr>
                <td  style="text-transform:uppercase">
                    <?php echo htmlspecialchars($member['Firstname'] . " " . $member['Middlename'] . " " . $member['Lastname']); ?>
                </td>
                <td class="sort border-top border-translucent ps-3"><?php echo htmlspecialchars($member['Phone']); ?></td>
                <td class="sort border-top border-translucent ps-3"><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
                <td ><?php echo htmlspecialchars($member['Loan_Account_No']); ?></td>
                <td ><?php echo htmlspecialchars($member['Branch']); ?></td>
                <td ><?php echo htmlspecialchars($member['Unions']); ?></td>
                <td ><?php echo htmlspecialchars($member['Product']); ?></td>
                <td ><?php echo number_format($member['Loan_Amount'], 2); ?></td>
                <td ><?php echo number_format($member['Interest_Amt'], 2); ?></td>
                <td ><?php echo number_format($member['Total_Loan'], 2); ?></td>
                <td ><?php echo number_format($member['Total_Bal'], 2); ?></td>
                <td ><?php echo date("d-M-Y", strtotime($member['Date_Disbursed'])); ?></td>
                <td ><?php echo date("d-M-Y", strtotime($member['Maturity_Date'])); ?></td>
                <td ><?php echo date("d-M-Y", strtotime($member['Date_Closed'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php mysqli_close($con); ?>