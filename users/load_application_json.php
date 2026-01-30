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
$whereClause = "Status != 'Disbursed' AND Status != 'Cancelled' AND Status != 'Loan Closed' AND Status != 'Ready For Auditing' AND User = '$User_escaped'";

if (!empty($search)) {
$whereClause .= " AND (BVN LIKE '%$search_escaped%' OR Firstname LIKE '%$search_escaped%' OR Middlename LIKE '%$search_escaped%' OR Lastname LIKE '%$search_escaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM register WHERE $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Virtual_Account, Firstname, Lastname, Middlename, Gender, Phone, Branch, BVN, Status, Date_Reg, Time_Reg, Officer_Name, Loan_Amount 
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
$fp = fopen('../data/loan_application_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);

mysqli_close($con);
?>

<small>
Total Record: <?php echo $total; ?>
</small>
<br><br>
<div id="table-container" style="height:350px;">
<table>
<thead>
<tr>
<th style="font-size:8px">VIRTUAL ACCOUNT</th>
<th style="font-size:8px">BVN</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PHONE</th>
<th style="font-size:8px">GENDER</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">PRINCIPAL AMT</th>
<th style="font-size:8px">LOAN OFFICER</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">TIME</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<tbody>
<?php
if (empty($results)) {
?>
<tr>
<td colspan="20" style="text-align:center; font-size:10px; padding:9px;">
<strong>No record found</strong>
</td>
</tr>
<?php
} else {
foreach ($results as $member) {
// Escape output for XSS protection
$vrt = htmlspecialchars($member['Virtual_Account']);
$bvn = htmlspecialchars($member['BVN']);
$firstname = htmlspecialchars($member['Firstname']);
$middlename = htmlspecialchars($member['Middlename']);
$lastname = htmlspecialchars($member['Lastname']);
$phone = htmlspecialchars($member['Phone']);
$gender = htmlspecialchars($member['Gender']);
$branch = htmlspecialchars($member['Branch']);
$prin = number_format(htmlspecialchars($member['Loan_Amount']),2);
$officer = htmlspecialchars($member['Officer_Name']);
$status = htmlspecialchars($member['Status']);
$dateReg = htmlspecialchars($member['Date_Reg']);
$timeReg = htmlspecialchars($member['Time_Reg']);
$id = (int)$member['id'];
?>
<tr style="font-size:8px">
<td><?php echo $vrt; ?></td>
<td><?php echo $bvn; ?></td>
<td style="text-transform:capitalize"><?php echo "$firstname $middlename $lastname"; ?></td>
<td><?php echo $phone; ?></td>
<td><?php echo $gender; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $prin; ?></td>
<td><?php echo $officer; ?></td>
<td><span><?php echo $status; ?></span></td>
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
    // 1. .off('click') clears any previous bindings before adding a new one.
    // This is the absolute fix for multiple triggers during AJAX pagination.
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Prevents other scripts from intercepting this click

        const id = $(this).data('id');
        const $profileContainer = $('#profile');
        const $updateModal = $("#updateModal");

        if (!id) {
            console.error('Invalid ID provided');
            return;
        }

        // 2. Open modal and set loading state
        $updateModal.modal('show'); 
        
        $profileContainer.html(`
            <div class="text-center p-5" style="min-height: 200px;">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Fetching profile...</p>
            </div>
        `);

        // 3. Execute AJAX
        $.ajax({
            url: 'application_loan_profile.php',
            type: "GET",
            data: {'id': id},
            cache: true,
            success: function(data) { 
                // 4. Update content. Removed .hide().fadeIn() to prevent layout blinking
                $profileContainer.html(data);
            },
            error: function(xhr, status, error) {
                $profileContainer.html(`
                    <div class="alert alert-danger m-3 text-center">
                        Error loading profile. Please try again.
                    </div>
                `);
            }
        });
    });
});
</script>