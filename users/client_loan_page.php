<?php 
include '../config/db.php';

// Validate and sanitize ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die('<div class="alert alert-danger">Invalid ID provided</div>');
}

// Fetch repayment info using prepared statement
$stmt = mysqli_prepare($con, "SELECT * FROM repayments WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$reprow = mysqli_fetch_array($result);
mysqli_stmt_close($stmt);

if (!$reprow) {
    die('<div class="alert alert-danger">Repayment record not found</div>');
}

$repid = $reprow['id'];
$bvn = $reprow['BVN'];
$regid = $reprow['Reg_id'];

// Fetch client info
$stmt = mysqli_prepare($con, "SELECT * FROM register WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $regid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);
mysqli_stmt_close($stmt);

$biz = $row['Biz_Type'] ?? '';

// Fetch guarantor info
$stmt = mysqli_prepare($con, "SELECT * FROM gaurantors WHERE Regis_id = ?");
mysqli_stmt_bind_param($stmt, "i", $regid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rows = mysqli_fetch_array($result);
mysqli_stmt_close($stmt);

$gid = $rows['id'] ?? 0;
$gb = $rows['Gaurantor_BVN'] ?? '';

// Fetch payment history
$stmt = mysqli_prepare($con, "SELECT * FROM history WHERE Repayment_id = ? ORDER BY Date_Paid DESC");
mysqli_stmt_bind_param($stmt, "i", $repid);
mysqli_stmt_execute($stmt);
$paymentResult = mysqli_stmt_get_result($stmt);
$payments = mysqli_fetch_all($paymentResult, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Fetch loan history
$stmt = mysqli_prepare($con, "SELECT * FROM repayments WHERE Reg_id = ? ORDER BY Date_Disbursed DESC");
mysqli_stmt_bind_param($stmt, "i", $regid);
mysqli_stmt_execute($stmt);
$loanResult = mysqli_stmt_get_result($stmt);
$loans = mysqli_fetch_all($loanResult, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Calculate totals
$totalPrincipal = (float)($reprow['Total_Loan'] ?? 0);
$totalPaid = (float)($reprow['Paid'] ?? 0);
$outstanding = (float)($reprow['Total_Bal'] ?? 0);
$interestAmount = $totalPrincipal > 0 ? ($totalPrincipal - (float)($reprow['Loan_Amount'] ?? 0)) : 0;

// Calculate percentages
$paidPercentage = $totalPrincipal > 0 ? ($totalPaid / $totalPrincipal * 100) : 0;
$outstandingPercentage = $totalPrincipal > 0 ? ($outstanding / $totalPrincipal * 100) : 0;

mysqli_close($con);
?>

<style>
.client-profile-img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border: 3px solid #dee2e6;
}
.stat-card {
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.info-label {
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 5px;
}
.info-value {
    font-size: 1.1rem;
    color: #212529;
}
</style>

<div class="row">
<div class="col-sm-3">
<br>
<center>
<img src="<?php echo htmlspecialchars($row['Location'] ?? 'default-avatar.png', ENT_QUOTES, 'UTF-8'); ?>" 
class="rounded-circle client-profile-img" alt="Client Photo"><br><br>
<h4><b style="text-transform:capitalize">
<?php echo htmlspecialchars($row['Firstname']." ".$row['Middlename'], ENT_QUOTES, 'UTF-8'); ?><br>
<?php echo htmlspecialchars($row['Lastname'], ENT_QUOTES, 'UTF-8'); ?>
</b></h4><br>
<p class="text-secondary mb-1">[ <?php echo htmlspecialchars($reprow['Status'], ENT_QUOTES, 'UTF-8'); ?> ]</p><br>
<button class="btn btn-outline-success btn-sm w-100" style="font-size: 12px; margin-top:5px" onclick="customerInfo()">
<i class="fa fa-server"></i> Dashboard
</button>
<button class="btn btn-outline-info btn-sm w-100" style="font-size: 12px; margin-top:5px" onclick="customerLoan()">
<i class="fa fa-history"></i> Loan History
</button>
<button class="btn btn-outline-warning btn-sm w-100" style="font-size: 12px; margin-top:5px" onclick="customerGua()">
<i class="fa fa-user"></i> Client Info
</button>
<button class="btn btn-outline-primary btn-sm w-100" style="font-size: 12px; margin-top:5px" onclick="customerBiz()">
<i class="fa fa-file"></i> Documents & Business Gallery
</button>
</center>
</div>

<div class="col-sm-9">

<!-- DASHBOARD SECTION -->
<div id="dashboard" style="display:block;">

<div class="row">
<div class="col-sm-4">
<h6><i class="fa fa-home"></i> DASHBOARD</h6>
</div>
<div class="col-sm-8">
<div style="overflow-x: auto;">
<div class="btn-group">
<button class="btn btn-light" onclick="clientDash()"><i class="fa fa-home"></i> Home</button>
<button class="btn btn-light" onclick="updateHis()"><i class="fa fa-list"></i> Payment History</button>
<button class="btn btn-light" onclick="updateCrc()"><i class="fa fa-exclamation-triangle"></i> Write-Off</button>
<button class="btn btn-light" onclick="updateComment()"><i class="fa fa-comment"></i> Comment</button>
</div>
</div>
</div>
</div>

<!-- HOME TAB -->
<div id="dash" style="display:block;">
<br>
<br>
<div class="row">
<div class="col-sm-4">
<span><b>Loan Account:</b> <?php echo $reprow['Loan_Account_No']; ?></span>
</div>
<div class="col-sm-4">
<span><b>Disbursement No:</b> <?php echo $reprow['Disbursement_No']; ?></span>
</div>
<div class="col-sm-4">
<span><b>Virtual Account:</b> <?php echo $reprow['Account_Number']; ?></span>
</div>
</div>


<br><br>
<div id="mydivs">
<div class="row">
<div class="col-sm-6 mb-3">
<div class="card stat-card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center p-3">
<div>
<h5 class="mb-2 fw-semibold text-primary">Principal Amount</h5>
<h2 class="fw-normal my-2"><?php echo number_format($totalPrincipal, 2); ?></h2>
</div>
<i class="fa fa-money" style="font-size:40px; color:#0d6efd;"></i>
</div>
<div class="px-3 pb-3">
<div class="progress" style="height: 10px;">
<div class="progress-bar bg-primary" style="width: 100%;"></div>
</div>
</div>
</div>
</div>
</div>

<div class="col-sm-6 mb-3">
<div class="card stat-card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center p-3">
<div>
<h5 class="mb-2 fw-semibold text-success">Repayment Paid</h5>
<h2 class="fw-normal my-2"><?php echo number_format($totalPaid, 2); ?></h2>
</div>
<i class="fa fa-check-circle" style="font-size:40px; color:#198754;"></i>
</div>
<div class="px-3 pb-3">
<div class="progress" style="height: 10px;">
<div class="progress-bar bg-success" style="width: <?php echo min($paidPercentage, 100); ?>%;"></div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-6 mb-3">
<div class="card stat-card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center p-3">
<div>
<h5 class="mb-2 fw-semibold text-danger">Outstanding</h5>
<h2 class="fw-normal my-2"><?php echo number_format($outstanding, 2); ?></h2>
</div>
<i class="fa fa-exclamation-circle" style="font-size:40px; color:#dc3545;"></i>
</div>
<div class="px-3 pb-3">
<div class="progress" style="height: 10px;">
<div class="progress-bar bg-danger" style="width: <?php echo min($outstandingPercentage, 100); ?>%;"></div>
</div>
</div>
</div>
</div>
</div>

<div class="col-sm-6 mb-3">
<div class="card stat-card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center p-3">
<div>
<h5 class="mb-2 fw-semibold text-warning">Interest Amount</h5>
<h2 class="fw-normal my-2"><?php echo number_format($interestAmount, 2); ?></h2>
</div>
<i class="fa fa-percent" style="font-size:40px; color:#ffc107;"></i>
</div>
<div class="px-3 pb-3">
<div class="progress" style="height: 10px;">
<div class="progress-bar bg-warning" style="width: 100%;"></div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>

</div>

<!-- PAYMENT HISTORY TAB -->
<div id="payment" style="display:none;">
<br>
<h6><i class="fa fa-list"></i> Payment History</h6>
<div id="table-container">
<table>
<thead>
<tr style="font-size:8px;">
<th>Date</th>
<th>Amount Paid</th>
<th>Payment Method</th>
<th>Reference</th>
<th>Balance After</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php if (!empty($payments)): ?>
<?php foreach($payments as $payment): ?>
<tr>
<td><?php echo htmlspecialchars($payment['Date_Paid'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo number_format((float)($payment['Amount'] ?? 0), 2); ?></td>
<td><?php echo htmlspecialchars($payment['Payment_Method'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($payment['Reference'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo number_format((float)($payment['Balance'] ?? 0), 2); ?></td>
<td><span class="badge bg-success" style="font-size:8px"><?php echo htmlspecialchars($payment['Status'] ?? 'Paid', ENT_QUOTES, 'UTF-8'); ?></span></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="6" class="text-center">No payment history available</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>

<!-- CRC DATA TAB -->
<div id="crc" style="display:none;">
<br>

<div class="alert alert-info mt-3">
<i class="fa fa-info-circle"></i> Please state the reason why you want to write off this loan
</div>
<br>
<br>
<br>
<h6><b> Loan Write Off Form</b></h6>
<form action="" method="POST" enctype="multipart/form-data" id="upwriteoff">
<input type="text" class="form-control form-control-md" placeholder="Repayment id" hidden name="id" required="required" value="<?php echo $id; ?>">
<textarea class="form-control form-control-md" name="re" placeholder="State Reason......" required="required" cols="5" rows="5"></textarea>
<br>
<button type="submit" class="btn btn-outline-primary btn-sm" id="butsave" onclick="data()">Send Request</button><hr>
</form>
<div class="alert alert-success mt-3" id="sent" style="display: none;">
<i class="fa fa-check"></i> Request has been sent to the head of risk for approval
</div>
</div>

<!-- COMMENT TAB -->
<div id="comment" style="display:none;">
<br>

<div class="col-xl-12 col-xxl-12 col-sm-12">
<div class="d-flex justify-content-between align-items-center">
<h5 class="card-title mb-0"> Comment</h5>
</div>
<div>
<div class="px-4 mx-n4 simplebar-scrollable-y" data-simplebar="init" style="max-height:300px;">
<div class="simplebar-wrapper" style="margin: 0px -16px;">
<div class="simplebar-height-auto-observer-wrapper">
<div class="simplebar-height-auto-observer"></div>
</div>
<div class="simplebar-mask">
<div class="simplebar-offset" style="right: 0px; bottom: 0px;">
<div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
<div class="simplebar-content" style="padding: 0px 16px;">
<div class="timeline">
<?php 
include '../config/db.php';
$Query = "SELECT Comment, Comment_By, User_Role, Date_Comment, Time_Comment FROM comment WHERE Reg_No = '$regid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$comment = mysqli_fetch_array($result);
?>
<div class="timeline-item">
<div class="timeline-pin">
<i class="marker marker-circle text-info"></i>
</div>
<p class="rich-list-title text-muted lh-lg">
<strong class="text-body"><?php echo $comment['Comment_By']; ?>:</strong>
<a href="#!" class="text-body fw-medium">Comment:</a> <?php echo $comment['Comment']; ?>
<span class="badge badge-label-info">[ <?php echo $comment['User_Role']; ?> ]</span>.
</p>
<span class="rich-list-subtitle mb-2"><?php echo $comment['Date_Comment']; ?> <a href="#!"><?php echo $comment['Time_Comment']; ?></a></span>
</div>

<?php
}
}
?>

</div>
</div>
</div>
</div>
</div>
<div class="simplebar-placeholder" style="width: 920px; height: 437px;">
</div>
</div>
<div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
<div class="simplebar-scrollbar" style="width: 0px; display: none;">
</div>
</div>
<div class="simplebar-track simplebar-vertical" style="visibility: visible;">
<div class="simplebar-scrollbar" style="height: 335px; transform: translate3d(0px, 47px, 0px); display: block;"></div>
</div>
</div>
</div>
</div>


</div>
</div>


<!-- LOAN HISTORY SECTION -->
<div id="loan" style="display:none;">
<br>
<h6><i class="fa fa-history"></i> Loan History</h6>
<br>
<div id="table-container" style="height:410px;">
<table>
<thead>
<tr style="font-size:8px;">
<th>Loan Account</th>
<th>Product</th>
<th>Amount</th>
<th>Paid</th>
<th>Balance</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php if (!empty($loans)): ?>
<?php foreach($loans as $loan): ?>
<tr>
<td><?php echo htmlspecialchars($loan['Loan_Account_No'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($loan['Product'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo number_format((float)($loan['Total_Loan'] ?? 0), 2); ?></td>
<td><?php echo number_format((float)($loan['Paid'] ?? 0), 2); ?></td>
<td><?php echo number_format((float)($loan['Total_Bal'] ?? 0), 2); ?></td>
<td><?php echo htmlspecialchars($loan['Date_Disbursed'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
<td>
<?php 
$status = $loan['Status'] ?? 'Unknown';
$badgeClass = $status == 'Active' ? 'bg-info' : ($status == 'Closed' ? 'bg-success' : 'bg-danger');
?>
<span class="badge <?php echo $badgeClass; ?>" style="font-size:8px"><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></span>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="7" class="text-center">No loan history available</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>

<!-- CLIENT INFO SECTION -->
<div id="client" style="display:none;">
<h6><i class="fa fa-user"></i> Client Information</h6>
<div class="card mt-3">
<div class="card-body">
<div class="row" style="font-size:12px;">
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Full Name:</p>
<p class="" style="text-transform:capitalize; font-size:12px;">
<?php echo htmlspecialchars($row['Firstname']." ".$row['Middlename']." ".$row['Lastname'], ENT_QUOTES, 'UTF-8'); ?>
</p>
</div>
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Phone Number:</p>
<p class="" style="font-size:12px;"><?php echo htmlspecialchars($row['Phone'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
</div>
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Email:</p>
<p class="" style="font-size:12px;"><?php echo htmlspecialchars($row['Email'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
</div>
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Address:</p>
<p class="" style="font-size:12px;"><?php echo htmlspecialchars($row['Address'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
</div>
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Business Type:</p>
<p class="" style="font-size:12px;"><?php echo htmlspecialchars($biz, ENT_QUOTES, 'UTF-8'); ?></p>
</div>
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Date Registered:</p>
<p class="" style="font-size:12px;"><?php echo htmlspecialchars($row['Date_Reg'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
</div>
</div>

<?php if ($gid > 0): ?>

<h6 class="mt-2"><i class="fa fa-users"></i> Guarantor Information</h6>
<div class="row mt-3">
<div class="col-sm-6 mb-1">
<p class="" style="font-size:12px;">Guarantor Name:</p>
<p class="" style="text-transform:capitalize; font-size:12px;">
<?php echo htmlspecialchars($rows['Firstname']." ".$rows['Lastname']  ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
</p>
</div>
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Guarantor Phone:</p>
<p class="" style="font-size:12px;"><?php echo htmlspecialchars($rows['Phone'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
</div>
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Guarantor BVN:</p>
<p class="" style="font-size:12px;"><?php echo htmlspecialchars($gb, ENT_QUOTES, 'UTF-8'); ?></p>
</div>
<div class="col-sm-6 mb-3">
<p class="" style="font-size:12px;">Guarantor Address:</p>
<p class="" style="font-size:12px;"><?php echo htmlspecialchars($rows['Address'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
</div>
</div>
<?php endif; ?>
</div>
</div>
</div>

<!-- DOCUMENTS & BUSINESS GALLERY SECTION -->
<div id="biz" style="display:none;">
<br>
<h6><i class="fa fa-file"></i> Documents & Business Gallery</h6>
<div class="col-sm-3" style="float:right;">
<input type="number" class="form-control for-control-sm" hidden id="regid" value="<?php echo $regid; ?>">
<select class="form-control for-control-sm" id="document" oninput="getDocument()">
<option value="">Select Gallery</option>
<option value="Document">Document Gallery</option>
<option value="Business">Business Gallery</option>
</select>
</div>


<br><br>
<div id="documentview"></div>

</div>


<script type="text/javascript">
function getDocument()  {
var regid = document.getElementById("regid").value;
var document_type = document.getElementById("document").value;
// ajax function start here
$.ajax({
method: "POST",
url: "gallery_type_bck.php",
dataType: "html",  
data: {
'regid': regid,
'document_type': document_type
},
success:function(data){
setTimeout(function(){
$('#documentview').html(data);
}, 100);
}
});
// ajax function ends here
}
</script>


<script>
// Navigation functions
function customerInfo() {
    $('#dashboard').show();
    $('#loan').hide();
    $('#client').hide();
    $('#biz').hide();
}

function customerLoan() {
    $('#dashboard').hide();
    $('#loan').show();
    $('#client').hide();
    $('#biz').hide();
}

function customerGua() {
    $('#dashboard').hide();
    $('#loan').hide();
    $('#client').show();
    $('#biz').hide();
}

function customerBiz() {
    $('#dashboard').hide();
    $('#loan').hide();
    $('#client').hide();
    $('#biz').show();
}

// Dashboard tab functions
function clientDash() {
    $('#dash').show();
    $('#payment').hide();
    $('#crc').hide();
    $('#comment').hide();
}

function updateHis() {
    $('#dash').hide();
    $('#payment').show();
    $('#crc').hide();
    $('#comment').hide();
}

function updateCrc() {
    $('#dash').hide();
    $('#payment').hide();
    $('#crc').show();
    $('#comment').hide();
}

function updateComment() {
    $('#dash').hide();
    $('#payment').hide();
    $('#crc').hide();
    $('#comment').show();
}

// Comment form submission
$(document).ready(function() {
    $('#commentForm').on('submit', function(e) {
        e.preventDefault();
        alert('Comment functionality will be implemented with backend integration');
    });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
setTimeout(function () {
// ajax function start here to load table data
$.ajax({
method: "GET",
url: "check_loan_balance.php?id=<?php echo $id; ?>",
dataType: "html",
success:function(data){
$("#mydivs").load("client_loan_page.php?id=<?php echo $id; ?>" + " #mydivs");
}
});
}, 100);
// ajax function ends here
});
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#upwriteoff").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to submit this request.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "submit_writeoff.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#upwriteoff")[0].reset();
if (data == 1){
$("#please").hide();
alert(" 🚫 Request has been sent already");
}else if(data == 2){
setTimeout(function(){
$("#updateModal").modal('show');
$("#please").hide();
$("#sent").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#sent").hide();
}, 6000);
}else{
$("#please").hide();
alert(" 🚫 " + data);
}
},
error: function(){
}
});
}
}));
});
</script>
