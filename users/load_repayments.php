<br>
<div class="row">
<div class="col-sm-2" style="margin-bottom:10px;">
<small>
Total Record: 
<?php 
$d = date('Y-m-d');
include '../config/db.php';
include '../config/user_session.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM nip_notifications WHERE User = '$User' AND Status = 'Waiting For Approval' 
AND Payment_Type = 'Repayment Transaction'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</small>
</div>
<div class="col-sm-4" style="margin-bottom:10px;">
<small>
Total Transaction Recieved: 
<?php 
$d = date('Y-m-d');
include '../config/db.php';
$result = mysqli_query($con, "SELECT SUM(amount) FROM nip_notifications WHERE User = '$User' AND Status = 'Waiting For Approval' 
AND Payment_Type = 'Repayment Transaction'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
mysqli_close($con);
?>
</small>
</div>
<div class="col-sm-6" style="margin-bottom:10px;">
<button type="button" class="btn btn-outline-primary btn-sm" onclick="load()" style="float:right;">
<i id="frt" style="display:block">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24">
<path d="M5.89155 8.94037C5.89155 8.94037 9.06324 4.5 13.8208 4.5C15.9237 4.5 17.9406 5.3354 19.4276 6.82242C20.9146 8.30943 21.75 10.3263 21.75 12.4292C21.75 14.5322 20.9146 16.549 19.4276 18.036C17.9406 19.5231 15.9237 20.3585 13.8208 20.3585C11.0646 20.3585 8.63701 18.851 7.21609 16.9429" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M4.01239 12.7139C4.09736 12.7198 4.18269 12.7029 4.25979 12.6639L9.27776 10.0921C9.41563 10.0211 9.50597 9.88782 9.51635 9.73793C9.52673 9.58804 9.45563 9.44359 9.32886 9.35425L4.71338 6.11519C4.57901 6.02124 4.40214 6.00373 4.25173 6.07095C4.10075 6.13755 4.00082 6.27715 3.98984 6.43576L3.58736 12.2466C3.57637 12.4053 3.6561 12.5573 3.79645 12.6441C3.8625 12.6854 3.93712 12.7087 4.01239 12.7139" fill="currentColor"></path>
</svg>
Reload Data
</i>
</button>
</div>
</div>
<div style="overflow:auto; height:380px;">
<div style="display:none;">
</div>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT DISTINCT id, originatoraccountnumber, amount, originatorname, narration, craccountname, bankname, sessionid, craccount, 
Payment_Type, bankcode, tnxdate, tnxtime FROM nip_notifications WHERE User = '$User' AND Status = 'Waiting For Approval' AND Payment_Type = 'Repayment Transaction'
ORDER BY tnxdate ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/notification.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div id="table-container" style="height:350px;">
<table>
<thead>
<tr>
<th style="font-size:8px">ORIGINATOR ACCT NO</th>
<th style="font-size:8px">ORIGINATOR NAME</th>
<th style="font-size:8px">NARRATION</th>
<th style="font-size:8px">CREDITOR ACCT NO</th>
<th style="font-size:8px">CREDITOR ACCT NAME</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">BANK</th>
<th style="font-size:8px">SESSION ID</th>
<th style="font-size:8px">PAYMENT TYPE</th>
<th style="font-size:8px">DATE</th>
</tr>
<tbody>
<?php
$url = '../data/notification.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px" class="invks" data-bs-toggle="modal" data-bs-target="#updateMod" id="<?php echo $member->id?>">
<td ><?php echo $member->originatoraccountnumber?></td>
<td style="text-transform:uppercase"><?php echo $member->originatorname?></td>
<td ><?php echo $member->narration?></td>
<td ><?php echo $member->craccount?></td>
<td ><?php echo $member->craccountname?></td>
<td ><?php echo number_format($member->amount,2)?></td>
<td ><?php echo $member->bankname?></td>
<td ><?php echo $member->sessionid?></td>
<td ><?php echo $member->Payment_Type?></td>
<td ><?php echo $member->tnxdate?></td>
</tr>
<?php
}
?>
</tbody>
</table>

</div>

