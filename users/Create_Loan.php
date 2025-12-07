<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display: none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Loan Created Successfully
</div>
</div>
</div>

<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toasts" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display: none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Application Declined Successfully
</div>
</div>
</div>

<?php include 'head.php'; ?>
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
<h3 class="mb-sm-0">Create Loan</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Create Loan</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->


<div class="card">
<div class="card-body">
<div class="row">
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div class="" style="float:right; width:320px">
<label>Enter BVN <i style="color:red;">[ For existing client registration ]</i></label>
<div class="input-group">
<input type="text" class="form-control" name="bvn" placeholder="Enter 11 Digit Number" aria-label="Example text with two button addons" required>
<button class="btn btn-outline-secondary" type="submit">Search</button>
</div>
</div>
</form>
</div>
</div>
</div>

<div class="card">
<div class="card-body">
<div class="row">
<div class="col-sm-2">

</div>
</div>
<br>
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
<input type="search" class="form-control form-control-sm"  id="search" placeholder="search..." style="margin-top:10px">
</div>
</div>
<br>
<div id="result"></div>

</div>
</div>






<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-xl">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">LOAN APPLICATION</h5>
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


<div class="modal" id="renewForm" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CUSTOMER RENEWAL FORM</h5>
</div>
<div class="modal-body">
<div id="form"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>

<script>
var loadFile = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>








<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
$("#please").show();
$.ajax({
url: "existing_loan_registration.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#uploadForm")[0].reset();
setTimeout(function(){
$("#please").hide();
$("#renewForm").modal('show');
$('#form').html(data);
}, 3000);
},
error: function(){
}
});
}));
});
</script>



<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "approved_loan_application.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#result').html(data);
}, 1000);
}
});
// ajax function ends here
});
</script>


<script type="text/javascript">
function getEntry()  {
$("#loader").show();
$("result").hide();
var maxRows = document.getElementById("maxRows").value;
// ajax function start here
$.ajax({
method: "POST",
url: "approved_loan_application.php",
dataType: "html",  
data: {
'maxRows': maxRows
},
success:function(data){
$("result").show();
setTimeout(function(){
$("#loader").hide();
$('#result').html(data);
}, 1000);
}
});
// ajax function ends here
}
</script>



<script type="text/javascript">
$(document).ready(function(){
$("#search").keydown(function(){
var search = document.getElementById("search").value;
// ajax function start here
$.ajax({
method: "POST",
url: "approved_loan_application.php",
dataType: "html",  
data: {
'search': search
},
success:function(data){
$('#result').html(data);
}
});
// ajax function ends here
});
});
</script>




<script type="text/javascript">
function load() {
$.ajax({
method: "POST",
url: "approved_loan_application.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 

<?php include '../footer.php'; ?>