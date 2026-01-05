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
<i class="fa fa-check"></i> Loan Created Successfully
</div>
</div>
</div>

<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toasts" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display: none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Application Declined Successfully
</div>
</div>
</div>

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
<h3 class="mb-sm-0">Create Loan</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Create Loan</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->

<br>
<br>


<br>
<button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#existingForm" style="float:right;">
<i class="fa fa-plus"></i> Create Existing Loan Profile</button>
<br>
<br>
<div class="row">
<div class="col-sm-2">

</div>
</div>
<br>
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



<div class="modal" id="existingForm" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-md" style="display:none; width:900px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">APPLICATION RENEWAL FORM</h5>
</div>
<div class="modal-body">
<img src="" id="userPhoto" class="rounded-circle d-flex" style="height: 150px; width:150px; margin:auto">
<br>
<center>
<span id="name"></span>
</center>
<br>
<div style="margin: auto; width:250px">
<label style="font-size:13px"><i style="color:red">*</i> BVN</label> 
<input type="number" class="form-control form-control-sm" placeholder="Enter BVN" id="bvn" required>
<h5 id="fullName"></h5>
<br>
<center>
<i id="check" style="margin-left:10px; display:none"><img src="../loader/loader.gif" style="height:18px"> Checking BVN.! Please wait...</i>
<i id="bvnerror" style="color:red; margin-left:10px; display:none">Invalid BVN !! Please Check...</i>
</center>
</div>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadEx">
<b><i class="fa fa-star"></i> Personal Information</b><br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Fee Type</label>
<input type="text" class="form-control form-control-sm" hidden name="id" id="reg" required>
<select type="text" class="form-control form-control-md" name="type" required="required">
<option value="">Select Option</option>
<option value="Deduction">Deduction</option>
<option value="Virtual Payment">Virtual Payment</option>
<option value="Monie Point Payment">Monie Point Payment</option>
<option value="Saving For Upfront">Saving For Upfront</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Repayment Day</label>
<select class="form-control form-control-sm"  name="repday" required>
<option value="">Select Option</option>
<option value="Mon">Monday</option>
<option value="Tue">Tuesday</option>
<option value="Wed">Wednesday</option>
<option value="Thu">Thursday</option>
<option value="Fri">Friday</option>
<option value="Daily">Everyday</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Groups</label>
<select type="text" class="form-control form-control-md" name="un" required>
<option value="">Select Group</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Name FROM groups WHERE User='$User' AND Status = 'Activated' ORDER BY id DESC";
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
<b>Loan Product Information</b><br><br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Loan Products</label>
<select type="text" class="form-control form-control-md" name="pr" id="pr" oninput="getProduct()" required="required">
<option value="">Select Loan Product</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Product_Name FROM product WHERE Status = 'Activated' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Product_Name'];// product
?>
<option value="<?php echo $pp; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Tenure</label>
<select type="text" class="form-control form-control-md" name="ten" id="hey" required="required">
<option value="">Select Option</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Principal Amount</label>
<input type="number" class="form-control form-control-md" name="lum" placeholder="Principal Amount" required="required">
</div>
</div>
<hr>
<b>Bank Details</b><br><br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Bank Name</label>
<select type="text" class="form-control form-control-md" name="bn" required="required">
<option value="">Select Bank</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Bank_Name FROM bank ORDER BY Bank_Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Bank_Name'];// product
?>
<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Account No</label>
<input type="number" class="form-control form-control-md" placeholder="Account No" name="an" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Account Name</label>
<input type="text" class="form-control form-control-md" placeholder="Account Name" name="ann" required="required">
</div>
</div>
<br>
<br>
<b><i class="fa fa-star"></i> Gaurantor Information</b><br>
<div style="margin: auto; width:250px">
<label style="font-size:13px"><i style="color:red">*</i> NIN</label>
<input type="number" class="form-control form-control-sm"  placeholder="Enter NIN" name="nin" oninput="validateNIN()" required>
<br>
<center>
<i id="checks" style="margin-left:10px; display:none"><img src="../loader/loader.gif" style="height:18px"> Checking NIN.! Please wait...</i>
<i id="bvnerrors" style="color:red; margin-left:10px; display:none">Invalid NIN !! Please Check...</i>
<h5 id="fullNames"></h5>
</center>
</div>
<br>
<div class="row" style="margin-top:20px; display:none">
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Surname</label>
<input type="text" class="form-control form-control-sm" hidden name="imgs" id="imgs" required>
<input type="text" class="form-control form-control-sm" placeholder="Surname" hidden name="surname2" id="sn" required>
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Firstname</label>
<input type="text" class="form-control form-control-sm" placeholder="Firstname" name="firstname2" hidden id="fn" required>
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Lastname</label>
<input type="text" class="form-control form-control-sm" placeholder="Lastname" hidden name="lastname2" id="ln" required>
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Phone No</label>
<input type="number" class="form-control form-control-sm" placeholder="Phone No" name="phone2" id="ph" required>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Address</label>
<input type="text" class="form-control form-control-sm" placeholder="Address" name="address3" required>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Occupation</label>
<input type="text" class="form-control form-control-sm" placeholder="Occupation" name="occupation" required>
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Relationship</label>
<select class="form-control form-control-sm" name="relationship" required>
<option value="">Select Type</option>
<option value="Sister">Sister</option>
<option value="Brother">Brother</option>
<option value="Spouse">Spouse</option>
<option value="Father">Father</option>
<option value="Mother">Mother</option>
<option value="Daughter">Daughter</option>
<option value="Friend">Friend</option>
<option value="In-Law">In-Law</option>
<option value="Nephew">Nephew</option>
<option value="Niece">Niece</option>
<option value="Husband">Husband</option>
<option value="Wife">Wife</option>
<option value="Neighbor">Neighbor</option>
<option value="Other">Other</option>
</select>
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Gender</label>
<select class="form-control form-control-sm" name="gender3" required>
<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>
</div>
<div class="row" style="margin-top:20px; display:none">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> ID Type</label>
<input type="text" class="form-control form-control-sm" value="National ID Card" hidden name="idtype" required>
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> ID Card No</label>
<input type="text" class="form-control form-control-sm" placeholder="ID Number" hidden name="idno" id="ninData" required>
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-12">
<label style="font-size:13px"><i style="color:red">*</i> Remark/Comment</label>
<textarea type="text" class="form-control form-control-sm" name="remark" cols="6" rows="6" required></textarea>
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" id="submit"><i class="fa fa-plus"></i> Create Loan</button>
</form>



