<?php include 'header.php'; ?>


<div class="row">
<div class="col-xl-4 col-md-4 col-sm-4">
<div class="card">
<div class="card-body">
<div>
<h5 class="text-uppercase">Total User's</h5>
</div>
<div class="mb-3">
<canvas id="promptsChart" height="100"></canvas>
</div>
<div class="d-flex justify-content-between">
<div>
<span class="text-muted">Active User</span>
<div class="fw-semibold"><?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM users WHERE Status = 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?><span>

</span></div>
</div>
<div class="text-end">
<span class="text-muted">Non-Active</span>
<div class="fw-semibold"><span>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM users WHERE Status != 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</span> <i class="ti ti-arrow-down"></i></div>
</div>
</div>


</div>
</div>
</div>
<div class="col-xl-4 col-md-4 col-sm-4">
<div class="card">
<div class="card-body">
<div>
<h5 class="text-uppercase">Total Branch</h5>
</div>
<div class="mb-3">
<canvas id="tokenChart" height="100"></canvas>
</div>
<div class="d-flex justify-content-between">
<div>
<span class="text-muted">Active Branch</span>
<div class="fw-semibold"><span>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM branch WHERE Status = 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</span></div>
</div>
<div class="text-end">
<span class="text-muted">Non-Branch</span>
<div class="fw-semibold"><span>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM users WHERE Status != 'Activate'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</span> <i class="ti ti-arrow-down"></i></div>
</div>
</div>



</div>
</div>
</div>
<div class="col-xl-4 col-md-4 col-sm-4">
<div class="card">
<div class="card-body">
<div>
<h5 class="text-uppercase">Total Role</h5>
</div>
<div class="mb-3">
<canvas id="accuracyChart" height="100" width="100"></canvas>
</div>
<div class="d-flex justify-content-between">
<div>
<span class="text-muted">Active Role</span>
<div class="fw-semibold"><span>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM role WHERE Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</span></div>
</div>
<div class="text-end">
<span class="text-muted">Non-Role</span>
<div class="fw-semibold"><span>
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT count(*) FROM role WHERE Status != 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</span> <i class="ti ti-arrow-down"></i></div>
</div>
</div>



</div>
</div>
</div>
</div>






<div class="row">
<div class="col-xl-8 col-md-8 col-sm-8">
<div class="card">
<div class="card-body">
<div class="w-100" style="height: 240px;">
<canvas id="activeUsersChart"></canvas>
</div>

</div>
</div>
</div>

<div class="col-xl-4 col-md-4 col-sm-4">
<div class="card" style="height:273px;">
<div class="card-body">
<?php include 'branch_list.php'; ?>
</div>
</div>

</div>
</div>


</div>

<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "branch_list.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#result').html(data);
}, 1000);
}
});
// ajax function ends here
});
</script>
<?php include '../footer.php'; ?>