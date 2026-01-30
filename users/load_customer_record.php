<?php
// 1. Inputs & Sanitization
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 10;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

if ($maxRows <= 0) $maxRows = 10;
if ($page < 1) $page = 1;

include '../config/db.php';
include '../config/user_session.php';

// 2. Build WHERE clause
$whereClause = "";
$params = array();
$types = "";

if (!empty($search)) {
$whereClause = " WHERE (BVN LIKE ? OR Virtual_Account LIKE ? OR Phone LIKE ? OR CONCAT(Firstname, ' ', Middlename, ' ', Lastname) LIKE ? 
OR CONCAT(Firstname, ' ', Lastname) LIKE ? OR Branch LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?)";
$searchParam = "%$search%";
$params = array_fill(0, 9, $searchParam);
$types = str_repeat('s', 9);
}

// 3. Get TOTAL count for pagination
$countQuery = "SELECT COUNT(*) FROM register" . $whereClause;
$countStmt = mysqli_prepare($con, $countQuery);
if (!empty($search)) {
mysqli_stmt_bind_param($countStmt, $types, ...$params);
}
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$total = mysqli_fetch_array($countResult)[0];
mysqli_stmt_close($countStmt);

// 4. Pagination math
$totalPages = ceil($total / $maxRows);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
$offset = ($page - 1) * $maxRows;

// 5. Data query (LIMIT and OFFSET now work with search)
$dataQuery = "SELECT DISTINCT id, Virtual_Account, BVN, Firstname, Lastname, Middlename, Phone, Gender, Branch, Officer_Name, Status
FROM register" . $whereClause . " ORDER BY Firstname ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$dataStmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($dataStmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($dataStmt);
$result = mysqli_stmt_get_result($dataStmt);
$results = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($dataStmt);

// Optional: Save to JSON
file_put_contents('../data/customer_record.json', json_encode($results));
mysqli_close($con);

// Calculate display range
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

<div id="table-container" style="overflow:auto; height:360px">
<table>
<thead>
<tr style="font-size:8px">
<th>VIRTUAL ACCT</th>
<th>BVN NO</th>
<th>NAME</th>
<th>PHONE NO</th>
<th>GENDER</th>
<th>BRANCH</th>
<th>LOAN OFFICER</th>
<th>STATUS</th>
<th>DETAIL</th>
</tr>
</thead>
<tbody>
<?php if (!empty($results)): ?>
<?php foreach ($results as $member): ?>
<tr style="font-size:8px">
<td><?php echo htmlspecialchars($member['Virtual_Account']); ?></td>
<td><?php echo htmlspecialchars($member['BVN']); ?></td>
<td style="text-transform:capitalize"><span><?php echo htmlspecialchars($member['Firstname']." ".$member['Lastname']); ?></span></td>
<td><?php echo htmlspecialchars($member['Phone']); ?></td>
<td><?php echo htmlspecialchars($member['Gender']); ?></td>
<td><?php echo htmlspecialchars($member['Branch']); ?></td>
<td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
<td><?php echo htmlspecialchars($member['Status']); ?></td>
<td>
<a class="invks" href="#" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $member['id']; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="10" style="text-align:center; color:#999; padding:20px;">No records found</td></tr>
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
url: 'load_customer_record.php', // Ensure this matches the file name
type: 'POST',
data: {
page: newPage,
search: search,
maxRows: maxRows
},
success: function(response) {
// Replace 'customer_table_wrapper' with your actual outer container ID
$('#result').html(response); 
}
});
}



$(document).ready(function() {
    // 1. Event Delegation: Use one listener for all current and future buttons
    $(document).on('click', '.invks', function(e) {
        e.preventDefault();
        
        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $profile = $('#profile');

        // 2. Open the modal immediately
        $modal.modal('show');

        // 3. Show a Loading Spinner inside the modal (Improves perceived speed)
        $profile.html(`
            <div class="d-flex flex-column align-items-center p-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Fetching account details...</p>
            </div>
        `);

        // 4. Optimized AJAX call
        $.ajax({
            url: 'client_profile_page.php',
            type: "GET",
            data: {'id': id},
            cache: true, // Speeds up repeat clicks
            success: function(data) { 
                // 5. Update content instantly without closing/reopening the modal
                $profile.hide().html(data).fadeIn(200);
            },
            error: function() {
                $profile.html('<div class="alert alert-danger">Error: Could not load data.</div>');
            }
        });
    });
});
</script>