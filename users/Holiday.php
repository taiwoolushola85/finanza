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
<i class="fa fa-check"></i> Holiday Successfully Created
</div>
</div>
</div>


<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast1" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Holiday Successfully Deleted
</div>
</div>
</div>


<!-- Center modal content -->
<div class="modal" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myCenterModalLabel">Zone Form</h4>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form action="" method="post" id="uploadZone">
<label>Zone Title</label>
<input type="text" class="form-control form-control-md" required="required" name="zn" placeholder="Enter Zone Title">
<br>
<button type="submit" class="btn btn-outline-primary btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Create Zone</button>
</form>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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
<h3 class="mb-sm-0">Holiday</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Holiday</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>
<b>Holiday Form </b>
<br>
<br>
<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-4">
<label>Select Date</label>
<input type="date" class="form-control form-control-md" required="required" name="holiday">
</div>
<div class="col-sm-4">
<label>Description</label>
<input type="text" class="form-control form-control-md" required="required" name="dis" placeholder="Independent Day">
</div>
</div>
<br>
<span style="display:none; color:red" id="exit"><i class="fa fa-exclamation-triangle"></i> Date already exist! please select another date..</span>
<span style="display:none; color:green" id="toasts"><i class="fa fa-check"></i> Holiday successfully created. !!</span>
<hr>
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Add Date</button>
<button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#branchModal" style="font-size: 10px;"><i class="fa fa-list"></i> Holiday List</button>
</form>



<div class="modal" id="branchModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" style="display:none; width:1000px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">HOLIDAY LIST TABLE</h5>
</div>
<div class="modal-body">
<form action="" method="post" id="uploadForm">
<div class="row">
<div class="col-sm-6">
<label>Holiday Date</label>
<input type="hidden" class="form-control form-control-md" required="required" name="id" id="stid">
<input type="date" class="form-control form-control-md" required="required" name="rl" id="branchname">
</div>
<div class="col-sm-6">
<label>Discription</label>
<input type="text" class="form-control form-control-md" required="required" name="dis" id="dis">
</div>
</div>
<br>
<div class="row">
<div class="col-sm-2">
<div class="d-grid gap-2 mb-2">
<button type="submit" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i> Update</button>
</div>
</form>
</div>
<div class="col-sm-10">
<span style="display:none; color:green" id="bexit"><i class="fa fa-check"></i> Date successfully updated..</span>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-9">
<label>Show Entries</label>
<select class="form-control form-control-sm" id="maxRows" style="width:50px;" oninput="getEntry()">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-3">
<div>
<label>Search</label>
<input type="text" class="form-control form-control-sm" id="search" placeholder="Type here to search..." >
</div>
</div>
</div>
<br>
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
$("#tst").hide();// hide toast
$("#tst1").hide();// hide toast
});
</script>


<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "load_holiday_json.php",
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
url: "load_holiday_json.php",
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
url: "load_holiday_json.php",
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
function load()  {
$.ajax({
method: "POST",
url: "load_holiday_json.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to send the request to the server..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#tst").css("display", "block");
$("#please").show();
$.ajax({
url: "add_holiday.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#uploadRole")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#exit").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#exit").hide();
}, 7000);
}else if(data == 2){
setTimeout(function(){
$("#uploadRole")[0].reset();
$("#please").hide();
$("#toast").show();
load();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
load();
}, 7000);
}else{
$("#please").hide();
alert ("🚫" + data)
}
},
error: function(){
}
});
}
}));
});
</script>


<?php include '../footer.php'; ?>