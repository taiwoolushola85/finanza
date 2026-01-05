<?php 
// Include database connection once
include_once '../config/db.php';
// Sanitize and validate inputs
$br = mysqli_real_escape_string($con, $_POST['br'] ?? '');
$ln = mysqli_real_escape_string($con, $_POST['ln'] ?? '');
$pr = mysqli_real_escape_string($con, $_POST['pr'] ?? '');



// Function to get aggregated totals for active loans
function getBalanceTotals($con, $br = '', $ln = '', $pr = '') {
    $conditions = ["Status = 'Active'"];
    
    if (!empty($br)) $conditions[] = "Branch_id = '$br'";
    if (!empty($ln)) $conditions[] = "User = '$ln'";
    if (!empty($pr)) $conditions[] = "Frequency = '$pr'";
    
    $where = implode(" AND ", $conditions);
    
    $totals = [];
    $queries = [
        'principal' => "SELECT SUM(Loan_Amount) AS total FROM repayments WHERE $where",
        'interest' => "SELECT SUM(Interest_Amt) AS total FROM repayments WHERE $where",
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

// Function to get table data for active loans
function getBalanceData($con, $br = '', $ln = '', $pr = '') {
    $conditions = ["Status = 'Active'"];
    
    if (!empty($br)) $conditions[] = "Branch_id = '$br'";
    if (!empty($ln)) $conditions[] = "User = '$ln'";
    if (!empty($pr)) $conditions[] = "Frequency = '$pr'";
    
    $where = implode(" AND ", $conditions);
    
    $query = "SELECT Loan_Account_No, Disbursement_No, Unions, Firstname, Middlename, 
              Lastname, Branch, Product, Phone, Total_Loan, Total_Bal, Officer_Name 
              FROM repayments 
              WHERE $where 
              ORDER BY id ASC";
    
    return mysqli_query($con, $query);
}

// Get branch name
$branch_name = empty($br) ? "All" : htmlspecialchars($br);

// Get loan officer name
$officer_name = "All";
if (!empty($ln)) {
    $result = mysqli_query($con, "SELECT Name FROM users WHERE Username = '$ln'");
    if ($row = mysqli_fetch_array($result)) {
        $officer_name = $row['Name'];
    }
}

// Get totals
$totals = getBalanceTotals($con, $br, $ln, $pr);

// Get table data
$result = getBalanceData($con, $br, $ln, $pr);
$results = [];
while($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

// Determine filename based on filters
if (!empty($br) && !empty($ln) && !empty($pr)) {
    $filename = 'product_balance';
} elseif (!empty($br) && !empty($ln)) {
    $filename = 'Officer_balance';
} elseif (!empty($br)) {
    $filename = 'branch_balance';
} else {
    $filename = 'all_balance';
}

// Save to JSON
$fp = fopen("data/{$filename}.json", 'w');
fwrite($fp, json_encode($results));
fclose($fp);

// Close database connection
mysqli_close($con);
?>


        <div class="row">
            <div class="col-sm-4">
                <b style="font-size:10px">Report Date: <?php echo date('Y-m-d'); ?></b>
            </div>
            <div class="col-sm-4">
                <b style="font-size:10px">Branch: <?php echo $branch_name; ?></b>
            </div>
            <div class="col-sm-4">
                <b style="font-size:10px">Loan Officer: <?php echo htmlspecialchars($officer_name); ?></b>
            </div>
        </div>

        <!-- Totals Section -->
        <div class="row">
            <div class="col-sm-4">
                <b style="font-size:10px">Total Principal Amt: <?php echo number_format($totals['principal'], 2); ?></b>
            </div>
            <div class="col-sm-4">
                <b style="font-size:10px">Total Interest Amt: <?php echo number_format($totals['interest'], 2); ?></b>
            </div>
            <div class="col-sm-4">
                <b style="font-size:10px">Total Outstanding Amt: <?php echo number_format($totals['outstanding'], 2); ?></b>
            </div>
            <div class="col-sm-4">
                <b style="font-size:10px">Total Record: <?php echo number_format($totals['count']); ?></b>
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
                    // Use innerText to avoid HTML tags and escape quotes properly
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
            temp_link.download = "Daily_Balance_Printout_<?php echo date('Y-m-d'); ?>.csv";
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
                            <th >DISBURSEMENT NO</th>
                            <th >LOAN ACCOUNT NO</th>
                            <th >NAME</th>
                            <th >PHONE NO</th>
                            <th >GROUPS</th>
                            <th >PRODUCT</th>
                            <th >BRANCH</th>
                            <th >LOAN AMOUNT</th>
                            <th >OUTSTANDING</th>
                            <th >LOAN OFFICER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($results as $member): ?>
                        <tr >
                            <td ><?php echo htmlspecialchars($member['Disbursement_No']); ?></td>
                            <td ><?php echo htmlspecialchars($member['Loan_Account_No']); ?></td>
                            <td  style="text-transform:uppercase">
                                <?php echo htmlspecialchars($member['Firstname'] . " " . $member['Middlename'] . " " . $member['Lastname']); ?>
                            </td>
                            <td ><?php echo htmlspecialchars($member['Phone']); ?></td>
                            <td ><?php echo htmlspecialchars($member['Unions']); ?></td>
                            <td ><?php echo htmlspecialchars($member['Product']); ?></td>
                            <td ><?php echo htmlspecialchars($member['Branch']); ?></td>
                            <td ><?php echo number_format($member['Total_Loan'], 2); ?></td>
                            <td ><?php echo number_format($member['Total_Bal'], 2); ?></td>
                            <td ><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
