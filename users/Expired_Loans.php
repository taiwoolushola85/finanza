
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
<h3 class="mb-sm-0">Expired Loans</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Loan</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Loans</a></li>
<li class="breadcrumb-item active" aria-current="page">Expired Loans</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->




<br>
<br>
<div class="row">
<div class="col-sm-3">
<label>Branch</label>
<select class="form-control form-control-sm" id="branch" oninput="getBranch()">
<option value="All">All</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Name FROM branch WHERE Status = 'Activate' ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$nx= $rows['id']; // union id
$name= $rows['Name'];
?>
<option value="<?php echo $nx; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-3">
<label>Maturity Date</label>
<input type="date" class="form-control form-control-sm" id="date" oninput="getDate()" required>
</div>
<div class="col-sm-3">
<label>Loan Officer</label>
<select type="text" class="form-control form-control-sm" name="lo" id="lo" oninput="getOfficer()" required>
<option value="">Select Loan Officer</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Name FROM users WHERE Status = 'Activate' AND User_Group = 'Loan Officers' ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$nx= $rows['id']; // union id
$name= $rows['Name'];
?>
<option value="<?php echo $nx; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-2">

</div>
</div>
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





<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "load_expired_loan.php",
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
url: "load_expired_loan.php",
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
url: "load_expired_loan.php",
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
function getBranch()  {
$("#loader").show();
$("result").hide();
var branch = document.getElementById("branch").value;
// ajax function start here
$.ajax({
method: "POST",
url: "expired_by_branch.php",
dataType: "html",  
data: {
'branch': branch
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
function getDate()  {
$("#loader").show();
$("result").hide();
var date = document.getElementById("date").value;
// ajax function start here
$.ajax({
method: "POST",
url: "expired_by_date.php",
dataType: "html",  
data: {
'date': date
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
function getOfficer()  {
$("#loader").show();
$("result").hide();
var lo = document.getElementById("lo").value;
// ajax function start here
$.ajax({
method: "POST",
url: "loan_officer_expired.php",
dataType: "html",  
data: {
'lo': lo
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
function loads()  {
$.ajax({
method: "POST",
url: "load_expired_loan.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 


<?php include '../footer.php'; ?>