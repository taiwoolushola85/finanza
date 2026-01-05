<?php 
$bvn = $_GET['bvn'];
?>
<br>
<div id="upinit" style="display:block">
<form action="" method="POST" enctype="multipart/form-data" id="uploadUpfnt">
<div class="row">
<div class="col-sm-2">
<b>Upfront</b>
<input type="text" hidden class="form-control search-input search form-control-sm" name="id" id="upidd" style="width:200px" placeholder="reg ID" required>
<input type="text" class="form-control search-input search form-control-sm" name="up" id="ups" style="width:200px" placeholder="Upfront" required>
</div>
<div class="col-sm-2">
<b>Inssurance</b>
<input type="text" class="form-control search-input search form-control-sm" name="in" id="in" style="width:200px" placeholder="Inssurance" required>
</div>
<div class="col-sm-2">
<b>Card</b>
<input type="text" class="form-control search-input search form-control-sm" name="cd" id="cd" style="width:200px" placeholder="Card" required>
</div>
<div class="col-sm-2">
<b>Form</b>
<input type="text" class="form-control search-input search form-control-sm" name="fm" id="fm" style="width:200px" placeholder="Form" required>
</div>
<div class="col-sm-1">
<button type="submit" class="btn btn-outline-primary btn-sm" style="margin-top:18px">
Update
</i>
</button>
</div>
<div class="col-sm-3">
<div id="wt" style="margin-top:20px; display:none">
<i>
<img src="../loader/loader.gif" style="height:16px;"> Updating Payment ! Please wait...
</i>
</div>
<div id="dn" style="margin-top:20px; display:none"><i class="fa fa-check">Payment Updated !.</i>
</div>
</div>
</form>
</div>
</div>


<div id="payinit" style="display:none">
<form action="" method="POST" enctype="multipart/form-data" id="updateUp">
<div class="row">
<div class="col-sm-4">
<label class="form-label"><i style="color: red;">*</i> Enter Initial Deposit Amt</label>
<input type="text" name="id" class="form-control" id="reg" hidden required>
<input type="number" name="am" class="form-control" placeholder="Enter Initial Deposit Amt" required>
</div>
<div class="col-sm-4">
<button type="submit" class="btn btn-outline-primary btn-sm" style="margin-top:30px">
Post Payment
</i>
</button>
</div>
</div>
</form>
</div>


<br>
<div class="row">
<div class="col-sm-3">
<small><b>Total Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE BVN = '$bvn'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-3">

</div>
<div class="col-sm-3">

</small>
</div>

</div>
<br>
<div style="overflow-y:auto; height:200px">
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$result = mysqli_query($con, "SELECT id, BVN, Firstname, Middlename, Lastname, Product, Status, Date_Reg, Upfront, Inssurance, Card, Form, Date_Paid
FROM register WHERE BVN = '$bvn' ORDER BY id ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/data_upfront_record.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-responsive">
<table >
<thead>
<tr>
<th style="font-size:8px;">BVN</th>
<th style="font-size:8px;">NAME</th>
<th style="font-size:8px;">PRODUCT</th>
<th style="font-size:8px;">UPFRONT</th>
<th style="font-size:8px;">INSSURANCE</th>
<th style="font-size:8px;">CARD</th>
<th style="font-size:8px;">FORM</th>
<th style="font-size:8px;">STATUS</th>
<th style="font-size:8px;">DATE PAID</th>
<th style="font-size:8px;">DATE REG</th>
<th style="font-size:8px;">ACTION</th>
<th style="font-size:8px;">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/data_upfront_record.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td style="font-size:8px;"><?php echo $member->BVN?></td>
<td style="font-size:8px;"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
<td style="font-size:8px;"><?php echo $member->Product?></td>
<td style="font-size:8px;"><?php echo number_format($member->Upfront,2)?></td>
<td style="font-size:8px;"><?php echo number_format($member->Inssurance,2)?></td>
<td style="font-size:8px;"><?php echo number_format($member->Card,2)?></td>
<td style="font-size:8px;"><?php echo number_format($member->Form,2)?></td>
<td style="font-size:8px;"><?php echo $member->Status?></td>
<td style="font-size:8px;"><?php echo date("d-M-Y", strtotime($member->Date_Paid))?></td>
<td style="font-size:8px;"><?php echo date("d-M-Y", strtotime($member->Date_Reg))?></td>
<td style="font-size:8px;"><a class="up" href="#!" id="<?php echo $member->id?>" style="font-size:9px;">
+  Manage</a>
</td>
<td style="font-size:8px;"><a class="init" href="#!" id="<?php echo $member->id?>" style="font-size:9px;">+  Initial Deposit</a></td>
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
$('.up').on('click', function() {
var modalID = $(this).attr('id');
if(modalID) {
$("#payinit").hide();
$.ajax({
url: 'up_modal.php',
type: "POST",
data: {'id':modalID},
dataType: "json",
success:function(data) {
$("#upinit").show();
$('#upidd').val(data.regId);
$('#reg').val(data.regId);
$('#ups').val(data.upFront);
$('#in').val(data.inSsrance);
$('#cd').val(data.carD);
$('#fm').val(data.forM);
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
$('.init').on('click', function() {
var id = $(this).attr('id');
if(id) {
$("#upinit").hide();
$.ajax({
url: 'upo.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) {
$("#payinit").show();
$('#reg').val(data.regId);
}
});
}else{
}
});
});
</script>


<script type="text/javascript">
function loadUp()  {
// ajax function start here to load table data
$.ajax({
method: "POST",
url: "upfront_manager.php?bvn=<?php echo $bvn; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$("#up").html(data);
}, 1000);
}
});
}
</script> 



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadUpfnt").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this payment!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wt").show();
$.ajax({
url: "pay_edit.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
setTimeout(function(){
$("#wt").hide();
$("#dn").show();
loadUp();
}, 3000);
setTimeout(function(){
$("#dn").hide();
}, 5000);
}else{
alert(data)
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
$("#updateUp").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to make initiate payment!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "init.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toaste").show();
///loadUp();
loadList();
}, 3000);
setTimeout(function(){
$("#toaste").hide();
}, 5000);
}else{
alert(data);
}
},
error: function(){
}
});
}
}));
});
</script>
