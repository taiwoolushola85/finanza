<?php
// Set CORS headers
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

// 2. Build WHERE clause
$whereClause = "";
$params = array();
$types = "";

if (!empty($search)) {
    $whereClause = " WHERE (Client_BVN LIKE ? OR Gaurantor_BVN LIKE ? OR Phone LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?)";
    $searchParam = "%$search%";
    $params = array_fill(0, 6, $searchParam);
    $types = str_repeat('s', 6);
}

// 3. Get Total Count
$countQuery = "SELECT COUNT(*) FROM gaurantors" . $whereClause;
$countStmt = mysqli_prepare($con, $countQuery);
if (!empty($search)) {
    mysqli_stmt_bind_param($countStmt, $types, ...$params);
}
mysqli_stmt_execute($countStmt);
$total = mysqli_stmt_get_result($countStmt)->fetch_row()[0];
mysqli_stmt_close($countStmt);

// 4. Pagination Mathematics
$totalPages = ceil($total / $maxRows);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
$offset = ($page - 1) * $maxRows;

// 5. Data Query (Applying LIMIT and OFFSET)
$dataQuery = "SELECT DISTINCT id, Gaurantor_BVN, Client_BVN, Firstname, Lastname, Middlename, Phone, Gender, Officer_Name, Status, Client_Name
FROM gaurantors" . $whereClause . " ORDER BY Firstname ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$dataStmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($dataStmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($dataStmt);
$result = mysqli_stmt_get_result($dataStmt);
$results = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($dataStmt);

// Save to JSON
file_put_contents('../data/gaurantor_record.json', json_encode($results));
mysqli_close($con);

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding: 8px; border-radius: 4px;">
    <small>
        <strong>Total Guarantors: <?= number_format($total) ?></strong>
        <?php if (!empty($search)): ?> | <span style="color: #28a745;">Search: "<?= htmlspecialchars($search) ?>"</span><?php endif; ?>
        <span style="color: #17a2b8;"> | Showing: <?= $startRecord ?>-<?= $endRecord ?></span>
    </small>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 5px;">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(1)" <?= ($page <= 1) ? 'disabled' : '' ?> style="font-size: 10px;">Next</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?= $page - 1 ?>)" <?= ($page <= 1) ? 'disabled' : '' ?> style="font-size: 10px;">Prev</button>
        
        <span style="font-size: 11px; align-self: center;">Page <b><?= $page ?></b>/<?= $totalPages ?></span>
        
        <button type="button" class="btn btn-sm btn-primary" onclick="changePage(<?= $page + 1 ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> style="font-size: 10px;">Next</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?= $totalPages ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> style="font-size: 10px;">Prev</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="overflow:auto; height:340px; ">
    <table>
        <thead>
            <tr style="font-size:8px">
                <th>ID</th>
                <th>GUARANTOR BVN</th>
                <th>GUARANTOR NAME</th>
                <th>PHONE NO</th>
                <th>GENDER</th>
                <th>CLIENT BVN</th>
                <th>CLIENT NAME</th>
                <th>LOAN OFFICER</th>
                <th>STATUS</th>
                <th>DETAIL</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $member): ?>
                <tr style="font-size:8px">
                    <td><?= $member['id'] ?></td>
                    <td><?= htmlspecialchars($member['Gaurantor_BVN']) ?></td>
                    <td style="text-transform:capitalize"><span><?= trim($member['Firstname']." ".$member['Middlename']." ".$member['Lastname']) ?></span></td>
                    <td><?= htmlspecialchars($member['Phone']) ?></td>
                    <td><?= htmlspecialchars($member['Gender']) ?></td>
                    <td><?= htmlspecialchars($member['Client_BVN']) ?></td>
                    <td><?= htmlspecialchars($member['Client_Name']) ?></td>
                    <td><?= htmlspecialchars($member['Officer_Name']) ?></td>
                    <td><?= htmlspecialchars($member['Status']) ?></td>
                    <td>
                        <a class="invks" href="#" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?= $member['id'] ?>">
                            <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="10" style="text-align:center; padding: 30px; color:#999;">No records found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="currentSearch" value="<?= htmlspecialchars($search) ?>">
<input type="hidden" id="currentMaxRows" value="<?= $maxRows ?>">

<script>
function changePage(newPage) {
    var search = $('#currentSearch').val();
    var maxRows = $('#currentMaxRows').val();
    
    $('#table-container').css('opacity', '0.5');
    
    $.ajax({
        url: 'load_gaurantor_record.php',
        type: 'POST',
        data: {
            page: newPage,
            search: search,
            maxRows: maxRows
        },
        success: function(response) {
            $('#result').html(response); 
        }
    });
}
$(document).ready(function() {
    // 1. Use Event Delegation: Faster memory management for large tables
    $(document).on('click', '.invks', function(e) {
        e.preventDefault();
        
        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $container = $('#profile');

        if (!id) return;

        // 2. Open the modal immediately 
        $modal.modal('show');

        // 3. Set a Loading State (Instant visual feedback)
        $container.html(`
            <div class="text-center p-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Loading Guarantor Profile...</p>
            </div>
        `);

        // 4. AJAX call without artificial delays
        $.ajax({
            url: 'gaurantor_profile_page.php',
            type: "GET",
            data: { 'id': id },
            cache: true, 
            success: function(data) { 
                // 5. Swap the spinner for real data instantly
                $container.hide().html(data).fadeIn(200);
            },
            error: function() {
                $container.html('<div class="alert alert-danger">Error fetching profile.</div>');
            }
        });
    });
});

$(document).ready(function() {
    // 1. Use Event Delegation: Faster memory management for large tables
    $(document).on('click', '.invks', function(e) {
        e.preventDefault();
        
        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $container = $('#profile');

        if (!id) return;

        // 2. Open the modal immediately 
        $modal.modal('show');

        // 3. Set a Loading State (Instant visual feedback)
        $container.html(`
            <div class="text-center p-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Loading Guarantor Profile...</p>
            </div>
        `);

        // 4. AJAX call without artificial delays
        $.ajax({
            url: 'gaurantor_profile_page.php',
            type: "GET",
            data: { 'id': id },
            cache: true, 
            success: function(data) { 
                // 5. Swap the spinner for real data instantly
                $container.hide().html(data).fadeIn(200);
            },
            error: function() {
                $container.html('<div class="alert alert-danger">Error fetching profile.</div>');
            }
        });
    });
});
</script>