<?php
// Set CORS and Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

include '../config/db.php';
include '../config/user_session.php';

// 1. Inputs & Sanitization
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 12;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

if ($maxRows <= 0) $maxRows = 12;
if ($page < 1) $page = 1;

// 2. Build WHERE clause
$whereClause = "";
$params = array();
$types = "";

if (!empty($search)) {
    $whereClause = " WHERE (BVN LIKE ? OR Virtual_Account LIKE ? OR Phone LIKE ? OR Branch LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?)";
    $searchParam = "%$search%";
    $params = array_fill(0, 7, $searchParam);
    $types = str_repeat('s', 7);
}

// 3. Get Total Record Count
$countQuery = "SELECT COUNT(*) FROM register" . $whereClause;
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
$dataQuery = "SELECT DISTINCT id, Virtual_Account, BVN, Firstname, Lastname, Middlename, Phone, Gender, Branch, Officer_Name, Status
FROM register" . $whereClause . " ORDER BY Firstname ASC LIMIT ? OFFSET ?";

$dataParams = array_merge($params, [$maxRows, $offset]);
$dataTypes = $types . "ii";

$dataStmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($dataStmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($dataStmt);
$results = mysqli_stmt_get_result($dataStmt)->fetch_all(MYSQLI_ASSOC);
mysqli_stmt_close($dataStmt);

// Save to JSON
file_put_contents('../data/disbursement_tracking_record.json', json_encode($results));

// Row Color Function
function getStageColor($status) {
    $colors = [
        'Under Review' => '#ffffff',
        'Approved' => 'yellow',
        'Waiting For Verification' => 'pink',
        'Ready For Review' => '#e2e3e5',
        'Pending' => '#f8d7',
        'Ready For Underwriting' => '#cfe2ff',
        'Ready For Disbursement' => '#d1e7dd'
    ];
    return $colors[$status] ?? '#ffffff';
}

$startRecord = ($total > 0) ? ($offset + 1) : 0;
$endRecord = min($offset + $maxRows, $total);
?>

<div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <small>
        <strong>Total Records: <?= number_format($total) ?></strong>
        <?php if (!empty($search)): ?> | <span style="color: #28a745;">Search: "<?= htmlspecialchars($search) ?>"</span><?php endif; ?>
        <span style="color: #17a2b8;"> | Showing: <?= $startRecord ?>-<?= $endRecord ?></span>
    </small>

    <?php if ($totalPages > 1): ?>
    <div style="display: flex; gap: 5px;">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(1)" <?= ($page <= 1) ? 'disabled' : '' ?> style="font-size: 10px;">First</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?= $page - 1 ?>)" <?= ($page <= 1) ? 'disabled' : '' ?> style="font-size: 10px;">Prev</button>
        <span style="font-size: 11px; align-self: center; padding: 0 5px;">Page <b><?= $page ?></b> of <?= $totalPages ?></span>
        <button type="button" class="btn btn-sm btn-primary" onclick="changePage(<?= $page + 1 ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> style="font-size: 10px;">Next</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changePage(<?= $totalPages ?>)" <?= ($page >= $totalPages) ? 'disabled' : '' ?> style="font-size: 10px;">Last</button>
    </div>
    <?php endif; ?>
</div>

<div id="table-container" style="overflow:auto; height:330px;">
    <table >
        <thead >
            <tr style="font-size:8px">
                <th>VIRTUAL ACCT</th>
                <th>BVN NO</th>
                <th>NAME</th>
                <th>PHONE NO</th>
                <th>GENDER</th>
                <th>BRANCH</th>
                <th>LOAN OFFICER</th>
                <th>DEPARTMENT</th>
                <th>STAGE</th>
                <th style="width: 100px;">PROGRESS</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $member): 
                    $status = $member['Status'];
                    $rowColor = getStageColor($status);
                    
                    // Logic for Dept/Stage/Progress
                    $dept = "N/A"; $stage = "N/A"; $progress = 0;
                    switch($status) {
                        case 'Under Review': $dept = "Verification Officer"; $stage = "Stage 1 of 7"; $progress = 14; break;
                        case 'Approved': $dept = "Credit Officer"; $stage = "Stage 2 of 7"; $progress = 28; break;
                        case 'Waiting For Verification': $dept = "Verification Officer"; $stage = "Stage 3 of 7"; $progress = 42; break;
                        case 'Ready For Review': $dept = "Underwriter"; $stage = "Stage 4 of 7"; $progress = 56; break;
                        case 'Pending': $dept = "Team Lead"; $stage = "Stage 5 of 7"; $progress = 70; break;
                        case 'Ready For Underwriting': $dept = "Underwriter"; $stage = "Stage 6 of 7"; $progress = 84; break;
                        case 'Ready For Auditing': $dept = "Internal Control"; $stage = "Stage 6 of 7"; $progress = 90; break;
                        case 'Ready For Disbursement': $dept = "Head Of Risk"; $stage = "Stage 7 of 7"; $progress = 100; break;
                        default: $dept = $status; $stage = "N/A"; $progress = 0;
                    }
                ?>
                <tr style="font-size:8px; background-color: <?= $rowColor ?>;">
                    <td><?= htmlspecialchars($member['Virtual_Account']) ?></td>
                    <td><?= htmlspecialchars($member['BVN']) ?></td>
                    <td style="text-transform:capitalize"><span><?= trim($member['Firstname']." ".$member['Middlename']." ".$member['Lastname']) ?></span></td>
                    <td><?= htmlspecialchars($member['Phone']) ?></td>
                    <td><?= htmlspecialchars($member['Gender']) ?></td>
                    <td><?= htmlspecialchars($member['Branch']) ?></td>
                    <td><?= htmlspecialchars($member['Officer_Name']) ?></td>
                    <td><?= $dept ?></td>
                    <td><?= $stage ?></td>
                    <td>
                        <div class='progress' style='height: 8px;'>
                            <div class='progress-bar bg-primary' style='width:<?= $progress ?>%;'></div>
                        </div>
                    </td>
                    <td><span><?= $status ?></span></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="20" style="text-align:center; padding:20px;">No tracking records found.</td></tr>
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
        url: 'load_disbursement.php',
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
</script>