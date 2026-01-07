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
<i class="fa fa-check"></i> Application submited successfully
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
<h3 class="mb-sm-0">Pre Registration</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Pre Registration</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->



<div  id="first">
<div class="container">
<div class="position-relative m-4">
<div class="progress" style="height: 2px;">
<div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-icon btn-primary rounded-pill">1</button>
<button type="button" class="position-absolute top-0 start-50 translate-middle btn btn-icon btn-light rounded-pill">2</button>
<button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-icon btn-light rounded-pill">3</button>
</div>
</div> <!-- end col-->
<br>
<i><b style="color:red">Note:</b> All fields in red border are </i><br><br>

<img src="" id="userPhoto" class="rounded-circle d-flex" style="height: 150px; width:150px; margin:auto">

<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div style="margin: auto; width:250px">
<label style="font-size:13px"><i style="color:red">*</i> BVN</label> 
<input type="number" class="form-control form-control-sm" placeholder="Enter BVN" id="bvn" name="bvn" >
<br>
<center>
<i id="check" style="margin-left:10px; display:none"><img src="../loader/loader.gif" style="height:18px"> Checking BVN.! Please wait...</i>
<i id="bvnerror" style="color:red; margin-left:10px; display:none">Invalid BVN !! Please Check...</i>

<h5 id="fullName"></h5>
</center>
</div>
<br>
<b><i class="fa fa-star"></i> Personal Information</b><br>
<div class="row" style="margin-top: 20px; display:none">
<div class="col-sm-4">
<label style="font-size:13px; display:none"><i style="color:red">*</i> Surname</label>
<input type="text" class="form-control form-control-sm" hidden name="img" id="img" >
<input type="text" class="form-control form-control-sm" placeholder="Surname" hidden name="sn" id="firstName" style="text-transform: capitalize;" >
</div>
<div class="col-sm-4">
<label style="font-size:13px; display:none"><i style="color:red">*</i> Firstname</label>
<input type="text" class="form-control form-control-sm" placeholder="Firstname" hidden name="fn" id="middleName" style="text-transform: capitalize;" >
</div>
<div class="col-sm-4">
<label style="font-size:13px; display:none"><i style="color:red">*</i> Lastname</label>
<input type="text" class="form-control form-control-sm" placeholder="Lastname" hidden name="ln" id="lastName" style="text-transform: capitalize;" >
</div>
</div>


<div class="row" style="margin-top:20px;">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Education Level</label>
<select class="form-control form-control-sm" name="ed" >
<option value="">Select Option</option>
<option value="Primary School">Primary School</option>
<option value="Secondary School">Secondary School</option>
<option value="Tertiary School">Tertiary School</option>
<option value="No Education">No Education</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Groups</label>
<select type="text" class="form-control form-control-md" name="un" >
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
<div class="col-sm-4">
<input type="text" class="form-control form-control-sm" placeholder="Phone No" hidden name="ph" id="ph" >
<label style="font-size:13px"><i style="color:red">*</i> Repayment Day</label>
<select class="form-control form-control-sm"  name="repday" >
<option value="">Select Option</option>
<option value="Mon">Monday</option>
<option value="Tue">Tuesday</option>
<option value="Wed">Wednesday</option>
<option value="Thu">Thursday</option>
<option value="Fri">Friday</option>
<option value="Daily">Everyday</option>
</select>
</div>
</div>
<div class="row" style="margin-top: 20px; ; display:none">
<div class="col-sm-4">
<label style="font-size:13px; display:none"><i style="color:red">*</i> Gender</label>
<input type="text" class="form-control form-control-sm" hidden name="gn" id="gender" >
</div>
<div class="col-sm-4">
<label style="font-size:13px; display:none"><i style="color:red">*</i> Date Of Birth</label>
<input type="text" class="form-control form-control-sm" placeholder="Date Of Birth" hidden name="db" id="dateOfBirth" >
<input type="text" class="form-control form-control-sm" placeholder="Date Of Birth" disabled id="dateOfBirths" >
</div>
</div>

