<?php
// 1. Inputs & Sanitization
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 10;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

if ($maxRows <= 0) $maxRows = 10;
if ($page < 1) $page = 1;

include '../config/db.php';
include '../config/user_session.php';

// 2. Build Search Condition
$searchCondition = '';
$params = [];
$types = '';

if (!empty($search)) {
    $searchCondition = " WHERE (Name LIKE ? OR Branch LIKE ? OR Officer_Name LIKE ?)";
    $searchParam = "%{$search}%";
    $params = [$searchParam, $searchParam, $searchParam];
    $types = 'sss';
}

// 3. Get Total Record Count
$countQuery = "SELECT COUNT(*) as total FROM groups" . $searchCondition;
$countStmt = mysqli_prepare($con, $countQuery);
if (!empty($params)) {
    mysqli_stmt_bind_param($countStmt, $types, ...$params);
}
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$total = mysqli_fetch_assoc($countResult)['total'];
mysqli_stmt_close($countStmt);

// 4. Pagination Mathematics
$totalPages = ceil($total / $maxRows);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
$offset = ($page - 1) * $maxRows;

// 5. Data Query (Now applying LIMIT/OFFSET consistently)
$dataQuery = "SELECT id, Name, Branch, Officer_Name, Team_Name, Date_Register, Status 
FROM groups" . $searchCondition . " ORDER BY Name ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$results = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Save to JSON for reference
file_put_contents('../data/all_group_list.json', json_encode($results));
mysqli_close($con);

// Display Range Logic
$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <small>
        <strong>Total Records: <?php echo number_format($total); ?></strong>
        <?php if (!empty($search)): ?>
            <span style="color: #28a745;"> | Search: "<?php echo htmlspecialchars($search); ?>"</span>
        <?php endif; ?>
        <span style="color: #17a2b8;"> | Showing: <?php echo $startRecord; ?>-<?php echo $endRecord; ?></span>
    </small>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 5px;">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(1)" <?php echo ($page <= 1) ? 'disabled' : ''; ?> style="font-size: 10px;">&laquo; First</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?php echo $page - 1; ?>)" <?php echo ($page <= 1) ? 'disabled' : ''; ?> style="font-size: 10px;">Prev</button>
        
        <span style="font-size: 11px; padding: 0 5px; align-self: center;">Page <strong><?php echo $page; ?></strong>/<?php echo $totalPages; ?></span>
        
        <button type="button" class="btn btn-sm btn-primary" onclick="changePage(<?php echo $page + 1; ?>)" <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?> style="font-size: 10px;">Next</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?php echo $totalPages; ?>)" <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?> style="font-size: 10px;">Last &raquo;</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="height:350px; overflow-y:auto">
    <table>
        <thead>
            <tr style="font-size:8px">
                <th style="font-size:8px">ID</th>
                <th style="font-size:8px">NAME</th>
                <th style="font-size:8px">BRANCH</th>
                <th style="font-size:8px">CREDIT OFFICER</th>
                <th style="font-size:8px">TEAM LEAD</th>
                <th style="font-size:8px">DATE</th>
                <th style="font-size:8px">STATUS</th>
                <th style="font-size:8px">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $member): ?>
                <tr style="font-size:8px">
                    <td><?php echo htmlspecialchars($member['id']); ?></td>
                    <td style="text-transform:capitalize"><span><?php echo htmlspecialchars($member['Name']); ?></span></td>
                    <td><?php echo htmlspecialchars($member['Branch']); ?></td>
                    <td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
                    <td><?php echo htmlspecialchars($member['Team_Name']); ?></td>
                    <td><?php echo htmlspecialchars($member['Date_Register']); ?></td>
                    <td><?php echo htmlspecialchars($member['Status']); ?></td>
                    <td>
                        <a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo htmlspecialchars($member['id']); ?>">
                            <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" style="text-align:center; padding: 20px;">No records found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="currentSearch" value="<?php echo htmlspecialchars($search); ?>">
<input type="hidden" id="currentMaxRows" value="<?php echo $maxRows; ?>">

<script>
function changePage(newPage) {
    var search = $('#currentSearch').val();
    var maxRows = $('#currentMaxRows').val();
    
    $('#table-container').css('opacity', '0.5');
    
    $.ajax({
        url: 'load_all_group.php', // Ensure this matches the actual file name
        type: 'POST',
        data: {
            page: newPage,
            search: search,
            maxRows: maxRows
        },
        success: function(response) {
            // Replace 'group_table_wrapper' with the ID of the div wrapping this file on the main page
            $('#result').html(response); 
        },
        error: function() {
            alert('Error loading page.');
            $('#table-container').css('opacity', '1');
        }
    });
}

$(document).ready(function() {
// 1. Use Event Delegation: Faster memory management for tables with many rows
$(document).on('click', '.invks', function(e) {e.preventDefault();
const id = $(this).data('id');
const $modal = $("#updateModal");
const $profileContainer = $('#profile');
// 2. Open the modal immediately
$modal.modal('show');
//3. Set a Loading State inside the modal (Perceived Performance)
$profileContainer.html(`
<div class="d-flex flex-column align-items-center p-5">
<div class="spinner-border text-primary mb-3" role="status"></div>
<p class="text-muted">Loading client loan details...</p>
</div>`);
// 4. Optimized AJAX call
$.ajax({
 url: 'group_profile.php',
type: "GET",
data: {'id': id},
// Cache prevents re-downloading if the agent clicks the same row twice
cache: true, 
success: function(data) { 
// 5. Update content instantly without closing/reopening the modal
$profileContainer.hide().html(data).fadeIn(200);
},
error: function() {
$profileContainer.html(`
<div class="alert alert-danger m-3">
Failed to load loan details. Please check connection.
</div>`);
}
});
});
});
</script>