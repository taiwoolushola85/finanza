
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
<i class="fa fa-star avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Portfolio Disbursed</span>
</div>
</div>
<h6 class="mb-1">LOAN PORTFOLIO </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
//public sector
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) AS overs FROM repayments WHERE Status != 'Cancelled'");
$row = mysqli_fetch_array($result);
$total = $row[0];
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
<i class="fa fa-wallet avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Loan Outstanding</span>
</div>
</div>
<h6 class="mb-1">LOAN OUTSTANDING </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
//PUBLIC SECTOR
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE Status = 'Active' ");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</h5>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-4">
<div class="card">
<div class="card-body">


<div class="row">
<div class="col-9">
<i class="fa fa-exclamation-circle avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Expired Loan</span>
</div>
</div>
<h6 class="mb-1">EXPIRED LOAN </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
// public sector
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE '$d' > Maturity_Date AND Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
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
<i class="fa fa-box avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Express Saving</span>
</div>
</div>
<h6 class="mb-1">EXPRESS SAVING </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Balance) FROM savings WHERE Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
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
<i class="fa fa-money-bill avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Flexi Saving</span>
</div>
</div>
<h6 class="mb-1">FLEXI SAVING </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$yrs = date('Y');
$mt = date('M');
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM flexi_account");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</h5>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-4">
<div class="card">
<div class="card-body">

