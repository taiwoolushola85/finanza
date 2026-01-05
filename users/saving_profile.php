<?php 
include '../config/db.php';
$id = $_GET['id'];
$Query = "SELECT * FROM savings WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$rep_id = $row['id'];
$fll = $row['Firstname']. " ". $row['Middlename']. " ". $row['Lastname'];
$un = $row['Unions'];
$sid = $row['Savings_Account_No'];
$loan = $row['Loan_Account_No'];
// repayment 
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$loan'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$rep_id = $row['id'];
$bv = $row['BVN'];
$lli = $row['Location'];
$lon = $row['Loan_Account_No'];
$tr = $row['Transaction_id'];
$dis = $row['Disbursement_No'];
$did = $row['Date_Disbursed'];
$reg_rep = $row['Reg_id'];
$prin = $row['Loan_Amount'];
$prin_int = $row['Interest_Amt'];
$tlon = $row['Total_Loan'];
$pds = $row['Paid'];
$tb = $row['Total_Bal'];
$st = $row['Status'];
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
<div>
<div>
<div class="d-flex flex-column align-items-center text-center">
<img src="<?php echo $lli; ?>"  class="rounded-circle" width="120" height="120px">
<div class="mt-3">
<h4><b><?php echo $fll; ?></b></h4>
<p class="text-secondary mb-1"><?php echo $un; ?> Group</p>
</div>
</div>
</div>
</div>
<br>
<div id="dashboard">
<div style="font-size:11px">
<div>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Deposit:</b>
<?php
include '../config/db.php';
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Loan_Account_No = '$loan' AND Status ='Paid'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
echo number_format($pmd,2);
?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Withdrawal:</b> 
<?php 
include '../config/db.php';
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status ='Paid' AND Loan_Account_No = '$loan'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
echo number_format($pmw,2); 
?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Repayment:</b> 
<?php 
include '../config/db.php';
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status ='Paid' AND  Loan_Account_No = '$loan'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
echo number_format($pmr,2); 
?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Transfer:</b> 
<?php 
include '../config/db.php';
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status ='Paid' AND Loan_Account_No = '$loan'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
echo number_format($pmtr,2); 
?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Upfront:</b>
<?php 
include '../config/db.php';
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status ='Paid' AND  Loan_Account_No= '$loan'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
echo number_format($pmu,2); 
?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Credit:</b>
<?php 
include '../config/db.php';
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status ='Paid' AND Reciever_Loan_Acct = '$loan'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
echo number_format($pmc,2); 
?>
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
<b><i class="fa fa-list"></i> SAVING PAYMENT HISTORY</b>
<br><br>
</div>
<div class="col-sm-4">
<div id="waits" style="display:none">
<i>
<img src="../loader/loader.gif" style="height:12px"> Updating Payment, Please wait..
</i>
</div>
<div id="dones" style="display:none">
<i class="fa fa-check"> Payment Updated</i>
</div>
<div id="deleting" style="display:none">
<i>
<img src="../loader/loader.gif" style="height:12px"> Deleting, Please wait...
</i>
</div>
<div id="deldone" style="display:none">
<i class="fa fa-check">Payment Deleted !</i>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-4">
<div id="bal">
<?php 
echo 'Total Balance: '. number_format($bal = $pmd - $pmw - $pmr - $pmtr - $pmu + $pmc,2);
?>
</div>
</div>
<div class="col-sm-4">

</div>
<div class="col-sm-4">
<form action="" method="POST" enctype="multipart/form-data" id="uploadSavings">
<div class="row">
<div class="col-sm-8">
<input type="text" class="form-control form-control-sm"  hidden id="shids" name="spayid" required>
<input type="text" class="form-control form-control-sm" placeholder="Amount" id="samt" name="sv" required>
</div>
<div class="col-sm-4">
<button type="submit" class="btn btn-outline-info btn-sm" onclick="data()">Update</button>
</div>
</div>
</form>
</div>
</div>
<br>
<div id="tabl">
<div class="table-responsive" style="overflow: auto; height:300px">
<table style="font-size:7px">
<thead>
<tr>
<th style="font-size:7px">SAVING ACCT</th>
<th style="font-size:7px">LOAN ACCT</th>
<th style="font-size:7px">AMOUNT</th>
<th style="font-size:7px">METHOD</th>
<th style="font-size:7px">DATE</th>
<th style="font-size:7px">STATUS</th>
<th style="font-size:7px">EDIT</th>
<th style="font-size:7px">DELETE</th>
</tr>
</thead>
<tbody>
<?php
include '../config/db.php';
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM save WHERE Saving_Account = '$sid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$s_id= $rows['id'];
$cl_id= $rows['Register_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$lan= $rows['Loan_Account_No'];
$sv= $rows['Saving_Account'];
$svs= $rows['Savings'];
$dp= $rows['Date_Paid'];
$ofd= $rows['Officer_Name'];
$stt= $rows['Status'];
$mt= $rows['Posting_Method'];
?>
<tr>
<td  style="font-size:7px"><?php echo $sv; ?></td>
<td  style="font-size:7px"><?php echo $lan; ?></td>
<td  style="font-size:7px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:7px"><?php echo $mt; ?></td>
<td  style="font-size:7px"><?php echo $dp; ?></td>
<td  style="font-size:7px"><?php echo $stt; ?></td>
<td> 
<a href="#" class = "invs"  data-toggle="modal" data-target="#modalsaving" id="<?php echo $s_id;?>">Edit</a>
</td>
<td> 
<a href="#" class = "del" id="<?php echo $s_id;?>">Delete</a>
</td>
</tr>
<?php  
}
}else {
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>
</div>

</div>
</div>


<script type="text/javascript">
function loadPage()  {
$.ajax({
method: "GET",
url: "saving_profile.php?id=<?php echo $id; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#profile').html(data);
}, 1000);
}
});
}
</script> 

<script type="text/javascript">
function loadBal() {
$.ajax({
method: "GET",
url: "update_saving_bal.php?id=<?php echo $id; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
//
}, 1000);
}
});
}
</script> 

<script>
// to show data on a modal box
$(document).ready(function() {
$('.invs').on('click', function() {
var modalID = $(this).attr('id');
if(modalID) {
$.ajax({
url: 'update_saving.php',
type: "POST",
data: {'id':modalID},
dataType: "json",
success:function(data) {
$('#sfull').text(data.fullName);
$('#shids').val(data.saveId);
$('#shidds').val(data.saveId);
$('#samt').val(data.amountPaid);
}
});
}else{

}
});
});
</script>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.del').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete saving payment history from the database!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
$("#deleting").show();
$.ajax({
url: 'delete_saving_amount.php',
type: "POST",
data: {'id':id},
success:function(data) {
if(data == 1){
loadBal();
setTimeout(function(){
$("#deleting").hide();
$("#deldone").show();
loadPage();
loadList();
}, 3000);
setTimeout(function(){
$("#deleting").hide();
$("#deldone").hide();
}, 6000);
}else{
alert('Error' + data);
}
}
});
}
});
});
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadSavings").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this savings!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#waits").show();
$.ajax({
url: "update_saving_history.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
loadBal();
setTimeout(function(){
$("#waits").hide();
$("#dones").show();
loadPage();
loadList();
}, 3000);
setTimeout(function(){
$("#dones").hide();
}, 6000);
},
error: function(){
}
});
}
}));
});
</script>
