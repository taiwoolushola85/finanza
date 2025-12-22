

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
<option value="3">Collection Sheet Report</option>
<option value="4">Branch Client Report</option>
<option value="5">Disbursement Report</option>
<option value="6">Expired Loan Report</option>
<option value="7">Expected Repayment Report</option>
<option value="8">Loan Performance Report</option>
<option value="9">Repayment Collection Report</option>
<option value="10">Upfront Payment Report</option>
<option value="11">Savings Report</option>
<option value="12">Loan Target Report</option>
<option value="13">Transaction Callover Report</option>
</select>
</div>
</div>


<?php include '../footer.php'; ?>
