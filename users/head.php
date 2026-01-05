<?php
session_start();// start session
if( !isset( $_SESSION['Username'] )){
session_destroy();
header('location:../index.php');
}else{
$user = $_SESSION['Username'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Finanza</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="description" content="Loan management system for all kinds of loans - personal, business, and more. Streamline your lending process with our user-friendly platform.">
<meta name="keywords" content="loan management system, loan processing, lending platform, personal loans, business loans">
<meta name="author" content="I-Create Software Technology">
<!-- layout setup -->
<!-- <script type="module" src="assets/js/layout-setup.js"></script> -->
<!-- App favicon -->
<link rel="shortcut icon" href="../assets/images/logo-sm.png">
<!-- select2 -->
<link href="../assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
<!-- Simplebar Css -->
<link rel="stylesheet" href="../assets/libs/simplebar/simplebar.min.css">
<!-- Bootstrap Css -->
<link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
<!--icons css-->
<link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">
<!-- App Css-->
<link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
<!-- my css -->
<link href="../assets/css/mystyle.min.css" rel="stylesheet" type="text/css">
<!-- Include SheetJS library from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<!-- my jquery -->
<script src="../js/jquery-2.2.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>

.form-control {
    border: none;
    border-bottom: 2px solid #ccc;
    border-radius: 8;
}

.form-control:focus {
    box-shadow: none;
    border-bottom-color: #0d6efd;
}

/* Toast Container */
.toast{
    min-width: 300px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-left: 4px solid #28a745;
    overflow: hidden;
}

/* Toast Header */
.toast-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 12px 16px;
    display: flex;
    align-items: center;
}

.toast-header .fa-bell {
    color: #28a745;
    font-size: 16px;
}

.toast-header strong {
    color: #333;
    font-size: 14px;
}

.toast-header .btn-close {
    padding: 0;
    margin-left: auto;
}

/* Toast Body */
.toast-body {
    padding: 16px;
    background-color: #d4edda;
    color: #155724;
    font-size: 14px;
    border-top: 1px solid #c3e6cb;
}

.toast-body .fa-check {
    color: #28a745;
    margin-right: 8px;
    font-size: 16px;
}

/* Animation */
.toast.show {
    display: block !important;
    animation: slideInRight 0.3s ease-out;
}

.toast.hide {
    animation: slideOutRight 0.3s ease-in;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

/* Hover Effect */
.toast:hover {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}


</style>
</head>
<body>
<!-- logout function start-->
<script>
$(document).ready(function() { 

function redirect(){
document.location = "lock.php?id=<?php echo $user; ?>&&resume=<?php echo $_SERVER["REQUEST_URI"];?>"
}
setInterval(function(){
redirect();
}, 40 * 60 * 1000);
});

</script>

<?php
include('../config/db.php') ;
if (isset($_SESSION['Username'])) {
$user = $_SESSION['Username'];
$Query = "SELECT id, Staff_ID, Username, Location, Name, Password, Email, Branch, Branch_id, Pin, User_Group, Checks,
Address, Role_Categorys, Mapped, Status, Usertype, Phone, Zone, Zone_id, Country FROM users WHERE Username='$user'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$usid = $row['id'];
$User = $row['Username'];
$loc = $row['Location'];
$gr = $row['User_Group'];
$ct = $row['Role_Categorys'];
$mapped = $row['Mapped'];
$brss = $row['Branch'];
}
?>
<!-- Begin page -->
<div id="layout-wrapper">
<!-- Start topbar -->
<header id="page-topbar">
<div class="navbar-header">
<!-- Start Navbar-Brand -->
<div class="navbar-logo-box">
<a href="#" class="logo logo-dark">
<span class="logo-sm">
<h4 style="margin-top:10px;"><img src="../assets/images/logo-sm.png" class="dark-logo d-none" height="20" alt="Logo-Dark"><b style="font-size:19px;"> FINANZA</b></h4>
</span>
<span class="logo-lg">
<h4><img src="../assets/images/logo-sm.png" class="dark-logo" height="30" alt="Logo-Dark"><b> FINANZA</b></h4>
</span>
</a>
<a href="#" class="logo logo-light">
<span class="logo-sm">
<h4 style="margin-top:10px;"><img src="../assets/images/logo-sm.png" class="dark-logo d-none" height="20" alt="Logo-Dark"><b style="font-size:19px;"> FINANZA</b></h4>
</span>
<span class="logo-lg">
<h4><img src="../assets/images/logo-sm.png" class="dark-logo" height="30" alt="Logo-Dark"><b> FINANZA</b></h4>
</span>
</a>
<button type="button" class="btn btn-icon top-icon sidebar-btn" id="sidebar-btn" aria-label="Toggle navigation"><i class="mdi mdi-menu-open align-middle" style="margin-left:60px; font-size:25px"></i></button>
<button type="button" class="btn btn-icon top-icon sidebar-horizontal-btn d-none" aria-label="Toggle navigation"><i class="mdi mdi-menu align-middle fs-17"></i></button>
</div>
<!-- Start menu -->
<div class="d-flex justify-content-between menu-sm px-4 ms-auto">
<div class="d-flex align-items-center gap-2">
<div class="dropdown d-none d-lg-block">
<button type="button" class="btn btn-primary dropdown-toggle btn-sm" hidden data-bs-toggle="dropdown" aria-expanded="false">Apps</button>
<div class="dropdown-menu dropdown-menu-start dropdown-menu-animated">
<a href="#!" class="dropdown-item">
<span class="dropdown-content"><i class="mdi mdi-briefcase-outline me-2 text-muted fs-15 align-middle"></i>Inventory Manager</span>
</a>
<a href="#!" class="dropdown-item">
<span class="dropdown-content"><i class="mdi mdi-file-document-remove-outline me-2 text-muted fs-15 align-middle"></i>Invoice</span>
</a>
<a href="pages-contact.html" class="dropdown-item">
<span class="dropdown-content"><i class="mdi mdi-account-outline me-2 text-muted fs-15 align-middle"></i>My Account</span>
</a>
</div>
</div>
</div>
<div class="d-flex align-items-center gap-3">
<!--Start App Search-->
<form class="app-search d-none d-lg-block me-2">
<div class="position-relative">
<input type="text" class="form-control" placeholder="Search...">
<i data-eva="search-outline" class="align-middle"></i>
</div>
</form>


<!-- Start Notifications -->
<div class="dropdown d-inline-block">
<button type="button" class="btn btn-icon top-icon d-md-block" id="light-dark-mode" aria-label="Toggle Light/Dark">
<i class="mdi mdi-brightness-7 align-middle"></i>
<i class="mdi mdi-white-balance-sunny align-middle"></i>
</button>
</div>
<!-- Start Profile -->
<div class="dropdown d-inline-block ps-3 ms-2 border-start admin-user-info">
<button type="button" aria-label="profile" class="btn btn-sm p-0" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="avatar avatar-xs p-1 d-inline-block">
<img src="<?php echo $row['Location']; ?>" class="img-fluid" style="border-radius:5px; height:30px">
</span>
<span class="d-none d-xl-inline-block ms-1 fw-semibold fs-14 admin-name"><?php echo $row['Name']; ?></span>
<i class="mdi mdi-chevron-down align-middle fs-16 d-none d-xl-inline-block"></i>
</button>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end dropdown-menu-animated overflow-hidden py-0">
<div class="card mb-0">
<div class="card-header">
<div class="rich-list-item w-100 p-0">
<div class="rich-list-prepend">
<span class="rounded avatar-sm p-1 bg-body d-flex">
<img src="<?php echo $row['Location']; ?>" class="img-fluid">
</span>
</div>
<div class="rich-list-content">
<h3 class="rich-list-title fs-13 mb-1"><?php echo $row['Name']; ?></h3>
<span class="rich-list-subtitle"><?php echo $row['User_Group']; ?></span>
</div>
<div class="rich-list-append"><span class="badge badge-label-primary fs-6">6+</span></div>
</div>
</div>
<br>
<div class="container">
<div class="row">
<div class="col-6">
<a href="lock.php?id=<?php echo $row['Username']; ?>&&resume=<?php echo $_SERVER["REQUEST_URI"];?>" >
<div class="d-grid gap-2">
<button class="btn btn-outline-info btn-block"><i class="fas fa-lock"></i> Lockscreen</button>
</div>
</a>
</div>
<div class="col-6">
<a href="../config/session.php">
<div class="d-grid gap-2">
<button class="btn btn-outline-danger btn-block"><i class="fas fa-power-off"></i> Sign-Out</button>
</div>
</a>
</div>
</div>
<br>
</div>

</div>
</div>
</div>
</div>
</div>
<!-- End menu -->
</div>
</header>
<!-- End topbar -->
<!-- ========== Left Sidebar Start ========== -->
<div class="sidebar-left">
<div class="sidebar-slide h-100" data-simplebar>
<!--- Sidebar-menu -->
<div id="sidebar-menu">
<!-- Left Menu Start -->
<ul class="left-menu list-unstyled" id="side-menu">
<li>
<a href="home.php" style="font-size:12px;">
<i class="fas fa-square"></i>
<span>DASHBOARD</span>
</a>
</li>
<li class="menu-title">Menu List</li>
<?php
include '../config/db.php';
//Get branch Details
$Query = "SELECT DISTINCT Tab FROM control WHERE Role_Categorys = '$ct' AND Groups = '$gr' ORDER BY Tab ASC";
//echo $Query, "<br>";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$tab = $rows['Tab'];
?>
<li>
<a href="javascript: void(0);" class="has-arrow" style="font-size:12px;">
<i class="fas fa-square"></i>
<span><?php echo $tab; ?></span>
</a>
<ul class="sub-menu mm-collapse" aria-expanded="false">
<?php
$Query = "SELECT role, Name FROM control WHERE Tab = '$tab' AND Groups = '$gr' AND Role_Categorys = '$ct' ORDER BY Name ASC";
$mresult = mysqli_query($con, $Query);
$mCount = mysqli_num_rows($mresult);
if ($mCount > 0) {
for ($mj=0 ; $mj < $mCount; $mj++){
$mrows = mysqli_fetch_array($mresult);
$mroles = $mrows['role'];
$name = $mrows['Name'];

?>
<li><a href="<?php echo $mroles; ?>.php"><?php echo $name; ?> </a></li>
<?php
}
}
?>
</ul>
</li>
<?php  
}
}else {
//$Available = false; 
echo "<i style='margin-left:20px'>No Menu Available</i>";       

}
?>
</ul>
</div>
<!-- Sidebar -->
</div>
</div>



<div class="modal" id="loader" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true" style="display:none;">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<center>
<br>
<i>
<img src="../loader/loader.gif" style="height:20px"> Loading Data ! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>


<div class="modal" id="please" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true" style="display:none;">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<center>
<br>
<i>
<img src="../loader/loader.gif" style="height:20px"> Waiting For Response ! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>


<div class="modal" id="view" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-sm" style=" width:300px">
<div class="modal-content">
<div class="modal-body">
<br>
<center>
<i>
<img src="../loader/loader.gif" style="height:20px"> Loading Data ! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>
