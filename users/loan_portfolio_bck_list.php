<?php
// Set CORS and Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

include '../config/db.php';
include '../config/user_session.php';

// 1. Inputs & Sanitization
$types = isset($_POST['types']) ? trim($_POST['types']) : '';
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 10;
$d = date('Y-m-d');

if ($maxRows <= 0) $maxRows = 10;
if ($page < 1) $page = 1;

// 2. Build Efficient WHERE clause
$params = [];
$paramTypes = '';
$whereClause = "1=1";

// Status Filter
if (!empty($types)) {
    $whereClause .= " AND Status = ?";
    $params[] = $types;
    $paramTypes .= 's';
}

// Search Filter (Optimized)
if (!empty($search)) {
    $searchParam = "%$search%";
    // Columns to search
    $cols = [
        "Account_Number", 
        "Loan_Account_No", 
        "Disbursement_No", 
        "BVN", 
        "CONCAT(Firstname, ' ', Lastname)", // Note: CONCAT can be slow on huge tables
        "Branch", 
        "Product"
    ];
    
    // Dynamically build the OR clause
    $likeParts = [];
    foreach ($cols as $col) {
        $likeParts[] = "$col LIKE ?";
        $params[] = $searchParam;
        $paramTypes .= 's';
    }
    $whereClause .= " AND (" . implode(" OR ", $likeParts) . ")";
}

// 3. Get Total Record Count (Lightweight Query)
$countQuery = "SELECT COUNT(id) as total FROM repayments WHERE $whereClause";
$stmt = mysqli_prepare($con, $countQuery);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
}
mysqli_stmt_execute($stmt);
$countResult = mysqli_stmt_get_result($stmt);
$total = $countResult->fetch_assoc()['total'];
mysqli_stmt_close($stmt);

// 4. Pagination Math
$totalPages = ($total > 0) ? ceil($total / $maxRows) : 1;
if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $maxRows;
if ($offset < 0) $offset = 0;

// 5. Data Query (Fetch ONLY what is needed)
$dataQuery = "SELECT id, Account_Number, Firstname, Lastname, Branch, Product, 
              Loan_Amount, Interest_Amt, Paid, Expected_Amount,
              Date_Disbursed, Maturity_Date, Status, Total_Bal 
              FROM repayments 
              WHERE $whereClause 
              ORDER BY id DESC 
              LIMIT ? OFFSET ?";

// Add Limit/Offset params
$params[] = $maxRows;
$params[] = $offset;
$paramTypes .= "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
mysqli_stmt_execute($stmt);
$resultData = mysqli_stmt_get_result($stmt);
$results = $resultData->fetch_all(MYSQLI_ASSOC);
mysqli_stmt_close($stmt);
mysqli_close($con);

