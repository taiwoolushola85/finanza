<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display: none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/favicon.ico" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Account Successfully Created !
</div>
</div>
</div>


<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toasts" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display: none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/favicon.ico" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Account already exist.!
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
<h3 class="mb-sm-0">Staff Directory</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Staff Directory</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-sm-4" style="margin-top: 10px;">

</div>
<div class="col-sm-8">
<div class="row" style="margin-top: 10px; float:right">
<div class="col-sm-12" >
<div class="d-grid gap-2 mb-2">
<button type="button" class="btn btn-outline-success btn-sm btn-block" data-bs-toggle="modal" data-bs-target="#addstaff"><i class="fa fa-user-plus"></i> Create Staff</button>
</div>
</div>
</div>
</div>
</div>

<br>
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
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel">ACCOUNT INFO</h6>
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


<!-- Top modal content -->
<div id="addstaff" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="topModalLabel">Staff Onboarding Form</h4>
</div>
<div class="modal-body">
<center>
<div class="menu-profile-image">
<img src="" alt="" style="border-radius:100px; height:150px; width:150px" id="output">
</div>
<br><br>
<span>Only</span>
<a href="javascript:void(0);">.jpg</a>
<a href="javascript:void(0);">.png</a>
<a href="javascript:void(0);">.jpeg</a>
<span>allowed</span>
</center>
<br>
<form action="" method="post" id="uploadUser">
<div class="row">
<div class="form-group col-md-6">
<label class="form-label" for="fname">Upload Image:</label>
<input type="file" class="form-control" id="furl" name="Pic" onchange="loadFile(event)" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="lname">Name:</label>
<input type="text" class="form-control" name="nm" placeholder="Name" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="add1">Sex</label>
<select  class="selectpicker form-control" data-style="py-0" name="gen" required="required">
<option value="">Select Option</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>
<div class="form-group col-md-6">
<label class="form-label" for="add2">Address</label>
<input type="text" class="form-control" name="ad" placeholder="Address" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="mobno">Mobile No:</label>
<input type="number" class="form-control" name="ph" placeholder="Mobile No" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="altconno">Town/City:</label>
<input type="text" class="form-control" name="st" placeholder="Town/City" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="email">Email:</label>
<input type="email" class="form-control" name="em" placeholder="Email" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="pno">Staff ID:</label>
<input type="number" class="form-control" name="staffid" placeholder="Staff ID" required="required">
</div>
</div>
<hr>
<h5 class="mb-3">Other Info</h5>
<div class="row">
<div class="form-group col-md-6">
<label class="form-label">User Role:</label>
<select class="selectpicker form-control" data-style="py-0" name="gr" required="required">
<option value="">Select Option</option>
<?php
include '../config/db.php';
$Query = "SELECT  * FROM role ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$id= $rows['id'];
$name= $rows['Name'];
?>
<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="form-group col-md-6">
<label class="form-label">Branch:</label>
<select class="selectpicker form-control" data-style="py-0" name="br" required="required">
<option value="">Select Option</option>
<?php
include '../config/db.php';
$Query = "SELECT  * FROM branch ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bri= $rows['id'];
$name= $rows['Name'];
?>
<option value="<?php echo $bri; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" onclick="data()"><i class="fa fa-check"></i> Create Account</button>
</form>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var loadFile = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>






<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "load_user_json.php",
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
url: "load_user_json.php",
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
url: "load_user_json.php",
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
url: "load_user_json.php",
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
$("#uploadUser").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to onboard this new staff..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#addstaff").modal('hide');
$("#please").show();
$.ajax({
url: "create_staff_account.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#uploadUser")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 5000);
}else if (data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
load();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
load();
}, 5000);
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