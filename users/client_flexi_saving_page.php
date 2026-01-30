<?php 
$d = date('Y-m-d');
include '../config/db.php';
include '../config/user_session.php';
$idact = $_GET['id'];
$Query = "SELECT * FROM flexi_account WHERE id = '$idact'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$flexid = $row['Flexi_id'];
//
//
$sql = "SELECT COALESCE(SUM(Amount), 0) AS lm FROM flexi_history WHERE Flexi_Reg = '$flexid' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$rows=mysqli_fetch_assoc($result);
$pm = $rows['lm'];
//
$sql = "SELECT COALESCE(SUM(Amount), 0) AS lm FROM flexi_withdraw WHERE Flexi_id = '$flexid' AND Status = 'Paid'";
$result=mysqli_query($con,$sql);
$rows=mysqli_fetch_assoc($result);
$pmt = $rows['lm'];

$tot = $pm - $pmt;

// getting registration info
$Query = "SELECT * FROM flexi_reg WHERE id = '$flexid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$flesid = $rows['id'];

?>


<div class="row">
<div class="col-sm-3">
<center>
<?php
$img = $row['Location'] ?? '';
$defaultImage = '../assets/no-image.png';
if (!empty($img)) {
// Check if path starts with ../
if (strpos($img, '../') === 0) {
$imgPath = $img;
} else {
$imgPath = '../' . $img;
}
} else {
$imgPath = $defaultImage;
}
?>
<img src="<?= htmlspecialchars($imgPath) ?>" style="height:150px; width:150px; border-radius:50px; margin-left:8px;" onerror="this.src='../assets/no-image.png';">
<br>
</center>
<br>
<button class="btn btn-light btn-sm w-100" onclick="myDash()" style="margin-top:8px">Dashboard</button>
<button class="btn btn-light btn-sm w-100" onclick="myHistory()" style="margin-top:8px">Payment History</button>
<button class="btn btn-light btn-sm w-100" onclick="myWith()" style="margin-top:8px">Withdraw Savings</button>
</div>
<div class="col-sm-9">
<div id="dash" style="display:block">
<b>DASHBOARD</b>
<br>
<br>
<br>
<div class="row">
<div class="col-sm-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Surname:</b> <?php echo $row['Surname']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Othername:</b> <?php echo $row['Firstname']." ". $row['Othername']; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Saving Account:</b> <?php echo $row['Flexi_Account_No'];; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Phone No:</b> <?php echo $rows['Phone']; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Initial Deposit:</b> <?php echo number_format($rows['Deposit_Amt'],2); ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Branch:</b> <?php echo $row['Branch'];; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>N-O-K:</b> <?php echo $rows['NOK_Surname']." ".$rows['NOK_Firstname']." ".$rows['NOK_Othername']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>N-O-K Phone:</b> <?php echo $rows['NOK_Phone'];; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="margin-left:8px;"><b>Address:</b> <?php echo $rows['NOK_Address'];; ?></small>
</div>
</div>
<br>
</div>

