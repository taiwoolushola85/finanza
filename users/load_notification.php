<?php
// Set CORS headers at the top
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

include '../config/db.php';

// Verify database connection
if (!$con) {
    die("Database connection failed");
}

$d = date('Y-m-d');

// Get total record count using prepared statement
$countStmt = mysqli_prepare($con, "SELECT COUNT(*) as total FROM nip_notifications WHERE Status = ?");
$status = 'Waiting For Approval';
mysqli_stmt_bind_param($countStmt, 's', $status);
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$countRow = mysqli_fetch_assoc($countResult);
$totalRecords = $countRow['total'];
mysqli_stmt_close($countStmt);

// Get total transaction amount using prepared statement
$sumStmt = mysqli_prepare($con, "SELECT SUM(amount) as total_amount FROM nip_notifications WHERE Status = ?");
mysqli_stmt_bind_param($sumStmt, 's', $status);
mysqli_stmt_execute($sumStmt);
$sumResult = mysqli_stmt_get_result($sumStmt);
$sumRow = mysqli_fetch_assoc($sumResult);
$totalTransaction = $sumRow['total_amount'] ?? 0;
mysqli_stmt_close($sumStmt);

// Get total posted amount using prepared statement
$postedStmt = mysqli_prepare($con, "SELECT SUM(Amount) as total_posted FROM history WHERE Date_Paid = ?");
mysqli_stmt_bind_param($postedStmt, 's', $d);
mysqli_stmt_execute($postedStmt);
$postedResult = mysqli_stmt_get_result($postedStmt);
$postedRow = mysqli_fetch_assoc($postedResult);
$totalPosted = $postedRow['total_posted'] ?? 0;
mysqli_stmt_close($postedStmt);

