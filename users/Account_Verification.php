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
<h3 class="mb-sm-0">Account Verification</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">KYC</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">KYC</a></li>
<li class="breadcrumb-item active" aria-current="page">Account Verification</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>
<br>
<form id="bvnForm">
<div class="row">
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Account No</label>
<input type="text" class="form-control form-control-sm" placeholder="10 Digit Number" name="acct" id="acct" required>
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Select Bank</label>
<select type="text" class="form-control form-control-sm" name="code" id="code" required="required">
<option value="">Select Bank</option>
<?php 
include '../config/db.php';
$Query = "SELECT Bank_Name, Bank_Code FROM bank ORDER BY Bank_Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['Bank_Code']; // bank code
$name= $rows['Bank_Name'];// bank name
?>
<option value="<?php echo $pp; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<br>
<button type="submit" class="invks btn btn-outline-success btn-sm" id="submitBtn" >Verify</button>
</form>
<br>
<b style="display:none;" id="loaders"><img src="../loader/loader.gif" style="height:16px"> Verifying Account Information ! Please wait...</b>




<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:900px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">BANK ACCOUNT DATA</h5>
</div>
<div class="modal-body">
<div id="profile"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" id="close">Close</button>
</div>
</div>
</div>
</div>
</div>


<script>
$(document).ready(function () {
$('#close').on('click', function () {
$('#updateModal').hide(); // instantly hides
});
});
</script>


<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").modal('hide');
$("#loaders").show();
var acct = document.getElementById("acct").value;
var code = document.getElementById("code").value;
$.ajax({
url: 'account_loading.php',
type: "GET",
data: {'acct': acct, 'code': code},
success: function(data) { 
$("#loaders").hide();
$("#profile").show();
$('#profile').html(data);
},
error: function(xhr, status, error) {
alert('Error loading profile: ' + error);
$("#loaders").hide();
}
});
});
});
</script>

<?php include '../footer.php'; ?>