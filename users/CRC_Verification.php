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
<h3 class="mb-sm-0">CRC Verification</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">KYC</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">KY</a></li>
<li class="breadcrumb-item active" aria-current="page">CRC Verification</li>
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
<label style="font-size:13px"><i style="color:red">*</i> CRC Type</label>
<select type="text" class="form-control form-control-sm" name="type" id="type" required>
<option value="">Select CRC Type</option>
<option value="Basic">Basic</option>
<option value="Premium">Premium</option>
</select>
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> BVN</label>
<input type="text" class="form-control form-control-sm" placeholder="11 Digit Number" name="bvn" id="bvn" required>
</div>
</div>
<br>
<button type="submit" class="invks btn btn-outline-success btn-sm" id="submitBtn" >Verify</button>
</form>
<br>
<b style="display:none;" id="loaders"><img src="../loader/loader.gif" style="height:16px"> Checking CRC Record ! Please wait...</b>




<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:1200px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CRC DATA</h5>
</div>
<div class="modal-body">
<button id="downloadPdf" style="display:none; margin-bottom:15px; padding:8px 15px; background:#FF8C00; color:#fff; border:none; cursor:pointer;">
Download as PDF
</button>
<div id="result"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>




<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").modal('hide');
$("#downloadPdf").hide();
$("#loaders").show();
var type = document.getElementById("type").value;
var bvn = document.getElementById("bvn").value;
if(bvn) {
$.ajax({
url: 'crc_loading.php',
type: "GET",
data: {'type': type, 'bvn': bvn},
success: function(data) { 
$("#loaders").hide();
$('#result').html(data);
},
error: function(xhr, status, error) {
alert('Error loading data: ' + error);
$("#loaders").hide();
}
});
} else {
alert('Select and filled all the required field..');
$("#loaders").hide();
}
});
});
</script>



<script>
$(document).on('click', '#downloadPdf', function () {
var element = document.getElementById('pdfContent');
var opt = {
margin: 0.5,
filename: 'CRC_Report_' + new Date().getTime() + '.pdf',
image: { type: 'jpeg', quality: 0.98 },
html2canvas: { scale: 2, useCORS: true },
jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
};
html2pdf().set(opt).from(element).save();
});
</script>


<?php include '../footer.php'; ?>