<b style="display:none"><i class="fa fa-star"></i> Means Of Identification</b><br>
<div class="row" style="margin-top: 20px; display:none">
<div class="col-sm-4">
<label style="font-size:13px; display:none"><i style="color:red">*</i> Document Type</label>
<input type="text" class="form-control form-control-sm" value="National ID Card" name="doc" hidden >
</div>
<div class="col-sm-4">
<label style="font-size:13px; display:none"><i style="color:red">*</i> NIN No</label>
<input type="text" class="form-control form-control-sm" placeholder="Document No" hidden id="nin" name="docn" >
</div>
</div>
<br>
<b><i class="fa fa-star"></i> Contact Information</b><br>
<div class="row" style="margin-top: 20px;">
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Phone No</label>
<input type="text" class="form-control form-control-sm" placeholder="Phone No" name="ph" id="ph" >
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Address</label>
<input type="text" class="form-control form-control-sm" hidden name="sta" id="stateOfOrigin"  placeholder="State Of Origin" >
<input type="text" class="form-control form-control-sm" placeholder="Address" name="ad" >
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Town/City</label>
<input type="text" class="form-control form-control-sm" placeholder="Town/City" name="cit" style="text-transform: capitalize;" >
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Maritial Status</label>
<select class="form-control form-control-sm"  name="ms" >
<option value="">Select Option</option>
<option value="Single">Single</option>
<option value="Married">Married</option>
<option value="Divorce">Divorce</option>
<option value="Widow">Widow</option>
</select>
</div>
</div>
<br>
<?php 
// checking if loan officer has been mapped to a team lead
if($mapped == 'Mapped'){
?>
<button type="button"  class="btn btn-outline-primary btn-sm"  onclick="datas()" id="cli" style="float:right">Next >></button>
<br>
<?php 
}else{
?>
<button type="button" disabled class="btn btn-outline-primary btn-sm"  onclick="datas()" id="cli" style="float:right">Next >></button>
<br>
<marquee><span style="color:red">This user need's to be mapped to a team leader</span></marquee>
<?php 
}
?>

</div>

<br>






<div style="display:none" id="second">
<div class="container">
<div class="position-relative m-4">
<div class="progress" style="height: 2px;">
<div class="progress-bar" role="progressbar" style="width:50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-icon btn-primary rounded-pill">1</button>
<button type="button" class="position-absolute top-0 start-50 translate-middle btn btn-icon btn-primary rounded-pill">2</button>
<button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-icon btn-light rounded-pill">3</button>
</div>
</div> <!-- end col-->
<br>
<i><b style="color:red">Note:</b> All fields in red border are </i><br><br>
<b><i class="fa fa-star"></i> Business Information</b><br><br>
<div class="row" style="margin-top:20px;">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Business Name</label>
<input type="text" class="form-control form-control-sm" placeholder="Business Name" name="bsn" style="text-transform: capitalize;" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Business Type</label>
<input type="text" class="form-control form-control-sm" placeholder="Business Type" name="bt" style="text-transform: capitalize;" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> State</label>
<input type="text" class="form-control form-control-sm" name="st2"  placeholder="State Of Origin" style="text-transform: capitalize;" >
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Start Date</label>
<input type="Date" class="form-control form-control-sm" name="sd" >
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Address</label>
<input type="text" class="form-control form-control-sm" placeholder="Address" name="ad2" >
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Business Owner Name</label>
<input type="text" class="form-control form-control-sm" placeholder="Business Owner Name" name="owner" style="text-transform: capitalize;" >
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Shop Ownership</label>
<select type="text" class="form-control form-control-sm" name="sh" >
<option value="">Select Option</option>
<option value="Rented">Rented</option>
<option value="Owned">Owned</option>
<option value="Leased">Leased</option>
<option value="No Shop">No Shop</option>
</select>
</div>
</div>
<br>
<button type="button" class="btn btn-outline-success btn-sm" onclick="sec()"  id="save" style="float:right">Next >></button>
<button type="button" class="btn btn-outline-primary btn-sm" onclick = "bck()" style="float:right; margin-right:10px"><< Back</button>
<br><br><br>




</div>





