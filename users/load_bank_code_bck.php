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

// 2. Build WHERE clause
$whereClause = "";
$params = [];
$types = "";

if (!empty($search)) {
    $whereClause = " WHERE Bank_Name LIKE ?";
    $params[] = "%$search%";
    $types = "s";
}

// 3. Get Total Record Count
$countQuery = "SELECT COUNT(*) FROM bank" . $whereClause;
$countStmt = mysqli_prepare($con, $countQuery);
if (!empty($search)) {
    mysqli_stmt_bind_param($countStmt, $types, ...$params);
}
mysqli_stmt_execute($countStmt);
$total = mysqli_stmt_get_result($countStmt)->fetch_row()[0];
mysqli_stmt_close($countStmt);

// 4. Pagination Math
$totalPages = ceil($total / $maxRows);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
$offset = ($page - 1) * $maxRows;

// 5. Data Query
$dataQuery = "SELECT id, Bank_Name, Date_Created, Time_Created FROM bank " . $whereClause . " ORDER BY Bank_Name ASC LIMIT ? OFFSET ?";
$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$results = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Save to JSON
file_put_contents('../data/bank_lists.json', json_encode($results));

mysqli_close($con);

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>
<br>
<br>
<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <small>
        <strong>Total Banks: <?= number_format($total) ?></strong> 
        | Showing: <?= $startRecord ?>-<?= $endRecord ?>
    </small>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 3px;">
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeBankPage(1)" <?= ($page <= 1) ? 'disabled' : '' ?> >Next</button>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeBankPage(<?= $page - 1 ?>)" <?= ($page <= 1) ? 'disabled' : '' ?> >Prev</button>
        <span style="font-size: 10px; align-self: center; padding: 0 5px;">Pg <?= $page ?>/<?= $totalPages ?></span>
        <button type="button" class="btn btn-xs btn-primary" onclick="changeBankPage(<?= $page + 1 ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?>>Next</button>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeBankPage(<?= $totalPages ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> >Prev</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="overflow:auto; height:240px;">
    <table>
        <thead>
            <tr style="font-size:8px">
                <th>ID</th>
                <th>BANK</th>
                <th>DATE</th>
                <th>TIME</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach($results as $member): ?>
                <tr style="font-size:8px">
                    <td><?= htmlspecialchars($member['id']) ?></td>
                    <td style="text-transform:capitalize"><span><?= htmlspecialchars($member['Bank_Name']) ?></span></td>
                    <td><?= htmlspecialchars($member['Date_Created']) ?></td>
                    <td><?= htmlspecialchars($member['Time_Created']) ?></td>
                    <td>
                        <a class="invks" href="#!" data-id="<?= $member['id'] ?>" style="color:red;">
                            <i class="fa fa-trash"></i> Remove
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center p-3">No banks found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="bankSearch" value="<?= htmlspecialchars($search) ?>">
<input type="hidden" id="bankMaxRows" value="<?= $maxRows ?>">

<script>
function changeBankPage(newPage) {
    var search = $('#bankSearch').val();
    var maxRows = $('#bankMaxRows').val();
    
    $('#table-container').css('opacity', '0.5');
    
    $.ajax({
        url: 'load_bank_code_bck.php',
        type: 'POST',
        data: { page: newPage, search: search, maxRows: maxRows },
        success: function(response) {
            $('#result').html(response); 
        }
    });
}

$(document).ready(function() {
    $('.invks').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if(confirm("You are about to remove this bank record from the database?")) {
            $.ajax({
                url: 'delete_bank_record.php',
                type: "GET",
                data: {'id': id},
                success: function(data) { 
                    if(data == 1){
                        changeBankPage(<?= $page ?>); // Refresh current page
                    } else {
                        alert("Error: " + data);
                    }
                }
            });
        }
    });
});
</script>