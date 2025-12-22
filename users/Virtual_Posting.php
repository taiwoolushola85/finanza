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
<i class="fa fa-check"></i> Payment Successfully Posted
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
<h3 class="mb-sm-0">Virtual Posting</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Posting</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Posting</a></li>
<li class="breadcrumb-item active" aria-current="page">Virtual Posting</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>
<br>



<br>
<br>

<div class="row">
<div class="col-sm-2">

</div>
</div>
<br><br>
<b><i class="fa fa-table"></i> Virtual Repayment Notifications Table</b>
<br>
<br>
<div id="result"></div>








<script type="text/javascript">
$(document).ready(function(){
$("#ld").show();
$.ajax({
method: "POST",
url: "load_repayments.php",
dataType: "html",  
success:function(data){
$("#ld").hide();
$('#result').html(data);
}
});
});
</script>














<?php include '../footer.php'; ?>