<?php 
include './config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Finanza Authentication </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="description" content="Loan management system for all kinds of loans - personal, business, and more. Streamline your lending process with our user-friendly platform.">
<meta name="keywords" content="loan management system, loan processing, lending platform, personal loans, business loans">
<meta name="author" content="I-Create Software Technology">
<!-- layout setup -->
<!-- <script type="module" src="assets/js/layout-setup.js"></script> -->
<!-- App favicon -->
<link rel="shortcut icon" href="assets/images/logo-sm.png">
<!-- Simplebar Css -->
<link rel="stylesheet" href="assets/libs/simplebar/simplebar.min.css">
<!-- Bootstrap Css -->
<link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
<!--icons css-->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
<!-- App Css-->
<link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
<script src="js/jquery-2.2.0.min.js"></script>
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
<div class="position-relative min-vh-100">
<div class="row gx-0">
<div class="col-xl-5">
<div class="row justify-content-center align-items-center p-10 min-vh-100 bg-body-secondary position-relative">
<div class="col-md-7 col-lg-6 col-xl-8 col-xxl-7">
<a href="#!" class="text-nowrap d-block w-100">
<h4><img src="assets/images/logo-sm.png" class="dark-logo" height="30" alt="Logo-Dark"><b> FINANZA</b></h4>
</a>
<h3 class="mb-3 mt-8">Two-Factor Authentication</h3>
<p class="text-muted mb-8">Enter the 4-digit authentication code to secure your account.</p>
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
<div class="mb-8">
<label for="otp" class="form-label mb-3">Authentication Code</label>
<div class="d-flex justify-content-between gap-2">
<input  class="form-control" hidden name="usd_id" value="<?php echo $usd_id; ?>">
<input type="text" name="auth1" class="form-control text-center fw-bold fs-5 otp-input" maxlength="1">
<input type="text" name="auth2" class="form-control text-center fw-bold fs-5 otp-input" maxlength="1">
<input type="text" name="auth3" class="form-control text-center fw-bold fs-5 otp-input" maxlength="1">
<input type="text" name="auth4" class="form-control text-center fw-bold fs-5 otp-input" maxlength="1">
</div>
</div>
<button type="submit" class="btn btn-primary w-100">Proceed</button>
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
<img src="assets/images/users/avatar-2.png" alt="Avatar Image" class="avatar-xs">
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
<img src="assets/images/users/avatar-1.png" alt="Avatar Image" class="avatar-xs">
</div>
</div>
</div>
<div class="floating-card position-absolute card-3">
<div class="d-flex gap-5">
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 linkedin">
<img src="assets/images/users/avatar-7.png" alt="Avatar Image" class="avatar-xs">
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
<img src="assets/images/users/avatar-8.png" alt="Avatar Image" class="avatar-xs">
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
<img src="assets/images/users/avatar-9.png" alt="Avatar Image" class="avatar-xs">
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
<img src="assets/images/users/avatar-13.png" alt="Avatar Image" class="img-fluid">
</div>
<div class="avatar avatar-circle">
<img src="assets/images/users/avatar-14.png" alt="Avatar Image" class="img-fluid">
</div>
<div class="avatar avatar-circle">
<img src="assets/images/users/avatar-24.png" alt="Avatar Image" class="img-fluid">
</div>
<div class="avatar avatar-circle">
<img src="assets/images/users/avatar-16.png" alt="Avatar Image" class="img-fluid">
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
<img src="assets/images/social-icons/linkedin.png" alt="Avatar Image" class="avatar-2xs">
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 google">
<img src="assets/images/social-icons/google.png" alt="Avatar Image" class="avatar-2xs">
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 instagram">
<img src="assets/images/social-icons/instagram.png" alt="Avatar Image" class="avatar-2xs">
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 facebook">
<img src="assets/images/social-icons/facebook.png" alt="Avatar Image" class="avatar-2xs">
</div>
<div class="avatar avatar-md bg-body-secondary shadow-lg rounded-3 apple">
<img src="assets/images/social-icons/apple.png" alt="Avatar Image" class="avatar-2xs dafault-img">
<img src="assets/images/social-icons/apple-white.png" alt="Avatar Image" class="avatar-2xs dark-img">
</div>
</div>
</div>
</div>
</div>
</div>


<div class="custom-setting bg-primary pe-0 d-md-flex flex-column rounded-start-3 d-none">
    <button type="button" class="btn btn-wide border-0 text-white fs-20 avatar-md" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-label="Toggle Switcher">
        <i class="mdi mdi-cog-outline align-middle"></i>
    </button>
    <button type="button" class="btn btn-wide border-0 text-white fs-20 avatar-md" data-toggle="fullscreen" aria-label="Toggle Fullscreen">
        <i class="mdi mdi-arrow-expand-all align-middle"></i>
    </button>
    <button type="button" disabled class="btn btn-wide border-0 text-white fs-14 avatar-md" id="layout-dir-btn" aria-label="Toggle RTL/LTR">
        <span>RTL</span>
    </button>
