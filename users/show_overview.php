<?php 
// Include database connection once
include '../config/db.php';
// Sanitize and validate inputs
$st = mysqli_real_escape_string($con, $_POST['st'] ?? '');
$en = mysqli_real_escape_string($con, $_POST['en'] ?? '');
$br = mysqli_real_escape_string($con, $_POST['br'] ?? '');
$ln = mysqli_real_escape_string($con, $_POST['ln'] ?? '');



// Function to get aggregated totals for active loans
function getActiveLoanTotals($con, $st, $en, $br = '', $ln = '') {
    $conditions = ["Date_Disbursed BETWEEN '$st' AND '$en'", "Status = 'Active'"];
    
    if (!empty($br)) $conditions[] = "Branch_id = '$br'";
    if (!empty($ln)) $conditions[] = "User = '$ln'";
    
    $where = implode(" AND ", $conditions);
    
    $totals = [];
    $queries = [
        'principal' => "SELECT SUM(Loan_Amount) AS total FROM repayments WHERE $where",
        'interest' => "SELECT SUM(Interest_Amt) AS total FROM repayments WHERE $where",
        'loan' => "SELECT SUM(Total_Loan) AS total FROM repayments WHERE $where",
        'outstanding' => "SELECT SUM(Total_Bal) AS total FROM repayments WHERE $where",
        'savings' => "SELECT SUM(Savings_Bal) AS total FROM repayments WHERE $where",
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
function getActiveLoanData($con, $st, $en, $br = '', $ln = '') {
    $conditions = ["Date_Disbursed BETWEEN '$st' AND '$en'", "Status = 'Active'"];
    
    if (!empty($br)) $conditions[] = "Branch_id = '$br'";
    if (!empty($ln)) $conditions[] = "User = '$ln'";
    
    $where = implode(" AND ", $conditions);
    
    $query = "SELECT Firstname, Middlename, Lastname, Phone, Gender, Status, Unions, Paid, 
              Officer_Name, Branch, Date_Reg, Loan_Amount, Interest_Amt, Total_Loan, 
              Total_Bal, Savings_Bal, Date_Disbursed 
              FROM repayments 
              WHERE $where 
              ORDER BY id ASC";
    
    return mysqli_query($con, $query);
}

// Get branch name if specified
$branch_name = "All";
if (!empty($br)) {
    $result = mysqli_query($con, "SELECT Name FROM branch WHERE id = '$br'");
    if ($row = mysqli_fetch_array($result)) {
        $branch_name = $row['Name'];
    }
}

// Get loan officer name if specified
$officer_name = "All";
if (!empty($ln)) {
    $result = mysqli_query($con, "SELECT Name FROM users WHERE Username = '$ln'");
    if ($row = mysqli_fetch_assoc($result)) {
        $officer_name = $row['Name'];
    }
}

// Get totals
$totals = getActiveLoanTotals($con, $st, $en, $br, $ln);

// Get table data
$result = getActiveLoanData($con, $st, $en, $br, $ln);
$results = [];
while($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

// Determine filename based on filters
if (!empty($br) && !empty($ln)) {
    $filename = 'show_over';
    $csv_filename = 'Loan_Officer_Overview';
} elseif (!empty($br)) {
    $filename = 'show_overviews';
    $csv_filename = 'Branch_overviews';
} else {
    $filename = 'show_overview';
    $csv_filename = 'All_overview';
}

// Save to JSON
$fp = fopen("../data/{$filename}.json", 'w');
fwrite($fp, json_encode($results));
fclose($fp);

// Close database connection
mysqli_close($con);
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
            
            <!-- Totals Section -->
            <div class="col-sm-3">
                <b style="font-size:11px">Total Principal: <?php echo number_format($totals['principal'], 2); ?></b>
            </div>
            <div class="col-sm-3">
                <b style="font-size:11px">Total Interest: <?php echo number_format($totals['interest'], 2); ?></b>
            </div>
            <div class="col-sm-3">
                <b style="font-size:11px">Total Loan: <?php echo number_format($totals['loan'], 2); ?></b>
            </div>
            <div class="col-sm-3">
                <b style="font-size:11px">Total Outstanding: <?php echo number_format($totals['outstanding'], 2); ?></b>
            </div>
            <div class="col-sm-3">
                <b style="font-size:11px">Total Saving: <?php echo number_format($totals['savings'], 2); ?></b>
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
            temp_link.download = "<?php echo $csv_filename; ?>_<?php echo date('Y-m-d'); ?>.csv";
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
                        <th scope="col">GENDER</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">GROUP</th>
                        <th scope="col">LOAN OFFICER</th>
                        <th scope="col">BRANCH</th>
                        <th scope="col">REG DATE</th>
                        <th scope="col">PRINCIPAL</th>
                        <th scope="col">INTEREST AMT</th>
                        <th scope="col">TOTAL LOAN</th>
                        <th scope="col">AMT PAID</th>
                        <th scope="col">OUTSTANDING</th>
                        <th scope="col">SAVINGS</th>
                        <th scope="col">ACTIVE DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($results as $member): ?>
                    <tr>
                        <td class="sort border-top" style="text-transform:uppercase">
                            <?php echo htmlspecialchars($member['Firstname'] . " " . $member['Middlename'] . " " . $member['Lastname']); ?>
                        </td>
                        <td class="sort border-top"><?php echo htmlspecialchars($member['Phone']); ?></td>
                        <td class="sort border-top"><?php echo htmlspecialchars($member['Gender']); ?></td>
                        <td class="sort border-top"><?php echo htmlspecialchars($member['Status']); ?></td>
                        <td class="sort border-top"><?php echo htmlspecialchars($member['Unions']); ?></td>
                        <td class="sort border-top"><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
                        <td class="sort border-top"><?php echo htmlspecialchars($member['Branch']); ?></td>
                        <td class="sort border-top"><?php echo htmlspecialchars($member['Date_Reg']); ?></td>
                        <td class="sort border-top"><?php echo number_format($member['Loan_Amount'], 2); ?></td>
                        <td class="sort border-top"><?php echo number_format($member['Interest_Amt'], 2); ?></td>
                        <td class="sort border-top"><?php echo number_format($member['Total_Loan'], 2); ?></td>
                        <td class="sort border-top"><?php echo number_format($member['Paid'], 2); ?></td>
                        <td class="sort border-top"><?php echo number_format($member['Total_Bal'], 2); ?></td>
                        <td class="sort border-top"><?php echo number_format($member['Savings_Bal'], 2); ?></td>
                        <td class="sort border-top"><?php echo htmlspecialchars($member['Date_Disbursed']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
  