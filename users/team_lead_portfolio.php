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
$whereClause = "Status != 'Cancelled' AND Team_Leader = '$User'";

if (!empty($search)) {
$whereClause .= " AND (BVN LIKE '%$search_escaped%' OR Account_Number LIKE '%$search_escaped%' OR Loan_Account_No LIKE '%$search_escaped%' 
OR Disbursement_No LIKE '%$search_escaped%' OR Transaction_id LIKE '%$search_escaped%' OR Savings_Account_No LIKE '%$search_escaped%' 
OR Unions LIKE '%$search_escaped%' OR Firstname LIKE '%$search_escaped%' OR Middlename LIKE '%$search_escaped%' OR Lastname LIKE '%$search_escaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM repayments WHERE $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Account_Number, Firstname, Lastname, Middlename, Product, Branch, Total_Loan, Paid, Maturity_Status, Expected_Amount,
Date_Disbursed, Maturity_Date, Status, Total_Bal FROM repayments WHERE $whereClause ORDER BY id ASC";

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
$fp = fopen('../data/team_portfolio_list.json', 'w'); 
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
<th style="font-size:8px">VIRTUAL ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">PRODUCT</th>
<th style="font-size:8px">TOTAL LOAN</th>
<th style="font-size:8px">PAID</th>
<th style="font-size:8px">OUTSTANDING</th>
<th style="font-size:8px">EXPECTED AMT</th>
<th style="font-size:8px">DATE DISBURSED</th>
<th style="font-size:8px">DATE EXPIRED</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DETAIL</th>
</tr>
</thead>
<tbody>
<?php
foreach($results as $member) {
// Escape output for XSS protection
$vrt = htmlspecialchars($member['Account_Number']);
$firstname = htmlspecialchars($member['Firstname']);
$middlename = htmlspecialchars($member['Middlename']);
$lastname = htmlspecialchars($member['Lastname']);
$branch = htmlspecialchars($member['Branch']);
$product = htmlspecialchars($member['Product']);
$totalloan = htmlspecialchars($member['Total_Loan']);
$paid = htmlspecialchars($member['Paid']);
$exp = htmlspecialchars($member['Expected_Amount']);
$totalbal = htmlspecialchars($member['Total_Bal']);
$datedisburse = htmlspecialchars($member['Date_Disbursed']);
$maturitydate = htmlspecialchars($member['Maturity_Date']);
$status = htmlspecialchars($member['Maturity_Status']);
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
<td><?php echo $vrt; ?></td>
<td style="text-transform:capitalize"><?php echo "$firstname $middlename $lastname"; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $product; ?></td>
<td><?php echo number_format($totalloan,2); ?></td>
<td><?php echo number_format($paid,2); ?></td>
<td><?php echo number_format($totalbal,2); ?></td>
<td><?php echo number_format($exp,2); ?></td>
<td><?php echo $datedisburse; ?></td>
<td><?php echo $maturitydate; ?></td>
<td>
<span class=''><?php echo $status; ?></span>
</td>
<td>
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $id; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
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
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'client_loan_page.php',
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
$("#view").hide();
}
});
} else {
alert('Invalid ID');
$("#view").hide();
}
});
});
</script>



