<?php
session_start();// start session
if( !isset( $_SESSION['Username'] )){
$user = $_SESSION['Username'];
header("Location:../index.php");
}else{
$user = $_SESSION['Username'];
}
?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../js/jquery-2.2.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" 
integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Sweetalert 2 CSS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- my css -->
<link href="../assets/css/mystyle.min.css" rel="stylesheet" type="text/css">
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
}
?>
<!-- Begin page -->
<div class="wrapper">
<!-- Topbar Start -->
<header class="app-topbar">
<div class="container-fluid topbar-menu">
<div class="d-flex align-items-center justify-content-center gap-2">
<!-- Topbar Brand Logo -->
<div class="logo-topbar">
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
</div>
<div class="d-lg-none d-flex mx-1">
<a href="#">
<img src="../assets/images/logo-sm.png" height="28" alt="Logo">
</a>
</div>
<!-- Sidebar Hover Menu Toggle Button -->
<button class="button-collapse-toggle d-xl-none">
<i data-lucide="menu" class="fs-22 align-middle"></i>
</button>
<!-- Topbar Link Item -->
<div class="topbar-item d-none d-lg-flex">
<a href="#!" class="topbar-link btn shadow-none btn-link px-2 disabled"> [ v 2.0.0 ]</a>
</div>
<!-- Topbar Link Item -->
<div class="topbar-item d-none d-lg-flex">
<i class="fa fa-lock"></i>
<a href="lock.php?id=<?php echo $row['Username']; ?>&&resume=<?php echo $_SERVER["REQUEST_URI"];?>" class="topbar-link btn shadow-none btn-link px-2">   Lockscreen</a>
</div>
<!-- Dropdown -->
<div class="topbar-item" style="display: none;">
<div class="dropdown">
<a href="#!" class="topbar-link btn shadow-none btn-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,13">
Dropdown <i class="ti ti-chevron-down ms-1"></i>
</a>
<div class="dropdown-menu">
<a class="dropdown-item" href="#!">
<i class="ti ti-user-plus fs-15 me-1"></i> Add Project Member
</a>
<a class="dropdown-item" href="#!">
<i class="ti ti-activity fs-15 me-1"></i> View Activity
</a>
<a class="dropdown-item" href="#!">
<i class="ti ti-settings fs-15 me-1"></i> Settings
</a>
</div> <!-- end dropdown-menu-->
</div> <!-- end dropdown-->
</div> <!-- end topbar item-->
<!-- Mega Menu Dropdown -->
<div class="topbar-item d-none d-md-flex">
<div class="dropdown" style="display: none;">
<button class="topbar-link btn shadow-none btn-link px-2 dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,13" type="button" aria-haspopup="false" aria-expanded="false">
Mega Menu <i class="ti ti-chevron-down ms-1"></i>
</button>
<div class="dropdown-menu dropdown-menu-xxl p-0">
<div class="h-100" style="max-height: 380px;" data-simplebar>
<div class="row g-0">
<div class="col-md-4">
<div class="p-3">
<h5 class="fw-semibold fs-sm dropdown-header">Workspace Tools</h5>
<ul class="list-unstyled">
<li><a href="javascript:void(0);" class="dropdown-item">My Dashboard</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Recent Activity</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Notifications Center</a></li>
<li><a href="javascript:void(0);" class="dropdown-item">File Manager</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Calendar View</a>
</li>
</ul>
</div>
</div>
<div class="col-md-4">
<div class="p-3">
<h5 class="fw-semibold fs-sm dropdown-header">Team Operations</h5>
<ul class="list-unstyled">
<li><a href="javascript:void(0);" class="dropdown-item">Team Overview</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Meeting Schedule</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Timesheets</a></li>
<li><a href="javascript:void(0);" class="dropdown-item">Feedback Hub</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Resource Allocation</a></li>
</ul>
</div>
</div>
<div class="col-md-4">
<div class="p-3">
<h5 class="fw-semibold fs-sm dropdown-header">Account Settings</h5>
<ul class="list-unstyled">
<li><a href="javascript:void(0);" class="dropdown-item">Profile Settings</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Billing & Plans</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Integrations</a>
</li>
<li><a href="javascript:void(0);" class="dropdown-item">Privacy & Security</a></li>
<li><a href="javascript:void(0);" class="dropdown-item">Support Center</a>
</li>
</ul>
</div> <!-- end dropdown-->
</div> <!-- end col-->
</div> <!-- end row-->
</div> <!-- end .h-100-->
</div> <!-- .dropdown-menu-->
</div> <!-- .dropdown-->
</div> <!-- end topbar-item -->
</div> <!-- .d-flex-->
<div class="d-flex align-items-center gap-2">
<!-- Search -->
<div class="app-search d-none d-xl-flex me-xl-2">
<input type="search" class="form-control topbar-search" name="search" placeholder="Search for something...">
<i data-lucide="search" class="app-search-icon text-muted"></i>
</div>
<!-- Theme Dropdown -->
<div class="topbar-item me-2">
<div class="dropdown" data-dropdown="custom">
<button class="topbar-link  fw-semibold" data-bs-toggle="dropdown" data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">
<img data-trigger-img src="assets/images/themes/shadcn.svg" alt="user-image" class="w-100 rounded me-2" height="18">
<span data-trigger-label class="text-nowrap"> Shadcn </span>
<span class="dot-blink" aria-label="live status indicator"></span>
</button>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-1">
<div class="h-100" style="max-height: 250px;" data-simplebar>
<div class="row g-0">
<div class="col-md-6">
<button class="dropdown-item position-relative drop-custom-active" data-skin="shadcn">
<img src="../assets/images/themes/shadcn.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Shadcn</span>
</button>
<button class="dropdown-item position-relative" data-skin="corporate">
<img src="../assets/images/themes/corporate.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Corporate</span>
</button>
<button class="dropdown-item position-relative" data-skin="spotify">
<img src="../assets/images/themes/spotify.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Spotify</span>
</button>
<button class="dropdown-item position-relative" data-skin="saas">
<img src="../assets/images/themes/saas.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">SaaS</span>
</button>
<button class="dropdown-item position-relative" data-skin="nature">
<img src="../assets/images/themes/nature.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Nature</span>
</button>
<button class="dropdown-item position-relative" data-skin="vintage">
<img src="../assets/images/themes/vintage.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Vintage</span>
</button>
<button class="dropdown-item position-relative" data-skin="leafline">
<img src="../assets/images/themes/leafline.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Leafline</span>
</button>
</div>
<div class="col-md-6">
<button class="dropdown-item position-relative" data-skin="ghibli">
<img src="../assets/images/themes/ghibli.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Ghibli</span>
</button>
<button class="dropdown-item position-relative" data-skin="slack">
<img src="../assets/images/themes/slack.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Slack</span>
</button>
<button class="dropdown-item position-relative" data-skin="material">
<img src="../assets/images/themes/material.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Material Design</span>
</button>
<button class="dropdown-item position-relative" data-skin="flat">
<img src="../assets/images/themes/flat.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Flat</span>
</button>
<button class="dropdown-item position-relative" data-skin="pastel">
<img src="../assets/images/themes/pastel.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Pastel Pop</span>
</button>
<button class="dropdown-item position-relative" data-skin="caffieine">
<img src="../assets/images/themes/caffieine.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Caffieine</span>
</button>
<button class="dropdown-item position-relative" data-skin="redshift">
<img src="../assets/images/themes/redshift.svg" alt="" class="me-1 rounded" height="18">
<span class="align-middle">Redshift</span>
</button>
</div>
</div> <!-- end row-->
</div> <!-- end .h-100-->
</div> <!-- .dropdown-menu-->
</div> <!-- end dropdown-->
</div> <!-- end topbar item-->


