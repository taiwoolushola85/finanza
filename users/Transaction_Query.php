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
<h3 class="mb-sm-0">Transaction Query</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Transaction Query</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>
<br>





<form id="transactionForm">
<div class="row">
<div class="col-sm-3" id="reciept" style="margin-top:10px">
<label style="font-size:13px"><i style="color:red">*</i> Enter Session ID</label>
<input type="number" class="form-control form-control-md" placeholder="Session ID" required name="sessionid" id="sessionid">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" style="float:left;" id="transaction">View Transaction</button>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<br>
<br>

<div id="errorMessage"></div>
<br>
<b>Transaction Details</b>
<br>
<br>
<div id="table-containers">
<table style="font-size:8px">
<thead>
<tr>
<th>Originator Account</th>
<th>Amount</th>
<th>Originator Name</th>
<th>Narration</th>
<th>CR Account Name</th>
<th>Bank Name</th>
<th>Session ID</th>
<th>CR Account</th>
<th>Bank Code</th>
<th>Request Date</th>
<th>NIBSS Response</th>
<th>Send Status</th>
<th>Send Response</th>
</tr>
</thead>
<tbody id="responseTableBody">
<!-- Response data will be inserted here -->
</tbody>
</table>


<script>

$(document).ready(function() {
// Form submission handler
$("#transactionForm").submit(function(e) { e.preventDefault();
// Get form data
var requestData = { sessionid: $("#sessionid").val() };
// Show loading indicator
$("#please").show();
$("#responseTable").hide();
$("#errorMessage").hide();
// Send AJAX request
$.ajax({
url: "https://apps3.wemabank.com/FintechTransQuery/api/v1/Trans/TransQuery", // Replace with your actual endpoint
type: "POST",
data: JSON.stringify(requestData),
contentType: "application/json",
dataType: "json",
success: function(response) {
// Hide loading indicator
$("#please").hide();
if (response.status === "00") {
// Clear previous table data
$("#responseTableBody").empty();
// Populate table with transaction data
$.each(response.transactions, function(index, transaction) {
var row = $("<tr>");
row.append($("<td>").text(transaction.originatoraccountnumber));
row.append($("<td>").text(transaction.amount));
row.append($("<td>").text(transaction.originatorname));
row.append($("<td>").text(transaction.narration));
row.append($("<td>").text(transaction.craccountname));
row.append($("<td>").text(transaction.bankname));
row.append($("<td>").text(transaction.sessionid));
row.append($("<td>").text(transaction.craccount));
row.append($("<td>").text(transaction.bankcode));
row.append($("<td>").text(transaction.requestdate));
row.append($("<td>").text(transaction.nibssresponse));
row.append($("<td>").text('Successful'));
row.append($("<td>").text(transaction.sendresponse));
$("#responseTableBody").append(row);
});
// Show the results table
$("#responseTable").show();
} else {
// Show error message
$("#errorMessage").text("Error: " + response.status_desc).show();
}
},
error: function(xhr, status, error) {
// Hide loading indicator and show error
$("#please").hide();
$("#errorMessage").text("Request failed: " + error).show();
}
});
});
});
</script>





<br>
<br>
<?php include '../footer.php'; ?>