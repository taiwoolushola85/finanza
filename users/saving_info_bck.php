<?php 
$bvn = $_GET['bvn'];
include '../config/db.php';
$Query = "SELECT * FROM savings WHERE Client_BVN = '$bvn'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row == 0){
echo "<i>🚫 Record Not Found..!!</i>";
exit();
}else{
?>
<?php
include '../config/db.php';
$Query = "SELECT id, Loan_Account_No, Disbursement_No, Account_Number, Reg_id FROM repayments WHERE BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$repid = $rows['id'];
$loanacct = $rows['Loan_Account_No'];
$dis = $rows['Disbursement_No'];
$vrt = $rows['Account_Number'];
$regid = $rows['Reg_id'];
?>
<br>
<div style="overflow-x: auto;">
<div class="btn-group" style="float: right;">
<button class="btn btn-light" onclick="clientDash()"><i class="fa fa-list"></i> Savings List</button>
<button class="btn btn-light" onclick="updateDoc()"><i class="fa fa-recycle"></i> Merging Saving Account</button>
<button class="btn btn-light" onclick="updateReq()"><i class="fa fa-star"></i> Saving Request List</button>
<button class="btn btn-light" onclick="updateVerification()"><i class="fa fa-plus"></i> Create Saving Account</button>
<button class="btn btn-light" onclick="updateLoan()"><i class="fa fa-money-bill"></i> Upfront Adjustment</button>
</div>
</div>
<br>
<br>


<div id="list" style="display:block;">

<div class="row">
<div class="col-sm-3">
<small><b>Total Closed Acct:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM savings WHERE Client_BVN = '$bvn' AND Status ='Closed'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-3">
<small><b>Total Active Acct:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM  savings WHERE Client_BVN = '$bvn' AND Status ='Active'");
$row = mysqli_fetch_array($result);
$totalbal = $row[0];
echo $totalbal;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-3">
<small><b>Total Loan Cycle:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM savings WHERE Client_BVN = '$bvn'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
</div>
<br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$result = mysqli_query($con, "SELECT id, Reg_id, Loan_Account_No, Client_BVN, Savings_Account_No, Firstname, Middlename, Lastname, Product, 
Status,  Balance, Date_Opend FROM savings WHERE Client_BVN = '$bvn' ORDER BY id ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/data_saving_record.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-responsive" style="overflow-y:auto; height:200px">
<table>
<thead>
<tr>
<th style="font-size:8px;">LOAN ACCT</th>
<th style="font-size:8px;">SAVING ACCT</th>
<th style="font-size:8px;">BVN</th>
<th style="font-size:8px;">NAME</th>
<th style="font-size:8px;">PRODUCT</th>
<th style="font-size:8px;">OUTSTANDING</th>
<th style="font-size:8px;">STATUS</th>
<th style="font-size:8px;">DATE OPENED</th>
<th style="font-size:8px;">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/data_saving_record.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td style="font-size:8px;"><?php echo $member->Loan_Account_No?></td>
<td style="font-size:8px;"><?php echo $member->Savings_Account_No?></td>
<td style="font-size:8px;"><?php echo $member->Client_BVN?></td>
<td style="font-size:8px;"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
<td style="font-size:8px;"><?php echo $member->Product?></td>
<td style="font-size:8px;"><?php echo number_format($member->Balance,2)?></td>
<td style="font-size:8px;"><?php echo $member->Status?></td>
<td style="font-size:8px;"><?php echo date("d-M-Y", strtotime($member->Date_Opend))?></td>
<td style="font-size:8px;"><a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModals" id="<?php echo $member->id?>" style="font-size:9px;">
+  Manage Account</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
<?php
}
?>

</div>

<div id="merge" style="display:none;">
<b>Saving Merging Account Section</b>
<br>
<br>
<div class="row">
<div class="col-sm-8">
<div class="row">
<div class="col-sm-4">
<small><b>Total Closed Acct Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$bvn' AND Status = 'Closed'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-4">
<small><b>Total Available Balance:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT SUM(Savings_Bal) FROM repayments WHERE BVN = '$bvn'");
$row = mysqli_fetch_array($result);
$totalbal = $row[0];
echo number_format($totalbal,2);
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-4">
<small><b>Total Active Acct Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$bvn' AND Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
</div>
<br>

<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$result = mysqli_query($con, "SELECT id, Reg_id, Loan_Account_No, BVN, Savings_Account_No, Firstname, Middlename, Lastname, Product,
Status, Total_Loan, Savings_Bal FROM repayments WHERE BVN = '$bvn' ORDER BY id ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/bvn_record.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div id="mergeDiv" class="table-responsive" style="overflow-y:auto; height:190px">
<table id="mergetable">
<thead>
<tr>
<th style="font-size:8px;">LOAN ACCT</th>
<th style="font-size:8px;">SAVING ACCT</th>
<th style="font-size:8px;">LOAN BVN</th>
<th style="font-size:8px;">NAME</th>
<th style="font-size:8px;">PRODUCT</th>
<th style="font-size:8px;">LOAN AMT </th>
<th style="font-size:8px;">SAVINGS </th>
<th style="font-size:8px;">STATUS</th>
</tr>
<tbody>
<?php
$url = '../data/bvn_record.json';
$data = file_get_contents($url);
$json = json_decode($data);

foreach($json as $member){
?>
<tr>
<td style="font-size:8px;"><?php echo $member->Loan_Account_No ?></td>
<td style="font-size:8px;"><?php echo $member->Savings_Account_No ?></td>
<td style="font-size:8px;"><?php echo $member->BVN ?></td>
<td style="font-size:8px;"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname ?></td>
<td style="font-size:8px;"><?php echo $member->Product ?></td>
<td style="font-size:8px;"><?php echo number_format($member->Total_Loan,2) ?></td>
<td style="font-size:8px;"><?php echo number_format($member->Savings_Bal,2) ?></td>
<td style="font-size:8px;"><?php echo $member->Status ?></td>
<td style="font-size:8px; display:none"><a class="invit" href="#!" id="<?php echo $member->id ?>" style="color:red">+ Merge Acct</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>



</div>
<div class="col-sm-4">
<b>Saving Merging Form</b><hr>
<?php 
$bvn = $_GET['bvn'];
include '../config/db.php';
$Query = "SELECT id, Loan_Account_No, Savings_Account_No, Client_BVN FROM savings WHERE Client_BVN = '$bvn' AND Status = 'Active' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
if($rows == true){
$savid = $rows['id'];
$ll = $rows['Loan_Account_No'];
$sv = $rows['Savings_Account_No'];
$bv = $rows['Client_BVN'];
?>
Recent Loan Acct: [ <?php echo $ll; ?> ]<br>
Recent Saving Acct: [ <?php echo $sv; ?> ]
<br><br>
<b>Note:</b> <i style="color:red">You are to merged closed loan saving account to an active loan account</i>
<br><br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadMerge">
<div class="row">
<div class="col-sm-6">
<label>Active Saving Acct No</lable>
<input type="text" class="form-control form-control-md" name="new" value="<?php echo $savid; ?>" hidden required>
<input type="text" class="form-control form-control-md" name="bvn" value="<?php echo $bv; ?>" hidden required>
<input type="text" class="form-control form-control-md" value="<?php echo $sv; ?>" disabled>
</div>
<div class="col-sm-6">
<label>Other Saving Acct No</lable>
<div id="savinglist">
<select type="text" class="form-control form-control-md" name="old" id="lnno" required>
<option value="">Select Saving Acct</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Savings_Account_No FROM savings WHERE Client_BVN = '$bvn' AND Status = 'Active' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$nx= $rows['id']; // union id
$name= $rows['Savings_Account_No'];
?>
<option value="<?php echo $nx; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
</div>
<?php 
include '../config/db.php';
$Query = "SELECT * FROM saving_merge WHERE New = '$ll' AND Status = 'Account Merged' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row == 0){
?>
<br>
<button type="submit" class="btn btn-success btn-sm">Merged Account</button>
<button type="reset" class="btn btn-danger btn-sm" style="float:right">Reset Input Form</button>
<?php 
//
}else{

}
?>
</form>
<?php 
}else{
echo "<i style='color:red'>No Active Loan Record Found.!</i>";
}
?>

</div>
</div>





</div>

<div id="request" style="display:none;">
<div class="col-sm-3">
<label>Request Type</label>
<input class="form-control form-control-sm"  id="saving" value="<?php echo $sv; ?>" hidden>
<select class="form-control form-control-sm" name="types" id="types" required oninput="getRequest()">
<option value="">Select Option</option>
<option value="Withdraw">Withdrawal Request</option>
<option value="Repayment">Repayment Request</option>
<option value="Transfer">Transfer Request</option>
<option value="Upfront">Upfront Request</option>
<option value="Credit">Credit Request</option>
</select>
</div>
<br>
<div id="requests"></div>

</div>


<div id="create" style="display:none;">
<i>Please fill the account opening form below</i><hr>
<div class="row">
<div class="col-sm-4">
<form method="POST" id="createAcct">
<div class="row">
<div class="col-sm-6">
<label>BVN</label>
<input type="number" class="form-control form-control-sm" name="bvn" hidden value="<?php echo $bvn; ?>" required>
<input type="number" class="form-control form-control-sm" disabled value="<?php echo $bvn; ?>" required>
</div>
<div class="col-sm-6">
<label>Rep ID</label>
<input type="number" class="form-control form-control-sm" hidden name="repid" value="<?php echo $repid; ?>" required>
<input type="number" class="form-control form-control-sm" hidden name="regid" value="<?php echo $regid; ?>" required>
<input type="number" class="form-control form-control-sm" disabled value="<?php echo $repid; ?>" required>
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<label>Loan Account No</label>
<input type="number" class="form-control form-control-sm" name="lon" value="<?php echo $loanacct; ?>" placeholder="Enter Loan Account No" required>
</div>
<div class="col-sm-6">
<label>Disbursement Account No</label>
<input type="number" class="form-control form-control-sm" name="dis" value="<?php echo $dis; ?>" placeholder="Enter Loan Account No" required>
</div>
</div><br>
<div class="row">
<div class="col-sm-12">
<label>Saving Type</label>
<input type="text" disabled class="form-control form-control-sm" value="Express Savings" required>
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-primary btn-sm w-100">Create Account</button>
</form>
</div>
<div class="col-sm-8">
<div id="myDiv"></div>


</div>
</div>




</div>

<div id="upfront" style="display:none;">
<div id="up"></div>


</div>



<script>
function clientDash(){
var x = document.getElementById("list");
var y = document.getElementById("merge");
var z = document.getElementById("create");
var a = document.getElementById("upfront");
var b = document.getElementById("request");
x.style.display = 'block';
y.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
b.style.display = 'none';
}
function updateReq(){
var x = document.getElementById("list");
var y = document.getElementById("merge");
var z = document.getElementById("create");
var a = document.getElementById("upfront");
var b = document.getElementById("request");
b.style.display = 'block';
x.style.display = 'none';
y.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
}
function updateDoc(){
var x = document.getElementById("list");
var y = document.getElementById("merge");
var z = document.getElementById("create");
var a = document.getElementById("upfront");
var b = document.getElementById("request");
x.style.display = 'none';
y.style.display = 'block';
z.style.display = 'none';
b.style.display = 'none';
a.style.display = 'none';
}
function updateVerification(){
var x = document.getElementById("list");
var y = document.getElementById("merge");
var z = document.getElementById("create");
var a = document.getElementById("upfront");
var b = document.getElementById("request");
x.style.display = 'none';
b.style.display = 'none';
y.style.display = 'none';
z.style.display = 'block';
a.style.display = 'none';
}
function updateLoan(){
var x = document.getElementById("list");
var y = document.getElementById("merge");
var z = document.getElementById("create");
var a = document.getElementById("upfront");
var b = document.getElementById("request");
x.style.display = 'none';
y.style.display = 'none';
b.style.display = 'none';
z.style.display = 'none';
a.style.display = 'block';
}
</script>


<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "POST",
url: "saving_list.php?bvn=<?php echo $bvn; ?>",// display saving table
dataType: "html",  
success:function(data){
setTimeout(function(){
$('#myDiv').html(data);
}, 100);
}
});
// ajax function ends here
});
</script>



