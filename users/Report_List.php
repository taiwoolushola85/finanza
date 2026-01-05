

<?php include 'head.php'; ?>
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
<h3 class="mb-sm-0">Report List</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Report</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Report</a></li>
<li class="breadcrumb-item active" aria-current="page">Report List</li>
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
<div class="col-sm-3">
<label style="font-size:13px">Select Report</label>
<select type="text" class="form-control form-control-md" name="type" required id="type" oninput="getReport()">
<option value="">Select Option</option>
<option value="1">Cancelled Loan Report</option>
<option value="2">Closed Loan Report</option>
<option value="3">Client Overview Report</option>
<option value="4">Collection Sheet Report</option>
<option value="5">Disbursement Report</option>
<option value="6" hidden>Expected Repayment Report</option>
<option value="7">Branch Performance Report</option>
<option value="8">Loan Officer Performance Report</option>
<option value="9">Repayment Collection Report</option>
<option value="10">Upfront Payment Report</option>
<option value="11">Savings Deposit Report</option>
<option value="12">Customer Savings Report</option>
<option value="13">Transaction Callover Report</option>
<option value="14">Guarantor Schedule Report</option>
</select>
</div>
</div>


<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" style="display:none; width:1200px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel"></h5>
</div>
<div class="modal-body">
<div id="results"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" id="close" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>


<script>
// to hide modal box
$(document).ready(function() {
$('#close').on('click', function() {
$("#report").hide();
$('#type').val('');
});
});
</script>


<script type="text/javascript">
function getReport()  {
$("#please").show();
var type = document.getElementById("type").value;
// ajax function start here
$.ajax({
method: "POST",
url: "report_module.php",
dataType: "html",  
data: {
'type': type
},
success:function(data){
$("#please").show();
setTimeout(function(){
$("#please").hide();
$("#updateModal").modal('show');
$("#results").html(data);
}, 1000);
}
});
// ajax function ends here
}
</script>

<?php include '../footer.php'; ?>
