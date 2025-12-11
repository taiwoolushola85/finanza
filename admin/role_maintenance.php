<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Role Restricted Successfully
</div>
</div>
</div>



<?php include 'header.php'; ?>
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
<h3 class="mb-sm-0">Role Maintenance</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Role Maintenance</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<div class="card">
<div class="card-body">
<hr>
<form action="" method="post" id="uploadRole">
<label>Select User Group</label>
<div class="input-group" style="max-width:300px;">
<select type="text" class="form-control form-control-sm" required="required" name="cu" id="ua">
<option value="">Select User Group</option>
<?php
// selecting user group by distinct
include '../config/db.php';
$Query = "SELECT DISTINCT Name FROM role ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$name= $rows['Name'];
?>
<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
<?php
}
}
mysqli_close($con);
?>
</select>
<span class="input-group-append">
<button type="submit" class="btn btn-outline-info btn-md" style="font-size: 10px;" name="uni" onclick="data()"><i class="fa fa-search"></i> GO!</button>
</span>
</div>
</form>
<hr>

</div>
</div>



<div id="result"></div>

</div>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
var x = document.getElementById("ua").value;
$("#result").hide();
$("#loader").show();
$.ajax({
url: "menu_configuration_bck.php?cu=" + x,
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
setTimeout(function(){
$("#loader").hide();
$("#result").show();
$('#result').html(data);
}, 3000);
},
error: function(){
}
});
}));
});
</script>

<?php include '../footer.php'; ?>
