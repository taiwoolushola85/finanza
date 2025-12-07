<?php 
include_once '../config/db.php';
$id = $_GET['id']; // reg id
// 
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$reg_status = $row['Status'];
$un = $row['Unions'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
?>


<div class="row">
<div class="col-sm-8" style="margin-top:10px;">
<div style="overflow-x: auto;">
<div class="btn-group">
<button class="btn btn-light" onclick="clientDash()"><i class="fa fa-user"></i> Customer Profile</button>
<button class="btn btn-light" onclick="updateDoc()"><i class="fa fa-list"></i> Repayment Schedule</button>
</div>
</div>
</div>
<br>
<div class="col-sm-4" style="margin-top:10px;">

</div>
</div>
<br>
<hr>
<div class="row">
<div class="col-sm-3">
<b> Payment Mode:</b> <span><?php echo $row['Upfront_Types']; ?></span>
</div>
<div class="col-sm-3">
<b> Virtual Acct:</b><span> <?php echo $row['Virtual_Account']; ?></span>
</div>
<div class="col-sm-3">
<b> Upfront Amt:</b><span> 
<?php 
$total_fee = $row['Upfront'] + $row['Inssurance'] + $row['Form']+ $row['Card']; 
echo number_format($total_fee,2);

?>
</span>
</div>
<div class="col-sm-3">
<b> Amt To Disbursed:</b><span> 
<?php 
if($row['Upfront_Types'] == 'Deduction'){
$fee = $row['Upfront'] + $row['Inssurance'] + $row['Form']+ $row['Card'];
$disburse = $row['Loan_Amount'] - $fee; 
echo number_format($disburse,2);
}else{
echo number_format($row['Loan_Amount'],2);
}
?>
</span>
</div>
</div>
<hr>

<div id="seconds" style="display:none;">

<br>
<h6><b>Loan Repayment Schedule</b></h6>
<br>
<div class="row">
<div class="col-sm-6">
<b>Group Name: <?php echo $un; ?></b>
</div>
</div>
<br>
<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-6">
<small>No Of Installments</small>
<input type="number" hidden="hidden" class="form-control form-control-md" value="<?php echo $row['Tenure']; ?>" placeholder="number of days" required="required" name="no">
<input type="number" disabled="disabled" class="form-control form-control-md" value="<?php echo $row['Tenure']; ?>" placeholder="number of days" required="required">
</div>
<div class="col-sm-6">
<small>First Payment Date</small>
<input type="text" class="form-control form-control-md" hidden required="required" name="id" value="<?php echo $regid; ?>">
<input type="date" class="form-control form-control-md" required="required" name="ft">
</div>
</div><br>
<div class="row">
<div class="col-sm-4" style="margin-top:10px">
<button type="submit" class="btn btn-outline-info btn-block btn-sm" name="calculate" onclick="data()">Calculate Date</button>
</form>
</div>
</div>
<br>
<div id="results"></div>



</div>

<div id="firsts" style="display:block; font-size:12px">

<div class="row">
<div class="col-sm-6">
<br>
<b><i class="fa fa-star"></i> CLIENT INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<img src="<?php echo $row['Location']; ?>" style="height:50px; width:50px; border-radius:50px; margin-left:8px;">
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
<br>
<b><i class="fa fa-star"></i> GAURANTOR INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<img src="<?php echo $rows['Location']; ?>" style="height:50px; width:50px; border-radius:50px; margin-left:8px;">
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
<hr>
<div class="row">
<div class="col-sm-3" style="margin-top:10px; display:none" >
<form action="" method="POST" enctype="multipart/form-data" id="approveLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"> </i> Approve Loan</button>
</div>
</form>
</div>
<div class="col-sm-3" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="declineLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-warning btn-sm" style="font-size:10px;"><i class="fa fa-exclamation-triangle"></i> Reverse Loan</button>
</div>
</form>
</div>
<div class="col-sm-3" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="deleteLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-danger btn-sm" style="font-size:10px;"><i class="fa fa-trash"></i> Delete Loan</button>
</div>
</form>
</div>
</div>
<hr>

<script>
function clientDash(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
x.style.display = 'block';
y.style.display = 'none';
}
function updateDoc(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
x.style.display = 'none';
y.style.display = 'block';
}
</script>






<script type="text/javascript">
$(document).ready(function (e){
$("#approveLoan").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to submit and approve loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "approve_second_underwriting.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#approveLoan")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
loads();
}, 7000);
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
$("#declineLoan").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to reverse this loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "decline_second_underwriting.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#declineLoan")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
loads();
}, 7000);
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
$("#deleteLoan").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete this loan application from the database..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "delete_second_underwriting.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#declineLoan")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toas").show();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toas").hide();
loads();
}, 7000);
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
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "schedule_load.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
setTimeout(function(){
$("#please").hide();
$("#updateModal").modal('show');
$('#results').html(data);
}, 2000);
},
error: function(){
}
});
}));
});
</script>


<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "load_secound_underwriting.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 