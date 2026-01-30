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

// Escape user input for SQL
$User_escaped = mysqli_real_escape_string($con, $User);
$search_escaped = mysqli_real_escape_string($con, $search);

// Build query based on conditions
$whereClause = "Status = 'Approved' AND User = '$User_escaped'";

if (!empty($search)) {
$whereClause .= " AND (BVN LIKE '%$search_escaped%' OR Firstname LIKE '%$search_escaped%' OR Middlename LIKE '%$search_escaped%' OR Lastname LIKE '%$search_escaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM register WHERE $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Firstname, Lastname, Middlename, Gender, Phone, Branch, BVN, Status, Date_Reg, Time_Reg, Officer_Name 
FROM register WHERE $whereClause ORDER BY id ASC";

if ($maxRows > 0) {
$dataQuery .= " LIMIT $maxRows";
} elseif (empty($search) && $maxRows == 0) {
$dataQuery .= " LIMIT 10";
}

$result = mysqli_query($con, $dataQuery) or die("Database query failed: " . mysqli_error($con));

// Fetch results
$results = array();
while($row = mysqli_fetch_assoc($result)) {
$results[] = $row; 
}

// Save to JSON file
$fp = fopen('../data/loan_applications.json', 'w'); 
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
<?php
if (empty($results)) {
?>
<tr>
<td colspan="12" style="text-align:center; font-size:10px">
<strong>No record found</strong>
</td>
</tr>
<?php
} else {
foreach ($results as $member) {
// Escape output for XSS protection
$bvn = htmlspecialchars($member['BVN']);
$firstname = htmlspecialchars($member['Firstname']);
$middlename = htmlspecialchars($member['Middlename']);
$lastname = htmlspecialchars($member['Lastname']);
$phone = htmlspecialchars($member['Phone']);
$gender = htmlspecialchars($member['Gender']);
$branch = htmlspecialchars($member['Branch']);
$officer = htmlspecialchars($member['Officer_Name']);
$status = htmlspecialchars($member['Status']);
$dateReg = htmlspecialchars($member['Date_Reg']);
$timeReg = htmlspecialchars($member['Time_Reg']);
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
<td><?php echo $bvn; ?></td>
<td style="text-transform:capitalize"><?php echo "$firstname $middlename $lastname"; ?></td>
<td><?php echo $phone; ?></td>
<td><?php echo $gender; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $officer; ?></td>
<td>
<span><?php echo $status; ?></span>
</td>
<td><?php echo $dateReg; ?></td>
<td><?php echo $timeReg; ?></td>
<td>
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $id; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php
}
}
?>
</tbody>
</table>
</div>

<script>
$(document).ready(function() {
    // 1. Use .off().on() with Event Delegation
    // This fixes the "Double Click" bug and ensures it works after pagination/search
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $profile = $('#profile');
        const $loader = $("#view"); // Assuming this is your spinner/overlay

        if(!id) {
            alert('Invalid ID');
            return;
        }

        // 2. Open modal immediately and show loading state
        // DO NOT hide the whole modal; just show a loader inside or over it
        $modal.modal('show');
        $loader.show(); 
        
        // Clear previous content so the user doesn't see old data
        $profile.html('<div class="text-center p-5"><div class="spinner-border text-primary"></div></div>');

        // 3. Optimized AJAX (No artificial 1000ms delay)
        $.ajax({
            url: 'create_loan_profile.php',
            type: "GET",
            data: {'id': id},
            cache: true,
            success: function(data) { 
                // 4. Update content instantly
                $loader.hide();
                $profile.hide().html(data).fadeIn(200);
            },
            error: function(xhr, status, error) {
                $loader.hide();
                $profile.html('<div class="alert alert-danger m-3">Error loading profile.</div>');
            }
        });
    });
});
</script>