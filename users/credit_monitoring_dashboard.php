
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
<li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
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

<div class="card">
<div class="card-body">

<div class="row">
<div class="col-9">
<i class="fa fa-users avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Active Customer</span>
</div>
</div>
<h6 class="mb-1">ACTIVE CUSTOMER</h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
// PUBLIC SECTOR
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Active'");
$rows = mysqli_fetch_array($result);
$total = $rows[0];
echo $total;
?>
</h5>
                   
        
</div>
</div>

</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">

<div class="row">
<div class="col-9">
<i class="fa fa-wallet avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-info float-end">Loan Portfolio</span>
</div>
</div>
<h6 class="mb-1">LOAN PORTFOLIO</h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Status != 'Cancelled'");
$rows = mysqli_fetch_array($result);
$total = $rows[0];
echo number_format($total,2);
?>
</h5>
                   
        
</div>
</div>

</div>
<div class="col-sm-4">

<div class="card">
<div class="card-body">

<div class="row">
<div class="col-9">
<i class="fa fa-star avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-success float-end">Outstanding Loan</span>
</div>
</div>
<h6 class="mb-1">OUTSTANDING LOAN</h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE Status = 'Active'");
$rows = mysqli_fetch_array($result);
$total = $rows[0];
echo number_format($total,2);
?>
</h5>
                   
        
</div>
</div>

</div>
</div>


<div class="row">
<div class="col-sm-6">

<div class="card">
<div class="card-body">

<div class="row">
<div class="col-9">
<i class="fa fa-exclamation-triangle avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-danger float-end">Expired Loan</span>
</div>
</div>
<h6 class="mb-1">EXPIRED LOAN</h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE Status = 'Active' AND '$d' > Maturity_Date");
$rows = mysqli_fetch_array($result);
$total = $rows[0];
echo number_format($total,2);
?>
</h5>
                   
        
</div>
</div>

</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">

<div class="row">
<div class="col-9">
<i class="fa fa-user-plus avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-info float-end">Defaulters</span>
</div>
</div>
<h6 class="mb-1">DEFAULTERS</h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Active' AND '$d' > Maturity_Date");
$rows = mysqli_fetch_array($result);
$total = $rows[0];
echo $total;
?>
</h5>
                   
        
</div>
</div>

</div>
</div>


</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">


<div class="row">
<div class="col-6">
<i class="fa fa-box"></i>
<b>Closed Loans</b><br>
<span>Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Closed'");
$rows = mysqli_fetch_array($result);
$total = $rows[0];
echo $total;
?>
</span>
</div>
<div class="col-6">
<i class="fa fa-star"></i>
<b>Cancelled Loans</b><br>
<span>Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Cancelled'");
$rows = mysqli_fetch_array($result);
$total = $rows[0];
echo $total;
?>
</span>
</div>
</div>

<hr>

<b>TOTAL<br> NPL [%]</b><span style="float:right;">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT sum(Loan_Amount) FROM repayments WHERE Status != 'Cancelled'");
$row = mysqli_fetch_array($result);
$disbursement = $row[0];
//
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE '$d' > Maturity_Date AND Status = 'Active'");
$row = mysqli_fetch_array($result);
$overdue = $row[0];
//
$npl = ($overdue/$disbursement)*100;
echo round($npl);
?>%
</span>
<div class="progress progress-sm bg-danger-subtle" >
<div class="progress-bar bg-danger" style="width:<?php echo round($npl);?>%;"></div>
</div>
<br>
<?php 
include '../config/db.php';
// Total DAILY loans
$dailyResult = mysqli_query($con, "SELECT SUM(Total_Bal) AS daily_total FROM repayments WHERE Status = 'Active' AND Frequency = 'Daily'");
$dailyRow = mysqli_fetch_assoc($dailyResult);
$dailyTotal = $dailyRow['daily_total'] ?? 0;
// Total ALL loans
$totalResult = mysqli_query($con, "SELECT SUM(Total_Bal) AS grand_total FROM repayments WHERE Status = 'Active'");
$totalRow = mysqli_fetch_assoc($totalResult);
$grandTotal = $totalRow['grand_total'] ?? 0;
// Calculate percentage (avoid division by zero)
$percentage = ($grandTotal > 0) ? ($dailyTotal / $grandTotal) * 100 : 0;
?>

<b>DAILY LOANS OUTSTANDING</b>
<span style="float:right;">
<?php echo number_format($dailyTotal, 2); ?>
</span>
<div class="progress progress-sm bg-primary-subtle">
<div class="progress-bar bg-primary" style="width: <?php echo round($percentage, 2); ?>%;">
</div>
</div>


<br>
<?php 
include '../config/db.php';
// Total DAILY loans
$dailyResult = mysqli_query($con, "SELECT SUM(Total_Bal) AS weekly_total FROM repayments WHERE Status = 'Active' AND Frequency = 'Weekly'");
$dailyRow = mysqli_fetch_assoc($dailyResult);
$dailyTotal = $dailyRow['weekly_total'] ?? 0;
// Total ALL loans
$totalResult = mysqli_query($con, "SELECT SUM(Total_Bal) AS grand_total FROM repayments WHERE Status = 'Active'");
$totalRow = mysqli_fetch_assoc($totalResult);
$grandTotal = $totalRow['grand_total'] ?? 0;
// Calculate percentage (avoid division by zero)
$percentage = ($grandTotal > 0) ? ($dailyTotal / $grandTotal) * 100 : 0;
?>

<b>WEEKLY LOANS OUTSTANDING</b>
<span style="float:right;">
<?php echo number_format($dailyTotal, 2); ?>
</span>
<div class="progress progress-sm bg-primary-subtle">
<div class="progress-bar bg-info" style="width: <?php echo round($percentage, 2); ?>%;">
</div>
</div>
<br>


<?php 
include '../config/db.php';
// Total DAILY loans
$dailyResult = mysqli_query($con, "SELECT SUM(Total_Bal) AS monthly_total FROM repayments WHERE Status = 'Active' AND Frequency = 'Monthly'");
$dailyRow = mysqli_fetch_assoc($dailyResult);
$dailyTotal = $dailyRow['monthly_total'] ?? 0;
// Total ALL loans
$totalResult = mysqli_query($con, "SELECT SUM(Total_Bal) AS grand_total FROM repayments WHERE Status = 'Active'");
$totalRow = mysqli_fetch_assoc($totalResult);
$grandTotal = $totalRow['grand_total'] ?? 0;
// Calculate percentage (avoid division by zero)
$percentage = ($grandTotal > 0) ? ($dailyTotal / $grandTotal) * 100 : 0;
?>

<b>MONTHLY LOANS OUTSTANDING</b>
<span style="float:right;">
<?php echo number_format($dailyTotal, 2); ?>
</span>
<div class="progress progress-sm bg-primary-subtle">
<div class="progress-bar bg-warning" style="width: <?php echo round($percentage, 2); ?>%;">
</div>
</div>




</div>
</div>


</div>
</div>



<div class="row">
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<?php include 'gen_chart.php';?>
</div>
</div>
</div>

<div class="col-sm-6">
<div class="card">
<div class="card-body">
<?php include 'gen_line.php';?>
</div>
</div>
</div>
</div>