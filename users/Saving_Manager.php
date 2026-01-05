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
<i class="fa fa-check"></i> Account Successfully Merged
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
<i class="fa fa-check"></i> Account Successfully Created
</div>
</div>
</div>

<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toaste" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Payment Successfully Posted
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
<h3 class="mb-sm-0">Saving Manager</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Manager</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Manager</a></li>
<li class="breadcrumb-item active" aria-current="page">Saving Manager</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadSaving">
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


<div id="results"></div>



<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:1000px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CUSTOMER SAVING PROFILE</h5>
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
$("#uploadSaving").on('submit',(function(e){ e.preventDefault();
$("#results").hide();
$("#please").show();
var bvn = $("#bvn").val();
$.ajax({
url: 'saving_info_bck.php?bvn=' + bvn,
type: "GET",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
setTimeout(function(){
$("#please").hide();
$("#results").show();
$('#results').html(data);
}, 3000);
},
error: function(){
}
});
}));
});
</script>




<?php include '../footer.php'; ?>