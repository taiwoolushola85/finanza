<?php 
include '../config/db.php';
$id = $_GET['id'];
// repayment 
$Query = "SELECT * FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$rep_id = $row['id'];
$bv = $row['BVN'];
$fn = $row['Firstname']." ".$row['Lastname'];
$lon = $row['Loan_Account_No'];
$tr = $row['Transaction_id'];
$dis = $row['Disbursement_No'];
$did = $row['Date_Disbursed'];
$sid = $row['Savings_Account_No'];
$reg_rep = $row['Reg_id'];
$prin = $row['Loan_Amount'];
$prin_int = $row['Interest_Amt'];
$tlon = $row['Total_Loan'];
$pds = $row['Paid'];
$un = $row['Unions'];
$tb = $row['Total_Bal'];
$st = $row['Status'];
$lli = $row['Location'];
$dd = $row['Date_Disbursed'];
$dt = $row['Time_Disbursed'];
//
$sql = "SELECT SUM(Amount) AS lm FROM history WHERE Status ='Paid' AND Register_id = '$reg_rep'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmt = $data['lm'];
?>


<div class="row"style="text-transform:capitalize">
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="d-flex flex-column align-items-center text-center">
<img src="<?php echo $lli; ?>"  class="rounded-circle" width="130" height="130px">

<div class="mt-3">
<h4><b><?php echo $fn; ?></b></h4>
<p class="text-secondary mb-1"><?php echo $un; ?> </p>
</div>
</div>
<br>
<div id="processing" style="display:none">
<center>
<i>
<img src="loader.gif" style="height:13px"> Processing Payment ! Please Wait..
</i>
</center>
</div>
<div id="posted" style="display:none">
<center>
<i>
Payment Posted !..
</i>
</center>
</div>
<div id="alert" style="display:none">
<center>
<i>
<img src="loader.gif" style="height:13px"> Waiting For Response ! Please Wait..
</i>
</center>
</div>
<div id="alerts" style="display:none">
<center>
<i>
Loan Closed Sucessfuly !..
</i>
</center>
</div>
<div id="alert1" style="display:none">
<center>
<i>
<img src="loader.gif" style="height:13px"> Waiting For Response ! Please Wait..
</i>
</center>
</div>
<div id="alertss" style="display:none">
<center>
<i>
Loan Activated Sucessfuly !..
</i>
</center>
</div>

<div id="form">
<div class="card border-primary border border-dashed">
<br>
<div class="row" style="font-size:10px;">
<div class="col-sm-6">
<b style="margin-left:8px;">Principal Amount:</b> <?php echo number_format($prin,2); ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Interest Amount:</b> <?php echo number_format($prin_int,2); ?>
</div>
</div>
<div class="row" style="font-size:10px;">
<div class="col-sm-6">
<b style="margin-left:8px;">Total Loan:</b> <?php echo number_format($tlon,2); ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Amount Paid:</b> <?php echo number_format($pds,2); ?>
</div>
</div>
<div class="row" style="font-size:10px;">
<div class="col-sm-6">
<b style="margin-left:8px;">Outstanding:</b> <?php echo number_format($tb,2); ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Status:</b> <?php echo $st; ?>
</div>
</div>
<br>

</div>
</div>

</div>
</div>

</div>

<div class="col-sm-8">
<div class="row">
<div class="col-sm-8">
<b>PAYMENT HISTORY</b>
<br><br>
</div>
<div class="col-sm-4">
<div id="wait" style="display:none">
<i>
<img src="../loader/loader.gif"  style="height:13px"> Updating Payment, Please wait..
</i>
</div>
<div id="done" style="display:none">
<i class="fa fa-check"> Payment Updated </i>
</div>
<div id="de" style="display:none">
<i>
<img src="../loader/loader.gif" style="height:13px"> Deleting Payment, Please wait..
</i>
</div>
<div id="don" style="display:none">
<i class="fa fa-trash"> Payment Deleted </i>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-8">
<?php 
echo 'Total: '. number_format($pmt,2);
?>
</div>
<div class="col-sm-4">
<form action="" method="POST" enctype="multipart/form-data" id="updatePayment">
<div class="row">
<div class="col-sm-8">
<input type="text" class="form-control form-control-sm" hidden name="lon" id="repid" required>
<input type="text" class="form-control form-control-sm" hidden name="id" id="hiddh" required>
<input type="text" class="form-control form-control-sm" placeholder="Amount" name="am" id="amth"  required>
</div>
<div class="col-sm-4">
<button type="submit" class="btn btn-outline-info btn-sm" onclick="data()">Update</button>
</div>
</div>
</form>
</div>
</div>