<script type="text/javascript">
function loadSaving() {// load saving list
$.ajax({
method: "GET",
url: "saving_list.php?bvn=<?php echo $bvn; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#myDiv').html(data);
}, 1000);
}
});
}
</script> 


<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "GET",
url: "upfront_manager.php?bvn=<?php echo $bvn; ?>",// display saving table
dataType: "html",  
success:function(data){
setTimeout(function(){
$('#up').html(data);
}, 100);
}
});
// ajax function ends here
});
</script>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.invit').on('click', function() {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'pick_loan_account.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
$('#idno').val(data.loanId);
$('#lnno').val(data.loanAcct);
$('#bvnno').val(data.loanBVN);
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
$('.invks').on('click', function() {
$("#updateModal").modal('hide');
$("#please").show();
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'saving_profile.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
setTimeout(function(){
$("#updateModal").modal('show');
$("#please").hide();
$('#profile').html(data);
}, 1000);
}
});
}else{
alert ("🚫" + data)
}
});
});
</script>





<script type="text/javascript">
function getRequest(){
$("#loader").show();
$("#requests").hide();
var types = document.getElementById("types").value;
var saving = document.getElementById("saving").value;
// ajax function start here
$.ajax({
method: "GET",
url: "request_load.php",
dataType: "html",  
data: {
'types': types,
'saving': saving
},
success:function(data){
$("#requests").show();
setTimeout(function(){
$("#loader").hide();
$('#requests').html(data);
}, 1000);
}
});
// ajax function ends here
}
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#uploadMerge").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to merge this saving to a loan account.!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "acct_merged.php",
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
loadMerge();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else if(data == 2){
$("#please").hide();
alert("🚫 Account has already been merged to an active account..");
loadMerge();
}else if(data == 3){
$("#please").hide();
alert("🚫 The same loan account can not be merged..");
loadMerge();
}else if(data == 4){
$("#please").hide();
loadMerge();
alert(data);
}else{
$("#please").hide();
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






<script type="text/javascript">
$(document).ready(function (e){
$("#createAcct").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to create a new saving account to a loan account.!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "new_saving_account.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
$("#please").hide();
alert("Customer already has a saving account. Please check");
loadSaving();
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toasts").css("display", "block");
$("#toasts").show();
loadSaving();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
$("#please").hide();
loadSaving();
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


<script type="text/javascript">
function loadMerge() {
$.ajax({
method: "GET",
url: "saving_info_bck.php?bvn=<?php echo $bvn; ?>",
dataType: "html",
success: function (data) {
// replace table body
$("#mergeDiv").load("saving_info_bck.php?bvn=<?php echo $bvn; ?> #mergetable");
$("#savinglist").load("saving_info_bck.php?bvn=<?php echo $bvn; ?> #savinglist");
},
error: function () {
alert("Failed to reload table data");
}
});
}
</script>



<script type="text/javascript">
function loadList()  {
$.ajax({
method: "GET",
url: "saving_info_bck.php?bvn=<?php echo $bvn; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#results').html(data);
}, 1000);
}
});
}
</script> 