<!-- Notification Dropdown -->
<div class="topbar-item">
<div class="dropdown">
<button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,19" type="button" data-bs-auto-close="outside" aria-haspopup="false"
aria-expanded="false">
<i data-lucide="bell" class="fs-xxl"></i>
<span class="badge badge-square text-bg-success topbar-badge">9</span>
</button>
<div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
<div class="px-3 py-2 border-bottom">
<div class="row align-items-center">
<div class="col">
<h6 class="m-0 fs-md fw-semibold">Notifications</h6>
</div>
<div class="col text-end">
<a href="#!" class="badge text-bg-light badge-label py-1">9 Alerts</a>
</div>
</div>
</div>
<div style="max-height: 300px;" data-simplebar>
<!-- item 1 -->
<div class="dropdown-item notification-item py-2 text-wrap" id="notification-1">
<span class="d-flex gap-2">
<span class="avatar-md flex-shrink-0">
<span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-22">
<i data-lucide="cloud-cog" class="fs-xl fill-primary"></i>
</span>
</span>
<span class="flex-grow-1 text-muted">
<span class="fw-medium text-body">Backup completed successfully</span><br>
<span class="fs-xs">Just now</span>
</span>
<button type="button" class="flex-shrink-0 text-muted btn shadow-none btn-link p-0" data-dismissible="#notification-1">
<i data-lucide="circle-x" class="fs-xxl"></i>
</button>
</span>
</div>
<!-- item 2 -->
<div class="dropdown-item notification-item py-2 text-wrap" id="notification-2">
<span class="d-flex gap-2">
<span class="avatar-md flex-shrink-0">
<span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-22">
<i data-lucide="bug" class="fs-xl fill-primary"></i>
</span>
</span>
<span class="flex-grow-1 text-muted">
<span class="fw-medium text-body">New bug reported in Payment Module</span><br>
<span class="fs-xs">8 minutes ago</span>
</span>
<button type="button" class="flex-shrink-0 text-muted btn shadow-none btn-link p-0" data-dismissible="#notification-2">
<i data-lucide="circle-x" class="fs-xxl"></i>
</button>
</span>
</div>
</div> 
<!-- end dropdown -->
</div>
</div>
</div>

