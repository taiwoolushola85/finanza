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
<h3 class="mb-sm-0">Loan Portfolio</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Loan Portfolio</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Portflio</a></li>
<li class="breadcrumb-item active" aria-current="page">Loan Portfolio</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->






<?php 
if($gr == "Loan Officers"){
?>
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-sm-2">

</div>
</div>
<br><br>
<b><i class="fa fa-table"></i> Portfolio Table List</b>
<br><br>
<div class="row">
<div class="col-sm-10" style="margin-top: 10px;">
<label>Show Entries</label>
<select class="form-control form-control-sm" id="maxRows" style="width:50px;" oninput="getEntry()">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-2" style="margin-top: 10px;">
<input type="search" class="form-control form-control-sm"  id="search" placeholder="search..." style="margin-top:10px">
</div>
</div>
<br>
<div id="result"></div>

</div>
</div>



<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CUSTOMER PROFILE</h5>
</div>
<div class="modal-body">
<div id="profile"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
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
url: "loan_portfolio_list.php",
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


<script type="text/javascript">
function getEntry()  {
$("#loader").show();
$("result").hide();
var maxRows = document.getElementById("maxRows").value;
// ajax function start here
$.ajax({
method: "POST",
url: "loan_portfolio_list.php",
dataType: "html",  
data: {
'maxRows': maxRows
},
success:function(data){
$("result").show();
setTimeout(function(){
$("#loader").hide();
$('#result').html(data);
}, 1000);
}
});
// ajax function ends here
}
</script>



<script type="text/javascript">
$(document).ready(function(){
$("#search").keydown(function(){
var search = document.getElementById("search").value;
// ajax function start here
$.ajax({
method: "POST",
url: "loan_portfolio_list.php",
dataType: "html",  
data: {
'search': search
},
success:function(data){
$('#result').html(data);
}
});
// ajax function ends here
});
});
</script>




<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "loan_portfolio_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 





<?php 
}else if($gr == "Team Leaders"){
?>

<div class="card">
<div class="card-body">
<div class="row">
<div class="col-sm-2">

</div>
</div>
<br><br>
<b><i class="fa fa-table"></i> Portfolio Table List</b>
<br><br>
<div class="row">
<div class="col-sm-10" style="margin-top: 10px;">
<label>Show Entries</label>
<select class="form-control form-control-sm" id="maxRows" style="width:50px;" oninput="getEntry()">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-2" style="margin-top: 10px;">
<input type="search" class="form-control form-control-sm"  id="search" placeholder="search..." style="margin-top:10px">
</div>
</div>
<br>
<div id="results"></div>

</div>
</div>



<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CUSTOMER PROFILE</h5>
</div>
<div class="modal-body">
<div id="profile"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
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
url: "team_lead_portfolio.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#results').html(data);
}, 1000);
}
});
// ajax function ends here
});
</script>


<script type="text/javascript">
function getEntry()  {
$("#loader").show();
$("results").hide();
var maxRows = document.getElementById("maxRows").value;
// ajax function start here
$.ajax({
method: "POST",
url: "team_lead_portfolio.php",
dataType: "html",  
data: {
'maxRows': maxRows
},
success:function(data){
$("results").show();
setTimeout(function(){
$("#loader").hide();
$('#results').html(data);
}, 1000);
}
});
// ajax function ends here
}
</script>



<script type="text/javascript">
$(document).ready(function(){
$("#search").keydown(function(){
var search = document.getElementById("search").value;
// ajax function start here
$.ajax({
method: "POST",
url: "team_lead_portfolio.php",
dataType: "html",  
data: {
'search': search
},
success:function(data){
$('#results').html(data);
}
});
// ajax function ends here
});
});
</script>




<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "team_lead_portfolio.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#results').html(data);
}, 1000);
}
});
}
</script> 


<?php 
}else{
?>



<?php 
}
?>



<?php include '../footer.php'; ?>