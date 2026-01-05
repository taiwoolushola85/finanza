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


<center>
<img src="<?php echo $row['Location']; ?>" style="height:150px; width:150px; border-radius:100px;">
</center>
<br>
<div class="bd-example">
<nav>
<div class="mb-3 nav nav-tabs nav-iconly gap-3" id="nav-tab" role="tablist">
<button class="nav-link active" id="pro-nav-home-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-home" type="button" role="tab" aria-controls="pro-nav-home" aria-selected="true">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.294 7.29105C17.294 10.2281 14.9391 12.5831 12 12.5831C9.0619 12.5831 6.70601 10.2281 6.70601 7.29105C6.70601 4.35402 9.0619 2 12 2C14.9391 2 17.294 4.35402 17.294 7.29105ZM12 22C7.66237 22 4 21.295 4 18.575C4 15.8539 7.68538 15.1739 12 15.1739C16.3386 15.1739 20 15.8789 20 18.599C20 21.32 16.3146 22 12 22Z" fill="currentColor" />
</svg>
Client Info
</button>
<button class="nav-link" id="pro-nav-profile-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-profile" type="button" role="tab" aria-controls="pro-nav-profile" aria-selected="false">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z" fill="currentColor" />
</svg>
Savings Info
</button>
</div>
</nav>
<div class="tab-content iq-tab-fade-up" id="simple-tab-content">
<div class="tab-pane  active" id="pro-nav-home" role="tabpanel" aria-labelledby="pro-nav-home-tab">
<div style="font-size: 12px; text-transform:capitalize">
<div >
<div id="myPage">
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
<small style="margin-left:8px;"><b>Next Of Kin:</b> <?php echo $rows['NOK_Surname']." ".$rows['NOK_Firstname']." ".$rows['NOK_Othername']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Next Of Kin Phone:</b> <?php echo $rows['NOK_Phone'];; ?></small>
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
<small style="margin-left:8px;"><b>Saving Plan:</b> <?php echo $rows['Plan']; ?></small>
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
<span id="mydiv" style="margin-left:8px;"><b>Total Balance:</b> <?php echo number_format($tot,2); ?></span>
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




<div id="myDIV" style="display:none">
<br>
<br>
<span><b>Savings Withdrawal Form</b></span><br><br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
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


<div id="myDep" style="display:none">
<span><b>Savings Deposit Form</b></span><hr>
<form action="" method="POST" enctype="multipart/form-data" id="uploadDeposit">
<div class="row">
<div class="col-sm-6" style="margin-top:10px">
<input type="text" name="id" class="form-control" hidden value="<?php echo $id; ?>" required="required">
<input type="text" class="form-control" hidden="hidden" placeholder="Amount" name="sav" value="<?php echo $sv;?>" required="required">
<label>Amount</label><br>
<input type="number" class="form-control" placeholder="Amount" name="am"  required="required">
</div>
<div class="col-sm-6" id="reciept" style="margin-top:10px">
<label style="font-size:13px"><i style="color:red">*</i> Reciept Image</label>
<input type="file" class="form-control" name="Pic"  id="re">
</div>
</div><br>
<button type="submit"  class="btn btn-primary btn-sm">Submit Deposit</button>
</form>

</div>
<br>
<?php 
if($gr == 'Loan Officers'){
?>
<div class="row">
<div class="col-sm-6" style="margin-top:15px; display:none">
<button class="btn btn-light btn-sm w-100"onclick="myFunctions()">Deposit Savings</button>
</div>
<div class="col-sm-6" style="margin-top:15px">
<button class="btn btn-light btn-sm w-100" onclick="myFunction()">Withdraw Savings</button>

</div>
</div>
<?php 
}else{
    
}
?>

<script>
function show() {
tt = document.getElementById('method').value;
if(tt == 'Cash'){
    document.getElementById("reciept").style.display = 'none'; 
    document.getElementById("rec").style.display = 'none';  
    document.getElementById("re").required = false;  
    document.getElementById("rex").required = false;  
    //alert('Cash Payment');
}else{
    document.getElementById("reciept").style.display = 'block';  
    document.getElementById("rec").style.display = 'block';  
    document.getElementById("re").required = true;  
    document.getElementById("rex").required = true;  
    alert('⛔ Please upload reciept for the transaction.');

}
}
</script>


<script>
function myFunction() {
var x = document.getElementById("myDIV");
var y = document.getElementById("myDep");
if (x.style.display === "none") {
x.style.display = "block";
y.style.display = "none";
} else {
x.style.display = "none";
}
}

function myFunctions() {
var y = document.getElementById("myDep");
var x = document.getElementById("myDIV");
if (y.style.display === "none") {
x.style.display = "none";
y.style.display = "block";
} else {
y.style.display = "none";
}
}


</script>
</div>
</div>


<?php 
if($gr == 'Super User'){
?>
<div class="row" style="display:none;">
<div class="col-sm-3" style="margin-top:15px">
<button class="btn btn-light btn-sm w-100"onclick="myTransfer()">Transfer Client</button>
</div>
</div>
<?php 
}else{

}
?>



</div>
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
<div class="table-responsive" style="overflow: auto; height:300px">
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
<a href="#" class = "reciept" id="<?php echo $h_id;?>">View Reciept</a>
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
<div class="table-responsive" style="overflow: auto; height:300px">
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
echo"<small> No Record Found  </small> ";       
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
</div>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.reciept').on('click', function() {
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
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
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
