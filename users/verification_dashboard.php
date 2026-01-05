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
<span class="visually-hidden">Dashboard</span>
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
<div class="col-sm-8">
<div class="row">
<div class="col-sm-4">

<div class="card border">
<div class="card-body p-3">
<div class="d-flex justify-content-between align-items-center mb-4">
<a href="#!" class="mb-0 text-body fw-medium fs-14 text-truncate">Under Review</a>
<button type="button" class="btn btn-outline-light btn-sm">Total</button>
</div>
<div class="d-flex gap-3 align-items-center mb-4">
<div class="avatar-xs avatar d-flex align-items-center justify-content-center">
<i class="fa fa-star"></i>
</div>
<h5 class="mb-0 flex-grow-1">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Status = 'Under Review' AND Branch ='$brss'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
<span class="badge badge-label-primary float-end">Pending</span>
</div>
<p class="text-muted mb-3 text-truncate">
Client loan application under review</p>
</div>
</div>
</div>
<div class="col-sm-4">


<div class="card border">
<div class="card-body p-3">
<div class="d-flex justify-content-between align-items-center mb-4">
<a href="#!" class="mb-0 text-body fw-medium fs-14 text-truncate">Under Verification</a>
<button type="button" class="btn btn-outline-light btn-sm">Total</button>
</div>
<div class="d-flex gap-3 align-items-center mb-4">
<div class="avatar-xs avatar d-flex align-items-center justify-content-center">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-briefcase-outline size-5 text-muted">
<g data-name="Layer 2"><g data-name="briefcase">
<rect width="24" height="24" opacity="0"></rect>
<path d="M19 7h-3V5.5A2.5 2.5 0 0 0 13.5 3h-3A2.5 2.5 0 0 0 8 5.5V7H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3zm-4 2v10H9V9zm-5-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V7h-4zM4 18v-8a1 1 0 0 1 1-1h2v10H5a1 1 0 0 1-1-1zm16 0a1 1 0 0 1-1 1h-2V9h2a1 1 0 0 1 1 1z"></path></g></g></svg>
</div>
<h5 class="mb-0 flex-grow-1">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Status = 'Waiting For Verification' AND Branch ='$brss'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
<span class="badge badge-label-warning float-end">Pending</span>
</div>
<p class="text-muted mb-3 text-truncate">
Client loan application awaiting verification</p>
</div>
</div>

</div>
<div class="col-sm-4">

<div class="card border">
<div class="card-body p-3">
<div class="d-flex justify-content-between align-items-center mb-4">
<a href="#!" class="mb-0 text-body fw-medium fs-14 text-truncate">Total Applicant</a>
<button type="button" class="btn btn-outline-light btn-sm">Total</button>
</div>
<div class="d-flex gap-3 align-items-center mb-4">
<div class="avatar-xs avatar d-flex align-items-center justify-content-center">
<i class="fa fa-users"></i>
</div>
<h5 class="mb-0 flex-grow-1">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Status = 'Waiting For Verification' AND Branch ='$brss'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
//
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Status = 'Under Review' AND Branch ='$brss'");
$row = mysqli_fetch_array($result);
$total2 = $row[0];
echo $total1 + $total2;
?>
</h5>
<span class="badge badge-label-success float-end">Active</span>
</div>
<p class="text-muted mb-3 text-truncate">
Total active customer's in the branch</p>
</div>
</div>

</div>
</div>



<div class="row">
<div class="col-sm-6">

<div class="card border">
<div class="card-body p-3">
<div class="d-flex justify-content-between align-items-center mb-4">
<a href="#!" class="mb-0 text-body fw-medium fs-14 text-truncate">Closed Loan</a>
<button type="button" class="btn btn-outline-light btn-sm">Total</button>
</div>
<div class="d-flex gap-3 align-items-center mb-4">
<div class="avatar-xs avatar d-flex align-items-center justify-content-center">
<i class="fa fa-exclamation-circle"></i>
</div>
<h5 class="mb-0 flex-grow-1">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Closed' AND Branch ='$brss'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
<span class="badge badge-label-danger float-end">Closed</span>
</div>
<p class="text-muted mb-3 text-truncate">
Total customer close loan in the branch.</p>
</div>
</div>

</div>
<div class="col-sm-6">

<div class="card border">
<div class="card-body p-3">
<div class="d-flex justify-content-between align-items-center mb-4">
<a href="#!" class="mb-0 text-body fw-medium fs-14 text-truncate">Branch Portfolio</a>
<button type="button" class="btn btn-outline-light btn-sm">Total</button>
</div>
<div class="d-flex gap-3 align-items-center mb-4">
<div class="avatar-xs avatar d-flex align-items-center justify-content-center">
<i class="fa fa-money-bill"></i>
</div>
<h5 class="mb-0 flex-grow-1">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Status != 'Cancelled' AND Branch ='$brss'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</h5>
<span class="badge badge-label-info float-end">Active</span>
</div>
<p class="text-muted mb-3 text-truncate">
Total principal loan disbursed in the branch</p>
</div>
</div>

</div>
</div>




</div>
<div class="col-sm-4">
<div class="card border">
<div class="card-body p-3">
<b>Branch Staff</b>
<div class="mb-5">
<div class="d-flex flex-wrap align-items-center gap-2">
<a href="#!" class="avatar avatar-sm avatar-circle">
<img src="../assets/images/users/avatar-11.png" class="size-7" alt="Client">
</a>
<a href="#!" class="avatar avatar-sm avatar-circle">
<img src="../assets/images/users/avatar-12.png" class="size-7" alt="Client">
</a>
<a href="#!" class="avatar avatar-sm avatar-circle">
<img src="../assets/images/users/avatar-10.png" class="size-7" alt="Client">
</a>
<a href="#!" class="avatar avatar-sm avatar-circle">
<img src="../assets/images/users/avatar-9.png" class="size-7" alt="Client">
</a>
<a href="#!" class="avatar avatar-sm avatar-circle border d-flex justify-content-center align-items-center bg-light text-muted" aria-label="Add">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-plus-outline size-5">
<g data-name="Layer 2">
<g data-name="plus">
<rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect>
<path d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2z"></path>
</g>
</g>
</svg>
</a>
</div>
</div>
<hr>
<b>Latest Disbursement</b>
<div id="result"></div>

<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "POST",
url: "load_recent_disbursement.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 100);
}
});
// ajax function ends here
});
</script>

</div>
</div>
</div>
</div>



<div class="card">
<div class="card-body">
<b><i class="fa fa-list"></i> Recent Applicant List</b>
<div id="results"></div>




<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "POST",
url: "recent_applicant.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$('#results').html(data);
}, 1000);
}
});
// ajax function ends here
});
</script>
</div>
</div>