<div style="display:none" id="third">
<div class="container">
<div class="position-relative m-4">
<div class="progress" style="height: 2px;">
<div class="progress-bar" role="progressbar" style="width:100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-icon btn-primary rounded-pill">1</button>
<button type="button" class="position-absolute top-0 start-50 translate-middle btn btn-icon btn-primary rounded-pill">2</button>
<button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-icon btn-primary rounded-pill">3</button>
</div>
</div> <!-- end col-->
<br>
<img src="" id="userPhotos" class="rounded-circle d-flex" style="height: 150px; width:150px; margin:auto">
<br>
<div style="margin: auto; width:250px">
<label style="font-size:13px"><i style="color:red">*</i> NIN</label>
<input type="number" class="form-control form-control-sm"  placeholder="Enter NIN" name="nin" oninput="validateNIN()" >
<br>
<center>
<i id="checks" style="margin-left:10px; display:none"><img src="../loader/loader.gif" style="height:18px"> Checking NIN.! Please wait...</i>
<i id="bvnerrors" style="color:red; margin-left:10px; display:none">Invalid NIN !! Please Check...</i>

<h5 id="fullNames"></h5>
</center>
</div>
<br>
<i><b style="color:red">Note:</b> All fields in red border are </i><br><br>
<b><i class="fa fa-star"></i> Gaurantor Information</b><br>

<div class="row" style="margin-top:20px; display:none">
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Surname</label>
<input type="text" class="form-control form-control-sm" hidden name="imgs" id="imgs" >
<input type="text" class="form-control form-control-sm" placeholder="Surname" hidden name="surname2" id="sn" style="text-transform: capitalize;" >
<input type="text" class="form-control form-control-sm" placeholder="Surname" disabled id="sns" >
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Firstname</label>
<input type="text" class="form-control form-control-sm" placeholder="Firstname" name="firstname2" hidden id="fn" style="text-transform: capitalize;" >
<input type="text" class="form-control form-control-sm" placeholder="Firstname" disabled id="fns" >
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Lastname</label>
<input type="text" class="form-control form-control-sm" placeholder="Lastname" hidden name="lastname2" id="ln" style="text-transform: capitalize;" >
<input type="text" class="form-control form-control-sm" placeholder="Lastname" disabled id="lns" >
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Phone No</label>
<input type="number" class="form-control form-control-sm" placeholder="Phone No" name="phone2" id="ph" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Address</label>
<input type="text" class="form-control form-control-sm" placeholder="Address" name="address3" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Occupation</label>
<input type="text" class="form-control form-control-sm" placeholder="Occupation" name="occupation" style="text-transform: capitalize;" >
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Relationship</label>
<select class="form-control form-control-sm" name="relationship" >
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
<select class="form-control form-control-sm" name="gender3" >
<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>
</div>
<div class="row" style="margin-top:20px; display:none">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> ID Type</label>
<input type="text" class="form-control form-control-sm" value="National ID Card" hidden name="idtype" >
<input type="text" class="form-control form-control-sm" value="National ID Card" disabled >
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> ID Card No</label>
<input type="text" class="form-control form-control-sm" placeholder="ID Number" hidden name="idno" id="ninData" >
<input type="text" class="form-control form-control-sm" placeholder="ID Number" disabled id="ninDatas" >
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-12">
<label style="font-size:13px"><i style="color:red">*</i> Remark/Comment</label>
<textarea type="text" class="form-control form-control-sm" name="remark" cols="6" rows="6" placeholder="Type your comment here....." ></textarea>
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" id="submit" style="float:right; ">Save To Draft</button>
<button type="button" class="btn btn-outline-primary btn-sm" onclick = "bcks()" style="float:right; margin-right:10px"><< Back</button>
</form>
<br><br><br>



</div>







</div>








<script>
var loadFile = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
var loads = function(event) {
var image = document.getElementById('outputs');
image.src = URL.createObjectURL(event.target.files[0]);
};
function datas(){
var x = document.getElementById("first");
var y = document.getElementById("second");
x.style.display = 'none';
y.style.display = 'block';
}

function bck(){
var x = document.getElementById("first");
var y = document.getElementById("second");
x.style.display = 'block';
y.style.display = 'none';
}

function sec(){
var x = document.getElementById("second");
var y = document.getElementById("third");
x.style.display = 'none';
y.style.display = 'block';
}

