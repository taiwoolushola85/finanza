<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Savings Successfully Approved
</div>
</div>
</div>


<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toasts" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Savings Successfully Declined
</div>
</div>
</div>


<?php include 'head.php'; ?>

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
<h3 class="mb-sm-0">Flexi Transactions</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Transaction</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Transaction</a></li>
<li class="breadcrumb-item active" aria-current="page">Flexi Transactions</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->



<br>
<br>
<b style="color:red;">Note:</b> <i>Approval of only flexi saving collection for an active flexi customers</i>
<br>
<br>

<b><h6><i class="fa fa-box"></i> Transaction Dashboard</h6></b>
<div class="row">
<div class="col-xxl-6 col-6">
<div class="card card-h-100">
<div class="card-body d-flex align-items-center gap-3">
<div class="avatar-sm avatar avatar-info">
<i class="fa fa-box"></i>
</div>
<div>
<h6 class="mb-0">Flexi Savings Posting</h6>
<p class="mb-0 text-muted">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Amount) FROM flexi_history WHERE Status != 'Paid' AND Team_Leader ='$User' AND Posting_Method = 'Basic Posting'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</p>
</div>
</div>
</div>
</div>
<div class="col-xxl-6 col-12">
<div class="card card-h-100">
<div class="card-body d-flex align-items-center gap-3">
<div class="avatar-sm avatar avatar-warning">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-undo-outline"><g data-name="Layer 2"><g data-name="undo"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M20.22 21a1 1 0 0 1-1-.76 8.91 8.91 0 0 0-7.8-6.69v1.12a1.78 1.78 0 0 1-1.09 1.64A2 2 0 0 1 8.18 16l-5.06-4.41a1.76 1.76 0 0 1 0-2.68l5.06-4.42a2 2 0 0 1 2.18-.3 1.78 1.78 0 0 1 1.09 1.64V7A10.89 10.89 0 0 1 21.5 17.75a10.29 10.29 0 0 1-.31 2.49 1 1 0 0 1-1 .76zm-9.77-9.5a11.07 11.07 0 0 1 8.81 4.26A9 9 0 0 0 10.45 9a1 1 0 0 1-1-1V6.08l-4.82 4.17 4.82 4.21v-2a1 1 0 0 1 1-.96z"></path></g></g></svg>
</div>
<div>
<h6 class="mb-0">Total Posting</h6>
<p class="mb-0 text-muted">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT SUM(Savings) FROM save WHERE Status != 'Paid' AND Team_Leader ='$User' AND Payment_Method = 'Basic Posting'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
//
$result = mysqli_query($con, "SELECT SUM(Amount) FROM flexi_history WHERE Status != 'Paid' AND Team_Leader ='$User' AND Posting_Method = 'Basic Posting'");
$row = mysqli_fetch_array($result);
$total2 = $row[0];
echo number_format($total1 + $total2,2);
?>
</p>
</div>
</div>
</div>
</div>
</div>

     


<div id="list"></div>




<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">TRANSACTION LIST</h5>
</div>
<div class="modal-body">
<div id="result"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "flexi_team_list.php",
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




<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "flexi_team_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#list').html(data);
}, 1000);
}
});
}
</script> 





<?php include "../footer.php"; ?>