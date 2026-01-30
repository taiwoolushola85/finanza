
<div id="tableContainer">

<table id="myTable" style="font-size:9px;">
<thead>
<tr>
<th style="font-size:8px">PAYMENT ID</th>
<th style="font-size:8px">UPFRONT</th>
<th style="font-size:8px">INSSURANCE</th>
<th style="font-size:8px">FORM</th>
<th style="font-size:8px">CARD</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">RECIEPT</th>
<th style="font-size:8px">ACTION</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
$regid = $_GET['id'];// reg id
//Get branch Details
$Query = "SELECT * FROM fee WHERE Reg_id = '$regid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$fee = mysqli_fetch_array($result);
$feeid= $fee['id'];
$regg_id= $fee['Reg_id'];
$upf = $fee['Upfront'];
$ins = $fee['Inssurance'];
$forms = $fee['Form'];
$cards = $fee['Card'];
$status = $fee['Reciept_Status'];
$reci = $fee['Reciept'];
$date = $fee['Date_Paid'];
?>
<tr style="font-size: 9px">
<td  style="font-size:9px"><?php echo $feeid; ?></td>
<td  style="font-size:9px"><?php echo number_format($upf,2); ?></td>
<td  style="font-size:9px"><?php echo number_format($ins,2); ?></td>
<td  style="font-size:9px"><?php echo number_format($forms,2); ?></td>
<td  style="font-size:9px"><?php echo number_format($cards,2); ?></td>
<td  style="font-size:9px"><?php echo $status; ?></td>
<td  style="font-size:9px"><?php echo $date; ?></td>
<td  style="font-size:9px"><a href="#!" class = "invk" data-toggle="modal" data-target="#recieptdata" id="<?php echo $feeid; ?>">
<i class="fa fa-eye"></i> View Reciept</a></td>
<td  style="font-size:9px"><a href="#!" class = "inv" id="<?php echo $regg_id; ?>" style="color:green;"><i class="fa fa-check"></i> Confirm Payment</a></td>
<td  style="font-size:9px"><a href="#!" class = "invdel" id="<?php echo $feeid; ?>" style="color:red;"><i class="fa fa-trash"></i> Remove</a></td>
</tr>
<?php  
}
}else {
?>


<?php
}
?>
</tbody>
</table>
</div>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.invk').on('click', function() {
var recID = $(this).attr('id');
if(recID) {
$("#recieptdata").modal('show');
$.ajax({
url: 'upfront_reciept.php',
type: "POST",
data: {'id':recID},
dataType: "json",
success:function(data) {
$('#recp').val(data.recieptLocation);
$("#recp").attr("src",data.recieptLocation);
}
});
}else{

}
});
});
</script>




<script>
// confirming upfront fee payment
$(document).ready(function() {
$('.inv').on('click', function() {
WRN_PROFILE_DELETE = "You are about to approve reciept transaction..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'confirm_upfront.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
loadList();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
alert(data);
}
}
});
}else{

}
}
});
});
</script>




<script>
// confirming upfront fee payment
$(document).ready(function() {
$('.invdel').on('click', function() {
WRN_PROFILE_DELETE = "You are about to remove reciept transaction..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'remove_upfront.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
setTimeout(function(){
loadList();
}, 100);
}else{
alert(data);
}
}
});
}else{

}
}
});
});
</script>

