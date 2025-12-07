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
<div class="col-sm-4">
<div class="card">
<div class="card-body">


<div class="dropdown float-end">
<a href="#!" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Toggle navigation">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical-outline size-4">
<g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect>
<circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg>
</a>

</div>
<div class="avatar avatar-sm avatar-label-info mb-6">
<i class="fa fa-users"></i>
</div>
<h6 class="mb-1">Active Customer</h6>
<p class="text-muted mb-5">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Active' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</p>
<div class="progress progress-sm bg-danger-subtle">
<div class="progress-bar bg-info" style="width:100%;"></div>
</div>
                                       

</div>
</div>
</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="dropdown float-end">
<a href="#!" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Toggle navigation">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical-outline size-4">
<g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect>
<circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg>
</a>

</div>
<div class="avatar avatar-sm avatar-label-primary mb-6">
<i class="fa fa-file"></i>
</div>
<h6 class="mb-1">Portfolio</h6>
<p class="text-muted mb-5">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Status != 'Cancelled' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</p>
<div class="progress progress-sm bg-danger-subtle">
<div class="progress-bar bg-primary" style="width:100%;"></div>
</div>
       


</div>
</div>
</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="dropdown float-end">
<a href="#!" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Toggle navigation">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical-outline size-4">
<g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect>
<circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg>
</a>

</div>
<div class="avatar avatar-sm avatar-label-danger mb-6">
<i class="fa fa-exclamation-triangle"></i>
</div>
<h6 class="mb-1">Expired Loan</h6>
<p class="text-muted mb-5">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE Team_Leader = '$User' AND Status = 'Active' AND $d > Maturity_Date
AND Recovery_Status = 'No'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
mysqli_close($con);
?>
</p>
<div class="progress progress-sm bg-danger-subtle">
<div class="progress-bar bg-danger" style="width:100%;"></div>
</div>
       
</div>
</div>
</div>
</div>





