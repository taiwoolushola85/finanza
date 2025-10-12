<?php include 'header.php'; ?>
<?php 
$id = $_GET['id'];// get id tbrough query string
include '../config/db.php'; // db connection
$qry = mysqli_query($con,"SELECT * FROM users WHERE id='$id'"); // select query
$data = mysqli_fetch_array($qry); // fetch data 
?>

<div class="row">
<div class="col-sm-3">
<div class="card">
<div class="card-body">
<center>
<img src="<?php echo $data['Location']?>" width="150" height="150" class="rounded-circle d-flex">
<br>
<h4><b><?php echo $data['Name']?></b></h4>
</center>
</div>
</div>
<div class="card">
<div class="card-body">
<i class="fa fa-user-circle"></i> User Details
<hr>
<div id="mydiv">
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-home"></i> Branch:</small>
<small style="text-transform:capitalize; float:right"><b><?php echo $data['Branch']?></b></small>
<br>
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-phone"></i> Phone:</small>
<small style="text-transform:capitalize; float:right"><b><?php echo $data['Phone']?></b></small>
<br>
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-envelope"></i> Email:</small>
<small style="text-transform:capitalize; float:right"><b><?php echo $data['Email']?></b></small>
<br>
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-user"></i> Username:</small>       
<small style="text-transform:capitalize; float:right"><b><?php echo $data['Username']?></b></small>
<br>    
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-star"></i> Status:</small>
<small style="text-transform:capitalize; float:right"><b><?php echo $data['Status']?></b></small>        
<br>
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-cube"></i> Staff ID:</small>  
<small style="text-transform:capitalize; float:right"><b><?php echo $data['Staff_ID']?></b></small>
<br>
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-key"></i> Password:</small>
<small style="text-transform:capitalize; float:right"><b><?php echo $data['Password']?></b></small>
<br>
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-user-circle"></i> Role:</small>
<small style="text-transform:capitalize; float:right"><b><?php echo $data['User_Group']?></b></small>
<br>
<small style="text-transform:capitalize; font-size:12px"><i class="fa fa-globe"></i> Country:</small>
<small style="text-transform:capitalize; float:right"><b><?php echo $data['Country']?></b></small>
</div>
<hr>


</div>
</div>
</div>


<div class="col-sm-9">
<div class="card">
<div class="card-body">
<a href="manage_user.php" style="float: right;"> << Back</a>
<br>
<hr>
<br>
<div class="row">
<div class="col-sm-3">
<div id="btnCheck">
<?php 
if($data['Status'] == "Activate"){
// deactivate account form
?>
<form action="" method="POST" enctype="multipart/form-data" id="deactivateAccount">
<div class="d-grid gap-2 mb-2">
<input type="text" value="<?php echo $data['id']; ?>" hidden name="id"  required="required">
<button type="submit" class="btn btn-outline-success btn-sm"><i class="fa fa-exclamation-triangle"></i> Deactivate Account</button>
</div>
</form>
<?php
}else{
?>
<form action="" method="POST" enctype="multipart/form-data" id="activateAccount">
<div class="d-grid gap-2 mb-2">
<input type="text" value="<?php echo $data['id']; ?>" hidden name="id"  required="required">
<button type="submit" class="btn btn-outline-success btn-sm"><i class="fa fa-check"></i> Activate Account</button>
</div>
</form>
<?php 
}
?>
</div>
</div>
<div class="col-sm-3">
<div class="d-grid gap-2 mb-2">
<button class="btn btn-outline-warning btn-sm"><i class="fa fa-refresh"></i> Reset Account</button>
</div>
</div>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="accountDelete">
<div class="d-grid gap-2 mb-2">
<input type="text" value="<?php echo $data['id']; ?>" hidden placeholder="User ID" name="id"  required="required">
<button class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete Account</button>
</div>
</form>
</div>
<div class="col-sm-3">
<div class="d-grid gap-2 mb-2">
<button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="fa fa-edit"></i> Update Account</button>
</div>
</div>
</div>
<br>
<br>

<div class="col-xl-12">
<ul class="nav nav-tabs nav-justified nav-bordered nav-bordered-danger mb-3">
<li class="nav-item">
<a href="#home-b2" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
<i class="ti ti-file fs-lg me-md-1 align-middle"></i>
<span class="d-none d-md-inline-block align-middle">Create Login</span>
</a>
</li>
<li class="nav-item">
<a href="#profile-b2" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
<i class="ti ti-star fs-lg me-md-1 align-middle"></i>
<span class="d-none d-md-inline-block align-middle">Change Role</span>
</a>
</li>
</ul>
<div class="tab-content">
<div class="tab-pane show active" id="home-b2">
<br>
<form action="" method="POST" enctype="multipart/form-data" id="updateLogin">
<div class="row">
<div class="col-sm-6">
<label>Username</label>
<input type="text" class="form-control form-control-sm"  name="id" hidden value="<?php echo $data['id']?>" required>
<input type="text" class="form-control form-control-sm" name="us" value="<?php echo $data['Username']?>" required>
</div>
<div class="col-sm-6">
<label>Password</label>
<input type="password" class="form-control form-control-sm" name="ps" value="<?php echo $data['Password']?>" required>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-2">
<div id="btn">
<?php 
if($data['Username'] == 'NA'){
?>
<button type="submit" class="btn btn-outline-success btn-sm" onclick="data()"><i class="fa fa-edit"></i> Create Login</button>
<?php 
}else{
?>
<button type="button" disabled class="btn btn-outline-success btn-sm" onclick="data()"><i class="fa fa-edit"></i> Create Login</button>
<?php 
}
?>
</div>
</form>
</div>
<div class="col-sm-10">
<span style="display:none" id="wait"> <img src="../loader/loader.gif" style="height:16px"> Creating Login ! Please wait..</span>  
<span style="display:none; color:red" id="check"><i class="fa fa-exclamation-circle"></i> Username has already been taken by another staff, Please check..</span>  
</div>
</div>
</form>
</div>
<div class="tab-pane" id="profile-b2">