<div class="modal" id="updateMod" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm" style="display:none; width:400px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" style="font-size:12px; text-transform:uppercase"> Virtual Posting Form</h6>
<button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<center>
<p><img src="" id="customerImg" style="height: 100px; width:100px; border-radius:50px;" class="img-thumbnail" /></p>
[ <span id="des"></span> ]<br><br>
</center>
<form action="" method="POST" enctype="multipart/form-data" id="updateForm"> 
<div class="row">
<div class="col-sm-12">
<label class="form-label"><i style="color: red;">*</i> Enter Repayment</label>
<input type="text" name="notid" class="form-control" id="notid" hidden required>
<input type="text" name="sessionid" class="form-control" id="secid" hidden required>
<input type="text" name="repid" class="form-control" id="stid" hidden required>
<input type="text" name="amt" class="form-control" id="amt" hidden required>
<input type="text" name="date" class="form-control" id="date" hidden required>
<input type="number" name="am" class="form-control" placeholder="Enter Repayment Amount">
</div>
<div class="col-sm-12">
<label class="form-label"><i style="color: red;">*</i> Enter Savings</label>
<input type="number" name="sa"  class="form-control" placeholder="Enter Saving Amount">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm btn-block" style="float:left;">Post Repayment</button>
</form>

</div>
</div>
</div>
</div>

<script>
// to show data on a modal box
$(document).ready(function() {
$('.invks').on('click', function() {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'pick_notification.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
$('#notid').val(data.notId);
$('#secid').val(data.notSession);
$('#stid').val(data.repID);
$('#stids').val(data.repID);
$('#des').text(data.notName);
$('#amt').val(data.notAmt);
$('#amt1').val(data.notAmt);
$('#notid1').val(data.notId);
$('#stid1').val(data.repID);
$('#amt2').val(data.notAmt);
$('#notid2').val(data.notId);
$('#stid2').val(data.repID);
$('#amt3').val(data.notAmt);
$('#notid3').val(data.notId);
$('#stid3').val(data.repID);
$('#amt4').val(data.notAmt);
$('#notid4').val(data.notId);
$('#stid4').val(data.repID);
$('#date').val(data.notDate);
$('#date1').val(data.notDate);
$('#date2').val(data.notDate);
$('#date3').val(data.notDate);
$('#date4').val(data.notDate);
$('#secid1').val(data.notSession);
$('#secid2').val(data.notSession);
$('#secid3').val(data.notSession);
$('#secid4').val(data.notSession);
$('#customerImg').attr('src', data.notImg);
}
});
}else{
alert ("🚫" + data)
}
});
});
</script>




<script type="text/javascript">
function load()  {
$("#loader").show();
$.ajax({
method: "POST",
url: "load_repayments.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#result').html(data);
}, 2000);
}
});
}
</script> 



<script type="text/javascript">
$(document).ready(function (e){
$("#updateForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to post repayment for this client..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateMod").modal('hide');
$("#please").show();
$.ajax({
url: "post_notification.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){ 
$('#updateForm')[0].reset();
load();
if(data==1){
$("#please").hide();
alert("🚫 Failed to send transaction for approval ");
}else if(data==3){
$("#please").hide();
alert("🚫 Amount entered is higher than customer loan balance");
}else if(data==2){
$("#please").hide();
alert(" 🚫 Payment session id already exist. this is a duplicate transaction, please check..");
}else if(data==8){
$("#please").hide();
alert(" 🚫 You attempting to make a double posting on this client savings account, please check..");
}else if(data==7){
$("#please").hide();
alert(" 🚫 Amount entered must be equal to total amount paid, please check..");
}else if(data==9){
$("#please").hide();
alert(" 🚫 This customer currently has a repayment posted waiting for approval. Please check..");
}else if(data==11){
$("#please").hide();
alert(" 🚫 Amount enter is greater than loan balance, Please check & try again..");
$("#overlay").hide();
}else if(data==13){
$("#please").hide();
alert(" 🚫 No repayment posting is done..");
$("#overlay").hide();
}else if(data==4){
$("#please").hide();
alert(" 🚫 This customer currently has a saving posted waiting for approval. Please check..");
}else if(data==20){
$("#please").hide();
alert(" 🚫 Do not enter zero for repayments amount, instead leave the field empty");
}else if(data==21){
$("#please").hide();
alert(" 🚫 Do not enter zero for savings amount, instead leave the field empty");
}else if(data==14){
$("#please").hide();
alert(" 🚫 You are not allowed to post only saving on the system, Please contact IT for further clarification.");
}else if(data==15){
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
alert(data);
load();
}
},
error: function(){
}
});
}
}));
});
</script>

