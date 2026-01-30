<?php
// Set CORS and Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

include '../config/db.php';
include '../config/user_session.php';

// 1. Inputs & Sanitization
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 10;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

if ($maxRows <= 0) $maxRows = 10;
if ($page < 1) $page = 1;

// 2. Base Query Filters
$whereClause = "Status = ?";
$params = ['Ready For Underwriting'];
$types = 's';

if (!empty($search)) {
    $whereClause .= " AND (BVN LIKE ? OR Branch LIKE ? OR CONCAT(Firstname, ' ', Middlename, ' ', Lastname) LIKE ?)";
    $searchParam = "%$search%";
    $params = array_merge($params, array_fill(0, 3, $searchParam));
    $types .= 'sss';
}

// 3. Get Total Record Count & Breakdown
$countQuery = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN Status = 'Under Review' THEN 1 ELSE 0 END) as total_under_review,
    SUM(CASE WHEN Status = 'Declined' THEN 1 ELSE 0 END) as total_declined,
    SUM(CASE WHEN Status = 'Ready For Underwriting' THEN 1 ELSE 0 END) as total_ready
    FROM register WHERE $whereClause";

$countStmt = mysqli_prepare($con, $countQuery);
mysqli_stmt_bind_param($countStmt, $types, ...$params);
mysqli_stmt_execute($countStmt);
$countData = mysqli_stmt_get_result($countStmt)->fetch_assoc();

$total = $countData['total'];
$totalUnderReview = $countData['total_under_review'] ?? 0;
$totalDeclined = $countData['total_declined'] ?? 0;
$totalReady = $countData['total_ready'] ?? 0;
mysqli_stmt_close($countStmt);

// 4. Pagination Math
$totalPages = ceil($total / $maxRows);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
$offset = ($page - 1) * $maxRows;

// 5. Data Query with LIMIT and OFFSET
$dataQuery = "SELECT id, CONCAT(Firstname, ' ', Middlename, ' ', Lastname) as Full_Name, 
              Gender, Product, Loan_Amount, Tenure, Frequency, Phone, Branch, BVN, 
              Status, Date_Reg, Time_Reg, Officer_Name 
              FROM register WHERE $whereClause ORDER BY id ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt)->fetch_all(MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Save to JSON
file_put_contents('../data/loan_underwriting_lists.json', json_encode($results, JSON_PRETTY_PRINT));

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="margin-bottom: 15px; border-left: 4px solid #007bff; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div>
        <small style="font-weight: bold;">Total: <?= number_format($total) ?></small> | 
        <small style="color: #17a2b8; font-weight: bold;">Review: <?= $totalUnderReview ?></small> | 
        <small style="color: #dc3545; font-weight: bold;">Declined: <?= $totalDeclined ?></small> | 
        <small style="color: #28a745; font-weight: bold;">Ready: <?= $totalReady ?></small>
    </div>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 4px;">
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeUnderwritingPage(1)" <?= ($page <= 1) ? 'disabled' : '' ?> >Next</button>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeUnderwritingPage(<?= $page - 1 ?>)" <?= ($page <= 1) ? 'disabled' : '' ?> >Prev</button>
        
        <span style="font-size: 10px; align-self: center; font-weight: bold;">Page <?= $page ?>/<?= $totalPages ?></span>
        
        <button type="button" class="btn btn-xs btn-primary" onclick="changeUnderwritingPage(<?= $page + 1 ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?>>Next</button>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeUnderwritingPage(<?= $totalPages ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?>>Prev</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="height:340px; overflow-y:auto;">
    <table >
        <thead>
            <tr style="font-size:8px">
                <th>BVN</th><th>NAME</th><th>PHONE</th><th>GENDER</th><th>PRODUCT</th><th>TENURE</th><th>FREQ</th><th>AMOUNT</th><th>BRANCH</th><th>OFFICER</th><th>STATUS</th><th>DATE</th><th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach($results as $member): 
                    $badgeClass = ($member['Status'] === 'Under Review') ? 'badge-soft-info' : (($member['Status'] === 'Declined') ? 'badge-soft-danger' : 'badge-soft-success');
                ?>
                <tr style="font-size:8px">
                    <td><?= htmlspecialchars($member['BVN']) ?></td>
                    <td style="text-transform:capitalize"><span><?= htmlspecialchars($member['Full_Name']) ?></span></td>
                    <td><?= htmlspecialchars($member['Phone']) ?></td>
                    <td><?= htmlspecialchars($member['Gender']) ?></td>
                    <td><?= htmlspecialchars($member['Product']) ?></td>
                    <td><?= htmlspecialchars($member['Tenure']) ?></td>
                    <td><?= htmlspecialchars($member['Frequency']) ?></td>
                    <td><?= number_format($member['Loan_Amount'], 2) ?></td>
                    <td><?= htmlspecialchars($member['Branch']) ?></td>
                    <td><?= htmlspecialchars($member['Officer_Name']) ?></td>
                    <td><span class='<?= $badgeClass ?>'><?= htmlspecialchars($member['Status']) ?></span></td>
                    <td><?= htmlspecialchars($member['Date_Reg']) ?></td>
                    <td>
                        <a class="invks" href="#" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?= $member['id'] ?>">
                            <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="14" class="text-center p-4">No underwriting records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="currentSearch" value="<?= htmlspecialchars($search) ?>">
<input type="hidden" id="currentMaxRows" value="<?= $maxRows ?>">

<script>
function changeUnderwritingPage(newPage) {
    var search = $('#currentSearch').val();
    var maxRows = $('#currentMaxRows').val();
    
    $('#table-container').css('opacity', '0.5');
    
    $.ajax({
        url: 'load_underwriting_list.php',
        type: 'POST',
        data: { page: newPage, search: search, maxRows: maxRows },
        success: function(response) {
            $('#result').html(response); 
        }
    });
}


$(document).ready(function() {
    // 1. .off('click') removes previous bindings to prevent "Double Firing" 
    // especially when this script is re-loaded via AJAX pagination.
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Prevents conflict with other click listeners

        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $profile = $('#profile');

        // 2. Open modal immediately
        $modal.modal('show');

        // 3. Set 'Loading' state with min-height to prevent modal layout flickering
        $profile.html(`
            <div class="d-flex flex-column align-items-center justify-content-center p-5" style="min-height:250px;">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <span class="text-muted">Analyzing loan profile...</span>
            </div>
        `);

        // 4. Optimized AJAX Call
        $.ajax({
            url: 'loan_underwriting_page.php',
            type: "GET",
            data: {'id': id},
            cache: true, 
            success: function(data) { 
                // 5. Inject data and fade in. 
                // .stop(true, true) cancels existing animations if the user clicks rows fast.
                $profile.stop(true, true).hide().html(data).fadeIn(200);
            },
            error: function() {
                $profile.html(`
                    <div class="alert alert-danger m-3 text-center">
                        <b>Error:</b> Failed to load loan underwriting details.
                    </div>`);
            }
        });
    });
});
</script>