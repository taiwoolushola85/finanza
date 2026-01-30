<?php
// Set CORS headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

include '../config/db.php';
include '../config/user_session.php';

// 1. Inputs & Sanitization
$types = isset($_POST['types']) ? trim($_POST['types']) : 'Express';
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 10;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

if ($maxRows <= 0) $maxRows = 10;
if ($page < 1) $page = 1;

$savingsType = ($types === 'Flexi') ? 'Flexi' : 'Express';

// --- DATA FETCHING LOGIC ---
if ($savingsType === 'Flexi') {
    // FLEXI LOGIC
    $whereClause = "Status != ?";
    $params = ['Closed'];
    $paramTypes = 's';

    if (!empty($search)) {
        $searchParam = "%$search%";
        $whereClause .= " AND (BVN LIKE ? OR Flexi_Account_No LIKE ? OR Surname LIKE ? OR Firstname LIKE ? OR Officer_Name LIKE ?)";
        $params = array_merge($params, array_fill(0, 5, $searchParam));
        $paramTypes .= "sssss";
    }

    // Count Total
    $countStmt = mysqli_prepare($con, "SELECT COUNT(*) FROM flexi_account WHERE $whereClause");
    mysqli_stmt_bind_param($countStmt, $paramTypes, ...$params);
    mysqli_stmt_execute($countStmt);
    $total = mysqli_stmt_get_result($countStmt)->fetch_row()[0];

    // Pagination math
    $totalPages = ceil($total / $maxRows);
    if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
    $offset = ($page - 1) * $maxRows;

    // Fetch Data
    $dataQuery = "SELECT id, BVN, Flexi_Account_No, Surname, Firstname, Othername, Plan, Deposit_Amt, Withdraw_Amt, Total_Bal, Date_Start, Officer_Name, Status 
                  FROM flexi_account WHERE $whereClause ORDER BY id DESC LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($con, $dataQuery);
    $finalParams = array_merge($params, [$maxRows, $offset]);
    mysqli_stmt_bind_param($stmt, $paramTypes . "ii", ...$finalParams);
    mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt)->fetch_all(MYSQLI_ASSOC);
    
    file_put_contents('../data/general_flexi_portfolio_list.json', json_encode($results));

} else {
    // EXPRESS LOGIC
    $whereClause = "Status = ?";
    $params = ['Active'];
    $paramTypes = 's';

    if (!empty($search)) {
        $searchParam = "%$search%";
        $whereClause .= " AND (Client_BVN LIKE ? OR Virtual_Account LIKE ? OR Savings_Account_No LIKE ? OR Firstname LIKE ? OR Lastname LIKE ?)";
        $params = array_merge($params, array_fill(0, 5, $searchParam));
        $paramTypes .= "sssss";
    }

    // Count Total
    $countStmt = mysqli_prepare($con, "SELECT COUNT(*) FROM savings WHERE $whereClause");
    mysqli_stmt_bind_param($countStmt, $paramTypes, ...$params);
    mysqli_stmt_execute($countStmt);
    $total = mysqli_stmt_get_result($countStmt)->fetch_row()[0];

    // Pagination math
    $totalPages = ceil($total / $maxRows);
    if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
    $offset = ($page - 1) * $maxRows;

    // Fetch Data
    $dataQuery = "SELECT id, Virtual_Account, Client_BVN, Firstname, Lastname, Middlename, Savings_Account_No, Status, Savings_Paid, 
    Withdraw_Savings, Savings_Repayment, Savings_Transfer, Savings_Upfront, Balance FROM savings WHERE $whereClause ORDER BY id DESC LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($con, $dataQuery);
    $finalParams = array_merge($params, [$maxRows, $offset]);
    mysqli_stmt_bind_param($stmt, $paramTypes . "ii", ...$finalParams);
    mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt)->fetch_all(MYSQLI_ASSOC);
    
    file_put_contents('../data/all_saving_portfolio_list.json', json_encode($results));
}

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding: 10px; border-radius: 5px;">
    <small>
        <strong>Total <?php echo $types; ?>: <?php echo number_format($total); ?></strong>
        <?php if (!empty($search)): ?> | <span style="color: #28a745;">Search: "<?php echo htmlspecialchars($search); ?>"</span><?php endif; ?>
        <span style="color: #17a2b8;"> | Showing: <?php echo $startRecord; ?>-<?php echo $endRecord; ?></span>
    </small>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 5px;">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(1)" <?php echo ($page <= 1) ? 'disabled' : ''; ?> style="font-size: 10px;">&laquo; First</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?php echo $page - 1; ?>)" <?php echo ($page <= 1) ? 'disabled' : ''; ?> style="font-size: 10px;">Prev</button>
        <span style="font-size: 11px; align-self: center; padding: 0 5px;">Page <strong><?php echo $page; ?></strong>/<?php echo $totalPages; ?></span>
        <button type="button" class="btn btn-sm btn-primary" onclick="changePage(<?php echo $page + 1; ?>)" <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?> style="font-size: 10px;">Next</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?php echo $totalPages; ?>)" <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?> style="font-size: 10px;">Last &raquo;</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="height:350px; overflow:auto">
    <table>
        <thead>
            <?php if ($savingsType === 'Flexi'): ?>
                <tr style="font-size:9px;">
                    <th>BVN</th>
                    <th>ACCOUNT</th>
                    <th>NAME</th>
                    <th>PLAN</th>
                    <th >DEPOSIT</th>
                    <th>WITHDRAWAL</th>
                    <th>BALANCE</th>
                    <th>DATE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            <?php else: ?>
                <tr style="font-size:9px;">
                    <th>VIRTUAL ACCT</th>
                    <th>BVN</th>
                    <th>SAVINGS ACCT</th>
                    <th>NAME</th>
                    <th>DEPOSIT</th>
                    <th>WITHDRAW</th>
                    <th>REPAYMENT</th>
                    <th>TRANSFER</th>
                    <th>UPFRONT</th>
                    <th>CREDIT</th>
                    <th>BALANCE</th>
                    <th>STATUS</th>
                    <th>DETAIL</th>
                </tr>
            <?php endif; ?>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach($results as $member): ?>
                    <tr style="font-size:9px;">
                        <?php if ($savingsType === 'Flexi'): ?>
                            <td><?php echo $member['BVN']; ?></td>
                            <td><?php echo $member['Flexi_Account_No']; ?></td>
                            <td style="text-transform:capitalize"><span><?php echo $member['Surname']." ".$member['Firstname']; ?></span></td>
                            <td><?php echo $member['Plan']; ?></td>
                            <td ><?php echo number_format($member['Deposit_Amt'], 2); ?></td>
                            <td ><?php echo number_format($member['Withdraw_Amt'], 2); ?></td>
                            <td style=" font-weight:bold; color:green"><?php echo number_format($member['Total_Bal'], 2); ?></td>
                            <td><?php echo $member['Date_Start']; ?></td>
                            <td><?php echo $member['Status']; ?></td>
                            <td><button class="btn btn-outline-primary btn-sm invk" data-id="<?php echo $member['id']; ?>" style="font-size:8px">Details</button></td>
                        <?php else: ?>
                            <td><?php echo $member['Virtual_Account']; ?></td>
                            <td><?php echo $member['Client_BVN']; ?></td>
                            <td><?php echo $member['Savings_Account_No']; ?></td>
                            <td style="text-transform:capitalize"><span><?php echo $member['Firstname']." ".$member['Lastname']; ?></span></td>
                            <td ><?php echo number_format($member['Savings_Paid'], 2); ?></td>
                            <td ><?php echo number_format($member['Withdraw_Savings'], 2); ?></td>
                            <td ><?php echo number_format($member['Savings_Repayment'], 2); ?></td>
                            <td ><?php echo number_format($member['Savings_Transfer'], 2); ?></td>
                            <td ><?php echo number_format($member['Savings_Upfront'], 2); ?></td>
                            <td ><?php echo number_format($member['Savings_Recieved'], 2); ?></td>
                            <td style=" font-weight:bold; color:green"><?php echo number_format($member['Balance'], 2); ?></td>
                            <td ><?php echo $member['Status']; ?></td>
                            <td ><button class="btn btn-outline-primary btn-sm invks" data-id="<?php echo $member['id']; ?>" style="font-size:8px">Details</button></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="20" class="text-center p-4">No records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="currentTypes" value="<?php echo $types; ?>">
