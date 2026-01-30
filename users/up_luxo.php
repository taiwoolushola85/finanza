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
$result = mysqli_query($con, "SELECT COUNT(*) FROM nip_notifications WHERE craccount = '$vrt' AND Status = 'Notification Used'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</small>
</div>
</div>

<div id="table-container" style="overflow:auto; height:260px;">
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, originatoraccountnumber, amount, originatorname, craccountname, bankname, sessionid, craccount, Status, Payment_Type,
bankcode, tnxdate, tnxtime, Branch, Officer_Name FROM nip_notifications WHERE craccount = '$vrt' AND Status = 'Notification Used' ORDER BY tnxdate") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/upfront_payment.json', 'w'); 
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
</tr>
<tbody>
<?php
$url = '../data/upfront_payment.json';
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
<td ><a href="#!" class="testReverse" style="color:green" id="<?php echo $member->id?>"><i class="fa fa-history"></i> Reverse Payment</a></td>
<td ><a href="#!" class="paymentDel" style="color:red" id="<?php echo $member->id?>"><i class="fa fa-trash"></i> Remove Payment</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.testReverse').on('click', function() {
var id = $(this).attr('id');
WRN_PROFILE_DELETE = "You are about to reverse payment notification..!! ";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").hide();
$.ajax({
url: 'reverse_payment.php',
type: "POST",
data: {'id':id},
success:function(data) { 
$("#wait").show();
if(data == 1){
setTimeout(function(){
$("#wait").hide();
$("#done").show();
reloadPage();
}, 3000);
setTimeout(function(){
$("#wait").hide();
$("#done").hide();
reloadUp();
}, 5000);
}else{
$("#wait").hide();
alert ("🚫" + data)
}
$("#wait").hide();
}
});
}
});
});
</script>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.paymentDel').on('click', function() {
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
}, 6000);
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
function reloadUp()  {
$.ajax({
method: "GET",
url: 'up_luxo.php?bvn=' + <?php echo $bvn; ?>,
dataType: "html",
success:function(data){
setTimeout(function(){
$('#upfront').html(data);
}, 1000);
}
});
}
</script> 