<!-- Button Trigger Customizer Offcanvas -->
<div class="topbar-item d-none d-sm-flex">
<button class="topbar-link" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" type="button">
<i data-lucide="settings" class="fs-xxl"></i>
</button>
</div>
<!-- Light/Dark Mode Button -->
<div class="topbar-item d-none d-sm-flex">
<button class="topbar-link" id="light-dark-mode" type="button">
<i data-lucide="moon" class="fs-xxl mode-light-moon"></i>
<i data-lucide="sun" class="fs-xxl mode-light-sun"></i>
</button>
</div>
<!-- Monochrome Mode Button -->
<div class="topbar-item d-none d-sm-flex">
<button class="topbar-link" id="monochrome-mode" type="button">
<i data-lucide="palette" class="fs-xxl mode-light-moon"></i>
</button>
</div>
<!-- User Dropdown -->
<div class="topbar-item nav-user">
<div class="dropdown">
<a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,13" href="#!" aria-haspopup="false" aria-expanded="false">
<img src="../assets/images/users/user-2.jpg" width="32" class="rounded-circle d-flex" alt="user-image">
</a>
<div class="dropdown-menu dropdown-menu-end">
<!-- Header -->
<div class="dropdown-header noti-title">
<h6 class="text-overflow m-0">Welcome back!</h6>
</div>
<!-- My Profile -->
<a href="#!" class="dropdown-item">
<i class="ti ti-user-circle me-2 fs-17 align-middle"></i>
<span class="align-middle">Profile</span>
</a>
<!-- Logout -->
<a href="../config/session.php" class="dropdown-item text-danger fw-semibold">
<i class="ti ti-logout-2 me-2 fs-17 align-middle"></i>
<span class="align-middle">Log Out</span>
</a>
</div>
</div>
</div>
</div>
</div>
</header>
<!-- Topbar End -->