</div>

<!-- Rightbar Sidebar -->
<div class="offcanvas offcanvas-end" id="offcanvas-rightsidabar">
    <div class="offcanvas-header">
        <div>
            <h5 class="offcanvas-title" id="offcanvasLabel">Recent Activities</h5>
            <p class="text-muted mb-0">Stay updated with your store</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p class="mb-3 mt-1 fs-14">Today's Overview</p>
        <div class="row g-3 mb-5">
            <div class="col-6">
                <div class="px-4 py-3 bg-light bg-opacity-40 rounded d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-4">Orders</p>
                        <h5 class="mb-0 fw-medium">23</h5>
                    </div>
                    <span class="text-success fw-medium">+12%</span>
                </div>
            </div>
            <div class="col-6">
                <div class="px-4 py-3 bg-light bg-opacity-40 rounded d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-4">Revenue</p>
                        <h5 class="mb-0 fw-medium">$8,547</h5>
                    </div>
                    <span class="text-success fw-medium">+8%</span>
                </div>
            </div>
            <div class="col-6">
                <div class="px-4 py-3 bg-light bg-opacity-40 rounded d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-4">Pending</p>
                        <h5 class="mb-0 fw-medium">7</h5>
                    </div>
                    <span class="text-danger fw-medium">-3%</span>
                </div>
            </div>
            <div class="col-6">
                <div class="px-4 py-3 bg-light bg-opacity-40 rounded d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-4">Low Stock</p>
                        <h5 class="mb-0 fw-medium">12</h5>
                    </div>
                    <span class="text-success fw-medium">+2%</span>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0 fs-14">Activities</p>
            <a href="#!" class="text-muted"><i class="mdi mdi-refresh me-1"></i>Refresh</a>
        </div>
        <div class="timeline timeline-timed timeline-icon activity-timeline">
            <div class="timeline-item d-flex justify-content-between align-items-center gap-lg-4 flex-wrap flex-md-nowrap">
                <div>
                    <div class="timeline-pin">
                        <i data-eva="shopping-cart-outline" class="size-4"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="rich-list-title mb-2">New Order Received</h6>
                        <span class="rich-list-paragraph">
                            Order <span class="text-body">#12458</span> from <span class="text-body">John Smith</span> –
                            $245.99
                        </span>
                    </div>
                </div>
                <p class="text-muted mb-0 flex-shrink-0">2 mins ago</p>
            </div>
            <div class="timeline-item d-flex justify-content-between align-items-center gap-lg-4 flex-wrap flex-md-nowrap">
                <div>
                    <div class="timeline-pin">
                        <i data-eva="cube-outline" class="size-4"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="rich-list-title mb-2">54 Products Arrived</h6>
                        <span class="rich-list-paragraph">New inventory added to warehouse</span>
                    </div>
                </div>
                <p class="text-muted mb-0 flex-shrink-0">15 mins ago</p>
            </div>
            <div class="timeline-item d-flex justify-content-between align-items-center gap-lg-4 flex-wrap flex-md-nowrap">
                <div>
                    <div class="timeline-pin">
                        <i data-eva="person-add-outline" class="size-4"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="rich-list-title mb-2">New Customer Registration</h6>
                        <span class="rich-list-paragraph">
                            <span class="text-body">Sarah Johnson</span> joined as premium member
                        </span>
                    </div>
                </div>
                <p class="text-muted mb-0 flex-shrink-0">1 hr ago</p>
            </div>
            <div class="timeline-item d-flex justify-content-between align-items-center gap-lg-4 flex-wrap flex-md-nowrap">
                <div>
                    <div class="timeline-pin">
                        <i data-eva="alert-triangle-outline" class="size-4"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="rich-list-title mb-2">Low Stock Alert</h6>
                        <span class="rich-list-paragraph">
                            <span class="text-body">iPhone 15 Pro</span> has only 5 units left
                        </span>
                    </div>
                </div>
                <p class="text-muted mb-0 flex-shrink-0">2 hrs ago</p>
            </div>
            <div class="timeline-item d-flex justify-content-between align-items-center gap-lg-4 flex-wrap flex-md-nowrap">
                <div>
                    <div class="timeline-pin">
                        <i data-eva="trending-up" class="size-4"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="rich-list-title mb-2">Sales Milestone Reached</h6>
                        <span class="rich-list-paragraph">Daily target of <span class="text-body">$10,000</span>
                            achieved</span>
                    </div>
                </div>
                <p class="text-muted mb-0 flex-shrink-0">3 hrs ago</p>
            </div>
            <div class="timeline-item d-flex justify-content-between align-items-center gap-lg-4 flex-wrap flex-md-nowrap">
                <div>
                    <div class="timeline-pin">
                        <i data-eva="star-outline" class="size-4"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="rich-list-title mb-2">New Product Review</h6>
                        <span class="rich-list-paragraph">5-star review on <span class="text-body">MacBook Pro
                                M3</span></span>
                    </div>
                </div>
                <p class="text-muted mb-0 flex-shrink-0">4 hrs ago</p>
            </div>
            <div class="timeline-item d-flex justify-content-between align-items-center gap-lg-4 flex-wrap flex-md-nowrap">
                <div>
                    <div class="timeline-pin">
                        <i data-eva="refresh" class="size-4"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="rich-list-title mb-2">Return Processed</h6>
                        <span class="rich-list-paragraph">
                            Refund of <span class="text-body">$89.99</span> completed for Order #12445
                        </span>
                    </div>
                </div>
                <p class="text-muted mb-0 flex-shrink-0">5 hrs ago</p>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer pt-0 p-4 d-flex align-items-center gap-2">
        <a href="#!" class="btn btn-primary w-100">View All Activities</a>
        <a href="#!" class="btn btn-light flex-shrink-0" data-bs-dismiss="offcanvas">Cancel</a>
    </div>