</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>




<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-xl" style="display:none; width:900px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">LOAN APPLICATION</h5>
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


<div class="modal" id="renewForm" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">CUSTOMER RENEWAL FORM</h5>
</div>
<div class="modal-body">
<div id="form"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>

<script>
var loadFile = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>



<script type="text/javascript">
function getProduct()  {
var pr = document.getElementById("pr").value;
// ajax function start here
$.ajax({
method: "POST",
url: "load_tenure.php",
dataType: "html",  
data: {'pr': pr},
success:function(data){
setTimeout(function(){
$("#hey").html(data);
}, 100);
}
});
// ajax function ends here
}
</script>


<script type="text/javascript">
$(document).ready(function () {
$("#bvn").on("focusout", function () {
const bvn = $("#bvn").val().trim();
$("#check").show();
$("#bvnerror").hide();
// Validate BVN length
if (bvn.length !== 11) {
setTimeout(function () {
$("#check").hide();
$("#bvnerror").show();
$("#cli").prop("disabled", true);
}, 1000);
setTimeout(function () {
$("#bvnerror").hide();
}, 4000);
return;
}
// AJAX validation
$.ajax({
type: "POST",
url: "check_existing.php",
data: { bvn: bvn },
dataType: "json",
success: function (data) {
$("#check").hide();
// Numeric responses (error states)
if (data === 1) {
alert("🚫 Customer application already submitted for loan review.");
$("#cli").prop("disabled", true);
}else if (data === 2){
alert("🚫 Customer still has a running active loan.");
$("#cli").prop("disabled", true);
}else if (data === 3){
alert("🚫 Customer BVN has been blacklisted.");
$("#cli").prop("disabled", true);
}else if (data === 4){
alert("🚫 Customer has been used as a guarantor for another active loan.");
$("#cli").prop("disabled", true);
}else if (typeof data === "object") {
// JSON object response (valid BVN)
$("#cli").prop("disabled", false);
$('#userPhoto').attr('src', data.imgLoc || 'https://placehold.net/avatar.svg');
$('#reg').val(data.regId || '');
$('#name').text([data.fName, data.mName, data.lName].filter(Boolean).join(' ') || 'N/A');
$('#fullName').text([data.fName, data.mName, data.lName].filter(Boolean).join(' ') || 'N/A');
}
},
error: function () {
$("#check").hide();
alert("⚠️ Error validating BVN. Please try again.");
}
});
});
});
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadEx").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to create a loan profile for this customer ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#existingForm").modal('hide');
$("#please").show();
$.ajax({
url: "create_existing_loan.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#uploadEx")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
load();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data)
}
},
error: function(){
}
});
}
}));
});
</script>




