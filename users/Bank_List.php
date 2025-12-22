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
<i class="fa fa-check"></i> Bank successfully added
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
<h3 class="mb-sm-0">Bank List</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Bank</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Bank</a></li>
<li class="breadcrumb-item active" aria-current="page">Bank List</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->

<br>
<br>
<br>

<form action="" method="POST" enctype="multipart/form-data" id="uploadFile">
<div class="row">
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Bank</label>
<input type="text" class="form-control form-control" name="bnk"  placeholder="Enter Bank Name" required>
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Bank Code</label>
<input type="number" class="form-control form-control" name="code" placeholder="Enter Bank Code" required>
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-primary btn-sm"  onclick="datas()"><i class="fa fa-plus"></i> Add Bank</button>
<button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa fa-list"></i> Bank List</button>
</form>
<i style="color:red; display:none" id="error"><i class="fa fa-exclamation-triangle"></i> Bank name already exist, please check list</i>




<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:800px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">BANK LIST TABLE</h5>
</div>
<div class="modal-body">
<div class="row">
<div class="col-sm-9" style="margin-top: 10px;">
</div>
<div class="col-sm-3" style="margin-top: 10px;">
<input type="search" class="form-control form-control-sm"  id="search" placeholder="search..." style="margin-top:10px">
</div>
</div>
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
url: "load_bank_code_bck.php",
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
$(document).ready(function(){
$("#search").keydown(function(){
var search = document.getElementById("search").value;
// ajax function start here
$.ajax({
method: "POST",
url: "load_bank_code_bck.php",
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
$(document).ready(function (e){
$("#uploadFile").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to bank data to the server..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "add_bank.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){ 
$("#uploadFile")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#error").show();
loadBank();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#error").hide();
}, 6000);
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
loadBank();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert("" + data);
$("#uploadFile")[0].reset();
}
},
error: function(){
}
});
}
}));
});
</script>

<script type="text/javascript">
function loadBank() {
$.ajax({
method: "POST",
url: "load_bank_code_bck.php",
dataType: "html",
success:function(data){
$('#result').html(data);
}
});
}
</script> 


<?php include '../footer.php'; ?>