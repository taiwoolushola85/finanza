<?php
// Set CORS and Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

// 1. Inputs & Sanitization
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 10;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

if ($maxRows <= 0) $maxRows = 10;
if ($page < 1) $page = 1;

include '../config/db.php';
include '../config/user_session.php';

// 2. Build Search Filter
$whereClause = "Status = ?";
$params = ['Ready For Disbursement'];
$types = 's';

if (!empty($search)) {
    $whereClause .= " AND (BVN LIKE ? OR Phone LIKE ? OR Officer_Name LIKE ? OR CONCAT(Firstname, ' ', Middlename, ' ', Lastname) LIKE ?)";
    $searchParam = "%$search%";
    $params = array_merge($params, array_fill(0, 4, $searchParam));
    $types .= str_repeat('s', 4);
}

// 3. Get TOTAL count and payment stats
$countQuery = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN Upfront_Status = 'Paid' THEN 1 ELSE 0 END) as total_paid,
    SUM(CASE WHEN Upfront_Status != 'Paid' OR Upfront_Status IS NULL THEN 1 ELSE 0 END) as total_unpaid
    FROM register WHERE $whereClause";

$countStmt = mysqli_prepare($con, $countQuery);
mysqli_stmt_bind_param($countStmt, $types, ...$params);
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$counts = mysqli_fetch_assoc($countResult);

$total = $counts['total'] ?? 0;
$totalPaid = $counts['total_paid'] ?? 0;
$totalUnpaid = $counts['total_unpaid'] ?? 0;
mysqli_stmt_close($countStmt);

// 4. Pagination math
$totalPages = ceil($total / $maxRows);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
$offset = ($page - 1) * $maxRows;

// 5. Data query with LIMIT/OFFSET
$dataQuery = "SELECT id, CONCAT(Firstname, ' ', Middlename, ' ', Lastname) as Full_Name, 
Gender, Phone, Product, Loan_Amount, Tenure, Upfront_Types,
Frequency, Branch, BVN, Upfront_Status, Status, Date_Reg, Time_Reg, Officer_Name 
FROM register WHERE $whereClause ORDER BY id ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$results = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Save results to JSON
file_put_contents('../data/loan_disbursement_list.json', json_encode($results));
mysqli_close($con);

// Calculate display range
$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div class="row">
<div class="col-sm-8">
<small><strong>Total: <?php echo number_format($total); ?></strong></small> | 
<small style="color: green;"><strong>Paid: <?php echo number_format($totalPaid); ?></strong></small> | 
<small style="color: red;"><strong>Waiting: <?php echo number_format($totalUnpaid); ?></strong></small>
</div>
<div class="col-sm-4">
<div style="display:flex; justify-content: flex-end; align-items: center; margin-bottom: 10px;">
    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 5px;">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(1)" <?php echo ($page <= 1) ? 'disabled' : ''; ?> style="font-size: 10px;">&laquo; First</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?php echo $page - 1; ?>)" <?php echo ($page <= 1) ? 'disabled' : ''; ?> style="font-size: 10px;">Prev</button>
        
        <span style="font-size: 11px; padding: 0 5px; align-self: center;">Page <strong><?php echo $page; ?></strong>/<?php echo $totalPages; ?></span>
        
        <button type="button" class="btn btn-sm btn-primary" onclick="changePage(<?php echo $page + 1; ?>)" <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?> style="font-size: 10px;">Next &rsaquo;</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?php echo $totalPages; ?>)" <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?> style="font-size: 10px;">Last &raquo;</button>
    </div>
    <?php endif; ?>
</div>

</div>
</div>



<div id="table-container" style="height:360px; overflow-y:auto;">
    <table>
        <thead>
            <tr style="font-size:8px">
                <th>BVN</th>
                <th>NAME</th>
                <th>PHONE</th>
                <th>GENDER</th>
                <th>PRODUCT</th>
                <th>TENURE</th>
                <th>FREQUENCY</th>
                <th>AMOUNT</th>
                <th>BRANCH</th>
                <th>OFFICER</th>
                <th>UPFRONT</th>
                <th>STATUS</th>
                <th>DATE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach($results as $member): ?>
                    <tr style="font-size:8px">
                        <td><?php echo htmlspecialchars($member['BVN']); ?></td>
                        <td style="text-transform:capitalize"><span><?php echo htmlspecialchars($member['Full_Name']); ?></span></td>
                        <td><?php echo htmlspecialchars($member['Phone']); ?></td>
                        <td><?php echo htmlspecialchars($member['Gender']); ?></td>
                        <td><?php echo htmlspecialchars($member['Product']); ?></td>
                        <td><?php echo htmlspecialchars($member['Tenure']); ?></td>
                        <td><?php echo htmlspecialchars($member['Frequency']); ?></td>
                        <td><?php echo number_format($member['Loan_Amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($member['Branch']); ?></td>
                        <td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
                        <td>
<?php 
if($member['Upfront_Status'] === 'Paid' && $member['Upfront_Types'] === 'Virtual Payment') {
echo "<b style='color:green'>Payment Confirmed</b>";
}else if($member['Upfront_Status'] === 'Paid' && $member['Upfront_Types']  === 'Monie Point Payment') {
echo "<b style='color:green'>Payment Confirmed</b>";
}else if($member['Upfront_Status'] === 'Paid' && $member['Upfront_Types'] === 'Saving For Upfront') {
echo "<b style='color:green'>Payment Confirmed</b>";
}else if($member['Upfront_Status'] != 'Paid' && $member['Upfront_Types'] === 'Deduction') {
echo "<b style='color:orange'>Upfront Deduction</b>";
} else {
echo "<b style='color:red'>Waiting For Confirmation</b>";
}
?>
</td>
                        <td><span><?php echo htmlspecialchars($member['Status']); ?></span></td>
                        <td><?php echo htmlspecialchars($member['Date_Reg']); ?></td>
                        <td>
                            <a class="invks" href="#" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $member['id']; ?>">
                                <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="14" style="text-align:center; padding: 20px;">No records found</td></tr>
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
        url: 'load_disbursement_list.php', // Ensure this matches your file name
        type: 'POST',
        data: {
            page: newPage,
            search: search,
            maxRows: maxRows
        },
        success: function(response) {
            // TARGET: The div on your main page wrapping this file
            $('#result').html(response); 
        }
    });
}


$(document).ready(function() {
    // 1. Kill any existing click listeners before adding a new one.
    // This is the #1 fix for double-firing AJAX requests and blinking modals.
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Ensures no other script intercepts this click

        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $profile = $('#profile');

        // 2. Determine and Open the modal
        $modal.modal('show'); 

        // 3. Set a loading state with a min-height.
        // This prevents the modal from shrinking to zero height while waiting.
        $profile.html(`
            <div class="text-center p-5" style="min-height: 250px;">
                <div class="spinner-border text-success" role="status"></div>
                <p class="mt-2 text-muted">Preparing disbursement data...</p>
            </div>
        `);

        // 4. Optimized AJAX call
        $.ajax({
            url: 'client_loan_disbursement_page.php',
            type: "GET",
            data: {'id': id},
            cache: true, 
            success: function(data) { 
                // 5. Inject data. .stop(true, true) ensures smooth transitions 
                // if the user clicks between rows quickly.
                $profile.stop(true, true).hide().html(data).fadeIn(250);
            },
            error: function() {
                $profile.html(`
                    <div class="alert alert-danger m-3 text-center">
                        <b>Error:</b> Could not load disbursement details.
                    </div>`);
            }
        });
    });
});
</script>