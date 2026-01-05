<?php
// Set headers once at the top
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

// Include database connection once
include '../config/db.php';

// Validate and sanitize all inputs
$br = isset($_POST['br']) ? mysqli_real_escape_string($con, $_POST['br']) : '';
$ln = isset($_POST['ln']) ? mysqli_real_escape_string($con, $_POST['ln']) : '';

// Get branch and loan officer names efficiently
$branchName = "All";
$loanOfficerName = "All";

if (!empty($br)) {
$branchQuery = "SELECT Name FROM branch WHERE id = '$br' LIMIT 1";
$branchResult = mysqli_query($con, $branchQuery);
if ($branchResult && $branchRow = mysqli_fetch_assoc($branchResult)) {
$branchName = $branchRow['Name'];
}
}

if (!empty($ln)) {
$loanOfficerQuery = "SELECT Name FROM users WHERE Username = '$ln' LIMIT 1";
$loanOfficerResult = mysqli_query($con, $loanOfficerQuery);
if ($loanOfficerResult && $loanOfficerRow = mysqli_fetch_assoc($loanOfficerResult)) {
$loanOfficerName = $loanOfficerRow['Name'];
}
}
?>


<?php
// Build WHERE clause based on filters
$whereConditions = ["Status = 'Active'"];

if (!empty($br)) {
    $whereConditions[] = "Branch_id = '$br'";
}
if (!empty($ln)) {
    $whereConditions[] = "User = '$ln'";
}

$whereClause = implode(" AND ", $whereConditions);

// Single optimized query for summary statistics
$summaryQuery = "SELECT 
    COALESCE(SUM(Balance), 0) AS total_balance,
    COUNT(*) AS total_records
FROM savings
WHERE $whereClause";

$summaryResult = mysqli_query($con, $summaryQuery);

if (!$summaryResult) {
    die("Query Error: " . mysqli_error($con));
}

$summary = mysqli_fetch_assoc($summaryResult);
//
?>

<!-- Summary Section -->
 <!-- Header Section -->
<div class="row">
    <div class="col-sm-3">
        <b style="font-size:11px">Branch: <?php echo htmlspecialchars($branchName); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Loan Officer: <?php echo htmlspecialchars($loanOfficerName); ?></b>
    </div>
     <div class="col-sm-3">
        <b style="font-size:11px">Total Saving Balanace: <?php echo number_format($summary['total_balance'], 2); ?></b>
    </div>
    <div class="col-sm-3">
        <b style="font-size:11px">Total Record: <?php echo number_format($summary['total_records']); ?></b>
    </div>
</div>
<br>

<div class="row">
<div class="col-sm-2">
<button type="button" class="btn btn-info btn-sm btn-flat" onclick="tableToCSV()">Download Data</button>
</div>
</div>
<br>

<?php
// Main data query
$dataQuery = "SELECT 
    Virtual_Account,
    Client_BVN,
    Disbursement_No,
    Loan_Account_No,
    Firstname,
    Middlename,
    Lastname,
    Branch,
    Unions,
    Product,
    Savings_Paid,
    Withdraw_Savings,
    Savings_Repayment,
    Savings_Transfer,
    Savings_Upfront,
    Savings_Recieved,
    Balance,
    Officer_Name,
    Team_Name,
    Date_Opend,
    Status
FROM savings
WHERE $whereClause
ORDER BY Firstname ASC";

$result = mysqli_query($con, $dataQuery);

if (!$result) {
die("Query Error: " . mysqli_error($con));
}

// Fetch all results
$results = array();
while($row = mysqli_fetch_assoc($result)) {
$results[] = $row; 
}

// Determine filename based on filters
$filename = 'saving_history.json';
if (!empty($br) && !empty($ln)) {
$filename = 'saving_history.json';
} elseif (!empty($br)) {
$filename = 'saving_history.json';
}