<script>
// Skin Dropdown
document.querySelectorAll('[data-dropdown="custom"]').forEach(dropdown => {
const trigger = dropdown.querySelector('a[data-bs-toggle="dropdown"], button[data-bs-toggle="dropdown"]');
const items = dropdown.querySelectorAll('button[data-skin]');
const triggerImg = trigger.querySelector('[data-trigger-img]');
const triggerLabel = trigger.querySelector('[data-trigger-label]');
const config = JSON.parse(JSON.stringify(window.config));
const currentSkin = config.skin;
items.forEach(item => {
const itemSkin = item.getAttribute('data-skin');
const itemImg = item.querySelector('img')?.getAttribute('src');
const itemText = item.querySelector('span')?.textContent.trim();
// Set active on load
if (itemSkin === currentSkin) {
item.classList.add('drop-custom-active');
if (triggerImg && itemImg) triggerImg.setAttribute('src', itemImg);
if (triggerLabel && itemText) triggerLabel.textContent = itemText;
} else {
item.classList.remove('drop-custom-active');
}
// Click handler
item.addEventListener('click', function () {
items.forEach(i => i.classList.remove('drop-custom-active'));
this.classList.add('drop-custom-active');
const newImg = this.querySelector('img')?.getAttribute('src');
const newText = this.querySelector('span')?.textContent.trim();
if (triggerImg && newImg) triggerImg.setAttribute('src', newImg);
if (triggerLabel && newText) triggerLabel.textContent = newText;
if (typeof layoutCustomizer !== 'undefined') {
layoutCustomizer.changeSkin(itemSkin);
}
});
});
});
</script>

<!-- Sidenav Menu Start -->
<div class="sidenav-menu">
<div class="scrollbar" data-simplebar>
<!-- User -->
<div class="sidenav-user text-nowrap border border-dashed rounded-3">
<a href="#!" class="sidenav-user-name d-flex align-items-center">
<img src="../assets/images/users/user-2.jpg" width="36" class="rounded-circle me-2 d-flex" alt="user-image">
<span>
<h5 class="my-0 fw-semibold"><?php echo $row['Name']; ?></h5>
<h6 class="my-0 text-muted">Admin Head</h6>
</span>
</a>
</div>

<!--- Sidenav Menu -->
<ul class="side-nav">
<li class="side-nav-item">
<a href="index.php" class="side-nav-link page-link">
<span class="menu-icon"><i data-lucide="layout-grid"></i></span>
<span class="menu-text" data-lang="dashboard">Dashboard</span>
</a>
</li>
<li class="side-nav-item">
<a href="assign_role.php" class="side-nav-link">
<span class="menu-icon"><i data-lucide="plus"></i></span>
<span class="menu-text" data-lang="assign"> Assign Role </span>
</a>
</li>
<li class="side-nav-item">
<a href="branch.php" class="side-nav-link">
<span class="menu-icon"><i data-lucide="house"></i></span>
<span class="menu-text" data-lang="branch"> Branch </span>
</a>
</li>
<li class="side-nav-item">
<a href="#" class="side-nav-link">
<span class="menu-icon"><i data-lucide="database"></i></span>
<span class="menu-text" data-lang="database"> Database </span>
</a>
</li>
<li class="side-nav-item">
<a href="product.php" class="side-nav-link">
<span class="menu-icon"><i data-lucide="star"></i></span>
<span class="menu-text" data-lang="role"> Product </span>
</a>
</li>
<li class="side-nav-item">
<a href="role_maintenance.php" class="side-nav-link">
<span class="menu-icon"><i data-lucide="cog"></i></span>
<span class="menu-text" data-lang="role"> Role Maintenance </span>
</a>
</li>
<li class="side-nav-item">
<a href="user_group.php" class="side-nav-link">
<span class="menu-icon"><i data-lucide="user-plus"></i></span>
<span class="menu-text" data-lang="group"> User Group </span>
</a>
</li>
<li class="side-nav-item">
<a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false" aria-controls="sidebarPages" class="side-nav-link">
<span class="menu-icon"><i data-lucide="Users"></i></span>
<span class="menu-text" data-lang="pages"> User Account </span>
<span class="menu-arrow"></span>
</a>
<div class="collapse" id="sidebarPages">
<ul class="sub-menu">
</li>
<li class="side-nav-item">
<a href="manage_user.php" class="side-nav-link">
<span class="menu-text" data-lang="pages-empty">Manage User</span>
</a>
</li>
</ul>
</div>
</li>

