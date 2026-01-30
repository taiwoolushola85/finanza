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
$baseWhere = "Team_Leader = '$User' AND Status != 'De-Activated'";

// Build query based on conditions
if (!empty($search)) {
$baseWhere .= " AND (Name LIKE '%$searchEscaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM groups WHERE $baseWhere";
$countResult = mysqli_query($con, $countQuery);
$countRow = mysqli_fetch_array($countResult);
$total = $countRow[0];

// Data query
$dataQuery = "SELECT id, Name, Branch, Officer_Name, Date_Register, Status FROM groups WHERE $baseWhere ORDER BY id ASC";

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
$fp = fopen('../data/group_list.json', 'w');
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
<th style="font-size:8px">ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">OFFICER NAME</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php if (count($results) > 0): ?>
    <?php foreach ($results as $member): ?>
        <tr style="font-size:8px">
            <td><?php echo htmlspecialchars($member['id']); ?></td>
            <td style="text-transform:capitalize">
                <?php echo htmlspecialchars($member['Name']); ?>
            </td>
            <td><?php echo htmlspecialchars($member['Branch']); ?></td>
            <td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
            <td>
                <span><?php echo htmlspecialchars($member['Status']); ?></span>
            </td>
            <td><?php echo htmlspecialchars($member['Date_Register']); ?></td>
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
        <td colspan="7" style="text-align:center; font-size:11px">
            <span>No record found</span>
        </td>
    </tr>
<?php endif; ?>
</tbody>

</table>
</div>




<script>
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
url: 'review_group_info.php',
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


<script type="text/javascript">
function load()  {
$.ajax({
method: "POST",
url: "load_group_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 