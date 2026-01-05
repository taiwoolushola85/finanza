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
<i class="fa fa-check"></i> Loan Successfully Extended
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
<h3 class="mb-sm-0">Loan Extension</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Loans</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Loans</a></li>
<li class="breadcrumb-item active" aria-current="page">Loan Extension</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->

<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div class="row">
<div class="col-sm-3">
<label><i style="color:red">*</i> Enter Active Loan Account No</label>
<div class="input-group mb-3">
<input type="number" class="form-control form-control-sm"  id="acct" placeholder="Enter Active Loan Account" required>
<span class="input-group-append">
<button type="submit" class="btn btn-outline-primary btn-sm" onclick="data()"><i class="fa fa-search"></i> Search</button>
</span>
</div>
</form>
</div>
</div>
<br>
<br>
<div id="result"></div>







<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
var acct = document.getElementById('acct').value;
$("#please").show();
$.ajax({
url: "loan_customer_loan_profile.php?acct=" + acct,
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