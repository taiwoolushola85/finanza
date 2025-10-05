<?php
include_once './config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>FINANZA | Sign in</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Loan management system for all kinds of loans - personal, home, auto, business, and more. Streamline your lending process with our user-friendly platform.">
<meta name="keywords" content="loan management system, loan processing, lending platform, personal loans, home loans, auto loans, business loans">
<meta name="author" content="I-Create Software Technology">
<!-- App favicon -->
<link rel="shortcut icon" href="assets/images/favicon.ico">
<!-- Theme Config Js -->
<script src="assets/js/config.js"></script>
<!-- Vendor css -->
<link href="assets/css/vendors.min.css" rel="stylesheet" type="text/css">
<!-- App css -->
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css">
<script src="assets/plugins/lucide/lucide.min.js"></script>
<script src="js/jquery-2.2.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" 
integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
</head>
<body>
<div class="" style="margin-top: 130px;">
<div class="container">
<div class="row justify-content-center">
<div class="col-xxl-4 col-md-6 col-sm-8">
<div class="card">
<div class="card-body">
<div class="auth-brand mb-4">
<a href="index.php" class="logo-dark">
<span class="d-flex align-items-center gap-1">
<span class="avatar avatar-xs rounded-circle text-bg-dark">
<span class="avatar-title">
<i data-lucide="sparkles" class="fs-md"></i>
</span>
</span>
<span class="logo-text text-body fw-bold fs-xl">FINANZA</span>
</span>
</a>
<a href="index.php" class="logo-light">
<span class="d-flex align-items-center gap-1">
<span class="avatar avatar-xs rounded-circle text-bg-dark">
<span class="avatar-title">
<i data-lucide="sparkles" class="fs-md"></i>
</span>
</span>
<span class="logo-text text-white fw-bold fs-xl">FINANZA</span>
</span>
</a>
<p class="text-muted w-lg-75 mt-3">Let’s get you signed in. Enter your username and password to continue.</p>
</div>
<div class="alert alert-info alert-dismissible fade show" role="alert" id="up" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> Please enter username & password</center>
</div>
<div class="alert alert-warning alert-dismissible fade show" role="alert" id="yu" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> Please enter your username</center>
</div>
<div class="alert alert-warning alert-dismissible fade show" role="alert" id="yp" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> Please enter your password</center>
</div>
<div class="alert alert-danger alert-dismissible fade show" role="alert" id="nf" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> User account not found</center>
</div>
<div class="alert alert-danger alert-dismissible fade show" role="alert" id="ba" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> Your account has been de-activated</center>
</div>
<div class="">
<form action="" method="post" enctype="multipart/form-data" id="uploadForm">
<div class="mb-3">
<label for="userEmail" class="form-label">Username <span class="text-danger">*</span></label>
<div class="input-group">
<input type="text" class="form-control" name="user" placeholder="john123">
</div>
</div>
<div class="mb-3">
<label for="userPassword" class="form-label">Password <span class="text-danger">*</span></label>
<div class="input-group">
<input type="password" class="form-control" name="pass" placeholder="••••••••">
</div>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
<div class="form-check">
<input class="form-check-input form-check-input-light fs-14" type="checkbox" id="rememberMe">
<label class="form-check-label" for="rememberMe">Keep me signed in</label>
</div>
<a href="auth-reset-pass.html" class="text-decoration-underline link-offset-3 text-muted">Forgot Password?</a>
</div>
<div class="d-grid">
<button type="submit" class="btn btn-primary fw-semibold py-2">
<span style="display:none" id="vd"> <img src="loader/loader.gif" style="height:16px"> Checking access ! Please wait..</span>  
<span id="vdd">Sign In</span></button>
</div>
</form>
<p class="text-muted text-center mt-4 mb-0">
New here? <a href="#" class="text-decoration-underline link-offset-3 fw-semibold">Create an account</a>
</p>
</div>
</div>
</div>
<p class="text-center text-muted mt-4 mb-0">
© <script>document.write(new Date().getFullYear())</script> Finanza — by <span class="fw-semibold">I-Create Software Technology</span>
</p>
</div>
</div>
</div>
</div>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
$("#login").attr("disabled", "disabled");
$.ajax({
url: "login.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if (data == 1){
$("#up").show();
$("#up").fadeOut(4000);
$("#login").attr("disabled", false);
} else if (data == 2){
$("#yu").show();
$("#yu").fadeOut(4000);
$("#login").attr("disabled", false);
}else if (data == 3){
$("#yp").show();
$("#yp").fadeOut(4000);
$("#login").attr("disabled", false);
}else if (data == 4){
$("#ba").show();
$("#ba").fadeOut(4000);
$("#login").attr("disabled", false);
}else if (data == 5){
$("#nf").show();
$("#nf").fadeOut(4000);
$("#login").attr("disabled", false);
}else if (data == 6){
$("#nf").show();
$("#nf").fadeOut(4000);
$("#login").attr("disabled", false);
} else {
$("#vdd").hide();
$("#vd").show();
setTimeout(function(){
///alert("You have been authorized");
$("#vd").show();
window.location.href=data;
}, 3000);

}
},
error: function(){
}
});
}));
});
</script>

<!-- end auth-fluid-->
<!-- Vendor js -->
<script src="assets/js/vendors.min.js"></script>
<!-- App js -->
<script src="assets/js/app.js"></script>
</body>
</html>