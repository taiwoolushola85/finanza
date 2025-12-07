<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Finanza Lockscreen </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="description" content="Loan management system for all kinds of loans - personal, business, and more. Streamline your lending process with our user-friendly platform.">
<meta name="keywords" content="loan management system, loan processing, lending platform, personal loans, business loans">
<meta name="author" content="I-Create Software Technology">
<!-- layout setup -->
<!-- <script type="module" src="assets/js/layout-setup.js"></script> -->
<!-- App favicon -->
<link rel="shortcut icon" href="../assets/images/logo-sm.png">
<!-- Simplebar Css -->
<link rel="stylesheet" href="../assets/libs/simplebar/simplebar.min.css">
<!-- Bootstrap Css -->
<link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
<!--icons css-->
<link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">
<!-- App Css-->
<link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
<script src="../js/jquery-2.2.0.min.js"></script>
</head>
<body>
<?php
include '../config/db.php';
$user = $_GET['id'];
$bck = $_GET['resume'];// resume
$Query = "SELECT * FROM users WHERE Username='$user'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
?>
<div class="position-relative min-vh-100">
<div class="row gx-0">
<div class="col-xl-5">
<div class="row justify-content-center align-items-center p-10 min-vh-100 bg-body-secondary position-relative">
<div class="col-md-7 col-lg-6 col-xl-8 col-xxl-7">
<a href="#!" class="text-nowrap d-block w-100">
<h4><img src="../assets/images/logo-sm.png" class="dark-logo" height="30" alt="Logo-Dark"><b> FINANZA</b></h4>
</a>
<br>
<center>
<img src="<?php echo $row['Location']; ?>" style="height:50px; width:50px; border-radius:10px"  class="img-fluid"><br><br>
<span style="margin-top:20px">
<h5 class="my-0 fw-semibold"><?php echo $row['Name']; ?></h5>
</span>
</center>
<h3 class="mb-3 mt-8">Lockscreen</h3>
<p class="text-muted mb-8">Enter your password to restore ypur session</p>
<div class="alert alert-warning alert-dismissible fade show" role="alert" id="yp" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> Please enter your password</center>
</div>
<div class="alert alert-danger alert-dismissible fade show" role="alert" id="nf" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> Incorrect password, Please try again</center>
</div>
<form action="" method="post" enctype="multipart/form-data" id="uploadForm">
<div class="mb-5">
<label for="Password" class="form-label">Password</label>
<input  class="form-control" hidden required="required" name="id" value="<?php echo $row['id']; ?>" required>
<input  class="form-control" hidden required="required" name="us" value="<?php echo $row['Username']; ?>" required>
<input  class="form-control" hidden required="required" name="bck" value="<?php echo $bck; ?>" required>
<input type="password" class="form-control" name="ps" placeholder="********">
</div>
<div>
</div>
<button type="submit" class="btn btn-primary w-100">
<span style="display:none" id="vd"> <img src="../loader/loader.gif" style="height:16px"> Restoring session.! Please wait</span>     
<span id="vdd">Restore</span></button>
<div class="text-muted pt-14">
<p>©
<script>document.write(new Date().getFullYear())</script> Finanza — by <i class="mdi mdi-heart text-danger"></i> I-Create Software Technology
</p>
</div>
</form>
</div>
</div>
</div>
<div class="col-xl-7 d-none d-md-block">
<div class="h-100 d-flex align-items-center overflow-hidden justify-content-center position-relative z-2 hero-section bg-body">
<div class="floating-card position-absolute card-1">
<div class="d-flex gap-5">
<div class="bg-body-secondary shadow-lg rounded-3 px-4 py-2 team-info">
<h6 class="mb-0">Olivia Martinez</h6>
<small class="text-muted mb-0">Credit Officer</small>
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 linkedin">
<img src="../assets/images/users/avatar-2.png" alt="Avatar Image" class="avatar-xs">
</div>
</div>
</div>
<div class="floating-card position-absolute card-2 d-none d-xxl-block">
<div class="d-flex gap-5">
<div class="bg-body-secondary shadow-lg rounded-3 px-4 py-2 team-info">
<h6 class="mb-0">James Anderson</h6>
<small class="text-muted mb-0">Operations</small>
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 linkedin">
<img src="../assets/images/users/avatar-1.png" alt="Avatar Image" class="avatar-xs">
</div>
</div>
</div>
<div class="floating-card position-absolute card-3">
<div class="d-flex gap-5">
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 linkedin">
<img src="../assets/images/users/avatar-7.png" alt="Avatar Image" class="avatar-xs">
</div>
<div class="bg-body-secondary shadow-lg rounded-3 px-4 py-2 team-info">
<h6 class="mb-0">Sophia Lee</h6>
<small class="text-muted mb-0">Underwriter</small>
</div>
</div>
</div>
<div class="floating-card position-absolute card-4 d-none d-xxl-block">
<div class="d-flex gap-5">
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 linkedin">
<img src="../assets/images/users/avatar-8.png" alt="Avatar Image" class="avatar-xs">
</div>
<div class="bg-body-secondary shadow-lg rounded-3 px-4 py-2 team-info">
<h6 class="mb-0">Daniel Kim</h6>
<small class="text-muted mb-0">Auditor</small>
</div>
</div>
</div>
<div class="floating-card position-absolute card-5">
<div class="d-flex gap-5">
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 linkedin">
<img src="../assets/images/users/avatar-9.png" alt="Avatar Image" class="avatar-xs">
</div>
<div class="bg-body-secondary shadow-lg rounded-3 px-4 py-2 team-info">
<h6 class="mb-0">Emma Johnson</h6>
<small class="text-muted mb-0">Risk Manager</small>
</div>
</div>
</div>


