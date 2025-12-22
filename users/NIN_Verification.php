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
<h3 class="mb-sm-0">NIN Verification</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">KYC</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">KYC</a></li>
<li class="breadcrumb-item active" aria-current="page">NIN Verification</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>
<br>
<form id="bvnForm">
<div class="row">
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> NIN</label>
<input type="text" class="form-control form-control-sm" placeholder="11 Digit Number" name="nin" id="nin" required>
</div>
</div>
<br>
<button type="submit" class="invks btn btn-outline-success btn-sm" id="submitBtn" >Verify</button>
</form>
<br>
<b style="display:none;" id="loaders"><img src="../loader/loader.gif" style="height:16px"> Verifying NIN ! Please wait...</b>



<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:900px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">NIN DATA</h5>
</div>
<div class="modal-body">
<div id="profile"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" id="close">Close</button>
</div>
</div>
</div>
</div>
</div>




<script>
$(document).ready(function () {
$('#close').on('click', function () {
$('#updateModal').hide(); // instantly hides
});
});
</script>

<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").modal('hide');
$("#loaders").show();
var nin = document.getElementById("nin").value;
if(nin) {
$.ajax({
url: 'nin_loading.php',
type: "GET",
data: {'nin': nin},
success: function(data) { 
$("#loaders").hide();
$('#profile').html(data);
},
error: function(xhr, status, error) {
alert('Error loading profile: ' + error);
$("#loaders").hide();
}
});
} else {
alert('Invalid ID');
$("#loaders").hide();
}
});
});
</script>

<?php include '../footer.php'; ?>