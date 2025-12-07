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
$search_escaped = mysqli_real_escape_string($con, $search);

// Build query based on conditions
$whereClause = "";
if (!empty($search)) {
$whereClause = "WHERE (Name LIKE '%$search_escaped%' OR Staff_ID LIKE '%$search_escaped%')";
}

// Count query (without LIMIT or ORDER BY)
$countQuery = "SELECT COUNT(*) FROM users $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query - IMPORTANT: Never select raw passwords in production!
// Consider hashing passwords and not displaying them
$dataQuery = "SELECT id, Staff_ID, Name, Branch, User_Group, Email, Username, Location, Status  FROM users $whereClause ORDER BY Name ASC";

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
$fp = fopen('../data/users_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);

mysqli_close($con);
?>

<small>
Total Record: <?php echo $total; ?>
</small>
<br><br>

<div id="table-container" style="height:430px;">
<table>
<thead>
<tr>
<th style="font-size:8px">STAFF ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">ROLE</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">USERNAME</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
foreach($results as $member) {
// Escape output for XSS protection
$id = (int)$member['id'];
$staffId = htmlspecialchars($member['Staff_ID']);
$name = htmlspecialchars($member['Name']);
$userGroup = htmlspecialchars($member['User_Group']);
$email = htmlspecialchars($member['Email']);
$branch = htmlspecialchars($member['Branch']);
$username = htmlspecialchars($member['Username']);
$status = htmlspecialchars($member['Status']);
?>
<tr style="font-size:8px">
<td><?php echo $staffId; ?></td>
<td style="text-transform:capitalize"><?php echo $name; ?></td>
<td><?php echo $userGroup; ?></td>
<td><?php echo $email; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $username; ?></td>
<td><?php echo $status; ?></td>
<td>
<a href="view_user.php?id=<?php echo $id; ?>" class="btn btn-sm btn-outline-primary" style="font-size:7px">
<i class="fa fa-eye"></i> View
</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>

<style>
/* Optional: Add hover effect for better UX */
#table-container tbody tr {
transition: background-color 0.2s;
}
#table-container tbody tr:hover {
background-color: rgba(0, 123, 255, 0.1);
cursor: pointer;
}
</style>

<script>
// Make rows clickable (alternative to inline onclick)
$(document).ready(function() {
$('#table-container tbody tr').on('click', function(e) {
// Don't navigate if clicking on a link
if (!$(e.target).closest('a').length) {
var userId = $(this).find('a').attr('href');
if (userId) {
window.location.href = userId;
}
}
});
});
</script>