<?php 
// Include database connection once
include '../config/db.php';
// Sanitize and validate inputs
$st = mysqli_real_escape_string($con, $_POST['st'] ?? '');
$en = mysqli_real_escape_string($con, $_POST['en'] ?? '');
$br = mysqli_real_escape_string($con, $_POST['br'] ?? '');
$ln = mysqli_real_escape_string($con, $_POST['ln'] ?? '');
$pr = mysqli_real_escape_string($con, $_POST['pr'] ?? '');



// Function to get aggregated totals for disbursements
function getDisbursementTotals($con, $st, $en, $br = '', $ln = '', $pr = '') {
    $conditions = ["Date_Disbursed BETWEEN '$st' AND '$en'", "Status != 'Cancelled'"];
    
    if (!empty($br)) $conditions[] = "Branch_id = '$br'";
    if (!empty($ln)) $conditions[] = "User = '$ln'";
    if (!empty($pr)) $conditions[] = "Product = '$pr'";
    
    $where = implode(" AND ", $conditions);
    
    $totals = [];
    $queries = [
        'principal' => "SELECT SUM(Loan_Amount) AS total FROM repayments WHERE $where",
        'interest' => "SELECT SUM(Interest_Amt) AS total FROM repayments WHERE $where",
        'loan' => "SELECT SUM(Total_Loan) AS total FROM repayments WHERE $where",
        'count' => "SELECT COUNT(*) AS total FROM repayments WHERE $where"
    ];
    
    foreach ($queries as $key => $query) {
        $result = mysqli_query($con, $query);
        $data = mysqli_fetch_assoc($result);
        $totals[$key] = $data['total'] ?? 0;
    }
    
    return $totals;
}

// Function to get disbursement data with optimized subqueries
function getDisbursementData($con, $st, $en, $br = '', $ln = '', $pr = '') {
    $conditions = ["r.Date_Disbursed BETWEEN '$st' AND '$en'", "r.Status != 'Cancelled'"];
    $reg_conditions = ["reg.Status = 'Disbursed'"];
    
    if (!empty($br)) {
        $conditions[] = "r.Branch_id = '$br'";
        $reg_conditions[] = "reg.Branch_id = '$br'";
    }
    if (!empty($ln)) {
        $conditions[] = "r.User = '$ln'";
        $reg_conditions[] = "reg.User = '$ln'";
    }
    if (!empty($pr)) {
        $conditions[] = "r.Product = '$pr'";
        $reg_conditions[] = "reg.Product = '$pr'";
    }
    
    $where = implode(" AND ", $conditions);
    $reg_where = implode(" AND ", $reg_conditions);
    
    // Optimized query with LEFT JOIN instead of correlated subqueries
    $query = "SELECT 
        r.id, r.Reg_id, r.User, r.BVN, r.Phone, r.Firstname, r.Middlename, r.Lastname, 
        r.Gender, r.Branch, r.Loan_Account_No, r.Loan_Amount, r.Officer_Name, r.Team_Name, 
        r.Unions, r.Product, r.Interest_Amt, r.Total_Loan, r.Client_Type, r.Disbursed_By, 
        r.Date_Disbursed,
        COALESCE(reg.Upfront, 0) AS regfee,
        COALESCE(reg.Inssurance, 0) AS ins,
        COALESCE(reg.Card, 0) AS car,
        COALESCE(reg.Form, 0) AS fm
    FROM repayments r
    LEFT JOIN register reg ON reg.id = r.Reg_id AND $reg_where
    WHERE $where 
    ORDER BY r.id ASC";
    
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

$product_name = empty($pr) ? "All" : htmlspecialchars($pr);

// Get totals
$totals = getDisbursementTotals($con, $st, $en, $br, $ln, $pr);

// Get table data
$result = getDisbursementData($con, $st, $en, $br, $ln, $pr);
$results = [];
while($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

// Determine filename based on filters
if (!empty($br) && !empty($ln) && !empty($pr)) {
    $filename = 'full_filter_disbursed';
    $csv_filename = 'Disbursement';
} elseif (!empty($br) && !empty($ln)) {
    $filename = 'officer_disbursed';
    $csv_filename = 'branch_loan_officer_disbursement';
} elseif (!empty($br)) {
    $filename = 'branchs_disbursed';
    $csv_filename = 'Branch_disbursement';
} elseif (!empty($pr)) {
    $filename = 'product_disbursed';
    $csv_filename = 'Product_disbursement';
} else {
    $filename = 'all_disbursed';
    $csv_filename = 'All_disbursement';
}

// Save to JSON
$fp = fopen("data/{$filename}.json", 'w');
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
                            <th scope="col">BVN</th>
                            <th scope="col">CLIENT NAME</th>
                            <th scope="col">PHONE</th>
                            <th scope="col">GENDER</th>
                            <th scope="col">LOAN NUMBER</th>
                            <th scope="col">BRANCH</th>
                            <th scope="col">PRODUCT</th>
                            <th scope="col">PRINCIPAL</th>
                            <th scope="col">INTEREST</th>
                            <th scope="col">TOTAL LOAN</th>
                            <th scope="col">ONBOARDING FEE</th>
                            <th scope="col">LOAN OFFICER</th>
                            <th scope="col">TEAM NAME</th>
                            <th scope="col">DISBURSED BY</th>
                            <th scope="col">DATE DISBURSED</th>
                            <th scope="col">CLIENT TYPE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($results as $member): ?>
                        <tr>
                            <td class="sort border-top border-translucent ps-3"><?php echo htmlspecialchars($member['BVN']); ?></td>
                            <td class="sort border-top" style="text-transform:uppercase">
                                <?php echo htmlspecialchars($member['Firstname'] . " " . $member['Middlename'] . " " . $member['Lastname']); ?>
                            </td>
                            <td class="sort border-top border-translucent ps-3"><?php echo htmlspecialchars($member['Phone']); ?></td>
                            <td class="sort border-top border-translucent ps-3"><?php echo htmlspecialchars($member['Gender']); ?></td>
                            <td class="sort border-top"><?php echo htmlspecialchars($member['Loan_Account_No']); ?></td>
                            <td class="sort border-top"><?php echo htmlspecialchars($member['Branch']); ?></td>
                            <td class="sort border-top"><?php echo htmlspecialchars($member['Product']); ?></td>
                            <td class="sort border-top"><?php echo number_format($member['Loan_Amount'], 2); ?></td>
                            <td class="sort border-top"><?php echo number_format($member['Interest_Amt'], 2); ?></td>
                            <td class="sort border-top"><?php echo number_format($member['Total_Loan'], 2); ?></td>
                            <td class="sort border-top">
                                <?php echo number_format($member['regfee'] + $member['ins'] + $member['car'] + $member['fm'], 2); ?>
                            </td>
                            <td class="sort border-top"><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
                            <td class="sort border-top"><?php echo htmlspecialchars($member['Team_Name']); ?></td>
                            <td class="sort border-top"><?php echo htmlspecialchars($member['Disbursed_By']); ?></td>
                            <td class="sort border-top"><?php echo htmlspecialchars($member['Date_Disbursed']); ?></td>
                            <td class="sort border-top"><?php echo htmlspecialchars($member['Client_Type']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
 