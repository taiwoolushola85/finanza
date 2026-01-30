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
$whereClause = "Upfront_Status IS NULL AND Status = ? AND Upfront_Types IN (?, ?, ?)";
$params = ['Ready For Disbursement', 'Monie Point Payment', 'Virtual Payment', 'Saving For Upfront'];
$types = 'ssss';

if (!empty($search)) {
    $whereClause .= " AND (BVN LIKE ? OR Phone LIKE ? OR Officer_Name LIKE ? OR CONCAT(Firstname, ' ', Middlename, ' ', Lastname) LIKE ?)";
    $searchParam = "%$search%";
    $params = array_merge($params, array_fill(0, 4, $searchParam));
    $types .= 'ssss';
}

// 3. Get Total Record Count for Pagination
$countQuery = "SELECT COUNT(*) as total FROM register WHERE $whereClause";
$countStmt = mysqli_prepare($con, $countQuery);
mysqli_stmt_bind_param($countStmt, $types, ...$params);
mysqli_stmt_execute($countStmt);
$total = mysqli_stmt_get_result($countStmt)->fetch_assoc()['total'];
mysqli_stmt_close($countStmt);

// 4. Pagination Mathematics
$totalPages = ceil($total / $maxRows);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
$offset = ($page - 1) * $maxRows;

// 5. Data Query with LIMIT and OFFSET
$dataQuery = "SELECT id, CONCAT(Firstname, ' ', Middlename, ' ', Lastname) as Full_Name, 
Gender, Phone, Product, Loan_Amount, Branch, BVN, Upfront_Types, Upfront_Status, Date_Reg, Time_Reg, Officer_Name 
FROM register WHERE $whereClause ORDER BY id ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt)->fetch_all(MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Save to JSON for external tracking
file_put_contents('../data/upfront_payment_list.json', json_encode($results, JSON_PRETTY_PRINT));

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
<small style="font-weight: bold;">
Total Records: <?= number_format($total) ?> | Showing: <?= $startRecord ?>-<?= $endRecord ?>
</small>

<?php if ($totalPages > 1): ?>
<div style="display: flex; gap: 5px;">
<button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeUpfrontPage(1)" <?= ($page <= 1) ? 'disabled' : '' ?> style="font-size: 10px;">First</button>
<button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeUpfrontPage(<?= $page - 1 ?>)" <?= ($page <= 1) ? 'disabled' : '' ?> style="font-size: 10px;">Prev</button>
<span style="font-size: 11px; align-self: center; padding: 0 5px;">Page <b><?= $page ?></b> of <?= $totalPages ?></span>
<button type="button" class="btn btn-sm btn-primary" onclick="changeUpfrontPage(<?= $page + 1 ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> style="font-size: 10px;">Next</button>
<button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeUpfrontPage(<?= $totalPages ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> style="font-size: 10px;">Last</button>
</div>
<?php endif; ?>
</div>

<div id="table-container" style="height:350px; overflow-y:auto;">
<table>
<thead >
<tr style="font-size:8px">
<th>BVN</th>
<th>NAME</th>
<th>PHONE</th>
<th>GENDER</th>
<th>PRODUCT</th>
<th>LOAN AMOUNT</th>
<th>BRANCH</th>
<th>LOAN OFFICER</th>
<th>UPFRONT MODE</th>
<th>STATUS</th>
<th>DATE</th>
<th>TIME</th>
<th>ACTION</th>
</tr>
</thead>
<tbody>
<?php if (!empty($results)): ?>
<?php foreach($results as $member): ?>
<tr style="font-size:8px">
<td><?= htmlspecialchars($member['BVN']) ?></td>
<td style="text-transform:capitalize"><?= htmlspecialchars($member['Full_Name']) ?></td>
<td><?= htmlspecialchars($member['Phone']) ?></td>
<td><?= htmlspecialchars($member['Gender']) ?></td>
<td><?= htmlspecialchars($member['Product']) ?></td>
<td><?= number_format($member['Loan_Amount'], 2) ?></td>
<td><?= htmlspecialchars($member['Branch']) ?></td>
<td><?= htmlspecialchars($member['Officer_Name']) ?></td>
<td><?= htmlspecialchars($member['Upfront_Types']) ?></td>
<td><span style="color:red"><?= htmlspecialchars($member['Upfront_Status'] ?? 'Waiting For Confirmation') ?></span></td>
<td><?= htmlspecialchars($member['Date_Reg']) ?></td>
<td><?= htmlspecialchars($member['Time_Reg']) ?></td>
<td>
<a class="invks" href="#" role="button" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?= $member['id'] ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="13" class="text-center p-4">No upfront records found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>

<input type="hidden" id="currentSearch" value="<?= htmlspecialchars($search) ?>">
<input type="hidden" id="currentMaxRows" value="<?= $maxRows ?>">

<script>
function changeUpfrontPage(newPage) {
var search = $('#currentSearch').val();
var maxRows = $('#currentMaxRows').val();
$('#table-container').css('opacity', '0.5');
$.ajax({
url: 'load_upfront_list.php',
type: 'POST',
data: { page: newPage, search: search, maxRows: maxRows },
success: function(response) {
$('#result').html(response); 
}
});
}


$(document).ready(function() {
    // 1. Use .off() to kill any existing listeners before attaching a new one.
    // This is the absolute fix for multiple triggers when using AJAX pagination.
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Prevents other scripts from "fighting" for this click

        const id = $(this).data('id');
        const $profileContainer = $('#profile');
        const $updateModal = $("#updateModal");

        // 2. Open the modal immediately
        $updateModal.modal('show');

        // 3. Set a Loading State with min-height to prevent layout collapsing
        $profileContainer.html(`
            <div class="text-center p-5" style="min-height: 250px;">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted font-weight-bold">Loading client profile...</p>
            </div>`);

        // 4. Optimized AJAX Call
        $.ajax({
            url: 'client_upfront_page.php',
            type: "GET",
            data: { 'id': id },
            cache: true, 
            success: function(data) { 
                // 5. Inject data. .stop(true, true) ensures smooth transitions 
                // if the user clicks between rows quickly.
                $profileContainer.stop(true, true).hide().html(data).fadeIn(200);
            },
            error: function() {
                $profileContainer.html(`
                    <div class="alert alert-danger m-3 text-center">
                        <b>Error:</b> Could not retrieve upfront data.
                    </div>`);
            }
        });
    });
});
</script>