<?php 
$bvn = $_GET['bvn'];
include '../config/db.php';
$result = mysqli_query($con, "SELECT id, Reg_id, Loan_Account_No, Client_BVN, Savings_Account_No, Firstname, Middlename, Lastname, Product,
Status, Balance FROM savings WHERE Client_BVN = '$bvn' ORDER BY id ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/saving_record.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div id="savDiv" class="table-responsive" style="overflow-y:auto; height:190px">
<table id="savtable">
<thead>
<tr>
<th style="font-size:8px;">LOAN ACCT</th>
<th style="font-size:8px;">SAVING ACCT</th>
<th style="font-size:8px;">BVN</th>
<th style="font-size:8px;">NAME</th>
<th style="font-size:8px;">PRODUCT</th>
<th style="font-size:8px;">BALANCE </th>
<th style="font-size:8px;">STATUS</th>
<th style="font-size:8px;">ACTION</th>
<th style="font-size:8px;">ACTION</th>
<th style="font-size:8px;">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/saving_record.json';
$data = file_get_contents($url);
$json = json_decode($data);

foreach($json as $member){
?>
<tr>
<td style="font-size:8px;"><?php echo $member->Loan_Account_No ?></td>
<td style="font-size:8px;"><?php echo $member->Savings_Account_No ?></td>
<td style="font-size:8px;"><?php echo $member->Client_BVN ?></td>
<td style="font-size:8px;"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname ?></td>
<td style="font-size:8px;"><?php echo $member->Product ?></td>
<td style="font-size:8px;"><?php echo number_format($member->Balance,2) ?></td>
<td style="font-size:8px;"><?php echo $member->Status ?></td>
<td style="font-size:8px;"><a class="activate" href="#!" id="<?php echo $member->id ?>" style="color:green">[ Activate ]</a></td>
<td style="font-size:8px;"><a class="deactivate" href="#!" id="<?php echo $member->id ?>" style="color:navy">[ Deactivate ]</a></td>
<td style="font-size:8px;"><a class="delete" href="#!" id="<?php echo $member->id ?>" style="color:red">[ Delete ] </a></td>
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
$('.activate').on('click', function() {
WRN_PROFILE_DELETE = "You are about to activate this saving account..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'activate_saving_acct.php?id=' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
loadSaving();
}, 1000);
}else{
alert ("🚫" + data)
}
}
});
}else{
alert ("🚫" + data)
}
}
});
});
</script>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.deactivate').on('click', function() {
WRN_PROFILE_DELETE = "You are about to deactivate this saving account ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'deactivate_saving_acct.php?id=' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
loadSaving();
}, 1000);
}else{
alert ("🚫" + data)
}
}
});
}else{
alert ("🚫" + data)
}
}
});
});
</script>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.delete').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this saving account from the database ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'delete_saving_acct.php?id=' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
loadSaving();
}, 1000);
}else{
alert ("🚫" + data)
}
}
});
}else{
alert ("🚫" + data)
}
}
});
});
</script>
