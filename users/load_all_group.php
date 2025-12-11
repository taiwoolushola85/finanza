<?php
// Secure input handling
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$role = isset($_POST['role']) ? trim($_POST['role']) : '';
$branch = isset($_POST['branch']) ? trim($_POST['branch']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 10;

// Validate maxRows
if ($maxRows <= 0) {
$maxRows = 10;
}

include '../config/db.php';
include '../config/user_session.php';

// Prepare search condition using prepared statements
$searchCondition = '';
$params = [];
$types = '';

if (!empty($search)) {
$searchCondition = " WHERE Name LIKE ? OR Officer_Name LIKE ?";
$searchParam = "%{$search}%";
$params = [$searchParam, $searchParam];
$types = 'ss';
}

// Get total count
$countQuery = "SELECT COUNT(*) as total FROM groups" . $searchCondition;
$stmt = mysqli_prepare($con, $countQuery);

if (!empty($params)) {
mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$countResult = mysqli_stmt_get_result($stmt);
$totalRow = mysqli_fetch_assoc($countResult);
$total = $totalRow['total'];
mysqli_stmt_close($stmt);

// Get data with limit
$limit = empty($search) && empty($_POST['maxRows']) ? 10 : $maxRows;
$dataQuery = "SELECT id, Name, Branch, Officer_Name, Team_Name, Date_Register, Status 
FROM groups" . $searchCondition . " ORDER BY Name ASC LIMIT ?";

$stmt = mysqli_prepare($con, $dataQuery);
if (!empty($params)) {
$params[] = $limit;
$types .= 'i';
mysqli_stmt_bind_param($stmt, $types, ...$params);
} else {
mysqli_stmt_bind_param($stmt, 'i', $limit);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$results = [];
while ($row = mysqli_fetch_assoc($result)) {
$results[] = $row;
}

mysqli_stmt_close($stmt);
mysqli_close($con);

// Save to JSON file
$fp = fopen('../data/all_group_list.json', 'w');
fwrite($fp, json_encode($results));
fclose($fp);
?>

<small>Total Record: <?php echo htmlspecialchars($total); ?></small>
<br><br>


<div  id="table-container" style="height:350px;">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">CREDIT OFFICER</th>
<th style="font-size:8px">TEAM LEAD</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php foreach ($results as $member): ?>
<tr style="font-size:8px">
<td><?php echo htmlspecialchars($member['id']); ?></td>
<td style="text-transform:capitalize">
<?php echo htmlspecialchars($member['Name']); ?>
</td>
<td><?php echo htmlspecialchars($member['Branch']); ?></td>
<td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
<td><?php echo htmlspecialchars($member['Team_Name']); ?></td>
<td><?php echo htmlspecialchars($member['Date_Register']); ?></td>
<td><?php echo htmlspecialchars($member['Status']); ?></td>
<td>
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo htmlspecialchars($member['id']); ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<script>
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');
if (id) {
$.ajax({
url: 'group_profile.php',
type: "GET",
data: {'id': id},
success: function(data) { 
setTimeout(function() {
$("#updateModal").show();
$("#view").hide();
$('#profile').html(data);
}, 1000);
},
error: function(xhr, status, error) {
alert('Error loading profile: ' + error);
}
});
} else {
alert('Invalid ID');
}
});
});
</script>