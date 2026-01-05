<?php 
$dt = $_GET['types'];// request type
$sv = $_GET['saving'];// saving acct no
if ($dt == 'Withdraw'){
?>

<b>WITHDRAW REQUEST</b><br><br>
<div id="withDiv" class="table-responsive" style="overflow: auto; height:200px">
<table id="withList" style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">SAVING ACCOUNT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th style="font-size:8px">AMOUNT WITHDRAW</th>
<th style="font-size:8px">DATE WITHDRAW</th>
<th style="font-size:8px">OFFICER NAME</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
include '../config/db.php';
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM withdraw WHERE Saving_Account_No = '$sv' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$wid= $rows['id'];
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount_Withdraw'];
$dp= $rows['Date_Approved'];
$stt= $rows['Status'];
$off= $rows['Officer_Name'];
$sv= $rows['Saving_Account_No'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo $svs; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $off; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
<td style="font-size:9px">
<a href="#" class = "wit" id="<?php echo $wid;?>">Delete</a>
</td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>



<?php 
}else if ($dt == 'Repayment'){
?>


<b>SAVINGS FOR REPAYMENT REQUEST</b><br><br>
<div class="table-responsive" style="overflow: auto; height:200px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">SENDER SAVING ACCOUNT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th  style="font-size:8px">AMOUNT</th>
<th  style="font-size:8px">RECIEVER LOAN ACCT NO </th>
<th  style="font-size:8px">DATE PAID</th>
<th  style="font-size:8px">OFFICER NAME</th>
<th  style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
include '../config/db.php';
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM saving_rep WHERE Saving_Account_No = '$sv' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$svid= $rows['id'];
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$dp= $rows['Date_Approved'];
$sv= $rows['Saving_Account_No'];
$stt= $rows['Status'];
$rc= $rows['Reciever_Loan_No'];
$ofg= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo $svs; ?></td>
<td  style="font-size:9px"><?php echo $rc; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $ofg; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
<td style="font-size:9px">
<a href="#" class = "sit" id="<?php echo $svid;?>">Delete</a>
</td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found.</small> ";       
}
?>
</tbody>
</table>
</div>




<?php 
}else if ($dt == 'Transfer'){
?>


<b>TRANSFER REQUEST</b><br><br>
<div class="table-responsive" style="overflow: auto; height:200px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">SENDER SAVING ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th  style="font-size:8px">AMOUNT</th>
<th  style="font-size:8px">RECIEVER NAME</th>
<th  style="font-size:8px">RECIEVER SAVINGS ACCT</th>
<th  style="font-size:8px">DATE TRANSFER</th>
<th  style="font-size:8px">OFFICER NAME</th>
<th  style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
include '../config/db.php';
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM transfers WHERE Saving_Account_No = '$sv' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$tid= $rows['id'];
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$dp= $rows['Date_Approved'];
$sv= $rows['Saving_Account_No'];
$stt= $rows['Status'];
$reck= $rows['Reciever_Name'];
$recks= $rows['Reciever_Loan_Acct'];
$oh= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo $svs; ?></td>
<td  style="font-size:9px"><?php echo $reck; ?></td>
<td  style="font-size:9px"><?php echo $recks; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $oh; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
<td style="font-size:9px">
<a href="#" class = "tit" id="<?php echo $tid;?>">Delete</a>
</td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>


<?php 
}else if ($dt == 'Upfront'){
?>



<b>SAVINGS FOR UPFRONT REQUEST</b><br><br>
<div class="table-responsive" style="overflow: auto; height:200px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">SAVING ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
include '../config/db.php';
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM saving_upfront WHERE Saving_Account_No = '$sv' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$siid= $rows['id'];
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$dp= $rows['Date_Sent'];
$stt= $rows['Status'];
$dx= $rows['Officer_Name'];
$svv= $rows['Saving_Account_No'];
?>
<tr>
<td  style="font-size:9px"><?php echo $svv; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
<td style="font-size:9px">
<a href="#" class = "st" id="<?php echo $siid;?>">Delete</a>
</td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>



<?php 
}else if ($dt == 'Credit'){
?>


<b>SAVINGS FOR CREDIT REQUEST</b><br><br>
<div class="table-responsive" style="overflow: auto; height:200px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">SAVING ACCOUNT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th  style="font-size:8px">AMOUNT RECIEVED</th>
<th  style="font-size:8px">SENDER NAME</th>
<th  style="font-size:8px">SENDER ACCOUNT</th>
<th  style="font-size:8px">DATE RECIEVED</th>
<th  style="font-size:8px">OFFICER NAME</th>
<th  style="font-size:8px">STATUS</th>
<th  style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
include '../config/db.php';
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM credit WHERE Savings_Account_No = '$sv' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$rid= $rows['id'];
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$rn= $rows['Reciever_Name'];
$ra= $rows['Reciever_Account'];
$dp= $rows['Date_Transfer'];
$ok= $rows['Officer_Name'];
$stt= $rows['Status'];
$svv= $rows['Savings_Account_No'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $svv; ?></td>
<td  style="font-size:9px"><?php echo $rn; ?></td>
<td  style="font-size:9px"><?php echo $un; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $svv; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $ok; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
<td style="font-size:9px">
<a href="#" class = "rt" id="<?php echo $rid;?>">Delete</a>
</td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>

<?php 
}else{
echo "Invalid Request";
}
?>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.wit').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this request!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'next.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
loadReq();//
}else{
alert(data)
}
}
});
}else{
alert('Failed to delete request!!');
}
}
});
});
</script>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.sit').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this request!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'tw.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
loadReq();//
}else{
alert(data)
}
}
});
}else{
alert('Failed to delete request!!');
}
}
});
});
</script>





<script>
// to show data on a modal box
$(document).ready(function() {
$('.tit').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this request!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'to.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
loadReq();//
}else{
alert(data)
}
}
});
}else{
alert('Failed to delete request!!');
}
}
});
});
</script>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.st').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this request!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'ero.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
loadReq();//
}else{
alert(data)
}
}
});
}else{
alert('Failed to delete request!!');
}
}
});
});
</script>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.rt').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this request!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'rre.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
loadReq();//
}else{
alert(data)
}
}
});
}else{
alert('Failed to delete request!!');
}
}
});
});
</script>


<script type="text/javascript">
function loadReq() {
$.ajax({
method: "GET",
url: "request_load.php?types=<?php echo $dt; ?>&saving=<?php echo $sv; ?>",
dataType: "html",
success: function (data) {
$('#requests').html(data);
},
error: function () {
alert("Failed to reload table data");
}
});
}
</script>