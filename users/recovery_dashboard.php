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
<div class="col-sm-6">
<div class="row">
<div class="col-sm-6">
<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Defaulters</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-100">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-primary avatar-circle">
<i class="fas fa-users" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT count(*) FROM repayments WHERE Status='Active' AND Recovery_Status = 'Yes' AND Recovery_Username = '$User'");
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
<h6 class="mb-3" style="font-size:14px;">Portfolio Outstanding</h6>
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
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE Status = 'Active' AND Recovery_Status = 'Yes' AND Recovery_Username = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
?>
<h4 class="mb-0 fw-medium" style="font-size:17px;"><b>Total:</b> <span><?php echo number_format($total,2); ?></span> 
</span></h4>
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
<h6 class="mb-3" style="font-size:14px;">Recovered Amount</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-100">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-success avatar-circle">
<i class="fas fa-money-bill" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Amount) FROM recover WHERE Status = 'Paid' AND User= '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
?>
<h4 class="mb-0 fw-medium" style="font-size:17px;"><b>Total:</b> <span><?php echo number_format($total,2);?></span> 
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
<h6 class="mb-3" style="font-size:14px;">Repayment Collection</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-100">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-success avatar-circle">
<i class="fas fa-wallet" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Amount) FROM recover WHERE User= '$User'AND Date_Pay = '$d'");
$row = mysqli_fetch_array($result);
$total = $row[0];
?>
<h4 class="mb-0 fw-medium" style="font-size:17px;"><b>Total:</b> <span><?php echo number_format($total,2); ?></span> 
</span></h4>
</div>
</div>
</div>

</div>
</div>


</div>
<div class="col-sm-6">
<div class="card shadow-sm border-0"  style="height:140px;">
<div class="card-body">
<b>Gallery</b><br><br>
<div class="d-flex flex-wrap align-items-center gap-2">
<?php
include '../config/db.php';
$Query = "SELECT  * FROM users ORDER BY id DESC LIMIT 12";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pix= $rows['Location'];
?>
<a href="#!" class="avatar avatar-sm avatar-circle">
<img src="<?php echo $pix; ?>" class="size-7" alt="Client">
</a>
<?php
}
}
mysqli_close($con);
?>
</div>
</div>
</div>



<div class="row">
<div class="col-6">

<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Expected Repayment</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-75">
<svg class="position-absolute top-0 start-0 progress-svg">
</svg>
<div class="avatar size-11 avatar-label-info avatar-circle">
<i class="fas fa-wallet" style="font-size:24px;"></i>
</div>
</div>
</div>
<div class="d-flex justify-content-between align-items-center">
<?php 
include '../config/db.php';
$d = date('D');
$result = mysqli_query($con, "SELECT SUM(Expected_Amount) FROM repayments WHERE Status = 'Active' AND Recovery_Status = 'Yes' AND Recovery_Username = '$User' 
AND Repayment_Day = '$d'");
$row = mysqli_fetch_array($result);
$totals = $row[0];
?>
<h4 class="mb-0 fw-medium"><b style="font-size:17px;"> Total:</b> <span><?php echo number_format($totals,2); ?></span></h4>
</div>
</div>
</div>

</div>
<div class="col-6">
<div class="card shadow-sm border-0">
<div class="card-body">
<div class="d-flex align-items-start justify-content-between mb-6">
<div>
<h6 class="mb-3" style="font-size:14px;">Closed Loans</h6>
</div>
<div class="position-relative d-inline-block avatar-progress progress-75">
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
$result = mysqli_query($con, "SELECT count(*) FROM repayments WHERE Status='Closed' AND Recovery_Status = 'Yes' AND Recovery_Username = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
?>
<h4 class="mb-0 fw-medium"><b style="font-size:17px;"> Total:</b> <span><?php echo $total; ?></span></h4>
</div>
</div>
</div>
</div>
</div>


</div>
</div>


<div class="container-fluid">
<div class="row">
<div class="col-12 col-sm-12 col-md-6 ">
<div class="card">
<div class="card-body">
<?php include 'branch_default.php'; ?>
</div>
</div>
</div>

<div class="col-12 col-sm-12 col-md-6">
<div class="card" >
<div class="card-body">
<?php include 'pro_def.php'; ?> 
</div>
</div>
</div>
</div>