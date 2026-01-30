<?php
// Sanitize and validate inputs
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 0;

// Set CORS headers at the top
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");

include '../config/db.php';
include '../config/user_session.php';

// Build WHERE clause with prepared statement
$whereClause = " WHERE Team_Leader = ? AND (Status = 'Ready For Underwriting' OR Status = 'Ready For Disbursement')";
$params = array($User);
$types = "s";

if (!empty($search)) {
    $whereClause .= " AND (BVN LIKE ? OR Firstname LIKE ? OR Middlename LIKE ? OR Lastname LIKE ?)";
    $searchParam = "%$search%";
    $params = array_merge($params, [$searchParam, $searchParam, $searchParam, $searchParam]);
    $types .= "ssss";
}

// Count query with prepared statement
$countQuery = "SELECT COUNT(*) FROM register" . $whereClause;
$countStmt = mysqli_prepare($con, $countQuery);
mysqli_stmt_bind_param($countStmt, $types, ...$params);
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$row = mysqli_fetch_array($countResult);
$total = $row[0];
mysqli_stmt_close($countStmt);

// Data query with prepared statement
$dataQuery = "SELECT id, Firstname, Lastname, Middlename, Gender, Phone, Branch, BVN, Status, Date_Reg, Time_Reg, Officer_Name, Virtual_Account
FROM register" . $whereClause . " ORDER BY id ASC";

// Create separate params array for data query
$dataParams = $params;
$dataTypes = $types;

if ($maxRows > 0) {
    $dataQuery .= " LIMIT ?";
    $dataParams[] = $maxRows;
    $dataTypes .= "i";
}

$dataStmt = mysqli_prepare($con, $dataQuery);
mysqli_stmt_bind_param($dataStmt, $dataTypes, ...$dataParams);
mysqli_stmt_execute($dataStmt);
$result = mysqli_stmt_get_result($dataStmt);

// Fetch results
$results = array();
while($row = mysqli_fetch_assoc($result)) {
    $results[] = $row; 
}

mysqli_stmt_close($dataStmt);

// Save to JSON file with error handling
$jsonData = json_encode($results);
if ($jsonData !== false) {
    $fp = fopen('../data/application_tracker_list.json', 'w');
    if ($fp) {
        fwrite($fp, $jsonData);
        fclose($fp);
    }
}

mysqli_close($con);
?>