</div>
<div class="col-sm-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Plan:</b> <?php echo $rows['Plan']; ?></small>
</div>
<div class="col-6">
<small style="margin-left:8px;"><b>Duration:</b> <?php echo $rows['Duration']; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>BVN:</b> <?php echo $rows['Client_BVN']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Interest Amt:</b> <?php echo number_format($rows['Interest'],2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Total Balance:</b> <span id="mydiv"><?php echo number_format($tot,2); ?></span></span>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Date Start:</b> <?php echo $row['Date_Start'];; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Team Leader:</b> <?php echo $row['Team_Name']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Loan Officer:</b> <?php echo $row['Officer_Name']; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="margin-left:8px;"><b>Status:</b> <?php 
$st = $row['Status'];
if($st == 'Active'){
$msg = "<i style='color:orange'>Active</i>";
}else{
$msg = "<i style='color:green'>Matured</i>";
}
echo $msg; ?></small>
</div>
</div>
<br>
</div>

</div>
</div>





</div>
<div id="his" style="display:none">
<b>PAYMENT HISTORY</b>
<br>
<br>
<div class="tab-pane" id="pro-nav-profile" role="tabpanel" aria-labelledby="pro-nav-profile-tab">
<div class="bd-example" >
<ul class="nav nav-pills" data-toggle="slider-tab" role="tablist" >
<li class="nav-item" role="presentation">
<button class="nav-link active d-flex align-items-center" data-bs-toggle="tab" data-bs-target="#pills-home1" type="button" role="tab" aria-selected="true">Deposited</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link d-flex align-items-center" data-bs-toggle="tab" data-bs-target="#pills-profile1" type="button" role="tab" aria-selected="false">Withdrawed</button>
</li>
</ul>
<div class="tab-content iq-tab-fade-up">
<br>
<div class="tab-pane show active" id="pills-home1" role="tabpanel">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM flexi_history WHERE Flexi_Reg = '$flexid' AND Status = 'Paid'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
mysqli_close($con);
?>
<b><?php echo "Total: ".number_format($over,2);?></b>
<br><br>
<div class="table-container" style="overflow: auto; height:200px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">FLEXI ID</th>
<th style="font-size:8px">SAVING ACCOUNT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">PLAN</th>
<th style="font-size:8px">AMOUNT DEPOSIT</th>
<th style="font-size:8px">DATE DEPOSIT</th>
<th style="font-size:8px">OFFICER NAME</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">RECIEPT</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM flexi_history WHERE Flexi_Reg = '$flexid' AND  Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$h_id= $rows['id'];
$sv= $rows['Flexi_Account'];
$cl_id= $rows['Flexi_Reg'];
$nnm= $rows['Surname']. " ".$rows['Firstname']." ".$rows['Othername'];
$unn= $rows['Plan'];
$svs= $rows['Amount'];
$dp= $rows['Date_Paid'];
$ofd= $rows['Officer_Name'];
$stt= $rows['Status'];
$pyy= $rows['Payment_Method'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo $svs; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $ofd; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
<td>
<a href="#" class = "reciepts" id="<?php echo $h_id;?>">View Reciept</a>
</td>

</tr>
<?php  
}
}else {
//$Available = false; 
//echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>
</div>
<div class="tab-pane" id="pills-profile1" role="tabpanel">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM flexi_withdraw  WHERE Flexi_id = '$flexid' AND  Status ='Paid'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
mysqli_close($con);
?>
<b><?php echo "Total: ".number_format($over,2);?></b>
<br><br>
<div class="table-container" style="overflow: auto; height:200px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">FLEXI ID</th>
<th style="font-size:8px">SAVING ACCOUNT</th>
<th style="font-size:8px">NAME</th>
<th  style="font-size:8px">AMOUNT WITHDRAW</th>
<th  style="font-size:8px">DATE WITHDRAW</th>
<th  style="font-size:8px">OFFICER NAME</th>
<th  style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM flexi_withdraw WHERE Flexi_id = '$flexid' AND  Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Flexi_id'];
$nnm= $rows['Name'];
$sv= $rows['Flexi_Accounts'];
$svs= $rows['Amount'];
$dp= $rows['Date_Withdraw'];
$stt= $rows['Status'];
$off= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $off; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
//echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>
</div>

</div>
</div>
</div>



</div>
<div id="with" style="display:none">

<span><b>SAVING WITHDRAWAL</b></span><br><br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadWith">
<div class="row">
<div class="col-sm-3">
<input type="text" name="id" class="form-control" hidden value="<?php echo $id;?>" required="required">
<input type="text" name="bal" class="form-control" hidden value="<?php echo $tot;?>" required="required">
<label>Amount</label>
<input type="number" class="form-control" placeholder="Amount" name="amt"  required="required">
</div>
<div class="col-sm-3">
<label>Account Name</label>
<input type="text" class="form-control" placeholder="Account Name" name="actname"  required="required">
</div>
<div class="col-sm-3">
<label>Account No</label>
<input type="number" class="form-control" placeholder="Account No" name="acct"  required="required">
</div>
<div class="col-sm-3">
<label>Bank</label>
<select type="text" class="form-control form-control-md" name="bnk" required="required">
<option value="">Select Bank</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Bank_Name FROM bank ORDER BY Bank_Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Bank_Name'];// product
?>
<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div><br>
<label>Reason for Withdrawal</label>
<textarea class="form-control" rows="3" name="reason" placeholder="Type withdrawal reason here....." required="required"></textarea>
<br>
<button type="submit" class="btn btn-primary btn-sm" onclick="data()" >Send Withdrawal Request</button>
</form>


</div>











</div>
</div>



<script>
function myDash() {
var x = document.getElementById("dash");
var y = document.getElementById("his");
var z = document.getElementById("with");
if (x.style.display === "none") {
x.style.display = "block";
y.style.display = "none";
z.style.display = "none";
} else {
x.style.display = "block";
}
}
function myHistory() {
var x = document.getElementById("dash");
var y = document.getElementById("his");
var z = document.getElementById("with");
if (y.style.display === "none") {
x.style.display = "none";
y.style.display = "block";
z.style.display = "none";
} else {
y.style.display = "block";
}
}
function myWith() {
var x = document.getElementById("dash");
var y = document.getElementById("his");
var z = document.getElementById("with");
if (z.style.display === "none") {
x.style.display = "none";
y.style.display = "none";
z.style.display = "block";
} else {
z.style.display = "block";
}
}


</script>



<script type="text/javascript">
$(document).ready(function(){
setTimeout(function () {
// ajax function start here to load table data
$.ajax({
method: "GET",
url: "flexi_update.php?id=<?php echo $idact; ?>",
dataType: "html",
success:function(data){
alert(data)
$("#mydiv").load("client_flexi_saving_page.php?id=<?php echo $idact; ?>" + " #mydiv");
}
});
}, 100);
// ajax function ends here
});
</script>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.reciepts').on('click', function() {
var recID = $(this).attr('id');
$("#updateModal").modal('hide');
$("#updateRec").modal('show');
if(recID){
$.ajax({
url: 'flexi_reciept_preview.php',
type: "POST",
data: {'id':recID},
dataType: "json",
success:function(data) {
$('#full').text(data.fullName);
$('#hid').val(data.historyId);
$('#hidd').val(data.historyId);
$('#recp').val(data.recieptLocation);
$("#recp").attr("src",data.recieptLocation);
}
});
}else{
$('#full').empty();
$('#hid').empty();
$('#hidd').empty();
$('#samt').empty();
}
});
});
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadWith").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to send this request for approval.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "flexi_withdrawal_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
$("#please").hide();
alert("Request has pending approval already. Please check");
$("#updateModal").modal('show');
}else if(data == 2){
$("#please").hide();
alert("Amount to withdraw is more than available balance");
$("#updateModal").modal('show');
}else if(data == 3){
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
alert("Error" + data);
}
},
error: function(){
}
});
}
}));
});
</script>