// Save to JSON file
$jsonData = json_encode($results, JSON_PRETTY_PRINT);

// Ensure data directory exists
$dataDir = '../data';
if (!is_dir($dataDir)) {
mkdir($dataDir, 0755, true);
}

file_put_contents($dataDir . '/' . $filename, $jsonData);

// Close database connection
mysqli_close($con);
?>

<!-- Data Table -->
<div class="table-responsive" style="overflow: auto; height:300px;">
    <table id="repaymentTable">
        <thead>
            <tr style="font-size:9px;">
                <th scope="col">VIRTUAL ACCT</th>
                <th scope="col">BVN NO</th>
                <th scope="col">LOAN ACCOUNT</th>
                <th scope="col">NAME</th>
                <th scope="col">BRANCH</th>
                <th scope="col">DEPOSIT</th>
                <th scope="col">WITHDRAWAL</th>
                <th scope="col">REPAYMENT</th>
                <th scope="col">TRANSFER</th>
                <th scope="col">UPFRONT</th>
                <th scope="col">RECIEVED</th>
                <th scope="col">BALANCE</th>
                <th scope="col">LOAN OFFFICER</th>
                <th scope="col">STATUS</th>
                <th scope="col">DATE</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($results as $member): ?>
            <tr style="font-size:9px;">
                <td class="sort border-top border-translucent ps-3"><?php echo htmlspecialchars($member['Virtual_Account']); ?></td>
                <td class="sort border-top border-translucent ps-3"><?php echo htmlspecialchars($member['Client_BVN']); ?></td>
                <td class="sort border-top border-translucent ps-3"><?php echo htmlspecialchars($member['Loan_Account_No']); ?></td>
                <td class="sort border-top" style="text-transform:uppercase">
                    <?php echo htmlspecialchars(trim($member['Firstname'] . ' ' . $member['Middlename'] . ' ' . $member['Lastname'])); ?>
                </td>
                <td class="sort border-top"><?php echo htmlspecialchars($member['Branch']); ?></td>
                <td class="sort border-top"><?php echo number_format($member['Savings_Paid'], 2); ?></td>
                <td class="sort border-top"><?php echo number_format($member['Withdraw_Savings'], 2); ?></td>
                <td class="sort border-top"><?php echo number_format($member['Savings_Repayment'], 2); ?></td>
                <td class="sort border-top"><?php echo number_format($member['Savings_Transfer'], 2); ?></td>
                <td class="sort border-top"><?php echo number_format($member['Savings_Upfront'], 2); ?></td>
                <td class="sort border-top"><?php echo number_format($member['Savings_Recieved'], 2); ?></td>
                <td class="sort border-top"><?php echo number_format($member['Balance'], 2); ?></td>
                <td class="sort border-top"><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
                <td class="sort border-top"><?php echo htmlspecialchars($member['Status']); ?></td>
                <td class="sort border-top"><?php echo htmlspecialchars($member['Date_Opend']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
function tableToCSV() {
    const csv_data = [];
    const table = document.getElementById('repaymentTable');
    
    if (!table) {
        alert('No table found to export');
        return;
    }
    
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const csvrow = Array.from(cols).map(col => {
            // Clean HTML and escape quotes
            let text = col.textContent.trim();
            text = text.replace(/"/g, '""');
            return `"${text}"`;
        });
        csv_data.push(csvrow.join(','));
    });
    
    downloadCSVFile(csv_data.join('\n'));
}

function downloadCSVFile(csv_data) {
    const CSVFile = new Blob([csv_data], { type: "text/csv" });
    const temp_link = document.createElement('a');
    temp_link.download = "Saving_Deposit_Report.csv";
    temp_link.href = window.URL.createObjectURL(CSVFile);
    temp_link.style.display = "none";
    document.body.appendChild(temp_link);
    temp_link.click();
    document.body.removeChild(temp_link);
    window.URL.revokeObjectURL(temp_link.href);
}
</script>