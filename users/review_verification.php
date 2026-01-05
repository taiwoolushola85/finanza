<?php 
include_once '../config/db.php';
$id = $_GET['id']; // reg id
// 
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$reg_status = $row['Status'];
$bvn = $row['BVN'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
?>
<center>
<img src="<?php echo $row['Location']; ?>" style="height:100px; width:100px; border-radius:50px">
<br><br>
<div style="overflow-x: auto;">
<div class="btn-group">
<button class="btn btn-light" onclick="clientDash()"><i class="fa fa-user"></i> Loan Profile</button>
<button class="btn btn-light" onclick="updateDoc()"><i class="fa fa-eye"></i> Review Document</button>
<button class="btn btn-light" onclick="updateCRC()"><i class="fa fa-file"></i> CRC Report</button>
<button class="btn btn-light" onclick="updateVerification()"><i class="fa fa-upload"></i> Upload Business Img</button>
<button class="btn btn-light" onclick="updateApprove()"><i class="fa fa-star"></i> Remark/Comment </button>
</div>
</div>
</center>

<div id="firsts" style="display:block;">
<div class="row">
<div class="col-sm-6">
<br><br>
<b><i class="fa fa-star"></i> CLIENT INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Name:</b> <?php echo $row['Firstname']." ". $row['Middlename']." ".$row['Lastname']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Phone:</b> <?php echo $row['Phone']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gender:</b> <?php echo $row['Gender']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Branch:</b> <?php echo $row['Branch']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Marriage Status:</b> <?php echo $row['Maritial_Status']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b> Client BVN:</b> <?php echo $row['BVN']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Education:</b> <?php echo $row['Education']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Document:</b> <?php echo $row['Document']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Document No:</b> <?php echo $row['Document_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Registration ID:</b> <?php echo $row['id']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $row['Address']; ?></span>
</div>
</div>
<br>
</div>

</div>
<div class="col-sm-6">
<br><br>
<b><i class="fa fa-star"></i> GAURANTOR INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Name:</b> <?php echo $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Phone:</b>  <?php echo $rows['Phone']; ?></span>
</div>
</div>




<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Relationship:</b>  <?php echo $rows['Relationship']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gender:</b> <?php echo $rows['Gender']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>BVN/NIN:</b>  <?php echo $rows['Gaurantor_BVN']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Occupation:</b>  <?php echo $rows['Occupation']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>ID No:</b> <?php echo $rows['ID_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>ID Type:</b>   <?php echo $rows['ID_Type']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gaurantor ID:</b>  <?php echo $rows['id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Reg ID:</b>  <?php echo $row['id']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $rows['Address']; ?></span>
</div>
</div>
<br>

</div>

</div>
</div>



<div class="row">
<div class="col-sm-6">

<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Principal Amt:</b> <?php echo number_format($row['Loan_Amount'],2); ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Interest  Amt:</b> <?php echo number_format($row['Interest_Amt'],2); ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Repayment Amt:</b> <?php echo number_format($row['Repayment_Amt'],2); ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Total Loan:</b> <?php echo number_format($row['Total_Loan'],2); ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Bank:</b> <?php echo $row['Bank']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Account Name:</b> <?php echo $row['Account_Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Account No:</b> <?php echo $row['Account_No']; ?></span>
</div>
</div>
<br>
</div>
</div>
<div class="col-sm-6">

<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Product:</b> <?php echo $row['Product']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Frequency:</b> <?php echo $row['Frequency']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Tenure:</b> <?php echo $row['Tenure']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Rate:</b> <?php echo $row['Rate']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Product ID:</b> <?php echo $row['Product_id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Status:</b> <?php echo $row['Status']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Officer:</b> <?php echo $row['Officer_Name']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Team Leader:</b> <?php echo $row['Team_Name']; ?></span>
</div>
</div>
<br>
</div>

</div>
</div>


<br>
<b><i class="fa fa-star"></i> BUSINESS INFO</b>
<br><br>
<div>
<table>
<thead>
<tr>
<th style="font-size:8px">BUSSINESS</th>
<th style="font-size:8px">TYPE</th>
<th style="font-size:8px">STATE</th>
<th style="font-size:8px">START DATE</th>
<th style="font-size:8px">OWNERSHIP</th>
<th style="font-size:8px">ADDRESS</th>
</tr>
</thead>
<tbody>
<tr>
<td ><?php echo $row['Business']; ?></td>
<td ><?php echo $row['Biz_Type']; ?></td>
<td ><?php echo $row['Biz_State']; ?></td>
<td ><?php echo $row['Start_Date']; ?></td>
<td ><?php echo $row['Shop_Owner']; ?></td>
<td ><?php echo $row['Biz_Address']; ?></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>


<div id="seconds" style="display:none;">
<br><br>
<b>CLIENT DOCUMENT REVIEW</b>
<br><br>
<b>Select client document to review</b>
<br><br>
<div class="row">
<div class="col-sm-4">
<label>Select Document</label>
<input type="number" class="form-control for-control-sm" hidden id="regid" value="<?php echo $regid; ?>">
<select class="form-control for-control-sm" id="document" oninput="getDocument()">
<option value="">Select Option</option>
<option value="Loan Form">Loan Form</option>
<option value="Utility Bill">Utility Bill</option>
<option value="ID Card">ID Card</option>
<option value="Other Documents">Other Documents</option>
</select>
</div>
</div>
<br><br>
<div id="documentview"></div>
</div>

<div id="thirds" style="display:none;">
<br><br>
<b>BUSINESS VERIFICATION</b><br><br>
<maquee> <b style="color: red">Note: </b>You are to capture 3 business image and upload before approving the loan</maquee><hr>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div id="upload" style="display: block;">
<div class="row">
<div class="col-12 col-sm-12 col-md-12" style="margin-top: 10px;">
<div id="image"><img id="outver" width="270" height="270" style="border-radius:10px"/></div>
<span><i style="color:red">*</i> Select Image</span>
<input type="text" hidden name="id" required="required" value="<?php echo $regid; ?>">
<input type="file" class="form-control" name="Pic" required="required" onchange="loadver(event)" style="margin-top:10px; width:250px">
</div>
</div><br>
<div class="row">
<div class="col-sm-2">
<button type="submit" class="btn btn-outline-success btn-sm"  onclick="data()">Upload Business Image</button>
</form>
</div>
<div class="col-sm-10">
<i style="color:red; display:none" id="msg"><i class="fa fa-exclamation-triangle"></i> You can not upload more than 3 business image.</i>
</div>
</div>

</div>


</div>



<div id="crc" style="display:none;">
<br><br>
CRC REPORT
<br><br>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT id, Location FROM document WHERE BVN = '$bvn' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bn = $rows['id'];
$crc = $rows['Location'];
?>
<embed src="<?php echo $crc; ?>" type="application/pdf" width="100%" height="430px" />.
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo " No CRC Report Found  <br/> ";        
}
?>

</div>

<div id="fourth" style="display:none;">
<br><br>
<div class="row">
<div class="col-sm-8">
<b>VERIFICATION</b>
</div>
<div class="col-sm-4">

</div>
</div>

<ul class="nav nav-tabs nav-justified nav-bordered nav-bordered-danger mb-3">
<li class="nav-item">
<a href="#home-b2" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
<i class="fa fa-check"></i>
<span class="d-none d-md-inline-block align-middle">Verification Remark</span>
</a>
</li>
<li class="nav-item">
<a href="#profile-b2" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
<i class="fa fa-update"></i>
<span class="d-none d-md-inline-block align-middle">Reduce Loan Amount</span>
</a>
</li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="home-b2">
<br><br><br>
<div class="row">
<div class="col-sm-3">
<p><input type="checkbox" checked> Customer & Business verified</p>
</div>
<div class="col-sm-3">
<p><input type="checkbox" checked> Hard copies in custody</p>
</div>
<div class="col-sm-6">

</div>
</div>
<form action="" method="POST" enctype="multipart/form-data" id="uploadVeri">
<div class="row">
<div class="col-sm-12">
<label>Remark/Comment</label>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="bvn" value="<?php echo $row['BVN']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="name" value="<?php echo $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; ?>" required>
<textarea class="form-control form-control-sm" name="remark" cols="8" rows="8" required placeholder="type here...."></textarea>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-3">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm"><i class="fa fa-check"></i> Submit & Proceed</button>
</div>
</form>
</div>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="deleteApp">
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete Application</button>
</div>
</form>
</div>
<div class="col-sm-3">

</div>
</div>

</div>
<div class="tab-pane show" id="profile-b2">
<br><br>
<b style="color:red;">Note:</b> <span>You can only reduce loan principal amount</span>
<br><br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadAmt">
<div class="col-sm-4">
<label><i style="color:red">*</i> Loan Amount</label>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="pr" value="<?php echo $row['Product_id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="ten" value="<?php echo $row['Tenure']; ?>" required>
<input type="text" hidden class="form-control form-control-md" name="amt" value="<?php echo $row['Loan_Amount']; ?>" required>
<input type="number" class="form-control form-control-md" name="lum" value="<?php echo $row['Loan_Amount']; ?>" required placeholder="Enter Principal Amount">
</div>
<br>
<div class="row">
<div class="col-sm-2">
<button type="submit" class="d-block btn btn-outline-info btn-sm">Reduce Amount</button>
</div>
<div class="col-sm-10">
<i style="display:none" id="wait"><i class="fa fa-refresh"></i> Updating Principal Amount.! Please wait..</i>
<i style="color: green; display:none" id="prin"><i class="fa fa-check"></i> Principal Amount Updated..</i>
<i style="color: red; display:none" id="prins"><i class="fa fa-exclamation-triangle"></i> You can not increase loan principal amount..</i>
</div>
</div>
</div>
</form>
</div>

<script>
var loadver = function(event) {
var image = document.getElementById('outver');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>
<script>
function clientDash(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("crc");
x.style.display = 'block';
y.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
b.style.display = 'none';
}
function updateDoc(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
y.style.display = 'block';
b.style.display = 'none';
}
function updateVerification(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'block';
y.style.display = 'none';
b.style.display = 'none';
a.style.display = 'none';
}
function updateApprove(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
a.style.display = 'block';
y.style.display = 'none';
b.style.display = 'none';
}
function updateCRC(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
b.style.display = 'block';
y.style.display = 'none';
}
</script>


<script type="text/javascript">
function getDocument()  {
var regid = document.getElementById("regid").value;
var document_type = document.getElementById("document").value;
// ajax function start here
$.ajax({
method: "POST",
url: "preview_document_bck.php",
dataType: "html",  
data: {
'regid': regid,
'document_type': document_type
},
success:function(data){
setTimeout(function(){
$('#documentview').html(data);
}, 100);
}
});
// ajax function ends here
}
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to upload this client business image ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "upload_verification.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#uploadForm")[0].reset();
if(data == 1){
$("#please").show();
setTimeout(function(){
$("#image").load( "review_verification.php?id=<?php echo $id; ?> #image" );// 
$("#updateModal").modal('show');
$("#msg").show();
$("#please").hide();
}, 5000);
setTimeout(function(){
$("#msg").hide();
}, 10000);
}else if(data == 2){
setTimeout(function(){
$("#image").load( "review_verification.php?id=<?php echo $id; ?> #image" );// 
$("#please").hide();
$("#toat").css("display", "block");
$("#toat").show();
}, 3000);
setTimeout(function(){
$("#updateModal").modal('show');
$("#please").hide();
$("#toat").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data);
}
},
error: function(){
}
});
}
}));
});
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#uploadAmt").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update principal loan amount ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: "update_loan_amt.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#prins").show();
$("#wait").hide();
}, 4000);
setTimeout(function(){
$("#prins").hide();
$("#wait").hide();
$("#uploadAmt")[0].reset();
}, 7000);
}else if(data ==2){
$("#wait").show();
setTimeout(function(){
$("#firsts").load( "review_verification.php?id=<?php echo $regid; ?> #firsts" );// 
$("#prin").show();
$("#wait").hide();
}, 5000);
setTimeout(function(){
$("#prin").hide();
}, 10000);
}else{
$("#uploadAmt")[0].reset();
$("#wait").hide();
alert ("🚫" + data);
}
},
error: function(){
}
});
}
}));
});
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadVeri").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to submit and approve loan verification ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "submit_verification_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#uploadVeri")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toatver").show();
}, 5000);
setTimeout(function(){
$("#please").hide();
load();
$("#toatver").hide();
}, 9000);
}else{
$("#please").hide();
alert ("🚫" + data);
}
},
error: function(){
}
});
}
}));
});
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#deleteApp").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete this loan application the database ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "delete_app_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
$("#please").show();
setTimeout(function(){
$("#please").hide();
$("#toatdel").show();
load();
}, 5000);
setTimeout(function(){
$("#please").hide();
$("#toatdel").hide();
}, 9000);
}else{
$("#please").hide();
alert ("🚫" + data);
}
},
error: function(){
}
});
}
}));
});
</script>


<script type="text/javascript">
function load()  {
$.ajax({
method: "POST",
url: "load_verification_client.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 
