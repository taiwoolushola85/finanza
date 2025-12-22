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
<i class="fa fa-check"></i> Loan successfully closed
</div>
</div>
</div>



<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toasts" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Loan successfully reversed
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
<h3 class="mb-sm-0">Loan Auditing</h3>
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
<br>
<div id="result"></div>






<!-- reciept Modal -->
<div class="modal" id="updateReciept" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" style="width:300px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel">RECIEPT GALLERY</h6>
</div>
<div class="modal-body">
<center>
<img src="" alt="" id="recip" style="height:400px" width="400px" class="img-thumbnail">
</center>
</div>
<div class="modal-footer">
<button type="button" id="bck" class="btn btn-light btn-sm">Back</button>
</div>
</div>
</div>
</div>
</div>
<!--end modal-->


<script type="text/javascript">
function myStatus()  {
$("#please").show();
$("#result").hide();
var br = document.getElementById("br").value;
// ajax function start here
$.ajax({
method: "GET",
url: "check_close_loan.php?br=" + br,
dataType: "html",  
data: {
'br': br
},
success:function(data){
setTimeout(function(){
$("#please").hide();
$("#result").show();
$('#result').html(data);
}, 1000);
}
});
// ajax function ends here
}
</script>



<?php include '../footer.php'; ?>