<script>
// Validate NIN function called by oninput event
function validateNIN() {
const nin = $('input[name="nin"]').val().trim();
// Only validate when exactly 11 digits are entered
if (nin.length === 11 && /^\d+$/.test(nin)) {
verifyIdentity(nin);
} else if (nin.length > 11) {
alert('NIN must be exactly 11 digits');
}
}

function verifyIdentity(nin) {
// Show loader if element exists
$('#checks').show();
$('input[name="nin"]').prop('disabled', true);
$.ajax({
url: 'https://api.creditchek.africa/v1/identity/verifyData?nin=' + nin,
type: 'POST',
headers: {
'token': '5Gy5jXFNPWLnBnVeGDxylnL5oqorcdC+nVrCZI31Kxt1z2DFqN4sCUvnuN0hBX8h',
'Content-Type': 'application/json'
},
data: JSON.stringify({
nin: nin // Default BVN or get from another input
}),
success: function(response) {
//console.log('Success:', response);
if (response.status && response.data) {
displaySuccessResult(response.data);
} else {
displayErrorResult(response.message || 'Verification failed');
}
},
error: function(xhr, status, error) {
let errorMsg = 'An error occurred during verification';
try {
const errorResponse = JSON.parse(xhr.responseText);
errorMsg = errorResponse.message || errorMsg;
} catch(e) {
errorMsg = `Status: ${xhr.status} - ${error}`;
}
console.error('Error:', errorMsg);
displayErrorResult(errorMsg);
},
complete: function() {
$('input[name="nin"]').prop('disabled', false);
$('#checks').hide();
}
});
}

function displaySuccessResult(data) {
// Populate fields with user data
$('#userPhotos').attr('src', data.photo || 'https://via.placeholder.com/150');
$('#imgs').val(data.photo || 'https://placehold.net/avatar.svg');
$('#ninData').val(data.nin || 'N/A');
$('#ninDatas').val(data.nin || 'N/A');
$('#sn').val(data.surname || data.firstName || 'N/A');
$('#sns').val(data.surname || data.firstName || 'N/A');
$('#fn').val(data.firstname || data.middleName || 'N/A');
$('#fns').val(data.firstname || data.middleName || 'N/A');
$('#ln').val(data.surname || data.lastName || 'N/A');
$('#lns').val(data.surname || data.lastName || 'N/A');
$('#fullNames').text([data.surname, data.firstname].filter(Boolean).join(' ') || 'N/A');
// Show success message
alert('Gaurantor Verification successful!');
}

function displayErrorResult(message) {
alert('Verification Error: ' + message);
// Clear photo on error
$('#userPhotos').attr('src', 'https://via.placeholder.com/150');
}
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
$("#please").show();
$.ajax({
url: "existing_loan_registration.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#uploadForm")[0].reset();
setTimeout(function(){
$("#please").hide();
$("#renewForm").modal('show');
$('#form').html(data);
}, 3000);
},
error: function(){
}
});
}));
});
</script>



<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "approved_loan_application.php",
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
url: "approved_loan_application.php",
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
url: "approved_loan_application.php",
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
function load() {
$.ajax({
method: "POST",
url: "approved_loan_application.php",
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