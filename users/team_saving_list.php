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
$whereClause .= " AND (Client_BVN LIKE '%$search_escaped%' OR Virtual_Account LIKE '%$search_escaped%' OR Loan_Account_No LIKE '%$search_escaped%' 
OR Disbursement_No LIKE '%$search_escaped%' OR Transaction_id LIKE '%$search_escaped%' OR Savings_Account_No LIKE '%$search_escaped%' 
OR Unions LIKE '%$search_escaped%' OR Firstname LIKE '%$search_escaped%' OR Middlename LIKE '%$search_escaped%' OR Lastname LIKE '%$search_escaped%')";
}

// Count query
$countQuery = "SELECT COUNT(*) FROM savings WHERE $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Virtual_Account, Client_BVN, Firstname, Lastname, Middlename, Loan_Account_No, Savings_Account_No, Status,
(SELECT COALESCE(SUM(Savings), 0) FROM save WHERE Saving_Account = Savings_Account_No  AND Status = 'Paid' ) AS `Savings_Paid`,
(SELECT COALESCE(SUM(Amount_Withdraw), 0) FROM withdraw WHERE Saving_Account_No = Savings_Account_No  AND Status = 'Paid' ) AS `withdraw`,
(SELECT COALESCE(SUM(Amount), 0) FROM saving_rep WHERE Saving_Account_No = Savings_Account_No  AND Status = 'Paid' ) AS `repayment`,
(SELECT COALESCE(SUM(Amount), 0) FROM transfers WHERE Saving_Account_No = Savings_Account_No  AND Status = 'Paid' ) AS `transfer`,
(SELECT COALESCE(SUM(Amount), 0) FROM saving_upfront WHERE Saving_Account_No = Savings_Account_No  AND Status = 'Paid' ) AS `upfront`
FROM savings WHERE $whereClause ORDER BY id ASC";

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
$fp = fopen('../data/saving_portfolio_list.json', 'w'); 
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
<th style="font-size:8px">BVN NO</th>
<th style="font-size:8px">SAVINGS ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">DEPOSIT</th>
<th style="font-size:8px">WITHDRAW</th>
<th style="font-size:8px">REPAYMENT</th>
<th style="font-size:8px">TRANSFER</th>
<th style="font-size:8px">UPFRONT</th>
<th style="font-size:8px">BALANCE</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DETAIL</th>
</tr>
</thead>
<tbody>
<?php
foreach($results as $member) {
// Escape output for XSS protection
$vrt = htmlspecialchars($member['Virtual_Account']);
$firstname = htmlspecialchars($member['Firstname']);
$middlename = htmlspecialchars($member['Middlename']);
$lastname = htmlspecialchars($member['Lastname']);
$bvn = htmlspecialchars($member['Client_BVN']);
$sav_acct = htmlspecialchars($member['Savings_Account_No']);
$Savings_Paid = htmlspecialchars($member['Savings_Paid']);
$withdraw = htmlspecialchars($member['withdraw']);
$repayment = htmlspecialchars($member['repayment']);
$transfer = htmlspecialchars($member['transfer']);
$upfront = htmlspecialchars($member['upfront']);
$status = htmlspecialchars($member['Status']);
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
<td><?php echo $bvn; ?></td>
<td><?php echo $sav_acct; ?></td>
<td style="text-transform:capitalize"><?php echo "$firstname $middlename $lastname"; ?></td>
<td><?php echo number_format($Savings_Paid,2); ?></td>
<td><?php echo number_format($withdraw,2); ?></td>
<td><?php echo number_format($repayment,2); ?></td>
<td><?php echo number_format($transfer,2); ?></td>
<td><?php echo number_format($upfront,2); ?></td>
<td><?php echo number_format($Savings_Paid - ($withdraw + $repayment + $transfer + $upfront),2); ?></td>
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
url: 'client_team_saving_page.php',
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



