</div>
<div class="row">
<div class="col-sm-2" style="margin-bottom:10px;">
<small>
Total Record: 
<?php 
include '../config/db.php';
$bvn = $_GET['bvn'];
//
$result = mysqli_query($con, "SELECT Account_Number, Savings_Account_No FROM repayments WHERE BVN = '$bvn'  ORDER BY id DESC LIMIT 1");
$rows = mysqli_fetch_array($result);
$vrt = $rows['Account_Number'];
$savings = $rows['Savings_Account_No'];
//
$result = mysqli_query($con, "SELECT COUNT(*) FROM nip_notifications WHERE craccount = '$vrt' AND Status != 'Notification Used'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</small>
</div>
</div>

<div id="table-container" style="overflow:auto; height:250px;">
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, originatoraccountnumber, amount, originatorname, craccountname, bankname, sessionid, craccount, Status, Payment_Type,
bankcode, tnxdate, tnxtime, Branch, Officer_Name FROM nip_notifications WHERE craccount = '$vrt' AND Status != 'Notification Used' ORDER BY tnxdate") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/payment_notification.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<table>
<thead>
<tr>
<th style="font-size:8px">ORIGINATOR ACCT NO</th>
<th style="font-size:8px">ORIGINATOR NAME</th>
<th style="font-size:8px">CREDITOR ACCT NO</th>
<th style="font-size:8px">CREDITOR ACCT NAME</th>
<th style="font-size:8px">SEESION ID</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">BANK</th>
<th style="font-size:8px">CREDIT OFFICER</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">PAYMENT TYPE</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
<th style="font-size:8px">ACTION</th>
<th style="font-size:8px">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/payment_notification.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td ><?php echo $member->originatoraccountnumber?></td>
<td style="text-transform:uppercase"><?php echo $member->originatorname?></td>
<td ><?php echo $member->craccount?></td>
<td ><?php echo $member->craccountname?></td>
<td ><?php echo $member->sessionid?></td>
<td ><?php echo $member->Branch?></td>
<td ><?php echo number_format($member->amount,2)?></td>
<td ><?php echo $member->bankname?></td>
<td ><?php echo $member->Officer_Name?></td>
<td ><?php echo $member->tnxdate?></td>
<td ><?php echo $member->Payment_Type?></td>
<td ><?php echo $member->Status?></td>
<td >
<?php 
if($member->Payment_Type == 'Saving/Upfront Transaction'){
?> 
<a href="#!" class="testLk" data-bs-toggle="modal" data-bs-target="#exampleModalDefault" id="<?php echo $member->id?>" style="color:green">
<i class="fa fa-plus"></i> Post To Savings</a>
<?php 
}else{
?>
--
<?php 
}
?>
</td>
<td >
<?php 
if($member->Payment_Type == 'Saving/Upfront Transaction'){
?> 
<a href="#!" class="testRep" style="color:brown" id="<?php echo $member->id?>"><i class="fa fa-star"></i> Convert To Repayment</a>
<?php 
}else{
?>
<a href="#!" class="testSav" style="color:brown" id="<?php echo $member->id?>"><i class="fa fa-star"></i> Convert To Saving</a>
<?php 
}
?>
</td>
<td ><a href="#!" class="testDel" style="color:red" id="<?php echo $member->id?>"><i class="fa fa-trash"></i> Remove Payment</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>









<div class="modal" id="exampleModalDefault" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Payment Transfer Form</h5>
</div>
<div class="modal-body">
<form action="">
<label>Enter Savings Acct</lable>
<input type="text" class="form-control form-control-md" id="amt" name="amt" hidden required size="40">
<input type="text" class="form-control form-control-md" id="notid" name="notid" hidden required size="40">
<input type="text" class="form-control form-control-md" id="sav" name="sav" placeholder="Enter Reciever Active Saving Acct" value="<?php echo $savings; ?>" required size="40">
<br>
<button type="button" class="btn btn-success btn-sm btn-block" id="savingPosting">Post Payment</button>
</form>
<hr>
<hr>
<div id="pls" style="display:none">
<center>
<i>
<img src="loader.gif" style="height:20px"> Posting Payment ! Please wait.......
</i>
</center>
</div>
<div id="ale" style="display:none">
<center>
<i style="color:green">
Payment Posted Successfully..
</i>
</center>
</div>
</div>
</div>
</div>
</div>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.testLk').on('click', function() {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'select_notification.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
$('#amt').val(data.notAmt);
$('#notid').val(data.notID);
}
});
}else{
alert ("🚫" + data)
}
});
});
</script>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.testRep').on('click', function() {
var id = $(this).attr('id');
WRN_PROFILE_DELETE = "You are about to convert payment notification to repayment transaction..!! ";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: 'convert_repayment.php',
type: "POST",
data: {'id':id},
success:function(data) { 
$("#wait").show();
if(data == 1){
setTimeout(function(){
$("#wait").show();
$("done").show();
reloadPage();
}, 3000);
setTimeout(function(){
$("#wait").hide();
$("done").hide();
reloadPage();
}, 5000);
}else{
$("#wait").hide();
alert ("🚫" + data)
}
}
});
}
});
});
</script>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.testSav').on('click', function() {
var id = $(this).attr('id');
WRN_PROFILE_DELETE = "You are about to convert payment notification to saving transaction..!! ";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: 'convert_saving.php',
type: "POST",
data: {'id':id},
success:function(data) { 
$("#wait").show();
if(data == 1){
setTimeout(function(){
$("#wait").hide();
$("done").show();
reloadPage();
}, 3000);
setTimeout(function(){
$("#wait").hide();
$("#done").done();
reloadPage();
}, 5000);
}else{
$("#wait").hide();
alert ("🚫" + data)
}
}
});
}
});
});
</script>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.testDel').on('click', function() {
var id = $(this).attr('id');
WRN_PROFILE_DELETE = "You are about to declined payment notification..!! ";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: 'notification_del.php',
type: "POST",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
$("#wait").hide();
$("#done").show();
reloadPage();
}, 3000);
setTimeout(function(){
$("#wait").hide();
$("#done").hide();
reloadPage();
}, 5000);
}else{
$("#wait").hide();
alert ("🚫" + data)
}
}
});
}
});
});
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#savingPosting").click(function(){    
WRN_PROFILE_DELETE = "You are about to make payment transfer to this account..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var sav = $("#sav").val();
var amt = $("#amt").val();
var notid = $("#notid").val();
// Check if single input is empty
if (sav === '' || amt === '' || notid === '') {
alert('Missing field is required. please check..!');
}else{
//
$("#wait").show();
$.ajax({
url: "posting_upfront.php",
type: "POST",
data:{sav:sav, amt:amt, notid:notid},
success: function(data){  
if(data == 1){
$("#wait").hide();
alert ("🚫 Payment already exist in the account. please check..")
}else if(data == 2){
setTimeout(function(){
$("#wait").hide();
$("#done").show();
}, 3000);
setTimeout(function(){
$("#wait").hide();
reloadPage();
$("#done").hide();
$("#exampleModalDefault").modal('hide');// hidding modal
}, 5000);
}else{
$("#wait").hide();
alert ("🚫" + data)
}

},
error: function(){
}
});
}
}
});
});
</script>


<script type="text/javascript">
function reloadPage()  {
$.ajax({
method: "GET",
url: 'luxo.php?bvn=' + <?php echo $bvn; ?>,
dataType: "html",
success:function(data){
setTimeout(function(){
$('#notification').html(data);
}, 1000);
}
});
}
</script> 