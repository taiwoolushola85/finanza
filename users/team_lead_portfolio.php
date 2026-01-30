<?php
// Set CORS and Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

include '../config/db.php';
include '../config/user_session.php';

$d = date('Y-m-d');

// 1. Inputs & Sanitization
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 10;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

if ($maxRows <= 0) $maxRows = 10;
if ($page < 1) $page = 1;

// 2. Build Query with Prepared Statements
// We use $User from session to filter by Team Leader
$whereClause = "Status = 'Active' AND Team_Leader = ?";
$params = [$User];
$types = "s";

if (!empty($search)) {
    $whereClause .= " AND (BVN LIKE ? OR Account_Number LIKE ? OR Loan_Account_No LIKE ? 
    OR Disbursement_No LIKE ? OR Transaction_id LIKE ? OR Savings_Account_No LIKE ? 
    OR Unions LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?)";
    
    $searchParam = "%$search%";
    // Add the search param 10 times for the 10 LIKE conditions
    for($i=0; $i<10; $i++) {
        $params[] = $searchParam;
        $types .= "s";
    }
}

// 3. Get Total Count
$countQuery = "SELECT COUNT(*) FROM repayments WHERE $whereClause";
$countStmt = mysqli_prepare($con, $countQuery);
mysqli_stmt_bind_param($countStmt, $types, ...$params);
mysqli_stmt_execute($countStmt);
$total = mysqli_stmt_get_result($countStmt)->fetch_row()[0];
mysqli_stmt_close($countStmt);

// 4. Pagination Math
$totalPages = ceil($total / $maxRows);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
$offset = ($page - 1) * $maxRows;

// 5. Data Query
$dataQuery = "SELECT id, Account_Number, Firstname, Lastname, Middlename, Product, Branch, Total_Loan, Paid, Maturity_Status, Expected_Amount,
              Date_Disbursed, Maturity_Date, Status, Total_Bal FROM repayments 
              WHERE $whereClause ORDER BY id ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt)->fetch_all(MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Save to JSON
file_put_contents('../data/team_portfolio_list.json', json_encode($results));

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <small style="font-weight: bold;">Portfolio Records: <?= number_format($total) ?></small>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 5px;">
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changePortfolioPage(1)" <?= ($page <= 1) ? 'disabled' : '' ?> >Next</button>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changePortfolioPage(<?= $page - 1 ?>)" <?= ($page <= 1) ? 'disabled' : '' ?> >Prev</button>
        <span style="font-size: 10px; align-self: center;">Page <?= $page ?> of <?= $totalPages ?></span>
        <button type="button" class="btn btn-xs btn-primary" onclick="changePortfolioPage(<?= $page + 1 ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?>>Next</button>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changePortfolioPage(<?= $totalPages ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> >Prev</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="height:350px; overflow-y:auto;">
    <table>
        <thead>
            <tr style="font-size:8px">
                <th>VIRTUAL ACCT</th>
                <th>NAME</th>
                <th>BRANCH</th>
                <th>PRODUCT</th>
                <th>TOTAL LOAN</th>
                <th>PAID</th>
                <th>OUTSTANDING</th>
                <th>EXPECTED AMT</th>
                <th>DATE DISBURSED</th>
                <th>DATE EXPIRED</th>
                <th>STATUS</th>
                <th>DETAIL</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $member): 
                    $fullname = htmlspecialchars($member['Firstname'] . " " . $member['Middlename'] . " " . $member['Lastname']);
                    $maturityDate = $member['Maturity_Date'];
                    $isExpired = ($d > $maturityDate);
                ?>
                <tr style="font-size:8px">
                    <td><?= htmlspecialchars($member['Account_Number']) ?></td>
                    <td style="text-transform:capitalize"><span><?= $fullname ?></span></td>
                    <td><?= htmlspecialchars($member['Branch']) ?></td>
                    <td><?= htmlspecialchars($member['Product']) ?></td>
                    <td><?= number_format($member['Total_Loan'], 2) ?></td>
                    <td><?= number_format($member['Paid'], 2) ?></td>
                    <td style="color: #d9534f; font-weight: bold;"><?= number_format($member['Total_Bal'], 2) ?></td>
                    <td><?= number_format($member['Expected_Amount'], 2) ?></td>
                    <td><?= htmlspecialchars($member['Date_Disbursed']) ?></td>
                    <td><?= htmlspecialchars($maturityDate) ?></td>
                    <td>
                        <?php if($isExpired): ?>
                            <span  style="color:red">Expired</span>
                        <?php else: ?>
                            <span  style="color:green">Active</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?= $member['id'] ?>">
                            <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="12" class="text-center p-4">No portfolio records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="portSearch" value="<?= htmlspecialchars($search) ?>">
<input type="hidden" id="portMaxRows" value="<?= $maxRows ?>">

<script>
function changePortfolioPage(newPage) {
    var search = $('#portSearch').val();
    var maxRows = $('#portMaxRows').val();
    
    $('#table-container').css('opacity', '0.5');
    
    $.ajax({
        url: 'team_lead_portfolio.php',
        type: 'POST',
        data: { page: newPage, search: search, maxRows: maxRows },
        success: function(response) {
            $('#results').html(response); 
        }
    });
}

$(document).ready(function() {
    // 1. Clear previous listeners to prevent multiple AJAX calls on a single click
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Ensure no other scripts interfere

        const id = $(this).data('id');
        const $modal = $("#updateBm");
        const $profileContainer = $('#page');

        // 2. Open the modal immediately
        $modal.modal('show');

        // 3. Set a Loading State
        $profileContainer.html(`
            <div class="d-flex flex-column align-items-center p-5" style="min-height: 200px;">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted">Loading client loan details...</p>
            </div>`);

        // 4. Optimized AJAX call
        $.ajax({
            url: 'client_loan_page.php',
            type: "GET",
            data: {'id': id},
            cache: true, 
            success: function(data) { 
                // 5. Swap content instantly. 
                // Using .stop() prevents animation jumping if they click rapidly.
                $profileContainer.stop(true, true).hide().html(data).fadeIn(200);
            },
            error: function() {
                $profileContainer.html(`
                    <div class="alert alert-danger m-3 text-center">
                        Failed to load loan details. Please check your connection.
                    </div>`);
            }
        });
    });
});
</script>