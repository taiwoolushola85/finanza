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
<i class="fa fa-check"></i> Payment Successfully Updated
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
<i class="fa fa-check"></i> Payment Successfully Deleted
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
<h3 class="mb-sm-0">Loan Manager</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Manager</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Manager</a></li>
<li class="breadcrumb-item active" aria-current="page">Loan Manager</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div class="row">
<div class="col-sm-3">
<label><i style="color:red">*</i> Enter Customer BVN No</label>
<div class="input-group mb-3">
<input type="number" class="form-control form-control-sm"  id="bvn" placeholder="Enter 11 Digit Number" required>
<span class="input-group-append">
<button type="submit" class="btn btn-outline-primary btn-sm" onclick="data()"><i class="fa fa-search"></i> Search</button>
</span>
</div>
</form>
</div>
</div>
<br>
<br>



<!-- Loading Spinner -->
<div id="loadingSpinner" class="row mt-3" style="display: none;">
<div class="col-12">
<div class="text-center">
<div class="spinner-border text-primary" role="status">
<span class="visually-hidden">Loading...</span>
</div>
<p class="mt-2">Searching for client information...</p>
</div>
</div>
</div>
<!-- Results Container -->
<div id="result"></div>



<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm" style="display:none; width:1200px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CUSTOMER PROFILE</h5>
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



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
var bvn = document.getElementById('bvn').value;
$("#please").show();
$.ajax({
url: "load_loan_list.php?bvn=" + bvn,
type: "GET",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
setTimeout(function(){
$("#please").hide();
$('#result').html(data);
}, 1000);
},
error: function(){
}
});
}));
});
</script>

<?php include '../footer.php'; ?>
