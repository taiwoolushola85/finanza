<?php
include '../config/db.php';

$lon = $_GET['acct'] ?? '';

$stmt = $con->prepare("SELECT * FROM repayments WHERE Loan_Account_No = ? AND Status = 'Active'");
$stmt->bind_param("s", $lon);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
echo '<div class="card border-0 shadow-sm">
<div class="card-body text-center text-muted">🚫 Record not found</div>
</div>';
exit;
}

$row = $result->fetch_assoc();
$repid = $row['id'];
$fullname = ucwords($row['Firstname'].' '.$row['Lastname']);

// Loan history
$hist = $con->prepare(
"SELECT * FROM repayments WHERE id = ? ORDER BY Date_Disbursed ASC"
);
$hist->bind_param("i", $repid);
$hist->execute();
$history = $hist->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="row g-4">
<!-- LEFT CONTENT -->
<div class="col-lg-9">
<!-- PROFILE CARD -->
<div class="row align-items-center">
<div class="col-md-3 text-center">
<img src="<?= $row['Location']; ?>" class="rounded-circle mb-2" width="120" height="120">
<h5 class="mb-0"><?= $fullname; ?></h5>
<span class="badge bg-info mt-1"><?= $row['Status']; ?></span>
</div>
<div class="col-md-9">
<h6 class="fw-bold text-primary mb-3">ACCOUNT INFORMATION</h6>
<div class="row small">
<div class="col-md-6 mb-2"><b>Loan Account:</b> <?= $row['Loan_Account_No']; ?></div>
<div class="col-md-6 mb-2"><b>Disbursement No:</b> <?= $row['Disbursement_No']; ?></div>
<div class="col-md-6 mb-2"><b>Phone:</b> <?= $row['Phone']; ?></div>
<div class="col-md-6 mb-2"><b>Branch:</b> <?= $row['Branch']; ?></div>
<div class="col-md-6 mb-2"><b>Product:</b> <?= $row['Product']; ?></div>
<div class="col-md-6 mb-2"><b>Frequency:</b> <?= $row['Frequency']; ?></div>
<div class="col-md-6 mb-2"><b>Principal:</b> <?= number_format($row['Loan_Amount'],2); ?></div>
<div class="col-md-6 mb-2"><b>Total Loan:</b> <?= number_format($row['Total_Loan'],2); ?></div>
<div class="col-md-6 mb-2"><b>Paid:</b> <?= number_format($row['Paid'],2); ?></div>
<div class="col-md-6 mb-2"><b>Outstanding:</b> <?= number_format($row['Total_Bal'],2); ?></div>
<div class="col-md-6 mb-2"><b>Disbursed:</b> <?= date("d M Y", strtotime($row['Date_Disbursed'])); ?></div>
<div class="col-md-6 mb-2"><b>Maturity:</b> <?= date("d M Y", strtotime($row['Maturity_Date'])); ?></div>
</div>
</div>
</div>

<!-- LOAN HISTORY -->
<br>
<span style="margin-left: 10px;"><i class="fa fa-history"> Loan History</i></span>
<br><br>
<div id="table-container" style="height:180px;">
<table>
<thead class="table-light">
<tr style="font-size:8px;">
<th>Account</th>
<th>Product</th>
<th>Amount</th>
<th>Paid</th>
<th>Balance</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php foreach ($history as $h): ?>
<tr>
<td><?= $h['Loan_Account_No']; ?></td>
<td><?= $h['Product']; ?></td>
<td><?= number_format($h['Total_Loan'],2); ?></td>
<td><?= number_format($h['Paid'],2); ?></td>
<td><?= number_format($h['Total_Bal'],2); ?></td>
<td><?= date("d M Y", strtotime($h['Date_Disbursed'])); ?></td>
<td><span class="badge <?= $h['Status']=='Active'?'bg-info':'bg-success'; ?>">
<?= $h['Status']; ?>
</span>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<!-- RIGHT SIDEBAR -->
<div class="col-lg-3">
<h6 class="fw-bold text-primary mb-3">LOAN EXTENSION</h6>
<form id="uploadExt">
<input type="hidden" name="id" value="<?= $row['id']; ?>">
<input type="hidden" name="fr" value="<?= $row['Frequency']; ?>">
<input type="hidden" name="ten" value="<?= $row['Duration']; ?>">
<label class="small mb-1"><span style="color: red;">*</span> Frequency</label>
<select name="fr" class="form-control form-control-sm mb-3" required>
<option value="">Select Option</option>
<option value="Daily">Daily</option>
<option value="Weekly">Weekly</option>
<option value="Monthly">Monthly</option>
</select>
<label><span style="color: red;">*</span> Reason for Extension </label>
<select class="form-control form-control-sm mb-3" name="reason" required>
<option value="">Select reason</option>
<option value="Financial Hardship">Financial Hardship</option>
<option value="Medical Emergency">Medical Emergency</option>
<option value="Job Loss/Change">Job Loss/Change</option>
<option value="Business Issues">Business Issues</option>
<option value="Other">Other</option>
</select>
<label class="small mb-1"><span style="color: red;">*</span> New Due Date</label>
<input type="date" name="due" value="<?php echo $row['Maturity_Date']; ?>" class="form-control form-control-sm mb-3"  required>
<label><span style="color: red;">*</span> Additional Details</label>
<textarea class="form-control form-control-sm mb-3" name="detail" cols="8" rows="7" 
placeholder="Please provide more details about customer situation..." required></textarea>
<button class="btn btn-success btn-sm w-100">Extend Loan</button>
</form>
</div>
</div>




<script type="text/javascript">
function loadDa()  {
// ajax function start here to load table data
$.ajax({
method: "POST",
url: "loan_customer_loan_profile.php?acct=<?php echo $lon; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$("#result").html(data);
}, 1000);
}
});
}
</script> 



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadExt").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to extend this customer loan..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "extension.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){ 
$("#uploadExt")[0].reset(); 
if (data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
loadDa()
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
} else {
$("#please").hide();
alert ("🚫 " + data)
$("#uploadExt")[0].reset();
}
},
error: function(){
}
});
}
}));
});
</script>

