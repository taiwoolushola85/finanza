<?php
include '../config/db.php';
include '../config/user_session.php';

// Fix 1: Sanitize and validate the branch parameter
$br = isset($_GET['br']) ? mysqli_real_escape_string($con, $_GET['br']) : '';

if (empty($br)) {
die("Invalid branch parameter");
}
?>


<div class="row">
<div class="col-sm-3">
<small><b>Total: 
<?php 
// Fix 2: Use prepared statements to prevent SQL injection
$stmt = mysqli_prepare($con, "SELECT COUNT(*) FROM repayments WHERE Branch = ? AND Total_Bal = '0'");
mysqli_stmt_bind_param($stmt, "s", $br);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $total);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
echo $total;
?>
</b></small>
</div>
</div>

<br>
<?php 
// Fix 3: Use prepared statements for the main query
$stmt = mysqli_prepare($con, "SELECT id, Reg_id, Branch, Loan_Account_No, Account_Number, Firstname, Middlename, Lastname, Product, Total_Loan, Paid, 
Expected_Amount, Total_Bal, Date_Disbursed, Status, Maturity_Date, Officer_Name FROM repayments WHERE Branch = ? AND Total_Bal = '0' ORDER BY Firstname ASC");
mysqli_stmt_bind_param($stmt, "s", $br);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$results = array();
while($row = mysqli_fetch_assoc($result)) {
$results[] = $row; 
}
mysqli_stmt_close($stmt);
mysqli_close($con);
// Fix 4: Secure file writing
$fp = fopen('../data/loan_audit.json', 'w'); 
if ($fp) {
fwrite($fp, json_encode($results)); 
fclose($fp);
}
?>

<div id="table-container" style="height:370px;">
<table>
<thead>
<tr>
<th style="font-size:8px">VIRTUAL ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">PRODUCT</th>
<th style="font-size:8px">LOAN AMT</th>
<th style="font-size:8px">PAID</th>
<th style="font-size:8px">BALANCE</th>
<th style="font-size:8px">EXPT AMT</th>
<th style="font-size:8px">CREDIT OFFICER</th>
<th style="font-size:8px">DATE DISBURSED</th>
<th style="font-size:8px">DATE MATURED</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php foreach($results as $member): ?>
<tr style="font-size:8px" class="invks" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo htmlspecialchars($member['id']); ?>">
<td><?php echo htmlspecialchars($member['Account_Number']); ?></td>
<td style="text-transform:uppercase">
<?php echo htmlspecialchars($member['Firstname'] . " " . $member['Middlename'] . " " . $member['Lastname']); ?>
</td>
<td><?php echo htmlspecialchars($member['Branch']); ?></td>
<td><?php echo htmlspecialchars($member['Product']); ?></td>
<td><?php echo number_format($member['Total_Loan'], 2); ?></td>
<td><?php echo number_format($member['Paid'], 2); ?></td>
<td><?php echo number_format($member['Total_Bal'], 2); ?></td>
<td><?php echo number_format($member['Expected_Amount'], 2); ?></td>
<td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
<td><?php echo !empty($member['Date_Disbursed']) ? date("d-M-Y", strtotime($member['Date_Disbursed'])) : 'N/A'; ?></td>
<td><?php echo !empty($member['Maturity_Date']) ? date("d-M-Y", strtotime($member['Maturity_Date'])) : 'N/A'; ?></td>
<td><i style='color:green'>Auditing</i></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>



<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm" style="display:none; width:1000px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" style="font-size:15px; text-transform:uppercase"> [ LOAN ACCOUNT INFO ]</h6>
<button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<div class="bd-example">
<i id="lds" style="display:none; font-size:12px">
<img src="loader.gif" style="height:15px"> Loading Data ! Please wait...
</i>
<div id="hey"></div>
<br>
</div>
</div>
</div>
</div>




<script>
// Fix 5: Secure AJAX implementation
$(document).ready(function() {
$('.invks').on('click', function() {
$("#updateModal").modal('hide');
$("#loader").show();
$("#hey").hide();
// Fix 6: Use data attribute instead of id for security
var id = $(this).data('id');
$.ajax({
url: 'load_acct.php',
type: "POST",
data: {'id': id},
dataType: "html",
success: function(data) { 
setTimeout(function() {
$("#loader").hide();
$("#updateModal").modal('show');
$("#hey").show();
$('#hey').html(data);
}, 1000);
},
error: function(xhr, status, error) {
$("#lds").hide();
$("#hey").show();
$('#hey').html('<p class="text-danger">Error loading data. Please try again.</p>');
}
});
});
});

// Fix 7: Properly escape PHP variable in JavaScript
function loads() {
$.ajax({
method: "GET",
url: "check_close_loan.php?br=" + encodeURIComponent("<?php echo addslashes($br); ?>"),
dataType: "html",
success: function(data) {
setTimeout(function() {
$('#result').html(data);
}, 1000);
},
error: function() {
console.error('Failed to load data');
}
});
}
</script>