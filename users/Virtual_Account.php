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
<h3 class="mb-sm-0">Virtual Account</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Virtual Account</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>
<br>
<br>
<div class="row">
<div class="col-sm-3">
<form action="" method="post" id="uploadRole">
<div class="input-group">
<input type="text" class="form-control form-control-sm" id="bv" placeholder="Enter Bvn Number" required="required">
<span class="input-group-append">
<button type="submit" class="btn btn-outline-primary btn-sm" onclick="data()"><i class="fa fa-search"></i> Search</button>
</span>
</div>
</form>
</div>
</div>



<div id="result"></div>











<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
$("#result").hide();
$("#please").show();
var bv = $("#bv").val();
$.ajax({
url: 'load_account.php?bv=' + bv,
type: "GET",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
$("#please").hide();
alert("🚫 BVN Record Not Found..!!");
}else{
$("#please").show();
setTimeout(function(){
$("#result").show();
$("#please").hide();
$('#result').html(data);
}, 1000);
}
},
error: function(){
}
});
}));
});
</script>








<br>
<br>

<?php include '../footer.php'; ?>