<small>
Total Record: <?php echo htmlspecialchars($total); ?>
</small>
<br><br>
<div id="table-container" style="overflow:auto; height:330px;">
<table>
<thead>
<tr>
<th style="font-size:8px">VIRTUAL ACCOUNT</th>
<th style="font-size:8px">BVN</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">GENDER</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">LOAN OFFICER</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DEPARTMENT</th>
<th style="font-size:8px">STAGE</th>
<th style="font-size:8px">PROGRESS</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">TIME</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php if (empty($results)): ?>
    <tr>
        <td colspan="20" style="text-align:center; font-size:11px">
            <span>No record found</span>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($results as $member): 
        // Escape output for XSS protection
        $vrt = htmlspecialchars($member['Virtual_Account'] ?? '');
        $bvn = htmlspecialchars($member['BVN'] ?? '');
        $firstname = htmlspecialchars($member['Firstname'] ?? '');
        $middlename = htmlspecialchars($member['Middlename'] ?? '');
        $lastname = htmlspecialchars($member['Lastname'] ?? '');
        $phone = htmlspecialchars($member['Phone'] ?? '');
        $gender = htmlspecialchars($member['Gender'] ?? '');
        $branch = htmlspecialchars($member['Branch'] ?? '');
        $officer = htmlspecialchars($member['Officer_Name'] ?? '');
        $status = htmlspecialchars($member['Status'] ?? '');
        $dateReg = htmlspecialchars($member['Date_Reg'] ?? '');
        $timeReg = htmlspecialchars($member['Time_Reg'] ?? '');
        $id = (int)$member['id'];
        
        // Status badge
        $badgeClass = 'badge-soft-success';
        if ($status == 'Under Review') {
            $badgeClass = 'badge-soft-info';
        } elseif ($status == 'Declined') {
            $badgeClass = 'badge-soft-danger';
        }
    ?>
    <tr style="font-size:8px">
        <td><?= $vrt ?></td>
        <td><?= $bvn ?></td>
        <td style="text-transform:capitalize"><?= trim("$firstname $middlename $lastname") ?></td>
        <td><?= $phone ?></td>
        <td><?= $gender ?></td>
        <td><?= $branch ?></td>
        <td><?= $officer ?></td>
        <td>
            <?php 
            switch($status) {
                case 'Under Review':
                    echo "Verification Officer";
                    break;
                case 'Approved':
                    echo "Credit Officer";
                    break;
                case 'Waiting For Verification':
                    echo "Verification Officer";
                    break;
                case 'Ready For Review':
                    echo "Underwriter";
                    break;
                case 'Pending':
                    echo "Team Lead";
                    break;
                case 'Ready For Underwriting':
                    echo "Underwriter";
                    break;
                case 'Ready For Disbursement':
                    echo "Head Of Risk";
                    break;
                default:
                    echo $status;
            }
            ?>
        </td>
        <td>
            <?php 
            switch($status) {
                case 'Under Review':
                    echo "Stage 1 of 7";
                    break;
                case 'Approved':
                    echo "Stage 2 of 7";
                    break;
                case 'Waiting For Verification':
                    echo "Stage 3 of 7";
                    break;
                case 'Ready For Review':
                    echo "Stage 4 of 7";
                    break;
                case 'Pending':
                    echo "Stage 5 of 7";
                    break;
                case 'Ready For Underwriting':
                    echo "Stage 6 of 7";
                    break;
                case 'Ready For Disbursement':
                    echo "Stage 7 of 7";
                    break;
                default:
                    echo $status;
            }
            ?>
        </td>
        <td>          
            <?php 
            $progressWidth = 0;
            switch($status) {
                case 'Under Review':
                    $progressWidth = 14;
                    break;
                case 'Approved':
                    $progressWidth = 28;
                    break;
                case 'Waiting For Verification':
                    $progressWidth = 42;
                    break;
                case 'Ready For Review':
                    $progressWidth = 56;
                    break;
                case 'Pending':
                    $progressWidth = 70;
                    break;
                case 'Ready For Underwriting':
                    $progressWidth = 84;
                    break;
                case 'Ready For Disbursement':
                    $progressWidth = 100;
                    break;
                default:
                    $progressWidth = 100;
            }
            ?>
            <div class='progress progress-sm bg-primary-subtle'>
                <div class='progress-bar bg-primary' style='width:<?= $progressWidth ?>%;'></div>
            </div>
        </td>
        <td>
            <span class='<?= $badgeClass ?>'><?= $status ?></span>
        </td>
        <td><?= $dateReg ?></td>
        <td><?= $timeReg ?></td>
        <td>
            <a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?= $id ?>">
                <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
</div>



<script>
$(document).ready(function() {
    // 1. .off('click') clears any previous bindings. 
    // This is the absolute fix for multiple triggers during AJAX pagination.
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Prevents other scripts from "fighting" for this click

        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $profileContainer = $('#profile');

        // 2. Open the modal immediately
        $modal.modal('show');

        // 3. Set a Loading State with min-height to prevent the modal from "collapsing"
        $profileContainer.html(`
            <div class="d-flex flex-column align-items-center justify-content-center p-5" style="min-height: 250px;">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted">Loading client loan details...</p>
            </div>`);

        // 4. Optimized AJAX call
        $.ajax({
            url: 'app_loan_profile.php',
            type: "GET",
            data: {'id': id},
            cache: true, 
            success: function(data) { 
                // 5. Inject content and fade in. 
                // .stop(true, true) kills any pending animations for a snappy feel.
                $profileContainer.stop(true, true).hide().html(data).fadeIn(200);
            },
            error: function() {
                $profileContainer.html(`
                    <div class="alert alert-danger m-3 text-center">
                        <b>Error:</b> Could not load profile. Please check your network.
                    </div>`);
            }
        });
    });
});
</script>