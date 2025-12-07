<?php include "header.php"; ?>

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
<h3 class="mb-sm-0">Dashboard</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<div class="row">
<div class="col-sm-8">


<div class="row">
<div class="col-sm-6">

<div class="card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-12">
<h6 class="mb-0 fs-14 fw-medium text-truncate">Users</h6>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM users WHERE Status = 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
//echo $total;
mysqli_close($con);
?>
<div class="d-flex align-items-center gap-3">
<span class="text-success fw-medium flex-shrink-0"><i class="fas fa-users" class="size-6 me-1" style="font-size:20px;"></i></span>
</div>
</div>
<p class="mt-3 display-6 fw-normal mb-2"><span data-counter="<?php echo $total; ?>"></span></p>
<span class="text-muted"><span class="text-success fw-medium me-1">+ <?php echo $total; ?></span> Today</span>
<div class="position-absolute bottom-0 end-0">
<div id="spark1" data-colors='["var(--bs-success)"]' class="apex-charts" dir="ltr"></div>
</div>
<div class="position-absolute h-32 w-32 bg-success rounded-circle blury-effect"></div>
</div>
</div>





</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-12">
<h6 class="mb-0 fs-14 fw-medium text-truncate">Branch</h6>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM branch WHERE Status = 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
mysqli_close($con);
?>
<div class="d-flex align-items-center gap-3">
<span class="text-primary fw-medium flex-shrink-0"><i class="fas fa-city" class="size-4 me-1" style="font-size:20px;"></i></span>
</div>
</div>
<p class="mt-3 display-6 fw-normal mb-2"><span data-counter="<?php echo $total; ?>"></span></p>
<span class="text-muted"><span class="text-success fw-medium me-1">+ <?php echo $total; ?></span> Today</span>
<div class="position-absolute bottom-0 end-0">
<div id="spark2" data-colors='["var(--bs-primary)"]' class="apex-charts" dir="ltr"></div>
</div>
<div class="position-absolute h-32 w-32 bg-primary rounded-circle blury-effect"></div>
</div>
</div>



</div>
</div>

<div class="row">
<div class="col-sm-6">

<div class="card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-12">
<h6 class="mb-0 fs-14 fw-medium text-truncate">Product</h6>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM product");
$row = mysqli_fetch_array($result);
$total = $row[0];
mysqli_close($con);
?>
<div class="d-flex align-items-center gap-3">
<span class="text-warning fw-medium flex-shrink-0"><i class="fas fa-star" style="font-size:20px;"></i></span>
</div>
</div>
<p class="mt-3 display-6 fw-normal mb-2"><span data-counter="<?php echo $total; ?>"></span></p>
<span class="text-muted"><span class="text-success fw-medium me-1">+ <?php echo $total; ?></span> Today</span>
<div class="position-absolute bottom-0 end-0">
<div id="spark3" data-colors='["var(--bs-warning)"]' class="apex-charts" dir="ltr"></div>
</div>
<div class="position-absolute h-32 w-32 bg-warning rounded-circle blury-effect"></div>
</div>
</div>


</div>
<div class="col-sm-6">

<div class="card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-12">
<h6 class="mb-0 fs-14 fw-medium text-truncate">Role</h6>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM role WHERE Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
mysqli_close($con);
?>
<div class="d-flex align-items-center gap-3">
<span class="text-info fw-medium flex-shrink-0"><i class="fas fa-user-plus" style="font-size: 20px;"></i></span>
</div>
</div>
<p class="mt-3 display-6 fw-normal mb-2"><span data-counter="<?php echo $total; ?>"></span></p>
<span class="text-muted"><span class="text-success fw-medium me-1">+ <?php echo $total; ?></span> Today</span>
<div class="position-absolute bottom-0 end-0">
<div id="spark4" data-colors='["var(--bs-info)"]' class="apex-charts" dir="ltr"></div>
</div>
<div class="position-absolute h-32 w-32 bg-info rounded-circle blury-effect"></div>
</div>
</div>


</div>
</div>


</div>
<div class="col-sm-4">


<div class="card">
<div class="card-header">
<div class="row g-0">
<div class="col-6 border-end d-flex justify-content-end">
<div class="d-flex align-items-start gap-4 pe-4 py-3 text-end">
<div>
<h6 class="mb-1">Deactivated User</h6>
<p class="text-muted fw-medium mb-0">
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM users WHERE Status != 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</p>
</div>
<div class="size-2 bg-danger rounded-circle mt-1"></div>
</div>
</div>
<div class="col-6">
<div class="d-flex align-items-start gap-4 ps-4 py-3">
<div class="size-2 bg-success rounded-circle mt-1"></div>
<div>
<h6 class="mb-1">Active User</h6>
<p class="text-muted fw-medium mb-0">
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM users WHERE Status = 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</p>
</div>
</div>
</div>
<div class="col-6 border-end d-flex justify-content-end">
<div class="d-flex align-items-start gap-4 pe-4 py-3 text-end">
<div>
<h6 class="mb-1">Closed Branch</h6>
<p class="text-muted fw-medium mb-0">
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM branch WHERE Status != 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</p>
</div>
<div class="size-2 bg-info rounded-circle mt-1"></div>
</div>
</div>
<div class="col-6">
<div class="d-flex align-items-start gap-4 ps-4 py-3">
<div class="size-2 bg-warning rounded-circle mt-1"></div>
<div>
<h6 class="mb-1">Deactivated Product</h6>
<p class="text-muted fw-medium mb-0">
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM product WHERE Status != 'Activated'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</p>
</div>
</div>
</div>
<hr>

<div class="mb-5">
<br>
<h6 class="mb-3">Online User's</h6>
<div class="d-flex align-items-center gap-2">
<?php
include '../config/db.php';
$Query = "SELECT  * FROM users ORDER BY Name DESC LIMIT 8";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pix= $rows['Location'];
?>
<a href="#!" class="avatar avatar-sm avatar-circle">
<img src="<?php echo $pix; ?>" class="size-7" alt="Client">
</a>
<?php
}
}
mysqli_close($con);
?>
</div>
</div>
<div class="mb-3">
<label for="transferClient" class="form-label">Select User</label>
<select id="transferClient" class="form-select">
<option selected disabled>Choose user...</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Name FROM users WHERE Status = 'Activate' ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$nx= $rows['id']; // union id
$name= $rows['Name'];
?>
<option value="<?php echo $nx; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
</div>






</div>
</div>
</div>

<div class="card">
<div class="card-body">
<h5 class="card-title mb-0"><i class="fas fa-history"></i> Recent Onboarded User's</h5>
<br>

<div id="table-container" style="height:152px;">
<table>
<thead>
<tr>
<th style="font-size:8px">PICTURE</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">ROLE</th>
<th style="font-size:8px">EMAIL</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include '../config/db.php';
$Query = "SELECT  * FROM users ORDER BY id DESC LIMIT 4";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
?>
<tr style="font-size:8px">
<td><img src="<?php echo $rows['Location']; ?>" style="border-radius:20px" class="size-4" alt="Client"></td>
<td style="text-transform:capitalize"><?php echo $rows['Name']; ?></td>
<td><?php echo $rows['User_Group']; ?></td>
<td><?php echo $rows['Email']; ?></td>
<td><?php echo $rows['Branch']; ?></td>
<td><span class="badge badge-label-success" style="font-size:7px;"><?php echo $rows['Status']; ?></span></td>
</tr>
<?php
}
}
mysqli_close($con);
?>
</tbody>
</table>
</div>


</div>
</div>








<?php include "../footer.php"; ?>