<div class="table-responsive" style="overflow: auto; height:300px"><br>
<table style="font-size:7px">
<thead>
<tr>
<th>LOAN AMT</th>
<th>AMT PAID</th>
<th>EXP AMT</th>
<th>TYPES</th>
<th>POSTING TYPE</th>
<th>STATUS</th>
<th>DATE</th>
<th>EDIT</th>
<th>DELETE</th>
</tr>
</thead>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM history WHERE Loan_Account_No = '$lon' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$h_id = $rows['id'];
$fn = $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname'];
$dis = $rows['Disbursement_No'];
$lon = $rows['Loan_Account_No'];
$uns = $rows['Unions'];
$pr = $rows['Loan_Type'];
$la = $rows['Loan_Amount'];
$am = $rows['Amount'];
$int = $rows['Interest_Amt'];
$exp = $rows['Expected_Amount'];
$of = $rows['Officer_Name'];
$dp = $rows['Date_Paid'];
$stat = $rows['Status'];
$bb = $rows['Balance'];
$pm = $rows['Payment_Method'];
$po = $rows['Post_Method'];
?>
<tr>
<td><?php echo number_format($la + $int,2); ?></td>
<td><?php echo number_format($am,2); ?></td>
<td><?php echo number_format($exp,2); ?></td>
<td><?php echo $pm; ?></td>
<td><?php echo $po; ?></td>
<td><?php echo $stat; ?></td>
<td><?php echo $dp; ?></td>
<td> 
<a href="#" class = "invk" data-toggle="modal" data-target="#recieptdata" id="<?php echo $h_id;?>">Edit</a>
</td>
<td> 
<a href="#" class = "invd" id="<?php echo $h_id;?>">Delete</a>
</td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo" <small style='color:red'>No payment record </small> ";       
}
?>
</tr>
</table>
</div>





</div>
</div>

<script>
function myRep(){
var x = document.getElementById("image").style.display ='none';
var a = document.getElementById("rep").style.display ='none';
var b = document.getElementById("card1").style.display ='none';
var c = document.getElementById("card2").style.display ='none';
var z = document.getElementById("form").style.display ='block';
var y = document.getElementById("dash").style.display ='block';
}

function myDash(){
var x = document.getElementById("image").style.display ='block';
var a = document.getElementById("rep").style.display ='block';
var z = document.getElementById("form").style.display ='none';
var y = document.getElementById("dash").style.display ='none'; 
var b = document.getElementById("card1").style.display ='block';
var c = document.getElementById("card2").style.display ='block';
}
</script>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.invk').on('click', function() {
var repID = $(this).attr('id');
if(repID) {
$.ajax({
url: 'update_amount.php',
type: "POST",
data: {'id':repID},
dataType: "json",
success:function(data) {
$('#fullh').text(data.fullName);
$('#hidh').val(data.historyId);
$('#repid').val(data.loanAcct);
$('#hiddh').val(data.historyId);
$('#amth').val(data.amountPaid);
}
});
}else{
$('#full').empty();
$('#hidd').empty();
$('#hid').empty();
$('#amt').empty();
}
});
});
</script>

<script type="text/javascript">
$(document).ready(function (e){
$("#updatePayment").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this payment!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "edit_amount.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
$( "#form" ).load( "manage_data_profiles.php?id=<?php echo $id; ?> #form" );// reloading table
load();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
$("#updateModal").modal('show');
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
// to show data on a modal box
$(document).ready(function() {
$('.invd').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this payment!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var recID = $(this).attr('id');
$("#updateModal").modal('hide');
$("#please").show();
if(recID) {
$.ajax({
url: 'history_delete.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").css("display", "block");
$("#toasts").show();
$( "#form" ).load( "manage_data_profiles.php?id=<?php echo $id; ?> #form" );// reloading table
load();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
$("#updateModal").modal('show');
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data)
}
}
});
}else{
alert('Failed to delete payment history!!');
}
}
});
});
</script>



<script type="text/javascript">
function loads()  {
// ajax function start here to load table data
$.ajax({
method: "GET",
url: "manage_data_profiles.php?id=<?php echo $id; ?>",
dataType: "html",
success:function(data){
$("#profile").html(data);
}
});
}
</script> 

