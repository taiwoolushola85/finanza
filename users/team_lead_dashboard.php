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
<div class="row">
<div class="col-sm-6">
<div class="card">
<div class="card-body">


<div class="dropdown float-end">


</div>
<div class="avatar avatar-sm avatar-label-info mb-6">
<i class="fa fa-users"></i>
</div>
<h6 class="mb-1" style="font-size:14px;">Active Clients</h6><br>
<p class=" mb-5" style="font-size:17px;"><b >Total:</b>
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Active' AND Team_Leader = '$User'");
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


<div class="dropdown float-end">

</div>
<div class="avatar avatar-sm avatar-label-danger mb-6">
<i class="fa fa-exclamation-triangle"></i>
</div>
<h6 class="mb-1" style="font-size:14px;">Closed Clients</h6><br>
<p class=" mb-5" style="font-size:17px;"><b >Total:</b>
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE Status = 'Closed' AND Team_Leader = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</p>
                                       

</div>
</div>
</div>
</div>

<div class="card">
<div class="card-body">

<div class="dropdown float-end">


</div>
<div class="avatar avatar-sm avatar-label-warning mb-6">
<i class="fa fa-wallet"></i>
</div>
<h6 class="mb-1" style="font-size:14px;">Expired Loan</h6><br>
<p class=" mb-5" style="font-size:17px;"><b >Total:</b>
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
                                       


</div>
</div>

<div class="card">
<div class="card-body">
<i class="fa fa-list"></i> Posting History
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


</div>
<div class="col-sm-8">
<div class="row">
<div class="col-sm-6">

<div class="card">
<div class="card-body">


<div class="dropdown float-end">


</div>
<div class="avatar avatar-sm avatar-label-primary mb-6">
<i class="fa fa-star"></i>
</div>
<h6 class="mb-1" style="font-size:14px;">Portfolio</h6><br>
<p class="mb-5" style="font-size:17px;"><b>Total:</b>
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Status != 'Cancelled' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</p>
                                       

</div>
</div>


</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">


<div class="dropdown float-end">


</div>
<div class="avatar avatar-sm avatar-label-info mb-6">
<i class="fa fa-wallet"></i>
</div>
<h6 class="mb-1" style="font-size:14px;">Portfolio Outstanding</h6><br>
<p class=" mb-5" style="font-size:17px;"><b >Total:</b>
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE Team_Leader ='$User' AND Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</p>
                                     

</div>
</div>


</div>
</div>





<div class="row">
<div class="col-sm-6">

<div class="card">
<div class="card-body">


<div class="dropdown float-end">


</div>
<div class="avatar avatar-sm avatar-label-success mb-6">
<i class="fa fa-wallet"></i>
</div>
<h6 class="mb-1" style="font-size:14px;">Repayments Collections</h6><br>
<p class=" mb-5" style="font-size:17px;"><b >Total:</b>
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Amount) FROM history WHERE Team_Leader ='$User' AND Date_Paid = '$d' AND Post_Method = 'Basic Posting'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</p>
                                       

</div>
</div>


</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">


<div class="dropdown float-end">


</div>
<div class="avatar avatar-sm avatar-label-warning mb-6">
<i class="fa fa-wallet"></i>
</div>
<h6 class="mb-1" style="font-size:14px;">Savings Collections</h6><br>
<p class=" mb-5" style="font-size:17px;"><b >Total:</b>
<?php 
$d = date('Y-m-d');
include '../config/db.php';
$result = mysqli_query($con, "SELECT SUM(Savings) FROM save WHERE Team_Leader ='$User' AND Date_Paid = '$d' AND Posting_Method != 'Initial Deposit' 
AND Posting_Method != 'System Posting'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
$result = mysqli_query($con, "SELECT SUM(Amount) FROM flexi_history WHERE Team_Leader ='$User' AND Date_Paid = '$d' AND  Posting_Method != 'System Posting'
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


<div class="card">
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
</div>



