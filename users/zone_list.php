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
$whereClause = "Status = 'Mapped'";

if (!empty($search)) {
$whereClause .= " AND (Staff_Name LIKE '%$search_escaped%' OR Branches LIKE '%$search_escaped%' OR User_Role LIKE '%$search_escaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM zone_mapping WHERE $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Staff_Name, User_Role, Branches, Countrys, Date_Mapped, Status FROM zone_mapping WHERE $whereClause ORDER BY id ASC";

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
$fp = fopen('../data/zone_mapping_list.json', 'w'); 
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
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">ROLE</th>
<th style="font-size:8px">COUNTRY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
if (!empty($results)) {
    foreach($results as $member) {
        // Escape output for XSS protection
        $staff = htmlspecialchars($member['Staff_Name']);
        $branch = htmlspecialchars($member['Branches']);
        $role = htmlspecialchars($member['User_Role']);
        $country = htmlspecialchars($member['Countrys']);
        $status = htmlspecialchars($member['Status']);
        $date = htmlspecialchars($member['Date_Mapped']);
        $id = (int)$member['id'];

        // Status badge
        $badgeClass = 'badge-soft-success';
        if ($status == 'Active') {
            $badgeClass = 'badge-soft-info';
        } elseif ($status == 'Cancelled') {
            $badgeClass = 'badge-soft-danger';
        }
        ?>
        <tr style="font-size:8px">
            <td><?php echo $staff; ?></td>
            <td><?php echo $branch; ?></td>
            <td><?php echo $role; ?></td>
            <td><?php echo $country; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $date; ?></td>
            <td>
                <a class="inv" href="#!" data-id="<?php echo $id; ?>">    
                    <button class="btn btn-outline-primary btn-sm" style="font-size:8px;"><i class="fa fa-trash"></i></button>
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    // Show no records message
    ?>
    <tr>
        <td colspan="7" style="text-align:center; font-size:8px;">No record found</td>
    </tr>
    <?php
}
?>
</tbody>
</table>
</div>


<script>
// Display data in modal
$(document).ready(function() {
$('.inv').on('click', function(e) {e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete zoning record from database?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'delete_zone.php',
type: "GET",
data: {'id': id},
success: function(data) { 
if(data == 1){
setTimeout(function() {
loads();
}, 1000);
}else{
alert("Erroe" + data)
}
},
error: function(xhr, status, error) {
alert('Error deleting record: ' + error);
}
});
} else {
alert('Invalid ID');
}
}
});
});
</script>



