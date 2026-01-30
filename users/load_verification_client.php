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

// Prepare base query with proper escaping
$searchEscaped = mysqli_real_escape_string($con, $search);
$baseWhere = "Status = 'Waiting For Verification' AND Branch = '$brss'";

// Build query based on conditions
if (!empty($search)) {
$baseWhere .= " AND (BVN LIKE '%$searchEscaped%' OR Firstname LIKE '%$searchEscaped%' OR Lastname LIKE '%$searchEscaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM register WHERE $baseWhere";
$countResult = mysqli_query($con, $countQuery);
$countRow = mysqli_fetch_array($countResult);
$total = $countRow[0];

// Data query
$dataQuery = "SELECT id, Firstname, Lastname, Middlename, Gender, Phone, Branch, BVN, Status, Date_Reg, Time_Reg, Officer_Name FROM register WHERE $baseWhere 
ORDER BY id ASC";

if ($maxRows > 0) {
$dataQuery .= " LIMIT $maxRows";
} elseif (empty($search) && $maxRows == 0) {
$dataQuery .= " LIMIT 10"; // Default limit
}

$result = mysqli_query($con, $dataQuery) or die("Database query failed: " . mysqli_error($con));

// Store results
$results = array();
while ($row = mysqli_fetch_assoc($result)) {
$results[] = $row;
}

// Save to JSON file
$fp = fopen('../data/loan_review.json', 'w');
fwrite($fp, json_encode($results));
fclose($fp);

mysqli_close($con);
?>

<small>
Total Record: <?php echo $total; ?>
</small>
<br><br>

<div id="table-container" style="height:330px;">
<table>
<thead>
<tr>
<th style="font-size:8px">BVN</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">GENDER</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">LOAN OFFICER</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">TIME</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php if (count($results) > 0): ?>
    <?php foreach ($results as $member): ?>
        <tr style="font-size:8px">
            <td><?php echo htmlspecialchars($member['BVN']); ?></td>
            <td style="text-transform:capitalize">
                <?php echo htmlspecialchars($member['Firstname'] . " " . $member['Middlename'] . " " . $member['Lastname']); ?>
            </td>
            <td><?php echo htmlspecialchars($member['Phone']); ?></td>
            <td><?php echo htmlspecialchars($member['Gender']); ?></td>
            <td><?php echo htmlspecialchars($member['Branch']); ?></td>
            <td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
            <td>
                <span><?php echo htmlspecialchars($member['Status']); ?></span>
            </td>
            <td><?php echo htmlspecialchars($member['Date_Reg']); ?></td>
            <td><?php echo htmlspecialchars($member['Time_Reg']); ?></td>
            <td>
                <a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal"
                   data-id="<?php echo htmlspecialchars($member['id']); ?>">
                    <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">
                        Details
                    </button>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="10" style="text-align:center; font-size:11px">
            <span>No record found</span>
        </td>
    </tr>
<?php endif; ?>
</tbody>

</table>
</div>





<script>
$(document).ready(function() {
    // 1. .off('click') "cleans the slate" before adding the listener.
    // This is the essential fix for the double-firing/blinking bug.
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Stops other scripts from interfering

        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $profileContainer = $('#profile');

        // 2. Open the modal immediately
        $modal.modal('show');

        // 3. Set Loading State with min-height to prevent modal "jumping"
        $profileContainer.html(`
            <div class="d-flex flex-column align-items-center justify-content-center p-5" style="min-height: 250px;">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted">Loading verification details...</p>
            </div>`);

        // 4. Optimized AJAX call
        $.ajax({
            url: 'review_verification.php',
            type: "GET",
            data: {'id': id},
            cache: true, 
            success: function(data) { 
                // 5. Inject content and fade in.
                // .stop(true, true) cancels active animations for a snappy feel.
                $profileContainer.stop(true, true).hide().html(data).fadeIn(200);
            },
            error: function() {
                $profileContainer.html(`
                    <div class="alert alert-danger m-3 text-center">
                        <b>Error:</b> Could not load verification profile.
                    </div>`);
            }
        });
    });
});
</script>