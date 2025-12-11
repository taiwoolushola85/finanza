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
<i class="fa fa-check"></i> Portfolio transfered successfully
</div>
</div>
</div>




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
<h3 class="mb-sm-0">Transfer</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Portfolio</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Portfolio</a></li>
<li class="breadcrumb-item active" aria-current="page">Portfolio</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->



<br><br>
<div class="card" style="margin:auto">
<div class="card-body">
<h6>Portfolio Transfer Form</h6><hr>
<form action="" method="POST" enctype="multipart/form-data" id="uploadPort">
<div class="row">
<div class="col-sm-4" style="margin-top:10px">
<span>Loan Officer <i style="color:red">[ From ]</i></span>
<select name="fr" required="required" class="form-control form-control-md">
<option value="">Select Name</option>
<?php 
include_once 'db.php';
$Query = "SELECT  * FROM users WHERE User_Group = 'Loan Officers' AND Status = 'Activate' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$names= $rows['Name'];
$us= $rows['id'];
?>
<option value="<?php echo $us; ?>"><?php echo $names; ?></option>
<?php
}
}
?>
</select>
</div>

<div class="col-sm-4" style="margin-top:10px">
<span>Loan Officer <i style="color:red"> [ To ]</i></span>
<select class="form-control form-control-md" name="to" required="required">
<option value="">Select Name</option>
<?php 
include_once 'db.php';
$Query = "SELECT  * FROM users WHERE User_Group = 'Loan Officers' AND Status = 'Activate' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$names= $rows['Name'];
$uz= $rows['id'];
?>
<option value="<?php echo $uz; ?>"><?php echo $names; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-4" style="margin-top:10px">
<span>Types</span>
<select class="form-control form-control-md" name="types" required="required">
<option value="All">All</option>
<option value="Loan">Loan Portfolio</option>
<option value="Flexi">Flexi Savings Portfolio</option>
</select>
</div>
</div>
<hr>
<button type="submit" class="btn btn-outline-primary btn-sm" onclick="data()">Transfer Portfolio</button>
</form>
</div>
</div>

</div>
</div>
</section>



<script>
$(document).ready(function () {
//change selectboxes to selectize mode to be searchable
$("select").select2();
});
</script>





<script type="text/javascript">
$(document).ready(function (e){
$("#uploadPort").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "Are you sure you want to transfer this portfolio.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "portfolio_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
alert("🚫 Portfolio already belong to the user.. ");
window.location.reload();
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else if(data == 4){
$("#please").hide();
alert ("🚫 Invalid portfolio transfer types..")
}else{
$("#please").hide();
alert ("🚫 " + data)
}
},
error: function(){
}
});
      }
}));
});
</script>


<?php include '../footer.php'; ?>