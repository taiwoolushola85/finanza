
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
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-9">
<i class="fa fa-exclamation-triangle avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-danger float-end">Expired Loan Portfolio</span>
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
<span class="badge badge-label-info float-end">Portfolio Outstanding</span>
</div>
</div>
<h6 class="mb-1">PORTFOLIO OUTSTANDING </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
//public sector
$result = mysqli_query($con, "SELECT SUM(Total_Bal) AS overs FROM repayments WHERE Status = 'Active'");
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
<div class="col-sm-8">
<div class="row">
<div class="col-sm-6">

<div class="card">
<div class="card-body">
<div class="row">
<div class="col-9">
<i class="fa fa-money-bill avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-success float-end">Repayment Posted</span>
</div>
</div>
<h6 class="mb-1">REPAYMENT RECOVERED </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
// public sector
$result = mysqli_query($con, "SELECT SUM(Amount) FROM recover WHERE  Status = 'Waiting For Approval'");
$row = mysqli_fetch_array($result);
$total = $row[0];
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
<i class="fa fa-wallet avatar avatar-sm avatar-label mb-6"></i>
</div>
<div class="col-3">
<span class="badge badge-label-warning float-end">Saving Posted</span>
</div>
</div>
<h6 class="mb-1">SAVING POSTED </h6>
<h5 class="text mb-5" style="margin-top:10px;">Total: 
0.00
</h5>
</div>
</div>



</div>
</div>

</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div id="list"></div>

<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "recovery_officer.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#list').html(data);
}, 1000);
}
});
// ajax function ends here
});
</script>

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