// Get notification data using prepared statement
$dataStmt = mysqli_prepare($con, "SELECT id, originatoraccountnumber, amount, originatorname, craccountname, 
              bankname, sessionid, craccount, Status, bankcode, tnxdate, tnxtime, Branch, Officer_Name 
              FROM nip_notifications WHERE Status != ? ORDER BY id DESC LIMIT 100");
$notUsedStatus = 'Notification Used';
mysqli_stmt_bind_param($dataStmt, 's', $notUsedStatus);
mysqli_stmt_execute($dataStmt);
$result = mysqli_stmt_get_result($dataStmt);

// Fetch results
$results = array();
while($row = mysqli_fetch_assoc($result)) {
    $results[] = $row; 
}
mysqli_stmt_close($dataStmt);

// Save to JSON file with proper error handling
$jsonFile = '../data/bank_notification.json';
$jsonDir = dirname($jsonFile);

// Ensure directory exists and is writable
if (!is_dir($jsonDir)) {
    mkdir($jsonDir, 0755, true);
}

if (is_writable($jsonDir)) {
    $jsonData = json_encode($results, JSON_PRETTY_PRINT);
    if ($jsonData !== false) {
        file_put_contents($jsonFile, $jsonData, LOCK_EX);
    }
}

mysqli_close($con);
?>

<br>
<div class="row">
    <div class="col-sm-2" style="margin-bottom:10px;">
        <div style="background-color: #f8f9fa; padding: 8px; border-radius: 5px; border-left: 3px solid #007bff;">
            <small style="font-weight: bold; color:black">
                Total Record: <?php echo htmlspecialchars($totalRecords); ?>
            </small>
        </div>
    </div>
    <div class="col-sm-4" style="margin-bottom:10px;">
        <div style="background-color: #f8f9fa; padding: 8px; border-radius: 5px; border-left: 3px solid #28a745;">
            <small style="font-weight: bold; color: #28a745;">
                Total Transaction: ₦<?php echo number_format($totalTransaction, 2); ?>
            </small>
        </div>
    </div>
    <div class="col-sm-4" style="margin-bottom:10px;">
        <div style="background-color: #f8f9fa; padding: 8px; border-radius: 5px; border-left: 3px solid #17a2b8;">
            <small style="font-weight: bold; color: #17a2b8;">
                Total Posted Today: ₦<?php echo number_format($totalPosted, 2); ?>
            </small>
        </div>
    </div>
    <div class="col-sm-2" style="margin-bottom:10px;">
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDefault" style="float:right;">
            <i id="frt" style="display:block">
                <svg fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 10.6699C2 5.88166 5.84034 2 10.5776 2C12.8526 2 15.0343 2.91344 16.6429 4.53936C18.2516 6.16529 19.1553 8.37052 19.1553 10.6699C19.1553 15.4582 15.3149 19.3399 10.5776 19.3399C5.84034 19.3399 2 15.4582 2 10.6699ZM19.0134 17.6543L21.568 19.7164H21.6124C22.1292 20.2388 22.1292 21.0858 21.6124 21.6082C21.0955 22.1306 20.2576 22.1306 19.7407 21.6082L17.6207 19.1785C17.4203 18.9766 17.3076 18.7024 17.3076 18.4164C17.3076 18.1304 17.4203 17.8562 17.6207 17.6543C18.0072 17.2704 18.6268 17.2704 19.0134 17.6543Z" fill="currentColor" />
                </svg>
                Search Transaction
            </i>
        </button>
    </div>
</div>

<div style="overflow:auto; height:400px;">
    <div id="table-container" style="height:370px; overflow-y:auto;">
        <table >
            <thead >
                <tr>
                    <th style="font-size:8px">ORIGINATOR ACCT NO</th>
                    <th style="font-size:8px">ORIGINATOR NAME</th>
                    <th style="font-size:8px">CREDITOR ACCT NO</th>
                    <th style="font-size:8px">CREDITOR ACCT NAME</th>
                    <th style="font-size:8px">SESSION ID</th>
                    <th style="font-size:8px">BRANCH</th>
                    <th style="font-size:8px">AMOUNT</th>
                    <th style="font-size:8px">BANK</th>
                    <th style="font-size:8px">CREDIT OFFICER</th>
                    <th style="font-size:8px">DATE</th>
                    <th style="font-size:8px">STATUS</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($results)) {
                foreach($results as $member) {
                    // Escape output for XSS protection
                    $originatorAcct = htmlspecialchars($member['originatoraccountnumber'], ENT_QUOTES, 'UTF-8');
                    $originatorName = htmlspecialchars($member['originatorname'], ENT_QUOTES, 'UTF-8');
                    $crAcct = htmlspecialchars($member['craccount'], ENT_QUOTES, 'UTF-8');
                    $crAcctName = htmlspecialchars($member['craccountname'], ENT_QUOTES, 'UTF-8');
                    $sessionId = htmlspecialchars($member['sessionid'], ENT_QUOTES, 'UTF-8');
                    $branch = htmlspecialchars($member['Branch'], ENT_QUOTES, 'UTF-8');
                    $amount = floatval($member['amount']);
                    $bankName = htmlspecialchars($member['bankname'], ENT_QUOTES, 'UTF-8');
                    $officer = htmlspecialchars($member['Officer_Name'], ENT_QUOTES, 'UTF-8');
                    $tnxDate = htmlspecialchars($member['tnxdate'], ENT_QUOTES, 'UTF-8');
                    $status = htmlspecialchars($member['Status'], ENT_QUOTES, 'UTF-8');
                    
                    // Status badge
                    $badgeClass = 'badge-soft-secondary';
                    if ($status === 'Waiting For Approval') {
                        $badgeClass = 'badge-soft-warning';
                    } elseif ($status === 'Approved') {
                        $badgeClass = 'badge-soft-success';
                    } elseif ($status === 'Declined') {
                        $badgeClass = 'badge-soft-danger';
                    }
                    ?>
                    <tr style="font-size:8px">
                        <td><?php echo $originatorAcct; ?></td>
                        <td style="text-transform:uppercase"><?php echo $originatorName; ?></td>
                        <td><?php echo $crAcct; ?></td>
                        <td><?php echo $crAcctName; ?></td>
                        <td><?php echo $sessionId; ?></td>
                        <td><?php echo $branch; ?></td>
                        <td><?php echo number_format($amount, 2); ?></td>
                        <td><?php echo $bankName; ?></td>
                        <td><?php echo $officer; ?></td>
                        <td><?php echo $tnxDate; ?></td>
                        <td><span class='<?php echo $badgeClass; ?>'><?php echo $status; ?></span></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="11" style="text-align:center; font-size:11px">No records found</td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
function load() {
    $("#ld").show();
    $.ajax({
        method: "POST",
        url: "load_notification.php",
        dataType: "html",
        timeout: 10000, // 10 second timeout
        success: function(data) {
            $("#ld").show();
            setTimeout(function() {
                $("#ld").hide();
                $('#result').html(data);
            }, 2000);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            $("#ld").hide();
            alert('Error loading notifications. Please try again.');
        }
    });
}
</script>