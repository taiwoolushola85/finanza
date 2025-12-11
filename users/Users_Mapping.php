
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
<i class="fa fa-check"></i> User successfully mapped
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
<i class="fa fa-check"></i> User successfully switched
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
<h3 class="mb-sm-0">Mapping</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Mapping</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Mapping</a></li>
<li class="breadcrumb-item active" aria-current="page">User Mapping</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->




<br>
<br>
<div class="btn-group" style="float:right;">
<button class="btn btn-success"data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa fa-plus"></i> Mapp User</button>
<button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModals"><i class="fa fa-history"></i> Switch User</button>
</div>
<br><br>
<div class="card">
<div class="card-body">
<b><i class="fa fa-list"></i> User Mapped List</b>
<div class="row">
<div class="col-sm-10" style="margin-top:10px">
<b style="font-size:10px">
+ Limit</b>
<select class="form-control search-input search form-control-sm" name="lmt" required style="width:50px" id="lmt" oninput="getGroup()">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-2" style="margin-top:10px">
<b style="font-size:10px">
Search</b>
<form action="" method="post" id="uploadRole">
<div class="input-group mb-3">
<input type="search" class="form-control form-control-sm"  id="search" placeholder="search..." style="margin-top:10px">
<span class="input-group-append">
</span>
</div>
</form>
</div>
<br>
<div id="result"></div>
</div>
</div>
</div>



<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:400px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">USER MAPPING FORM</h5>
</div>
<div class="modal-body">
<!-- Create form -->
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label for="exampleInputEmail1">Loan Officer Name</label>
<select  class="form-control form-control-md" name="la" required="required">
<option value="">Select Loan Officer</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Name FROM users WHERE User_Group = 'Loan Officers' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$uzid= $rows['id'];
$name= $rows['Name'];
?>
<option value="<?php echo $uzid; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="exampleInputEmail1">Team Leader Name</label>
<select type="text" class="form-control form-control-md" id="exampleInputEmail1" name="tm" required="required">
<option value="">Select Team Leader</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Name FROM users WHERE User_Group = 'Team Leaders' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$uzerid= $rows['id'];
$name= $rows['Name'];
?>
<option value="<?php echo $uzerid; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12" style="margin-top:10px">
<button type="submit" class="btn btn-outline-primary btn-sm btn-block" name="mapping" onclick="data()"> Mapp Users</button>
</div>
</div>
</form>



</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>



<div class="modal" id="updateModals" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:400px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">USER SWITCHING FORM</h5>
</div>
<div class="modal-body">

<!-- Create form -->
<form action="" method="POST" enctype="multipart/form-data" id="uploadForms">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label for="exampleInputEmail1">Loan Officer Name</label>
<select  class="form-control form-control-md" name="la" required="required">
<option value="">Select Loan Officer</option>
<?php 
include '../config/db.php';
$Query = "SELECT Name, Username FROM users WHERE User_Group = 'Loan Officers' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$name= $rows['Name'];
$uzer= $rows['Username'];
?>
<option value="<?php echo $uzer; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="exampleInputEmail1">Team Leader Name</label>
<select type="text" class="form-control form-control-md" id="exampleInputEmail1" name="tm" required="required">
<option value="">Select Team Leader</option>
<?php 
include '../config/db.php';
$Query = "SELECT Name, Username FROM users WHERE User_Group = 'Team Leaders' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$name= $rows['Name'];
$uzer= $rows['Username'];
?>
<option value="<?php echo $uzer; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12" style="margin-top:10px">
<button type="submit" class="btn btn-outline-primary btn-sm btn-block" name="switch" onclick="data()">Switch Users</button>
</div>
</div>
</form>


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
$("result").hide();
var lmt = document.getElementById("lmt").value;
// ajax function start here
$.ajax({
method: "POST",
url: "mapping_user.php",
dataType: "html",  
data: {
'lmt': 10
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
});
</script>


<script type="text/javascript">
function getGroup()  {
$("#loader").show();
$("#result").hide();
var lmt = document.getElementById("lmt").value;
// ajax function start here
$.ajax({
method: "POST",
url: "mapping_user.php",
dataType: "html",  
data: {
'lmt': lmt
},
success:function(data){
setTimeout(function(){
$("#loader").hide();
$("#result").show();
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
url: "mapping_user.php",
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
function loads()  {
$.ajax({
method: "POST",
url: "mapping_user.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 10);
}
});
}
</script> 





<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to mapp this credit officer to a Team Lead.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "mapping_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
$("#please").hide();
alert ("🚫 You have already mapped this users together. Please check record.");
$("#updateModal").modal('show');
}else if (data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
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



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForms").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to switch this branch to this user role.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModals").modal('hide');
$("#please").show();
$.ajax({
url: "switching_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").css("display", "block");
$("#toasts").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
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