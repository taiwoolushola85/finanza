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
<h3 class="mb-sm-0">Registration</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Flexi</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Flexi</a></li>
<li class="breadcrumb-item active" aria-current="page">Registration</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->





<div class="container">
<div id="first">

<div class="container">
<div class="position-relative m-4">
<div class="progress" style="height: 2px;">
<div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-icon btn-primary rounded-pill">1</button>
<button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-icon btn-light rounded-pill">2</button>
</div>
</div> <!-- end col-->

<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<img src="" id="userPhoto" class="rounded-circle d-flex" style="height: 150px; width:150px; margin:auto">
<br>
<div style="margin: auto; width:250px">
<label style="font-size:13px"><i style="color:red">*</i> BVN</label> 
<input type="number" class="form-control form-control-sm" placeholder="Enter BVN" id="bvn" name="bvn" required><br>
<center>
<i id="check" style="margin-left:10px; display:none"><img src="../loader/loader.gif" style="height:18px"> Checking BVN.! Please wait...</i>
<i id="bvnerror" style="color:red; margin-left:10px; display:none">Invalid BVN !! Please Check...</i>
<h5 id="fullName"></h5>
</center>
</div>

<b>Basic Informations</b><br>
<div class="row" style="display:none;">
<div class="col-sm-4">
<input type="text" class="form-control form-control-sm" name="img" hidden id="img" required>
<input type="text" class="form-control form-control-md" placeholder="Enter Surname"  name="user" required="required" value="<?php echo $User; ?>" hidden>
<label style="font-size:13px"><i style="color:red">*</i> Surname</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Surname" hidden id="firstName" name="sn" required="required" >
<input type="text" class="form-control form-control-md" placeholder="Enter Surname" disabled id="firstNames"  required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Firstname</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Firstname" hidden name="fn" id="middleName" required="required">
<input type="text" class="form-control form-control-md" placeholder="Enter Firstname" disabled id="middleNames" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Othername</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Othername" hidden name="ln" id="lastName" required="required" >
<input type="text" class="form-control form-control-md" placeholder="Enter Othername" disabled id="lastNames" required="required" >
</div>
</div>


<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Phone No</label>
<input type="number" class="form-control form-control-md" placeholder="Enter Phone No" name="ph" required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> House Address</label>
<input type="text" class="form-control form-control-md" placeholder="Enter House Address" name="ha" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Gender</label>
<select class="form-control form-control-sm" name="gen" required>
<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Occupation</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Occupation"  name="ocu" required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Nationality</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Nationality" name="nat" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> State Of Origin</label>
<input type="text" class="form-control form-control-md" placeholder="Enter State Of Origin" name="stog" required="required" >
</div>
</div>
<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Business Address</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Business Address"  name="ba" required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Marital Status</label>
<select type="text" class="form-control form-control-md"  name="ms" required="required">
<option value="">Select Status</option>
<option value="Single">Single</option>
<option value="Married">Married</option>
<option value="Divorce">Divorce</option>
<option value="Widow">Widow</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Flexi Plan</label>
<select type="text" class="form-control form-control-md"  name="pl" required="required">
<option value="">Select Plan</option>
<option value="Flexi Saving Daily">Flexi Saving Daily</option>
<option value="Flexi Saving Weekly">Flexi Saving Weekly</option>
<option value="Flexi Saving Monthly">Flexi Saving Monthly</option>
</select>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Savings Freqeuncy</label>
<select type="text" class="form-control form-control-md"  name="fr" required="required">
<option value="">Select Option</option>
<option value="Daily">Daily</option>
<option value="Weekly">Weekly</option>
<option value="Monthly">Monthly</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> ID Types</label>
<select type="text" class="form-control form-control-md" name="ty" required="required">
<option value="">Select Type</option>
<option value="National ID Card">National ID Card</option>
<option value="Voter Card">Voters Card</option>
<option value="International Passport">International Passport</option>
<option value="Driver License">Driver's License</option>
<option value="Membership Card">Membership Card</option>
<option value="Other">Other</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> ID Number</label>
<input type="text" class="form-control form-control-md" placeholder="Enter ID Number" name="dn" required="required" >
</div>
</div>
<br>
<b>Payment Details</b><br>
<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Processing Fee</label>
<input type="number" class="form-control form-control-md" placeholder="Enter Processing Fee" name="card" required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Initial Deposit</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Initial Deposit" name="ini" required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Upload Reciept</label>
<input type="file" class="form-control form-control-md" name="Pic" required="required" >
</div>
</div>
<br>
<b>Bank Details</b><br>
<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Account Number</label>
<input type="number" class="form-control form-control-md" placeholder="Enter Account Number"  name="ac" required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Account Name</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Account Name" name="an" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Bank</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Bank Name" name="bnk" required="required" >
</div>
</div>
<br>
<button type="button" class="btn btn-outline-info btn-sm" onclick="nxt()"  id="cli" style="float:right;">Next >></button>

