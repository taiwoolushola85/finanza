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
<div style="margin: auto; width:250px">
<label style="font-size:13px"><i style="color:red">*</i> BVN</label> 
<input type="number" class="form-control form-control-sm" placeholder="Enter BVN" id="bvn" name="bvn" required><br>
<center>
<i id="check" style="margin-left:10px; display:none"><img src="../loader/loader.gif" style="height:18px"> Checking BVN.! Please wait...</i>
<i id="bvnerror" style="color:red; margin-left:10px; display:none">Invalid BVN !! Please Check...</i>
</center>
</div>
<br>
<b>Basic Informations</b><br>
<br>
<div class="row">
<div class="col-sm-4">
<input type="text" class="form-control form-control-md" placeholder="Enter Surname"  name="user" required="required" value="<?php echo $User; ?>" hidden>
<label style="font-size:13px"><i style="color:red">*</i> Surname</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Surname"  name="sn" required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Firstname</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Firstname" name="fn" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Othername</label>
<input type="text" class="form-control form-control-md" placeholder="Enter Othername" name="ln" required="required" >
</div>
</div>


<br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Phone No</label>
<input type="number" class="form-control form-control-md" placeholder="Enter Phone No"  name="ph" required="required" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> House Address</label>
<input type="text" class="form-control form-control-md" placeholder="Enter House Address" name="ha" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Gender</label>
<select class="form-control form-control-md" name="gen" required="required" >
<option value="">Select Option</option>
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
<?php 
include_once 'db.php';
$Query = "SELECT  * FROM flexi WHERE Status = 'Activated' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Name'];
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
<hr>
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
<b>Basic Informations</b><br>
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
url: "flexi_bvn_bck.php",
data: {'bvn': bvn},
success:function(data){
$("#check").hide();
if(data == 1){
alert("🚫 Customer has an active runing flexi account, Please check your list..");
$("#cli").attr("disabled", "disabled");
}else if(data == 2){
alert("🚫 You have already registered this customer info.!! please check..");
$("#cli").attr("disabled", "disabled");
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





<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
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
$("#overlay").hide();
}
},
error: function(){
}
});
}));
});
</script>


<?php include '../footer.php'; ?>