// Calculate display range
$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded">
    <small>
        <strong>Total Records: <?php echo number_format($total); ?></strong>
        <?php if (!empty($types)): ?> | <span class="text-primary">Status: <?php echo htmlspecialchars($types); ?></span><?php endif; ?>
        <span class="text-info"> | Showing: <?php echo $startRecord; ?>-<?php echo $endRecord; ?></span>
    </small>

    <?php if ($totalPages > 1): ?>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(1)" <?php echo ($page <= 1) ? 'disabled' : ''; ?>>&laquo;</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?php echo $page - 1; ?>)" <?php echo ($page <= 1) ? 'disabled' : ''; ?>>Prev</button>
        <button type="button" class="btn btn-sm btn-light" disabled><strong><?php echo $page; ?></strong>/<?php echo $totalPages; ?></button>
        <button type="button" class="btn btn-sm btn-primary" onclick="changePage(<?php echo $page + 1; ?>)" <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>>Next</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?php echo $totalPages; ?>)" <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>>&raquo;</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="height:335px; overflow:auto;">
    <table>
        <thead>
            <tr>
                <th style="font-size:9px;">VIRTUAL ACCT</th>
                <th style="font-size:9px;">NAME</th>
                <th style="font-size:9px;">BRANCH</th>
                <th style="font-size:9px;">PRODUCT</th>
                <th style="font-size:9px;">PRINCIPAL</th>
                <th style="font-size:9px;">INTEREST</th>
                <th style="font-size:9px;">PAID</th>
                <th style="font-size:9px;">OUTSTANDING</th>
                <th style="font-size:9px;">EXPECTED</th>
                <th style="font-size:9px;">DISBURSED</th>
                <th style="font-size:9px;">EXPIRES</th>
                <th style="font-size:9px;">MATURITY STATUS</th>
                <th style="font-size:9px;">LOAN STATUS</th>
                <th style="font-size:9px;">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach($results as $member): 
                    $isExpired = ($d > $member['Maturity_Date']);
                    $bal = (float)$member['Total_Bal'];
                ?>
                <tr style="font-size:9px; text-align:left;">
                    <td><?php echo $member['Account_Number']; ?></td>
                    <td class="text-uppercase text-nowrap"><?php echo htmlspecialchars($member['Firstname']." ".$member['Lastname']); ?></td>
                    <td><?php echo $member['Branch']; ?></td>
                    <td><?php echo $member['Product']; ?></td>
                    <td><?php echo number_format($member['Loan_Amount'], 2); ?></td>
                    <td><?php echo number_format($member['Interest_Amt'], 2); ?></td>
                    <td><?php echo number_format($member['Paid'], 2); ?></td>
                    <td style="color: <?php echo ($bal > 0 ? '#dc3545' : '#28a745'); ?>; font-weight:bold;">
                        <?php echo number_format($bal, 2); ?>
                    </td>
                    <td><?php echo number_format($member['Expected_Amount'], 2); ?></td>
                    <td><?php echo date("d-M-Y", strtotime($member['Date_Disbursed'])); ?></td>
                    <td><?php echo date("d-M-Y", strtotime($member['Maturity_Date'])); ?></td>
                    
                    <td>
                        <?php if($isExpired): ?>
                            <span style="font-size:8px; color:red">Expired</span>
                        <?php else: ?>
                            <span  style="font-size:8px; color:green">Running</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php 
                        if($bal == 0 && $member['Status'] == 'Active'){
                            echo "<span style='color:pink'> Ready For Auditing</span>";
                        } else if($bal == 0 && $member['Status'] == 'Closed'){
                            echo "<span style='color:red'>Closed</span>";
                        } else {
                            echo $member['Status'];
                        }
                        ?>
                    </td>

                    <td>
                        <button class="btn btn-outline-primary btn-sm page" 
                                data-id="<?php echo $member['id']; ?>" 
                               style="font-size:8px" >Details</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="20" class="text-center p-4 text-muted">No records found matching your criteria.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="currentTypes" value="<?php echo htmlspecialchars($types); ?>">
<input type="hidden" id="currentSearch" value="<?php echo htmlspecialchars($search); ?>">
<input type="hidden" id="currentMaxRows" value="<?php echo $maxRows; ?>">

<script>
// Efficient Pagination Function
function changePage(newPage) {
    const $container = $('#table-container');
    const $resultsDiv = $('#hey'); // Assuming 'hey' is the main container ID from your parent page
    
    // UI Feedback
    $container.css('opacity', '0.5');
    
    $.ajax({
        url: 'loan_portfolio_bck_list.php',
        type: 'POST',
        data: {
            page: newPage,
            types: $('#currentTypes').val(),
            search: $('#currentSearch').val(),
            maxRows: $('#currentMaxRows').val()
        },
        success: function(response) {
            $resultsDiv.html(response); 
        },
        error: function() {
            alert("Connection error. Please try again.");
            $container.css('opacity', '1');
        }
    });
}



$(document).ready(function() {
    // 1. .off('click') ensures only ONE listener is active at a time.
    // This stops the "multiple-trigger" and "blinking modal" bug.
    $(document).off('click', '.page').on('click', '.page', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Stops the click from triggering other scripts

        const id = $(this).data('id');
        const $modal = $("#updateModals");
        const $profileContainer = $('#profi');

        // 2. Open the modal immediately
        $modal.modal('show');

        // 3. Set Loading State with a fixed min-height to prevent layout shifting
        $profileContainer.html(`
            <div class="d-flex flex-column align-items-center justify-content-center p-5" style="min-height:300px;">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted font-weight-bold">Fetching profile data...</p>
            </div>`);

        // 4. Optimized AJAX call
        $.ajax({
            url: 'client_loan_profile_data.php',
            type: "GET",
            data: {'id': id},
            cache: true, 
            success: function(data) { 
                // 5. Inject data. .stop(true, true) kills any active fades to show content instantly.
                $profileContainer.stop(true, true).hide().html(data).fadeIn(200);
            },
            error: function() {
                $profileContainer.html(`
                    <div class="alert alert-danger m-3 text-center">
                        <b>Error:</b> Could not load profile. Please refresh and try again.
                    </div>`);
            }
        });
    });
});
</script>