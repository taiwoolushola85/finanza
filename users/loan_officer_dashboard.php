<!-- Left Sidebar End -->
<div class="sidebar-backdrop" id="sidebar-backdrop"></div>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h3 class="mb-sm-0">Dashboard</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-sm-7">
<div class="row">
<div class="col-sm-6">

<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Active Clients</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-100">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-success avatar-circle">
<i class="fas fa-users" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Active' AND User = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
?>
<h4 class="mb-0 fw-medium" style="font-size:17px;"><b>Total:</b> <span><?php echo $total; ?></span> 
</span></h4>
</div>
</div>
</div>


</div>
<div class="col-sm-6">

<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Portfolio</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-75">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-info avatar-circle">
<i class="fas fa-star" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Status != 'Cancelled' AND User = '$User'");
$row = mysqli_fetch_array($result);
$totals = $row[0];
?>
<h4 class="mb-0 fw-medium"><b style="font-size:17px;"> Total:</b> <span><?php echo number_format($totals,2); ?></span></h4>
</div>
</div>
</div>


</div>
</div>


<div class="row">
<div class="col-sm-6">

<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Repayment Transactions</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-75">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-primary avatar-circle">
<i class="fas fa-money-bill" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Amount) FROM history WHERE User = '$User' AND Date_Paid = '$d'");
$row = mysqli_fetch_array($result);
$total = $row[0];
?>
<h4 class="mb-0 fw-medium"><b style="font-size:17px;">Total:</b> <span><?php echo number_format($total,2);?></span></h4>
</div>
</div>
</div>


</div>
<div class="col-sm-6">

<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Saving Transactions</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-75">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-warning avatar-circle">
<i class="fas fa-briefcase" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Savings) FROM save WHERE User ='$User' AND Date_Paid = '$d' AND Posting_Method != 'Initial Deposit' 
AND Posting_Method != 'System Posting'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
$result = mysqli_query($con, "SELECT SUM(Amount) FROM flexi_history WHERE User ='$User' AND Date_Paid = '$d' AND Posting_Method != 'System Posting'
AND Posting_Method != 'Initial Deposit'");
$row = mysqli_fetch_array($result);
$total2 = $row[0];
mysqli_close($con);
?>
<h4 class="mb-0 fw-medium"><b style="font-size:17px;">Total:</b> <span><?php  echo number_format($total1 + $total2,2); ?></span></h4>
</div>
</div>
</div>


</div>
</div>




<div class="card shadow-sm border-0">
<div class="card-body">
<div class="avatar avatar-sm avatar-label-success mb-6">
<i class="fa fa-bookmark"></i>
</div><h6 class="mb-2">Disbursement Performance Progress</h6>
<div class="d-flex gap-4 flex-wrap justify-content-between align-items-start mb-8">
<div>
<p class="text-muted mb-0 lh-lg">You are monitoring monthly disbursement performance.</p>
</div>
<div class="d-flex gap-3">
<a href="#!" class="d-flex align-items-center gap-2 text-body"><span class="size-3 rounded-circle d-inline bg-primary bg-opacity-30"></span>Outstanding</a>
<a href="#!" class="d-flex align-items-center gap-2 text-body"><span class="size-3 rounded-circle d-inline bg-primary bg-opacity-60"></span>Achieve</a>
<a href="#!" class="d-flex align-items-center gap-2 text-body"><span class="size-3 rounded-circle d-inline bg-primary bg-opacity-90"></span>Target</a>
</div>
</div>
<div class="d-flex gap-2">
<div class="w-100">
<span class="text-muted px-2 py-1 border rounded mb-3 d-inline-block">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Target) FROM mapping WHERE Loan_Officer = '$User'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
//
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE User = '$User'");
$row = mysqli_fetch_array($result);
$total2 = $row[0];
echo number_format($total1 - $total2,2);
?>
<br>Target Outstanding</span>
<div class="progress progress-md bg-primary bg-opacity-30 w-100">
<div class="progress-bar" role="progressbar" style="width: 0%;"></div>
</div>
</div>
<div class="w-33 flex-shrink-0">
<span class="text-muted px-2 py-1 border rounded mb-3 d-inline-block">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE User = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
<br>Target Achieve</span>
<div class="progress progress-md bg-primary bg-opacity-60">
<div class="progress-bar" role="progressbar" style="width: 0%;"></div>
</div>
</div>
<div class="w-25 flex-shrink-0">
<span class="text-muted px-2 py-1 border rounded mb-3 d-inline-block">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Target) FROM mapping WHERE Loan_Officer = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?><br>Target</span>
<div class="progress progress-md bg-primary bg-opacity-90">
<div class="progress-bar" role="progressbar" style="width: 0%;"></div>
</div>
</div>
</div>


</div>
</div>




</div>
<div class="col-sm-5">
<div class="card shadow-sm border-0">
<div class="card-body">

<div class="row">
<div class="col-6">

<b>New Client</b>
<div class="mb-5">
<div class="d-flex flex-wrap align-items-center gap-2">
<?php
include '../config/db.php';
$Query = "SELECT Location FROM register WHERE User = '$User' AND Status != 'Disbursed' ORDER BY id DESC LIMIT 4";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pix= $rows['Location'];
?>
<a href="#!" class="avatar avatar-sm avatar-circle">
<img src="<?php echo $pix; ?>" class="size-7" >
</a>
<?php
}
}
mysqli_close($con);
?>
</div>
</div>
</div>
<div class="col-6">
<h5 class="card-title mb-4">Closed Loan :</h5>
<div class="d-flex align-items-start justify-content-between mb-5">
<div>
<h5 class="fw-medium mb-1">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Closed' AND User = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
</div>
</div>
</div>

</div>

<div class="mb-8">

<div class="row">
<div class="col-6">
<h5 class="card-title mb-4">Expired Loan :</h5>
<div class="d-flex align-items-start justify-content-between mb-5">
<div>
<h5 class="fw-medium mb-1">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE User = '$User' AND Status = 'Active' AND '$d' > Maturity_Date
AND Recovery_Status = 'No'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
mysqli_close($con);
?>
</h5>
<p class="text-muted mb-0">Runing Expired Loans</p>
</div>
</div>

</div>
<div class="col-6">
<h5 class="card-title mb-4">NPL [%] :</h5>
<div class="d-flex align-items-start justify-content-between mb-5">
<div>
<h5 class="fw-medium mb-1">0</h5>
<p class="text-muted mb-0">Non Performing Loan</p>
</div>
</div>
</div>
</div>
<div id="recent" ></div>

</div>




<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "POST",
url: "load_recent_transaction.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$('#recent').html(data);
}, 100);
}
});
// ajax function ends here
});
</script>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Pending Loans</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-100">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-info avatar-circle">
<i class="fas fa-star" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Status != 'Disbursed' AND User ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
?>
<h4 class="mb-0 fw-medium" style="font-size:17px;"><b>Total:</b> <span><?php echo $total; ?></span> 
</span></h4>
</div>


</div>
</div>
</div>

<div class="col-sm-6">
<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Cancelled Loans</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-100">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-danger avatar-circle">
<i class="fas fa-exclamation-triangle" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Cancelled' AND User ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
?>
<h4 class="mb-0 fw-medium" style="font-size:17px;"><b>Total:</b> <span><?php echo $total; ?></span> 
</span></h4>
</div>


</div>
</div>
</div>
</div>


</div>
</div>





