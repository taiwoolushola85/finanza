<div class="row">
<div class="col-sm-3">
<div class="card">
<div class="card-body">
<div class="text-center">
<img src="<?php echo $loc; ?>" class="img-fluid rounded-pill avatar-100" loading="lazy" id="output" style="height:120px; width:120px">
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadImage">
<input type="text" name="id" value="<?php echo $usid; ?>" required hidden >
<input type="file" class="form-control" id="furl" name="Pic" onchange="loadFile(event)" required="required">
<br>
<button type="submit" class="btn btn-outline-info btn-sm w-100" id="up"  onclick="data()">Upload Image</button>
</form>
</div>
</div>
</div>



</div>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-6">

<div class="card">
<div class="card-body">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Name:</b> <span><?php echo $na; ?></span>
</div>
<div class="col-sm-6">

<div class="row" id="first">
<div class="col-sm-8">
<b style="margin-left: 8px;">Staff ID:</b> <span><?php echo $stid; ?></span>
</div>
<div class="col-sm-4" >
<?php 
if($stid == 'NA'){
?>
<a href="#" style="font-size:11px;" data-bs-toggle="modal" data-bs-target="#modal6">+ Update</a>

<?php 
}else{
//
}
?>
</div>
</div>

</div>
</div>

<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Branch:</b> <span><?php echo $brss; ?></span>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">User ID:</b> <span><?php echo $usid; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left: 8px;">Address:</b> <span><?php echo $address; ?></span>
</div>
</div>
<br>
</div>

</div>
</div>



</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Gender:</b> <span><?php echo $gender; ?></span>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Role:</b> <span><?php echo $gr; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Phone:</b> <span><?php echo $phone; ?></span>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Status:</b>  <span><?php echo $status; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left: 8px;">Role Category:</b> <span><?php echo $ct; ?></span>
</div>
</div>
<br>
</div>

</div>
</div>


</div>
</div>

<ul class="list-group list-group-unbordered " style="font-size:11px">
<li class="list-group-item">
<b>TOTAL CLIENTS</b> <a class="float-right" style="float:right;"> 
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM repayments WHERE Team_Leader ='$User' AND Status != 'Cancelled'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</a>
</li>
<li class="list-group-item">
<b>LOAN PORTFOLIO SIZE</b> <a class="float-right" style="float:right;">
<?php 
$d = date('Y-m-d');
include '../config/db.php';
$result = mysqli_query($con, "SELECT SUM(Loan_Amount) FROM repayments WHERE Team_Leader ='$User' AND Status != 'Cancelled'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</a>
</li>
<li class="list-group-item">
<b>LOAN PORTFOLIO OUTSTANDING</b> <a class="float-right" style="float:right;">
<?php 
$d = date('Y-m-d');
include '../config/db.php';
$result = mysqli_query($con, "SELECT SUM(Total_Bal) FROM repayments WHERE Team_Leader ='$User' AND Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</a>
</li>

</ul>

</div>
</div>
<br>
<div class="card">
<div class="card-body">
<div class="container-fluid">
<div class="nav nav-pills" id="nav2-tab" role="tablist">
<a class="nav-item nav-link active" id="nav2-profile-tab" data-bs-toggle="tab" href="#nav2-profile" aria-selected="false" tabindex="-1" role="tab"><i class="fa fa-edit"></i> Password</a>
<a class="nav-item nav-link" id="nav2-contact-tab" data-bs-toggle="tab" href="#nav2-contact" aria-selected="false" tabindex="-1" role="tab"><i class="fa fa-key"></i>  Authentication</a>
</div>
</div>
<div class="tab-content" id="nav2-tabContent">
<div class="tab-pane fade show active" id="nav2-profile" role="tabpanel" aria-labelledby="#nav2-profile-tab">
<br>
<br>
<b>Update your password</b>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="uploadPswd">
<input type="text" name="id" value="<?php echo $usid; ?>" required hidden >
<input type="password" class="form-control" name="psd" placeholder="Enter your password" value="<?php echo $pwd; ?>" required="required">
<br>
<button type="submit" class="btn btn-outline-info btn-sm w-100" id="up"  onclick="data()">Update Password</button>
</form>
</div>

</div>
<div class="tab-pane fade" id="nav2-contact" role="tabpanel" aria-labelledby="#nav2-contact-tab">
<br>
<br>
<b>Set You Authentication Pin</b> [ <i>4 Digit Number</i> ]
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="uploadPin">
<input type="text" name="id" value="<?php echo $usid; ?>" required hidden >
<input type="teXt" class="form-control" name="pin" placeholder="Enter your 4 didgit pin code" value="<?php echo $pin; ?>" required="required">
<br>
<button type="submit" class="btn btn-outline-info btn-sm w-100" id="up"  onclick="data()">Set Pin</button>
</form>
</div>
</div>
</div>
</div>


</div>
</div>



<!-- Modal 6 -->
<div class="modal fade" id="modal6" tabindex="-1" aria-labelledby="modal6Label" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered"  style="display:none; width:300px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modal6Label">STAFF ID UPDATE FORM</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadID">
<input type="text" name="id" value="<?php echo $usid; ?>" required hidden >
<input type="teXt" class="form-control" name="stid" placeholder="Enter your Staff ID" required="required">
<br>
<br>
<button type="submit" class="btn btn-outline-info btn-sm w-100" id="up"  onclick="data()">Set Pin</button>
</form>
</div>
</div>
</div>
</div>
</div>



<script>
var loadFile = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
var loads = function(event) {
var image = document.getElementById('outputs');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadImage").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update profile image.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "user_img_update.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else if (data == 2){
$("#please").hide();
alert ("Failed to upload picture to the file on the server... ");
}else{
$("#please").hide();
alert (data);
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
$("#uploadTarget").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update your monthly sale target.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "user_target_update.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert (data);
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
$("#uploadPswd").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update account password.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "user_password_update.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert (data);
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
$("#uploadPin").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update account authentication pin.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "user_pin_update.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert (data);
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
$("#uploadID").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update your staff id.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#modal6").modal('hide');
$("#please").show();
$.ajax({
url: "user_staff_id_update.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
$("#first").load(window.location.href + " #first");
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert (data);
}
},
error: function(){
}
});
}
}));
});
</script>