<li class="side-nav-item">
<a href="admin_reset.php" class="side-nav-link">
<span class="menu-icon"><i data-lucide="user-cog"></i></span>
<span class="menu-text" data-lang="charts"> Admin Reset </span>
</a>
</li>
</ul>
</div>
<div class="menu-collapse-box d-none d-xl-block">
<button class="button-collapse-toggle">
<i data-lucide="square-chevron-left" class="align-middle flex-shrink-0"></i> <span>Collapse Menu</span>
</button>
</div>
</div>
<!-- Sidenav Menu End -->

<script>
// Note: If you do not want any of this logic here, you can remove it. It's already in app.js. This is for removing delays.
// Sidenav Icons
lucide.createIcons();
// Sidenav Link Activation
const currentUrlT = window.location.href.split(/[?#]/)[0];
const currentPageT = window.location.pathname.split("/").pop();
const sideNavT = document.querySelector('.side-nav');
document.querySelectorAll('.side-nav-link[href]').forEach(link => {
const linkHref = link.getAttribute('href');
if (!linkHref) return;
const match = linkHref === currentPageT || link.href === currentUrlT;
if (match) {
// Mark link and its li active
link.classList.add('active');
const li = link.closest('li.side-nav-item');
if (li) li.classList.add('active');
// Expand all parent .collapse and set toggles
let parentCollapse = link.closest('.collapse');
while (parentCollapse) {
parentCollapse.classList.add('show');
const parentToggle = document.querySelector(`a[href="#${parentCollapse.id}"]`);
if (parentToggle) {
parentToggle.setAttribute('aria-expanded', 'true');
const parentLi = parentToggle.closest('li.side-nav-item');
if (parentLi) parentLi.classList.add('active');
}
parentCollapse = parentCollapse.parentElement.closest('.collapse');
}
}
});
</script>

<!-- ============================================================== -->
<!-- Start Main Content -->
<!-- ============================================================== -->
<div class="content-page">
<div class="container-fluid">
<div class="card" style="margin-top: 50px;">
<div class="card-body">
<div class="row">
<div class="col-sm-9">
<p3 style="float:left;">
<script type="text/javascript">
document.write("<center>");
var day = new Date();
var hr = day.getHours();
if (hr >= 0 && hr < 12) {
document.write("Good Morning!: <span style='text-transform:capitalize'><?php echo $row['Name']; ?></span>");
} else if (hr == 12) {
document.write("Good Noon!: <span style='text-transform:capitalize'><?php echo $row['Name'];; ?></span>");
} else if (hr >= 12 && hr <= 17) {
document.write("Good Afternoon!:<span style='text-transform:capitalize'> <?php echo $row['Name'];; ?></span>");
} else {
document.write("Good Evening!: <span style='text-transform:capitalize'><?php echo $row['Name'];; ?></span>");
}document.write("</font></center>");
</script>
</p3>
</div>
<div class="col-sm-3">
<div class="row">
<div class="col-sm-6">
<span>Branch: <?php echo $row['Branch']; ?></span>
</div>
<div class="col-sm-6">
<span>Staff ID: <?php echo $row['Staff_ID']; ?></span>
</div>
</div>




</div>
</div>


</div>
</div>






<div class="modal" id="loader" tabindex="-1" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<center>
<i>
<img src="../loader/loader.gif" style="height:20px"> Loading Data ! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>


<div class="modal" id="please" tabindex="-1" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<center>
<i>
<img src="../loader/loader.gif" style="height:20px"> Waiting For Response ! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>