</div>
</div>


<div style="display:none" id="second">
<div class="container">
<div class="position-relative m-4">
<div class="progress" style="height: 2px;">
<div class="progress-bar" role="progressbar" style="width:100%;" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
</div>
<button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-icon btn-primary rounded-pill">1</button>
<button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-icon btn-primary rounded-pill">2</button>
</div>
</div> <!-- end col-->

<br>
<br>
<br>
<br>
<b>Next Of Kin Details</b><br>
<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Surname</label>
<input type="text" class="form-control form-control-md" name="nsu" placeholder="Enter Surname" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Firstname</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Firstname" placeholder="Enter Firstname"  name="nfn" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Othername</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Othername" name="no" placeholder="Enter Othername"  required="required">
</div>
</div>

<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Phone No</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Phone No"  name="ph2" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Relationship</label>
<select class="form-control form-control-md" name="re" required="required">
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
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Address</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Address" placeholder="Enter Firstname"  name="na" required="required">
</div>
</div><br><br>
<button type="submit" class="btn btn-outline-success btn-sm"   onclick="data()" style="float:right; margin:5px">Submit Application</button>
<button type="button" class="btn btn-outline-warning btn-sm" onclick="sec()"  style="float:right; margin:5px"><< Back</button>
</form>
</div>

</div>
</div>
</div>
</div>
</div>
</div>




<br>
<br>
<br>




<script>
function nxt(){
var x = document.getElementById("first");
var y = document.getElementById("second");
y.style.display = 'block';
x.style.display = 'none';
}

function sec(){
var x = document.getElementById("second");
var y = document.getElementById("first");
x.style.display = 'none';
y.style.display = 'block';
}

</script>


<script type="text/javascript">
$(document).ready(function () {
$("#bvn").on("blur", function () {
let bvn = $("#bvn").val().trim();
// reset states
$("#bvnerror").hide();
$("#cli").attr("disabled", true);
// show loader
$("#check").show();
// BVN must be exactly 11 digits
if (bvn.length !== 11) {
setTimeout(function () {
$("#check").hide();
$("#bvnerror").show();
}, 1000);
setTimeout(function () {
$("#check").hide();
$("#bvnerror").hide();
}, 2000);
return;
}
// Validate BVN via AJAX
$.ajax({
type: "POST",
url: "flexi_bvn_bck.php",
data: { bvn: bvn },
success: function (data) {
$("#check").hide();
if (data == 1) {
alert("🚫 Customer has an active running flexi account. Please check your list.");
} else if (data == 2) {
alert("🚫 You have already registered this customer. Please check.");
} else {
$("#bvnerror").hide();
$("#cli").removeAttr("disabled");
}
},
error: function () {
$("#check").hide();
alert("🚫 Network error. Please try again.");
}
});
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
$('#check').hide();
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
$('#gender').val(data.gender || 'N/A');
$('#fullName').text([data.firstName, data.middleName, data.lastName].filter(Boolean).join(' ') || 'N/A');
// Handle phone numbers array
//const phones = data.phones ? data.phones.filter(p => p).join(', ') : 'N/A';
$('#ph').val(phones || 'N/A');
}
});
</script>





<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to submit this saving application ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "flexi_registration_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if (data == 1){
alert("Client record already exist in our database, please check.!!");
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
} else {
alert ("🚫 " + data)
$("#please").hide();
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