</div>

<!-- Switcher -->
<div class="offcanvas offcanvas-end border-0 data-theme-colors layout-customizer" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <div>
            <h5 class="offcanvas-title" id="offcanvasLabel">Display Options</h5>
            <p class="text-muted mb-0">Customize the layout and interface to match your style.</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div data-simplebar class="h-100">
            <div class="p-3">
                <h6 class="mb-3">Choose Layouts</h6>
                <div class="row gy-3">
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="customizer-layout01" name="data-layout" type="radio" value="vertical" class="form-check-input" checked>
                            <label class="form-check-label p-0 avatar-xl w-100" for="customizer-layout01">
                                <span class="d-flex h-100">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Vertical</h5>
                    </div>
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="customizer-layout02" name="data-layout" type="radio" value="horizontal" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100" for="customizer-layout02">
                                <span class="d-flex h-100 flex-column">
                                    <span class="bg-light d-flex p-1 gap-1 align-items-center">
                                        <span class="d-block p-1 bg-dark-subtle rounded me-1"></span>
                                        <span class="d-block p-1 pb-0 px-2 bg-dark-subtle"></span>
                                        <span class="d-block p-1 pb-0 px-2 bg-dark-subtle ms-auto"></span>
                                        <span class="d-block p-1 pb-0 px-2 bg-dark-subtle"></span>
                                    </span>
                                    <span class="bg-light d-block p-1 border-dark-subtle border-top"></span>
                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                    </div>
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="customizer-layout03" name="data-layout" type="radio" value="semibox" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100" for="customizer-layout03">
                                <span class="d-flex h-100">
                                    <span class="flex-shrink-0 m-1">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1 mt-1 me-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto mb-1 me-1"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Semibox</h5>
                    </div>
                    <!-- end col -->
                </div>

                <h6 class="my-3">Content Width:</h6>

                <div class="row gy-3">
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="defaultContent" name="data-content-width" type="radio" value="default" class="form-check-input" checked>
                            <label class="form-check-label p-0 avatar-xl w-100" for="defaultContent">
                                <span class="d-flex h-100">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Default</h5>
                    </div>
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="boxLayout" name="data-content-width" type="radio" value="boxed" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100" for="boxLayout">
                                <span class="d-flex h-100 px-2">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Boxed</h5>
                    </div>
                    <!-- end col -->
                </div>

                <h6 class="my-3">Layout Mode:</h6>

                <div class="row gy-3">
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="layout-light" name="data-bs-theme" type="radio" value="light" class="form-check-input" checked>
                            <label class="form-check-label p-0 avatar-xl w-100" for="layout-light">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Light</h5>
                    </div>
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="layout-dark" name="data-bs-theme" type="radio" value="dark" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100 bg-dark" for="layout-dark">
                                <span class="d-flex h-100">
                                    <span class="flex-shrink-0">
                                        <span class="bg-white bg-opacity-10 d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-white bg-opacity-10 rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-white bg-opacity-10 d-block p-1"></span>
                                            <span class="bg-white bg-opacity-10 d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Dark</h5>
                    </div>
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="automode" name="data-bs-theme" type="radio" value="auto" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100" for="automode">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">System</h5>
                    </div>
                    <!-- end col -->
                </div>

                <h6 class="my-3 sidebarSize">Sidebar Size:</h6>

                <div class="row gy-3 sidebarSize">
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="sidebar-default" name="data-sidebar" type="radio" value="default" class="form-check-input" checked>
                            <label class="form-check-label p-0 avatar-xl w-100" for="sidebar-default">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Default</h5>
                    </div>
                    <div class="col-4 sidebarSize">
                        <div class="border rounded overflow-hidden">
                            <input id="sidebar-medium" name="data-sidebar" type="radio" value="medium" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100" for="sidebar-medium">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                            <span class="d-block p-1 px-1 bg-dark-subtle rounded mb-2"></span>
                                            <span class="d-block p-1 px-1 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-1 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-1 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Medium</h5>
                    </div>
                    <div class="col-4 sidebarSize">
                        <div class="border rounded overflow-hidden">
                            <input id="sidebar-small" name="data-sidebar" type="radio" value="small" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100" for="sidebar-small">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                            <span class="d-block p-1 ps-1 pe-0 bg-dark-subtle rounded mb-2"></span>
                                            <span class="d-block p-1 ps-1 pe-0 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 ps-1 pe-0 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 ps-1 pe-0 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Small</h5>
                    </div>
                    <!-- end col -->
                </div>

                <h6 class="my-3">Sidebar Color:</h6>

                <div class="row gy-3">
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="sidebar-light" name="data-sidebar-color" type="radio" value="light" class="form-check-input" checked>
                            <label class="form-check-label p-0 avatar-xl w-100" for="sidebar-light">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Light</h5>
                    </div>
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="sidebar-dark" name="data-sidebar-color" type="radio" value="dark" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100" for="sidebar-dark">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-primary-dark d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-light opacity-25 rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-light opacity-25"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-light opacity-25"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-light opacity-25"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Dark</h5>
                    </div>
                    <!-- end col -->
                </div>

                <h6 class="my-3">Topbar Color:</h6>

                <div class="row gy-3">
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="topbar-light" name="data-topbar-color" type="radio" value="light" class="form-check-input" checked>
                            <label class="form-check-label p-0 avatar-xl w-100" for="topbar-light">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Light</h5>
                    </div>
                    <div class="col-4">
                        <div class="border rounded overflow-hidden">
                            <input id="topbar-dark" name="data-topbar-color" type="radio" value="dark" class="form-check-input">
                            <label class="form-check-label p-0 avatar-xl w-100" for="topbar-dark">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-2">
                                            <span class="d-block p-2 bg-dark-subtle rounded-circle mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-dark-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-primary-dark d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Dark</h5>
                    </div>
                    <!-- end col -->
                </div>
                <div id="sidebar-color" class="my-4">
                    <h6 class="mb-0 mt-5 fw-semibold">Primary Color</h6>
                    <p class="text-muted mb-2">Choose a color of Primary.</p>
                    <div class="d-flex flex-wrap main-sidebar-color gap-2">
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-01" value="default" checked>
                            <label class="form-check-label rounded" for="themeColor-01"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-02" value="orange">
                            <label class="form-check-label rounded" for="themeColor-02"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-05" value="green">
                            <label class="form-check-label rounded" for="themeColor-05"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-04" value="blue">
                            <label class="form-check-label rounded" for="themeColor-04"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-03" value="lime">
                            <label class="form-check-label rounded" for="themeColor-03"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-06" value="pink">
                            <label class="form-check-label rounded" for="themeColor-06"></label>
                        </div>
                    </div>
                </div>
                <div class="row modal-footer pt-4 border-top">
                    <div class="col-6">
                        <button type="button" class="btn btn-light w-100" data-reset="layouts"><i class="ri-reset-right-line"></i> Reset Layouts </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary w-100"><i class="ri-shopping-bag-3-line"></i> Buy
                            Now </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap bundle js -->
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Layouts main js -->
<script src="assets/libs/jquery/jquery.min.js"></script>

<!-- Metimenu js -->
<script src="assets/libs/metismenu/metisMenu.min.js"></script>

<!-- simplebar js -->
<script src="assets/libs/simplebar/simplebar.min.js"></script>

<script src="assets/libs/eva-icons/eva.min.js"></script>

<!-- Scroll Top init -->
<script src="assets/js/scroll-top.init.js"></script>
<!-- select2 -->
<script src="assets/libs/select2/js/select2.min.js"></script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Init js -->
<script src="assets/js/dashboard/invoice.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>



<!-- Bootstrap bundle js -->
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Layouts main js -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<!-- Metimenu js -->
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<!-- simplebar js -->
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/eva-icons/eva.min.js"></script>
<!-- Scroll Top init -->
<script src="assets/js/scroll-top.init.js"></script>
<!-- App js -->
<script src="assets/js/app.js"></script>
</body>
</html>