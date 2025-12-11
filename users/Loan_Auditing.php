

<?php include 'head.php'; ?>

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
<h3 class="mb-sm-0">Auditing</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Auditing</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Auditing</a></li>
<li class="breadcrumb-item active" aria-current="page">Loan Auditing</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->



<br>
<br>
<br>
<div class="row">
<div class="col-sm-2">
<label><i style="color:red">*</i> Branch</label>
<select class="form-control" name="br" id="br" oninput="myStatus()">
<option value="">Select Branch</option>
<?php 
include '../config/db.php';
$Query = "SELECT Branches, Branches_id FROM zone_mapping WHERE Usernames = '$User' AND Status = 'Mapped' ORDER BY Branches ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['Branches_id']; // branch id
$name= $rows['Branches'];
?>
<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div><br>
<div class="card">
<div class="card-body">
<br>
<div id="result"></div>
</div>
</div>











<?php include '../footer.php'; ?>