<div class="text-center z-index-2 position-relative">
<p class="display-5 text-body fw-normal mb-6">
The Future of Micro Finance <br>
<span class="text-primary display-6 fw-normal">FINANZA</span>
</p>
<p class="mb-14 px-4 fs-14 max-w-75 mx-auto">Loan management system for all kinds of loans. Streamline your lending process with our user-friendly platform.</p>
<div class="d-flex justify-content-center align-items-center gap-2 mb-6">
<div class="avatar-group avatar-group-sm">
<div class="avatar avatar-circle">
<img src="../assets/images/users/avatar-13.png" alt="Avatar Image" class="img-fluid">
</div>
<div class="avatar avatar-circle">
<img src="../assets/images/users/avatar-14.png" alt="Avatar Image" class="img-fluid">
</div>
<div class="avatar avatar-circle">
<img src="../assets/images/users/avatar-24.png" alt="Avatar Image" class="img-fluid">
</div>
<div class="avatar avatar-circle">
<img src="../assets/images/users/avatar-16.png" alt="Avatar Image" class="img-fluid">
</div>
<div class="avatar avatar-circle avatar-dark">
<span>3+</span>
</div>
</div>
<span class="text-muted ">4M+ Users</span>
</div>
<button type="button" class="btn btn-primary">Get Started Free</button>
</div>
<div class="social-icons position-absolute d-flex gap-8">
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 linkedin">
<img src="../assets/images/social-icons/linkedin.png" alt="Avatar Image" class="avatar-2xs">
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 google">
<img src="../assets/images/social-icons/google.png" alt="Avatar Image" class="avatar-2xs">
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 instagram">
<img src="../assets/images/social-icons/instagram.png" alt="Avatar Image" class="avatar-2xs">
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 facebook">
<img src="../assets/images/social-icons/facebook.png" alt="Avatar Image" class="avatar-2xs">
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 apple">
<img src="../assets/images/social-icons/apple.png" alt="Avatar Image" class="avatar-2xs dafault-img">
<img src="../assets/images/social-icons/apple-white.png" alt="Avatar Image" class="avatar-2xs dark-img">
</div>
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
$.ajax({
url: "lock_login.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if (data == 1){
$("#yp").show();
$("#yp").fadeOut(3000);
}else if(data == 6){
$("#nf").show();
$("#nf").fadeOut(3000);
} else {
$("#vd").show();
setTimeout(function(){
$("#vdd").hide();
$("#vd").show();
window.location.href=data;
}, 2200);
}
},
error: function(){
}
});
}));
});
</script>


<!-- Bootstrap bundle js -->
<script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Layouts main js -->
<script src="../assets/libs/jquery/jquery.min.js"></script>
<!-- Metimenu js -->
<script src="../assets/libs/metismenu/metisMenu.min.js"></script>
<!-- simplebar js -->
<script src="../assets/libs/simplebar/simplebar.min.js"></script>
<script src="../assets/libs/eva-icons/eva.min.js"></script>
<!-- Scroll Top init -->
<script src="../assets/js/scroll-top.init.js"></script>
<!-- App js -->
<script src="../assets/js/app.js"></script>
</body>
</html>