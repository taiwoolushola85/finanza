<?php 
include './config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Finanza | Authentication</title>
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
</head>
<body>
                       <?php
include './config/db.php';
$mm = $_SESSION['Username'];
$sql="SELECT id, Name, Pin FROM users WHERE Username = '$mm'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$usd_id = $row['id'];
$nn = $row['Name'];
$pin = $row['Pin'];
?>
<div class="auth-box overflow-hidden align-items-center d-flex">
<div class="container">
<div class="row justify-content-center">
<div class="col-xxl-4 col-md-6 col-sm-8">
<div class="card">
<div class="card-body">
<div class="auth-brand mb-4">
<a href="#" class="logo-dark">
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
<p class="text-muted w-lg-75 mt-3">Please enter your 4 digit authentication number to proceed..</p>
</div>
<div class="text-center mb-4">
<div class="fw-bold fs-4"><?php echo $nn; ?></div>
</div>
<center>
<?php 
if (isset($_GET['Id'])) {
extract ($_GET);
if ($Id== 1){
//Success
echo '<div class="alert alert-danger alert-dismissable">    
<center><p style="font-size:14px" class="fa fa-exclamation-circle"> Invalid Pin, Please Try Again</p></center></div>';
}elseif ($Id==2) {
//Failed
echo '<div class="alert alert-danger alert-dismissable">    
<center><p style="font-size:14px" class="fa fa-exclamation-circle"> Please enter complete 4 digit pin. </p></center></div>';
}
}
?> 
</center>
<form action="verify_pin.php" method="post">
<label class="form-label">Enter your 4-digit code <span class="text-danger">*</span></label>
<input  class="form-control" name="usd_id" value="<?php echo $usd_id; ?>" hidden="hidden">
<div class="d-flex gap-2 mb-3 two-factor">
<input type="text" name="pin" class="form-control text-center" required>
</div>
<div class="d-grid">
<button type="submit" class="btn btn-primary fw-semibold py-2">Confirm</button>
</div>
</form>
<p></p>
<p class="text-muted text-center mb-0">
Return to <a href="index.php" class="text-decoration-underline link-offset-3 fw-semibold">Sign in</a>
</p>
</div>
</div>
<p class="text-center text-muted mt-4 mb-0">
© <script>document.write(new Date().getFullYear())</script> Finanza — by <span class="fw-semibold">I-Create Software Technology</span>
</p>
</div>
</div>
</div>
</div>
<!-- end auth-fluid-->
<!-- Vendor js -->
<script src="assets/js/vendors.min.js"></script>
<!-- App js -->
<script src="assets/js/app.js"></script>

</body>
</html>