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
    $whereClause .= " AND (Staff_Name LIKE ? OR Branches LIKE ? OR User_Role LIKE ?)";
    $searchParam = "%$search%";
    $params = [$searchParam, $searchParam, $searchParam];
    $types = "sss";
}

// 3. Get Total Record Count
$countQuery = "SELECT COUNT(*) FROM zone_mapping WHERE $whereClause";
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
$dataQuery = "SELECT id, Staff_Name, User_Role, Branches, Countrys, Date_Mapped, Status 
              FROM zone_mapping WHERE $whereClause 
              ORDER BY id ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$stmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt)->fetch_all(MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Save to JSON
file_put_contents('../data/zone_mapping_list.json', json_encode($results));

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 10px;;">
    <small>
        <strong>Mapped Records: <?= number_format($total) ?></strong>
        <?php if (!empty($search)): ?> | <span style="color: #007bff;">Filter: "<?= htmlspecialchars($search) ?>"</span><?php endif; ?>
        | Showing: <?= $startRecord ?>-<?= $endRecord ?>
    </small>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 3px;">
        <button type="button" class="btn btn-xs btn-outline-info" onclick="changeZonePage(1)" <?= ($page <= 1) ? 'disabled' : '' ?> >Next</button>
        <button type="button" class="btn btn-xs btn-outline-inf" onclick="changeZonePage(<?= $page - 1 ?>)" <?= ($page <= 1) ? 'disabled' : '' ?> >Prev</button>
        <span style="font-size: 10px; align-self: center; padding: 0 5px;">Page <b><?= $page ?></b>/<?= $totalPages ?></span>
        <button type="button" class="btn btn-xs btn-primary" onclick="changeZonePage(<?= $page + 1 ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?>>Next</button>
        <button type="button" class="btn btn-xs btn-outline-info" onclick="changeZonePage(<?= $totalPages ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> >Prev</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="height:330px; overflow-y:auto;">
    <table>
        <thead >
            <tr style="font-size:8px">
                <th>NAME</th>
                <th>BRANCH</th>
                <th>ROLE</th>
                <th>COUNTRY</th>
                <th>STATUS</th>
                <th>DATE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach($results as $member): 
                    $status = htmlspecialchars($member['Status']);
                    $badgeClass = ($status == 'Mapped' || $status == 'Active') ? 'badge-soft-success' : 'badge-soft-danger';
                ?>
                <tr style="font-size:8px">
                    <td style="text-transform:uppercase"><span><?= htmlspecialchars($member['Staff_Name']) ?></span></td>
                    <td><?= htmlspecialchars($member['Branches']) ?></td>
                    <td><?= htmlspecialchars($member['User_Role']) ?></td>
                    <td><?= htmlspecialchars($member['Countrys']) ?></td>
                    <td><span class="<?= $badgeClass ?>"><?= $status ?></span></td>
                    <td><?= htmlspecialchars($member['Date_Mapped']) ?></td>
                    <td>
                        <a class="inv_del" href="#!" data-id="<?= $member['id'] ?>">    
                            <button class="btn btn-outline-danger btn-sm" style="font-size:8px;"><i class="fa fa-trash"></i></button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align:center; padding:20px; font-size:10px;">No mapping records found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="zoneSearch" value="<?= htmlspecialchars($search) ?>">
<input type="hidden" id="zoneMaxRows" value="<?= $maxRows ?>">

<script>
function changeZonePage(newPage) {
    var search = $('#zoneSearch').val();
    var maxRows = $('#zoneMaxRows').val();
    
    $('#table-container').css('opacity', '0.5');
    
    $.ajax({
        url: 'zone_list.php',
        type: 'POST',
        data: { page: newPage, search: search, maxRows: maxRows },
        success: function(response) {
            $('#result').html(response); 
        }
    });
}

$(document).ready(function() {
    // Delete handling
    $('.inv_del').off('click').on('click', function(e) {
        e.preventDefault();
        if(confirm("You are about to delete this zoning record. Proceed?")) {
            var id = $(this).data('id');
            $.ajax({
                url: 'delete_zone.php',
                type: "GET",
                data: {'id': id},
                success: function(data) { 
                    if(data == 1) {
                        loads(); // Assuming loads() is your global refresh function
                    } else {
                        alert("Error: " + data);
                    }
                }
            });
        }
    });
});
</script>