<div class="row">
<div class="col-sm-8">
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-sm-6">
<div class="avatar avatar-sm avatar-label-success mb-6">
<i class="fa fa-money-bill"></i>
</div>
<span>Transactions</span>
<div class="row g-0">
<div class="col-6 border-end d-flex justify-content-end">
<div class="d-flex align-items-start gap-4 pe-4 py-3 text-end">
<div>
<h6 class="mb-1">Pending Repayments</h6>
<p class="text-muted fw-medium mb-0">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Amount) FROM history WHERE Team_Leader ='$User' AND Status != 'Paid' AND Post_Method = 'Basic Posting'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</p>
</div>
<div class="size-2 bg-danger rounded-circle mt-1"></div>
</div>
</div>
<div class="col-6">
<div class="d-flex align-items-start gap-4 ps-4 py-3">
<div class="size-2 bg-success rounded-circle mt-1"></div>
<div>
<h6 class="mb-1">Approved Repayments</h6>
<p class="text-muted fw-medium mb-0">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Amount) FROM history WHERE Team_Leader ='$User' AND Status = 'Paid' AND Date_Paid = '$d' AND Post_Method = 'Basic Posting'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</p>
</div>
</div>
</div>
<div class="col-6 border-end d-flex justify-content-end">
<div class="d-flex align-items-start gap-4 pe-4 py-3 text-end">
<div>
<h6 class="mb-1">Pending Savings</h6>
<p class="text-muted fw-medium mb-0">
<?php 
$d = date('Y-m-d');
include '../config/db.php';
$result = mysqli_query($con, "SELECT SUM(Savings) FROM save WHERE Team_Leader ='$User' AND Status != 'Paid' AND Posting_Method != 'Initial Deposit' 
AND Posting_Method != 'System Posting'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
$result = mysqli_query($con, "SELECT SUM(Amount) FROM flexi_history WHERE Team_Leader ='$User' AND Status != 'Paid' AND  Posting_Method != 'System Posting'
AND Posting_Method != 'Initial Deposit'");
$row = mysqli_fetch_array($result);
$total2 = $row[0];
echo number_format($total1 + $total2,2);
mysqli_close($con);
?>
</p>
</div>
<div class="size-2 bg-info rounded-circle mt-1"></div>
</div>
</div>
<div class="col-6">
<div class="d-flex align-items-start gap-4 ps-4 py-3">
<div class="size-2 bg-warning rounded-circle mt-1"></div>
<div>
<h6 class="mb-1">Approved Savings</h6>
<p class="text-muted fw-medium mb-0">
<?php 
$d = date('Y-m-d');
include '../config/db.php';
$result = mysqli_query($con, "SELECT SUM(Savings) FROM save WHERE Team_Leader ='$User' AND Status = 'Paid' AND Date_Paid = '$d' AND Posting_Method != 'Initial Deposit' 
AND Posting_Method != 'System Posting'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
$result = mysqli_query($con, "SELECT SUM(Amount) FROM flexi_history WHERE Team_Leader ='$User' AND Status = 'Paid' AND Date_Paid = '$d' AND Posting_Method != 'System Posting'
AND Posting_Method != 'Initial Deposit'");
$row = mysqli_fetch_array($result);
$total2 = $row[0];
echo number_format($total1 + $total2,2);
mysqli_close($con);
?>
</p>
</div>
</div>
</div>
</div>



</div>
<div class="col-sm-6">
<div class="avatar avatar-sm avatar-label-warning mb-6">
<i class="fa fa-chart-line"></i>
</div>
<span>Loan Profile</span>
<div class="row">
<div class="col-4">

<div class="col">
<div class="position-relative d-inline-block avatar-progress progress-75 mb-2">
<svg class="position-absolute top-0 start-0 progress-svg">
<circle class="progress-bg"></circle>
<circle class="progress-circle stroke-primary" stroke-dasharray="163.36281798666926" stroke-dashoffset="163.36281798666926" style="stroke-dashoffset: 40.8407;">
</circle>
</svg>
<div class="avatar size-11 avatar-label-primary avatar-circle">
<i class="fa fa-star"></i>
</div>
</div>
<h5 class="mb-2 fw-medium" style="margin-left:30px">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM groups WHERE Status = 'Activated' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
<p class="text-muted mb-0">Active Group</p>
</div>

</div>
<div class="col-4">

<div class="col">
<div class="position-relative d-inline-block avatar-progress progress-75 mb-2">
<svg class="position-absolute top-0 start-0 progress-svg">
<circle class="progress-bg"></circle>
<circle class="progress-circle stroke-info" stroke-dasharray="163.36281798666926" stroke-dashoffset="163.36281798666926" style="stroke-dashoffset: 40.8407;">
</circle>
</svg>
<div class="avatar size-11 avatar-label-info avatar-circle">
<i class="fa fa-star"></i>
</div>
</div>
<h5 class="mb-2 fw-medium" style="margin-left:30px">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Closed' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
<p class="text-muted mb-0">Closed Loan</p>
</div>

</div>
<div class="col-4">

<div class="col">
<div class="position-relative d-inline-block avatar-progress progress-100 mb-2">
<svg class="position-absolute top-0 start-0 progress-svg">
<circle class="progress-bg"></circle>
<circle class="progress-circle stroke-warning" stroke-dasharray="163.36281798666926" stroke-dashoffset="163.36281798666926" style="stroke-dashoffset: 40.8407;">
</circle>
</svg>
<div class="avatar size-11 avatar-label-warning avatar-circle">
<i class="fa fa-star"></i>
</div>
</div>
<h5 class="mb-2 fw-medium" style="margin-left:30px">0%</h5>
<p class="text-muted mb-0">Total NPL</p>
</div>

</div>

</div>



</div>

</div>


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
$result = mysqli_query($con, "SELECT SUM(Target) FROM mapping WHERE Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
//
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total2 = $row[0];
echo number_format($total1 - $total2,2);
?>
<br>Outstanding</span>
<div class="progress progress-md bg-primary bg-opacity-30">
<div class="progress-bar" role="progressbar" style="width: 0%;"></div>
</div>
</div>
<div class="w-33 flex-shrink-0">
<span class="text-muted px-2 py-1 border rounded mb-3 d-inline-block">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
<br>Achieve</span>
<div class="progress progress-md bg-primary bg-opacity-60">
<div class="progress-bar" role="progressbar" style="width: 0%;"></div>
</div>
</div>
<div class="w-25 flex-shrink-0">
<span class="text-muted px-2 py-1 border rounded mb-3 d-inline-block">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Target) FROM mapping WHERE Team_Leader ='$User'");
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

<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="mb-5">
<div class="d-flex flex-wrap align-items-center gap-2">
<?php
include '../config/db.php';
$Query = "SELECT Location FROM register WHERE Team_Leader = '$User' AND Status != 'Disbursed' ORDER BY id DESC LIMIT 8";
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
<a href="#!" class="avatar avatar-sm avatar-circle border d-flex justify-content-center align-items-center bg-light text-muted" aria-label="Add">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-plus-outline size-5">
<g data-name="Layer 2"><g data-name="plus">
<rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect>
<path d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2z"></path></g></g>
</svg>
</a>
</div>
</div>

<div class="avatar size-8 avatar-label-info avatar-circle">
<i class="fa fa-list"></i> 
</div>
Posting History
<div id="recent" ></div>



<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "POST",
url: "load_team_lead_recent.php",
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
<div class="card">
<div class="card-body">
<div class="avatar avatar-sm avatar-label-info mb-6">
<i class="fa fa-star"></i>
</div>Pending Loan
<p class="text-muted mb-5">Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Status != 'Disbursed' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</p>
</div>
</div>
</div>

<div class="col-sm-6">
<div class="card">
<div class="card-body">
<div class="avatar avatar-sm avatar-label-danger mb-6">
<i class="fa fa-exclamation-circle"></i>
</div>Cancelled Loan
<p class="text-muted mb-5">Total: <?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Cancelled' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?></p>
</div>
</div>

</div>
</div>


</div>
</div>







