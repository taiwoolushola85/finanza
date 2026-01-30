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

// 2. Build WHERE clause with Prepared Statements
$whereClause = "Status = 'Mapped'";
$params = [];
$types = "";

if (!empty($search)) {
    $whereClause .= " AND (Officer_Name LIKE ? OR Branch LIKE ? OR Team_Name LIKE ?)";
    $searchParam = "%$search%";
    $params = [$searchParam, $searchParam, $searchParam];
    $types = "sss";
}

// 3. Get Total Record Count
$countQuery = "SELECT COUNT(*) FROM mapping WHERE $whereClause";
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

// 5. Data Query
$dataQuery = "SELECT id, Officer_Name, Team_Name, Branch, Status, Date_Mapped 
              FROM mapping WHERE $whereClause 
              ORDER BY id ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt)->fetch_all(MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Save to JSON for sync
file_put_contents('../data/user_mapping_list.json', json_encode($results));

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <small style="font-size: 10px;">
        <strong>Total Mappings: <?= number_format($total) ?></strong> 
        | Showing: <?= $startRecord ?>-<?= $endRecord ?>
    </small>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 3px;">
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeMappingPage(1)" <?= ($page <= 1) ? 'disabled' : '' ?> >Next</button>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeMappingPage(<?= $page - 1 ?>)" <?= ($page <= 1) ? 'disabled' : '' ?> >Prev</button>
        <span style="font-size: 10px; align-self: center; padding: 0 5px;">Page <?= $page ?>/<?= $totalPages ?></span>
        <button type="button" class="btn btn-xs btn-primary" onclick="changeMappingPage(<?= $page + 1 ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> >Next</button>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="changeMappingPage(<?= $totalPages ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?>>Prev</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="height:330px; overflow-y:auto;">
    <table>
        <thead >
            <tr>
                <th style="font-size:8px">NAME</th>
                <th style="font-size:8px">BRANCH</th>
                <th style="font-size:8px">TEAM NAME</th>
                <th style="font-size:8px">STATUS</th>
                <th style="font-size:8px">DATE</th>
                <th style="font-size:8px">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach($results as $member): ?>
                <tr style="font-size:8px">
                    <td><?= htmlspecialchars($member['Officer_Name']) ?></td>
                    <td><?= htmlspecialchars($member['Branch']) ?></td>
                    <td><?= htmlspecialchars($member['Team_Name']) ?></td>
                    <td><span><?= htmlspecialchars($member['Status']) ?></span></td>
                    <td><?= htmlspecialchars($member['Date_Mapped']) ?></td>
                    <td>
                        <a class="inv-del" href="#!" data-id="<?= (int)$member['id']; ?>">    
                            <button class="btn btn-outline-danger btn-sm" style="font-size:8px;"><i class="fa fa-trash"></i></button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center; font-size:10px; padding:20px;">No mapping records found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="mapSearch" value="<?= htmlspecialchars($search) ?>">
<input type="hidden" id="mapMaxRows" value="<?= $maxRows ?>">

<script>
function changeMappingPage(newPage) {
    var search = $('#mapSearch').val();
    var maxRows = $('#mapMaxRows').val();
    
    $('#table-container').css('opacity', '0.5');
    
    $.ajax({
        url: 'mapping_user.php',
        type: 'POST',
        data: { page: newPage, search: search, maxRows: maxRows },
        success: function(response) {
            $('#result').html(response); 
        }
    });
}

$(document).ready(function() {
    $('.inv-del').off('click').on('click', function(e) {
        e.preventDefault();
        if(confirm("You are about to delete this mapping record. Proceed?")) {
            var id = $(this).data('id');
            $.ajax({
                url: 'delete_mapping.php',
                type: "GET",
                data: {'id': id},
                success: function(data) { 
                    if(data == 1){
                        // Refresh the list after deletion
                        changeMappingPage(<?= $page ?>); 
                    } else {
                        alert("Error: " + data);
                    }
                }
            });
        }
    });
});
</script>