<div class="row">
<div class="col-9">
<i class="fa fa-star avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Monthly Disbursement</span>
</div>
</div>
<h6 class="mb-1">MONTHLY DISBURSEMENT </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$m = date('M');
$y = date('Y');
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Months = '$m' AND Years = '$y' AND Status !='Cancelled'");
$row = mysqli_fetch_array($result);
$total = $row[0];
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
<i class="fa fa-wallet avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Disbursement Target</span>
</div>
</div>
<h6 class="mb-1">OVERALL TARGET</h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$m = date('M');
$y = date('Y');
$result = mysqli_query($con, "SELECT SUM(Interest_Amt) FROM history WHERE Months = '$m' AND Years = '$y' AND Status ='Paid'");
$row = mysqli_fetch_array($result);
$total = $row[0];
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
<i class="fa fa-wallet avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Disbursement Achieve</span>
</div>
</div>
<h6 class="mb-1">TARGET ACHIEVE </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$yrs = date('Y');
$mt = date('M');
$result = mysqli_query($con, "SELECT SUM(Upfront) FROM register WHERE Months = '$mt' AND Year_Booked = '$yrs' AND Status = 'Disbursed'");
$row = mysqli_fetch_array($result);
$totalm = $row[0];
//
$result = mysqli_query($con, "SELECT SUM(Inssurance) FROM register WHERE Months = '$mt' AND Year_Booked = '$yrs' AND Status = 'Disbursed'");
$row = mysqli_fetch_array($result);
$totalup = $row[0];
//
$result = mysqli_query($con, "SELECT SUM(Form) FROM register WHERE Months = '$mt' AND Year_Booked = '$yrs' AND Status = 'Disbursed'");
$row = mysqli_fetch_array($result);
$totalman = $row[0];
//
$result = mysqli_query($con, "SELECT SUM(Card) FROM register WHERE Months = '$mt' AND Year_Booked = '$yrs' AND Status = 'Disbursed'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];

echo number_format($totalm + $totalup + $totalman + $total1,2);
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


</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-9">
</div>
<div class="col-3">
<span class="badge badge-label-primary float-end">Staff Gallery</span>
</div>
</div>
<div class="mb-5">
<div class="d-flex flex-wrap align-items-center gap-2">
<?php
include '../config/db.php';
$Query = "SELECT  * FROM users WHERE Active = 'Online' ORDER BY id DESC LIMIT 7";
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

<br>
<div class="row">
<div class="col-2">
<center>
<i class="fas fa-star avatar avatar-sm avatar-label mb-6"></i>
</center>
</div>
<div class="col-10">
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
<div class="progress progress-sm bg-primary-subtle" >
<div class="progress-bar bg-danger" style="width:<?php echo round($npl);?>%;"></div>
</div>
</div>
</div>



<div class="row">
<div class="col-2">
<center>
<i class="fas fa-chart-bar avatar avatar-sm avatar-label mb-6"></i>
</center>
</div>
<div class="col-10">
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

<b>DAILY LOANS <br> OUTSTANDING</b>
<span style="float:right;">
<?php echo number_format($dailyTotal, 2); ?>
</span>
<div class="progress progress-sm bg-primary-subtle">
<div class="progress-bar bg-primary" style="width: <?php echo round($percentage, 2); ?>%;">
</div>
</div>
</div>
</div>



<div class="row">
<div class="col-2">
<center>
<i class="fas fa-inbox avatar avatar-sm avatar-label mb-6"></i>
</center>
</div>
<div class="col-10">

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

<b>WEEKLY LOANS<br> OUTSTANDING</b>
<span style="float:right;">
<?php echo number_format($dailyTotal, 2); ?>
</span>
<div class="progress progress-sm bg-primary-subtle">
<div class="progress-bar bg-info" style="width: <?php echo round($percentage, 2); ?>%;">
</div>
</div>
</div>

</div>

<div class="row">
<div class="col-2">
<center>
<i class="fas fa-wallet avatar avatar-sm avatar-label mb-6"></i>
</center>
</div>
<div class="col-10">

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

<b>MONTHLY LOANS <br> OUTSTANDING</b>
<span style="float:right;">
<?php echo number_format($dailyTotal, 2); ?>
</span>
<div class="progress progress-sm bg-primary-subtle">
<div class="progress-bar bg-warning" style="width: <?php echo round($percentage, 2); ?>%;">
</div>
</div>

</div>
</div>




<div class="container">
<div class="row">
<div class="col-4">

<div class="position-relative d-inline-block avatar-progress progress-75">
<svg class="position-absolute top-0 start-0 progress-svg">
<circle class="progress-bg"></circle>
<circle class="progress-circle stroke-warning" stroke-dasharray="163.36281798666926" stroke-dashoffset="163.36281798666926" style="stroke-dashoffset: 40.8407;"></circle>
</svg>
<div class="avatar size-11 avatar-label-warning avatar-circle">
<i class="fa fa-file"></i>
</div>
</div>
<h5 class="mb-4 fw-medium" style="margin-left:30px;">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
// public sector
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Status != 'Disbursed' AND Status != 'Loan Closed'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
<p class="text-muted mb-0" style="margin-left:5px;">Pending Loan</p>
</div>

<div class="col-4">

<div class="position-relative d-inline-block avatar-progress progress-100">
<svg class="position-absolute top-0 start-0 progress-svg">
<circle class="progress-bg"></circle>
<circle class="progress-circle stroke-info" stroke-dasharray="163.36281798666926" stroke-dashoffset="163.36281798666926" style="stroke-dashoffset: 40.8407;"></circle>
</svg>
<div class="avatar size-11 avatar-label-info avatar-circle">
<i class="fa fa-folder"></i>
</div>
</div>
<h5 class="mb-4 fw-medium" style="margin-left:30px;">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
// public sector
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Closed'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
<p class="text-muted mb-0">Closed Loan</p>

</div>

<div class="col-4">

<div class="position-relative d-inline-block avatar-progress progress-100">
<svg class="position-absolute top-0 start-0 progress-svg">
<circle class="progress-bg"></circle>
<circle class="progress-circle stroke-danger" stroke-dasharray="163.36281798666926" stroke-dashoffset="163.36281798666926" style="stroke-dashoffset: 40.8407;"></circle>
</svg>
<div class="avatar size-11 avatar-label-danger avatar-circle">
<i class="fa fa-wallet"></i>
</div>
</div>
<h5 class="mb-4 fw-medium" style="margin-left:30px;">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Status = 'Cancelled'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</h5>
<p class="text-muted mb-0">Cancelled Loan</p>

</div>
</div>
</div>



</div>
</div>
<div class="card">
<div class="card-body">
<b><i class="fa fa-history"></i> Latest Disbursement</b>
<div id="result"></div>


<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "POST",
url: "load_all_disbursement.php",
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


