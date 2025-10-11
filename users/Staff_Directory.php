<?php include 'head.php'; ?>
<br>
<div class="row">
<div class="col-sm-4" style="margin-top: 10px;">

</div>
<div class="col-sm-8">
<div class="row">
<div class="col-sm-4" style="margin-top: 10px;">
<select class="form-control form-control-sm">
<option value="">Select Role</option>
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
<div class="col-sm-4" style="margin-top: 10px;">
<select class="form-control form-control-sm">
<option value="">Select Branch</option>
<?php
include '../config/db.php';
$Query = "SELECT id, Name FROM Branch ORDER BY Name ASC";
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
<div class="col-sm-4" style="margin-top: 10px;">
<div class="d-grid gap-2 mb-2">
<button type="button" class="btn btn-soft-success btn-sm btn-block" data-bs-toggle="modal" data-bs-target="#addstaff"><i class="fa fa-user-plus"></i> Create Staff</button>
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




</div>




<!-- Top modal content -->
<div id="addstaff" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="topModalLabel">Staff Onboarding Form</h4>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
<select name="type" class="selectpicker form-control" data-style="py-0" name="gen" required="required">
<option>Select</option>
<option>Male</option>
<option>Female</option>
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
<button type="submit" class="btn btn-soft-success btn-sm" onclick="data()"><i class="fa fa-check"></i> Create Account</button>
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
WRN_PROFILE_DELETE = "You are about to send onboard this new staff..";
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
$("#please").hide();
Swal.fire({
toast: true,
icon: 'error',
title: 'Account Already Exist!',
html: '<small style="color: rgba(255,255,255,0.9);">The account record already exist</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
}else if (data == 2){
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Staff Created Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The staff has been created and saved</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
load();
}, 3000);
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