<form action="" method="POST" enctype="multipart/form-data" id="updateRole">
<div class="row">
<div class="col-sm-12">
<input type="text" hidden="hidden" class="form-control form-control-md" name="id" value= "<?php echo $data['id']; ?>" required="required">
User Group
<select type="text" class="form-control form-control-md" id="gr" name="gr" required="required">
<option value="">Select User Role</option>
<?php
include_once 'db.php';
$Query = "SELECT  * FROM role ORDER BY id DESC";
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
mysqli_close($con);
?>
</select>
</div>
</div>
<hr>
<button type="submit" class="btn btn-outline-info btn-sm" id="changes" onclick="data()" >Change User Role</button>
</form>

</div>
</div>
</div> <!-- end col-->

</div>
</div>

</div>
</div>

















</div>





<!-- /.bank modal -->
<div class="modal" id="standard-modal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content" >
<div class="modal-header">
<h4 class="modal-title">User Account Form Update</h4>
</div>
<div class="modal-body">
<form action="" method="POST" enctype="multipart/form-data" id="updateAcct">
<div class="row">
<div class="col-sm-6">
<input type="text" hidden class="form-control form-control-md" name="id" value= "<?php echo $data['id']; ?>" required="required">
<input type="text" hidden class="form-control form-control-md" name="go" value= "<?php echo $data['User_Group']; ?>" required="required">
<input type="text" hidden class="form-control form-control-md" name="br" value= "<?php echo $data['Branch_id']; ?>" required="required">
<input type="text" hidden class="form-control form-control-md" name="us" value= "<?php echo $data['Username']; ?>" required="required">
Name
<input type="text" class="form-control form-control-md" name="nm" value= "<?php echo $data['Name']; ?>" required="required">
</div>
<div class="col-sm-6">
Email
<input type="text" class="form-control form-control-md" name="em" value= "<?php echo $data['Email']; ?>" required="required">
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
Branch
<select type="text" class="form-control form-control-md" name="br" required = "required">
<option value="<?php echo $data['Branch_id']; ?>"><?php echo $data['Branch']; ?></option>
<?php
include '../config/db.php';
$Query = "SELECT id, Name FROM branch WHERE Status = 'Activate' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$br_id= $rows['id'];
$name= $rows['Name'];
?>
<option value="<?php echo $br_id; ?>"><?php echo $name; ?></option>
<?php
}
}
mysqli_close($con);
?>
</select>
</div>
<div class="col-sm-6">
Phone No
<input type="text" class="form-control form-control-md" name="ph" value= "<?php echo $data['Phone']; ?>" required="required">
</div>
</div>
<br>
<div class="row">
<div class="col-sm-6">
Address
<input type="text" class="form-control form-control-md" name="ad" value= "<?php echo $data['Address']; ?>" required="required">
</div>
<div class="col-sm-6">
Town
<input type="text" class="form-control form-control-md" name="tw" value= "<?php echo $data['Town']; ?>" required="required">
</div>
</div>
<hr>
<button type="submit" class="btn btn-outline-info btn-sm" id="butsave" onclick="data()">Update Account</button>
</form>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>


<script type="text/javascript">
$(document).ready(function (e){
$("#activateAccount").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to activate this account.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "activate_user.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Account Activated Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The account has been activated</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
}, 3000);
setTimeout(function(){
$("#btnCheck").load('view_user.php?id=<?php echo $data['id']; ?>' + " #btnCheck");
$("#mydiv").load('view_user.php?id=<?php echo $data['id']; ?>' + " #mydiv");
}, 4000);
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
$("#deactivateAccount").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to deactivate this account.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "deactivate_user.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Account Deactivated Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The account has been deactivated</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
}, 3000);
setTimeout(function(){
$("#btnCheck").load('view_user.php?id=<?php echo $data['id']; ?>' + " #btnCheck");
$("#mydiv").load('view_user.php?id=<?php echo $data['id']; ?>' + " #mydiv");
}, 4000);
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
$("#updateLogin").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to create login for this account.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: "create_login_dpetail.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
setTimeout(function(){
$("#wait").hide();
$("#check").show();
}, 3000);
setTimeout(function(){
$("#wait").hide();
$("#check").hide();
}, 5000);
}else if(data == 2){
$("#wait").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Login Created Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The login details has been create</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
$("#btn").load('view_user.php?id=<?php echo $data['id']; ?>' + " #btn");
}else{
$("#wait").hide();
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
$("#updateAcct").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this account info.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$('#standard-modal').modal('hide');
$("#please").show();
$.ajax({
url: "update_acct_info.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Account Updated Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The account has been updated</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
}, 3000);
setTimeout(function(){
$("#btnCheck").load('view_user.php?id=<?php echo $data['id']; ?>' + " #btnCheck");
$("#mydiv").load('view_user.php?id=<?php echo $data['id']; ?>' + " #mydiv");
}, 4000);
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
$("#updateRole").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to change this user role.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$('#standard-modal').modal('hide');
$("#please").show();
$.ajax({
url: "change_user_role.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Role Update Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The user role has been updated</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
}, 3000);
setTimeout(function(){
$("#mydiv").load('view_user.php?id=<?php echo $data['id']; ?>' + " #mydiv");
}, 4000);
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
$("#accountDelete").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete this account.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "account_delete.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Account Deleted Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The account has been deleted</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
}, 3000);
setTimeout(function(){
window.location.href='manage_user.php';
}, 4000);
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