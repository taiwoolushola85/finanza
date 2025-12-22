

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
<i class="fa fa-check"></i> Request Successfully Approved
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
<i class="fa fa-check"></i> Request Successfully Declined
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
<h3 class="mb-sm-0">Request Manager</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Request</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Request</a></li>
<li class="breadcrumb-item active" aria-current="page">Request Manager</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->

<br>
<br>
<div class="mb-3">
<div class="nav nav-lines mb-0" id="nav1-tab" role="tablist">
<a class="nav-item nav-link active" id="nav1-home-tab" data-bs-toggle="tab" href="#nav1-home" aria-selected="true" role="tab" style="font-size:13px;">
<i class="fa fa-box"></i> Withdrawal Request</a>
<a class="nav-item nav-link" id="nav1-profile-tab" data-bs-toggle="tab" href="#nav1-profile" aria-selected="false" role="tab" tabindex="-1" style="font-size:13px;">
<i class="fa fa-plus"></i> Savings Repayment Request</a>
<a class="nav-item nav-link" id="nav1-off-tab" data-bs-toggle="tab" href="#nav1-off" aria-selected="false" role="tab" tabindex="-1" style="font-size:13px;">
<i class="fa fa-cog"></i> Loan Write-Off Request</a> 
</div>
</div>
<div class="tab-content" id="nav1-tabContent">
<div class="tab-pane fade active show" id="nav1-home" role="tabpanel" aria-labelledby="#nav1-home-tab">
<br>
<br>
<br>
<div class="row">
<div class="col-sm-2">

</div>
</div>
<div class="row">
<div class="col-sm-10" style="margin-top: 10px;">
<label>Show Entries</label>
<select class="form-control form-control-sm" id="maxRows" style="width:50px;" oninput="getEntry()">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-2" style="margin-top: 10px;">
<input type="search" class="form-control form-control-sm" hidden  id="search" placeholder="search..." style="margin-top:10px">
</div>
</div>
<br>
<div id="result"></div>


</div>
<div class="tab-pane fade" id="nav1-profile" role="tabpanel" aria-labelledby="#nav1-profile-tab">
<br>
<br>
<br>
<div class="row">
<div class="col-sm-2">

</div>
</div>
<div class="row">
<div class="col-sm-10" style="margin-top: 10px;">
<label>Show Entries</label>
<select class="form-control form-control-sm" id="maxRows" style="width:50px;" oninput="getEntry()">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-2" style="margin-top: 10px;">
<input type="search" class="form-control form-control-sm" hidden id="search" placeholder="search..." style="margin-top:10px">
</div>
</div>
<br>
<div id="results"></div>

</div>
<div class="tab-pane fade" id="nav1-off" role="tabpanel" aria-labelledby="#nav1-off-tab">
<br>
<br>
<br>
<div class="row">
<div class="col-sm-2">

</div>
</div>
<div class="row">
<div class="col-sm-10" style="margin-top: 10px;">
<label>Show Entries</label>
<select class="form-control form-control-sm" id="maxRows" style="width:50px;" oninput="getEntry()">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-2" style="margin-top: 10px;">
<input type="search" class="form-control form-control-sm" hidden id="search" placeholder="search..." style="margin-top:10px">
</div>
</div>
<br>
<div id="writeoff"></div>

</div>


</div>
</div>



<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:1200px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CUSTOMER REQUEST PROFILE</h5>
</div>
<div class="modal-body">
<div id="profile"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>


<div class="modal" id="updateModals" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:1200px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CUSTOMER REQUEST PROFILE</h5>
</div>
<div class="modal-body">
<div id="profiles"></div>
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
//setInterval(function(){
// ajax function start here to load table data
$("#loader").show();
$.ajax({
method: "POST",
url: "load_withdrawal.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#result').html(data);
}, 1000);
}
});
///}, 1000);
// ajax function ends here
});
</script>




<script type="text/javascript">
$(document).ready(function(){
//setInterval(function(){
// ajax function start here to load table data
$("#loader").show();
$.ajax({
method: "POST",
url: "load_saving_repayment_request.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#results').html(data);
}, 1000);
}
});
///}, 1000);
// ajax function ends here
});
</script>


<script type="text/javascript">
$(document).ready(function(){
//setInterval(function(){
// ajax function start here to load table data
$("#loader").show();
$.ajax({
method: "POST",
url: "load_writeoff_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#writeoff').html(data);
}, 1000);
}
});
///}, 1000);
// ajax function ends here
});
</script>


<script type="text/javascript">
$(document).ready(function(){
//setInterval(function(){
// ajax function start here to load table data
$("#loader").show();
$.ajax({
method: "POST",
url: "load_writeoff_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#schedule').html(data);
}, 1000);
}
});
///}, 1000);
// ajax function ends here
});
</script>


<?php include '../footer.php'; ?>