<input type="hidden" id="currentSearch" value="<?php echo htmlspecialchars($search); ?>">
<input type="hidden" id="currentMaxRows" value="<?php echo $maxRows; ?>">

<script>
function changePage(newPage) {
    var types = $('#currentTypes').val();
    var search = $('#currentSearch').val();
    var maxRows = $('#currentMaxRows').val();
    
    $('#table-container').css('opacity', '0.5');
    
    $.ajax({
        url: 'select_saving_type.php',
        type: 'POST',
        data: { page: newPage, types: types, search: search, maxRows: maxRows },
        success: function(response) {
            $('#results').html(response); 
        }
    });
}

$(document).ready(function() {
    // 1. .off() ensures we don't bind the same click multiple times 
    // especially after AJAX pagination/table refreshes.
    $(document).off('click', '.invk, .invks').on('click', '.invk, .invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Stops potential conflicts
        
        const $this = $(this);
        const id = $this.data('id');
        const $profile = $('#profile');
        const $updateModal = $("#updateModal");
        
        // 2. Logic to pick the right file
        const targetUrl = $this.hasClass('invk') ? 'client_flexi_saving_page.php' : 'express_saving_page.php';

        // 3. Open modal immediately
        $updateModal.modal('show');

        // 4. Loading State with min-height to prevent the modal from "collapsing"
        $profile.html(`
            <div class="d-flex flex-column align-items-center justify-content-center p-5" style="min-height: 250px;">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted font-weight-bold">Fetching savings profile...</p>
            </div>
        `);

        // 5. AJAX Call
        $.ajax({
            url: targetUrl,
            type: "GET",
            data: { 'id': id },
            cache: true, 
            success: function(data) {
                // 6. Smoothly transition. .stop(true, true) ensures snappy behavior.
                $profile.stop(true, true).hide().html(data).fadeIn(200);
            },
            error: function() {
                $profile.html(`
                    <div class="alert alert-danger m-3 text-center">
                        <b>Connection Error:</b> Could not load the savings profile.
                    </div>`);
            }
        });
    });
});
</script>