function bcks(){
var x = document.getElementById("second");
var y = document.getElementById("third");
x.style.display = 'block';
y.style.display = 'none';
}
</script>


<script type="text/javascript">
$(document).ready(function(){
$("#bvn").focusout(function(){
$("#check").show();
var bvn = document.getElementById("bvn").value;
if($('#bvn').val().length != 11){
setTimeout(function(){
$("#check").hide();
$("#bvnerror").show();
$("#cli").attr("disabled", "disabled");
}, 3000);
setTimeout(function(){
$("#check").hide();
$("#bvnerror").hide();
}, 6000);
}else{
// validate bvn
$.ajax({
method: "POST",
url: "bvn_check_bck.php",
data: {'bvn': bvn},
success:function(data){
$("#check").hide();
if(data == 1){
alert("🚫 Customer application already submited for loan review.!! please check application list to confirm..");
$("#cli").attr("disabled", "disabled");
}else if(data == 2){
alert("🚫 Customer already has a running active loan.!! please check..");
$("#cli").attr("disabled", "disabled");
}else if(data == 3){
alert("🚫 Customer BVN has been blacklisted.!! please check..");
$("#cli").attr("disabled", "disabled");
}else if(data == 4){
alert("🚫 Systen show that customer has been used as a gaurantor for another client having a runing loan.!! please check..");
$("#cli").attr("disabled", "disabled");
}else if(data == 5){
alert("🚫 System show's that the customer is an existing customer. please go to create loan to proceed with the registration..");
}else{
$("#check").hide();
$("#bvnerror").hide();
$("#cli").removeAttr('disabled');
}
}
});
// conditional statement end here
}
});
});
</script>





<script>
$(document).ready(function() {
// Auto-validate BVN on input
$('#bvn').on('input', function() {
const bvn = $(this).val().trim();
// Only validate when exactly 11 digits are entered
if (bvn.length === 11 && /^\d+$/.test(bvn)) {
verifyBVN(bvn);
} else if (bvn.length > 11) {
// Show error if more than 11 digits
alert('BVN must be exactly 11 digits');
}
});
function verifyBVN(bvn) {
// Show loader and disable input
$('#check').show();
// Make API call
$.ajax({
url: 'https://api.creditchek.africa/v1/identity/verifyData?bvn=' + bvn,
type: 'POST',
headers: {
'token': '5Gy5jXFNPWLnBnVeGDxylnL5oqorcdC+nVrCZI31Kxt1z2DFqN4sCUvnuN0hBX8h',
'Content-Type': 'application/json'
},
data: JSON.stringify({
bvn: bvn
}),
success: function(response) {
if (response.status && response.data){
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
displayErrorResult(errorMsg);
},
complete: function() {
$('#bvn').prop('disabled', false);
$('#check').hide();
}
});
}
function displaySuccessResult(data) {      
$('#check').hide();
// Populate table
$('#userPhoto').attr('src', data.photo || 'https://placehold.net/avatar.svg');
$('#img').val(data.photo || 'https://placehold.net/avatar.svg');
$('#bvnData').val(data.bvn || 'N/A');
$('#firstName').val(data.firstName || 'N/A');
$('#middleName').val(data.middleName || 'N/A');
$('#lastName').val(data.lastName || 'N/A');
$('#dateOfBirth').val(data.dateOfBirth || 'N/A');
$('#gender').val(data.gender || 'N/A');
$('#nin').val(data.nin || 'N/A');
$('#stateOfOrigin').val(data.stateOfOrigin || 'N/A');
// disabled value
$('#fullName').text([data.firstName, data.middleName, data.lastName].filter(Boolean).join(' ') || 'N/A');
// Handle phone numbers array
//const phones = data.phones ? data.phones.filter(p => p).join(', ') : 'N/A';
$('#ph').val(phones || 'N/A');
// Show success message
alert('Customer Verification successful!');
}
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
$('#checks').hide();
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
WRN_PROFILE_DELETE = "You are about to submit this application for review ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "loan_registration.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#uploadForm")[0].reset();
if(data == 1){
alert("🚫 Please fill all required fields before submitting the application.!");
$("#please").hide();
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


<?php include '../footer.php'; ?>