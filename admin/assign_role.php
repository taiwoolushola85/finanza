<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display: none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Role Assigned Successfully
</div>
</div>
</div>



<!--  Modal content for the menu -->
<div class="modal" id="menu">
<div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" id="myLargeModalLabel">Menu List</h6>
</div>
<div class="modal-body">
<div id="result"></div>
<div class="modal-footer">
<a href="javascript:;" class="btn btn-outline-danger btn-sm" id="close" data-bs-dismiss="modal">Close</a>
</div>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



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
<h3 class="mb-sm-0">Assign Role</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Assign Role</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->


<div class="card">
<div class="card-body">
<h6><b class="fa fa-cog"></b> USER MENU CONTROL PANEL</h6>
<hr>
<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-4">
<label>User Role</label>
<select type="text" class="form-control form-control-md" required="required" name="lv">
<option value="">Select Option</option>
<?php
include_once '../config/db.php';
$Query = "SELECT  * FROM role ORDER BY Name ASC";
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
</div>
</div>
<hr>
<button type="submit" class="btn btn-outline-info btn-sm" style="font-size: 10px;"><i class="fa fa-eye"></i> View</button>
</form>
</div>
</div>




</div>



<script>
// to hide modal box
$(document).ready(function() {
$('#close').on('click', function() {
$("#menu").hide();
});
});
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
$("#please").show();
$.ajax({
url: "all_role.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
setTimeout(function(){
$("#please").hide();
$("#menu").show();
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