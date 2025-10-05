<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Finanza | Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Loan management system for all kinds of loans - personal, home, auto, business, and more. Streamline your lending process with our user-friendly platform.">
<meta name="keywords" content="loan management system, loan processing, lending platform, personal loans, home loans, auto loans, business loans">
<meta name="author" content="I-Create Software Technology">
<!-- App favicon -->
<link rel="shortcut icon" href="../assets/images/favicon.ico">
<!-- Theme Config Js -->
<script src="../assets/js/config.js"></script>
<!-- Vendor css -->
<link href="../assets/css/vendors.min.css" rel="stylesheet" type="text/css">
<!-- App css -->
<link href="../assets/css/app.min.css" rel="stylesheet" type="text/css">
<script src="../assets/plugins/lucide/lucide.min.js"></script>
<script src="../js/jquery-2.2.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" 
integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
<div class="auth-box overflow-hidden align-items-center d-flex">
<div class="container">
<div class="row justify-content-center">
<div class="col-xxl-4 col-md-6 col-sm-8">
<div class="card">
<div class="card-body">
<div class="auth-brand mb-4">
<a href="index.html" class="logo-dark">
<span class="d-flex align-items-center gap-1">
<span class="avatar avatar-xs rounded-circle text-bg-dark">
<span class="avatar-title">
<i data-lucide="sparkles" class="fs-md"></i>
</span>
</span>
<span class="logo-text text-body fw-bold fs-xl">FINANZA</span>
</span>
</a>
<a href="#" class="logo-light">
<span class="d-flex align-items-center gap-1">
<span class="avatar avatar-xs rounded-circle text-bg-dark">
<span class="avatar-title">
<i data-lucide="sparkles" class="fs-md"></i>
</span>
</span>
<span class="logo-text text-white fw-bold fs-xl">FINANZA</span>
</span>
</a>
<p class="text-muted w-lg-75 mt-3">This screen is locked. Enter your password to continue</p>
</div>
<div class="text-center mb-4">
<img src="<?php echo $row['Location']; ?>" class="rounded-circle img-thumbnail avatar-xxl mb-2" alt="thumbnail">
<span>
<h5 class="my-0 fw-semibold"><?php echo $row['Name']; ?></h5>
<h6 class="my-0 text-muted"><?php echo $row['User_Group']; ?></h6>
</span>
</div>
<div class="alert alert-warning alert-dismissible fade show" role="alert" id="yp" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> Please enter your password</center>
</div>
<div class="alert alert-danger alert-dismissible fade show" role="alert" id="nf" style="display:none">
<center><i class="fa fa-exclamation-circle"></i> Incorrect password, Please try again</center>
</div>
<form action="" method="post" enctype="multipart/form-data" id="uploadForm">
<div class="mb-3">
<input  class="form-control" hidden required="required" name="id" value="<?php echo $row['id']; ?>" required>
<input  class="form-control" hidden required="required" name="us" value="<?php echo $row['Username']; ?>" required>
<input  class="form-control" hidden required="required" name="bck" value="<?php echo $bck; ?>" required>
<label for="userPassword" class="form-label">Password <span class="text-danger">*</span></label>
<div class="input-group">
<input type="password" class="form-control" id="userPassword" name="ps" placeholder="••••••••">
</div>
</div>
<div class="d-grid">
<button type="submit" class="btn btn-primary fw-semibold py-2">
<span style="display:none" id="vd"> <img src="../loader/loader.gif" style="height:16px"> Restoring session ! Please wait..</span>     
<span id="vdd">Unlock</span></button>
</div>
</form>
<p class="text-muted text-center mt-4 mb-0">
Not you? Return to <a href="index.php" class="text-decoration-underline link-offset-3 fw-semibold">Sign in</a>
</p>
</div>
</div>
<p class="text-center text-muted mt-4 mb-0">
© <script>document.write(new Date().getFullYear())</script> Finanza By <span class="fw-semibold">I-Create Software Technology</span> 
</p>
</div>
</div>
</div>
</div>
<!-- end auth-fluid-->
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
<!-- Vendor js -->
<script src="../assets/js/vendors.min.js"></script>
<!-- App js -->
<script src="../assets/js/app.js"></script>
<!-- Dashboard Page js -->
<script src="../assets/js/pages/dashboard.js"></script>
</body>
</html>