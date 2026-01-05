<?php 
include_once '../config/db.php';
$id = $_GET['id']; // user id
// 
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$reg_status = $row['Status'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
?>


<?php 
if($reg_status == 'Under Review'){
?>
<div class="btn-group">
<button class="btn btn-light" onclick="myCRC()"><i class="fa fa-user"></i> Loan Profile</button>
<button class="btn btn-light" onclick="myProfile()"><i class="fa fa-book"></i> Generate CRC Report</button>
<button class="btn btn-light" onclick="myApprove()"><i class="fa fa-upload"></i> Upload & Approve Loan</button>
<a class="approve" href="#!" id="<?php echo $regid; ?>" hidden><button class="btn btn-success"><i class="fa fa-check"></i> Approve Application</button></a>
<a href="#!" class="decline" href="#!" id="<?php echo $regid; ?>"><button hidden class="btn btn-warning">
<i class="fa fa-exclamation-triangle"></i> Decline Application</button></a>
<a href="#!" class="delete" href="#!" id="<?php echo $regid; ?>"><button class="btn btn-light">
<i class="fa fa-trash"></i> Delete Application</button></a>
</div>
<?php 
}else{

}
?>

<div id="first" style="display:block">
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

<?php 
if($reg_status == "Under Review"){

}else{
?>
<div id="prlist">
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
<?php 
}
?>



<br>
<b><i class="fa fa-star"></i> BUSINESS INFO</b>
<br><br>
<div>
<table>
<thead>
<tr style="font-size:8px;">
<th>BUSSINESS</th>
<th>TYPE</th>
<th>STATE</th>
<th>START DATE</th>
<th>CASH FLOW</th>
<th>OWNERSHIP</th>
<th>ADDRESS</th>
</tr>
</thead>
<tbody>
<tr>
<td ><?php echo $row['Business']; ?></td>
<td ><?php echo $row['Biz_Type']; ?></td>
<td ><?php echo $row['Biz_State']; ?></td>
<td ><?php echo $row['Start_Date']; ?></td>
<td ><?php echo $row['Cash_Flow']; ?></td>
<td ><?php echo $row['Shop_Owner']; ?></td>
<td ><?php echo $row['Biz_Address']; ?></td>
</tr>
</tbody>
</table>

</div>
</div>




<div id="second" style="display:none;">
<br>
<form id="bvnForm">
<div class="row">
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> CRC Type</label>
<select type="text" class="form-control form-control-sm" name="type" id="type" required>
<option value="">Select CRC Type</option>
<option value="Basic">Basic</option>
<option value="Premium">Premium</option>
</select>
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> BVN</label>
<input type="text" class="form-control form-control-sm" placeholder="11 Digit Number" name="bvn" id="bvn" hidden value="<?php echo $row['BVN']; ?>" required>
<input type="text" class="form-control form-control-sm" placeholder="11 Digit Number" disabled value="<?php echo $row['BVN']; ?>" required>
</div>
</div>
<br>
<button type="submit" class="invks btn btn-outline-success btn-sm" id="submitBtn" >Verify</button>
</form>
<br>
<b style="display:none;" id="loaders"><img src="../loader/loader.gif" style="height:16px"> Checking CRC Record ! Please wait...</b>
<button id="downloadPdf" style="display:none; margin-bottom:15px; padding:8px 15px; background:#FF8C00; color:#fff; border:none; cursor:pointer;">
Download as PDF
</button>
<div id="report"></div>

</div>


<div id="third" style="display:none;">
<br>
<br>
Upload CRC Document Here to Approve Loan Application<br><br>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadCrc">
<div class="row">
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Upload CRC</label>
<input type="text" class="form-control form-control-sm" name="id" value="<?php echo $row['id']; ?>" hidden required>
<input type="file" class="form-control form-control-sm" name="Pic" required>
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" >Upload & Approve</button>
</form>
<br>



</div>

<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#downloadPdf").hide();
$("#loaders").show();
var type = document.getElementById("type").value;
var bvn = document.getElementById("bvn").value;
if(bvn) {
$.ajax({
url: 'crc_report.php',
type: "GET",
data: {'type': type, 'bvn': bvn},
success: function(data) { 
$("#loaders").hide();
$('#report').html(data);
},
error: function(xhr, status, error) {
alert('Error loading data: ' + error);
$("#loaders").hide();
}
});
} else {
alert('Select and filled all the required field..');
$("#loaders").hide();
}
});
});
</script>


<script>
function myCRC() {
var first = document.getElementById("first");
var second = document.getElementById("second");
var third = document.getElementById("third");
if (first.style.display === "none") {
first.style.display = "block";
second.style.display = "none";
third.style.display = "none";
} else {
}
}
function myProfile() {
var first = document.getElementById("first");
var second = document.getElementById("second");
var third = document.getElementById("third");
if (second.style.display === "none") {
first.style.display = "none";
second.style.display = "block";
third.style.display = "none";
} else {
}
}

function myApprove() {
var first = document.getElementById("first");
var second = document.getElementById("second");
var third = document.getElementById("third");
if (third.style.display === "none") {
first.style.display = "none";
second.style.display = "none";
third.style.display = "block";
} else {
}
}
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#uploadCrc").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to upload and approve this application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "approve_review.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
load();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert (data)
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
// to show data on a modal box
$(document).ready(function() {
$('.decline').on('click', function() {
WRN_PROFILE_DELETE = "You are about to decline this loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: 'decline_loan_review.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
load();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
alert (data)
}
}
});
}else{
alert (data)
}
}
});
});
</script>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.delete').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this loan application from the database..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: 'delete_loan_review.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toaste").show();
load();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toaste").hide();
}, 6000);
}else{
alert (data)
}
}
});
}else{
alert (data)
}
}
});
});
</script>