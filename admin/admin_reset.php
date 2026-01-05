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
<i class="fa fa-check"></i> Account Reset Successfully
</div>
</div>
</div>

<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast1" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display: none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/favicon.ico" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i>  Pin Successfully Created
</div>
</div>
</div>



<?php include 'header.php'; ?>


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
<h3 class="mb-sm-0">Admin Reset</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Admin Reset</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<div class="card">
<div class="card-body">
<b>Reset Admin</b>
<center>
<img src="<?php echo $row['Location']?>" width="90" height="90" class="rounded-circle d-flex" id="output">
<br>
<h4><b><?php echo $row['Name']?></b></h4>
</center>
<hr>

<form action="" method="post" id="resetPass">
<div style="margin: auto;">
<div class="row">   
<div class="col-sm-4">
<label>Username</label> 
<input type="text" class="form-control form-control-md" required="required" hidden name="id" value="<?php echo $row['id']; ?>">
<input type="text" class="form-control form-control-md" required="required" name="us" value="<?php echo $row['Username']; ?>" placeholder="Enter Username">

</div>
<div class="col-sm-4">
<label>Password</label> 
<input type="password" class="form-control form-control-md" required="required" name="pw" value="<?php echo $row['Password']; ?>" placeholder="Enter Password">
</div>
<div class="col-sm-4">
<label>Upload Image</label> 
<input type="file" class="form-control form-control-md" required="required" id="furl" name="Pic" onchange="loadFile(event)" placeholder="Enter Password">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Reset Admin</button>
<button type="button" class="btn btn-outline-info btn-sm" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="fa fa-key"></i> Set Authentication</button>
</form>
<hr>

</div>



</div>
</div>



<div class="row">
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<b><i class="fa fa-star"></i> Info</b>
<hr>
<span> Name: <b><?php echo $row['Name']?></b></span><br>
<span> Username: <b><?php echo $row['Username']?></b></span><br>
<span> Role: <b><?php echo $row['User_Group']?></b></span><br>
<span> Branch: <b><?php echo $row['Branch']?></b></span><br>
<hr>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<b><i class="fa fa-star"></i> Info</b>
<hr>
<span> Email: <b><?php echo $row['Email']?></b></span><br>
<span> Phone: <b><?php echo $row['Phone']?></b></span><br>
<span> Role Category: <b><?php echo $row['Role_Categorys']?></b></span><br>
<span> Status: <b><?php echo $row['Status']?></b></span><br>
<hr>
</div>
</div>
</div>
</div>







</div>




<div class="modal" id="standard-modal" tabindex="-1" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-sm" style="display:none; width:400px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" style="font-size:12px; text-transform:uppercase"> Authentication</h6>
<button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<form action="" method="post" id="setAuth">
<div style="margin: auto;">
<div class="row">   
<div class="col-sm-12"> 
<label>Authentication Pin</label> 
<input type="text" class="form-control form-control-md" value="<?php echo $row['id']; ?>" hidden required="required" name="id">
<input type="text" class="form-control form-control-md" value="<?php echo $row['Pin']; ?>" required="required" name="pin" placeholder="Enter Authentication Pin">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm"><i class="fa fa-lock"></i> Set Pin</button>
</div>
</div>
</div>
</div>





<script>
var loadFile = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>








</div>




<script type="text/javascript">
$(document).ready(function (e){
$("#resetPass").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to about to reset admin account.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "reset_admin_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#toast").hide();
window.location.href='../config/session.php';
}, 7000);
}else{
alert('🚫' + data);
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
$("#setAuth").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to about to set pin for admin account.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#standard-modal").modal('hide');
$("#please").show();
$.ajax({
url: "set_pin.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast1").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast1").hide();
}, 7000);
//
}else{
alert('🚫' + data);
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