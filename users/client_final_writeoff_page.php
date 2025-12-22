<!-- Main content -->
<?php 
include_once '../config/db.php';
$el_id = $_GET['id'];
// eligible info
$Query = "SELECT * FROM other_request WHERE id = '$el_id'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$regid = $rows['Reg_id'];
$rq_type = $rows['Request_Type'];
$res = $rows['Reason'];
$send = $rows['Sender'];
$drt = $rows['Date_Request'];
// repayment info
$Query = "SELECT * FROM repayments WHERE Reg_id = '$regid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];
$loc = $row['Location'];
$na = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
$un = $row['Unions'];
$tr = $row['Transaction_id'];
$ln = $row['Loan_Account_No'];
$sv = $row['Savings_Account_No'];
$ph = $row['Phone'];
$reg_id = $row['Reg_id'];
$bv = $row['BVN'];
$int = $row['Interest_Amt'];
$la = $row['Loan_Amount'];
$pd = $row['Paid'];
$tb = $row['Total_Bal'];
$er = $row['Expected_Amount'];
$br = $row['Branch'];
$pr = $row['Product'];
$fr = $row['Frequency'];
$of = $row['Officer_Name'];
$tn = $row['Team_Name'];
$st = $row['Status'];
$lamt = $row['Last_Amount'];
$dd = $row['Date_Disbursed'];
$td = $row['Transaction_Date'];
$ten = $row['Rate'];
$du = $row['Duration'];
$us = $row['User'];
?>
<section class="content">
<div class="row">
<div class="col-12 col-sm-12 col-md-3">
<div class="text-center">
<img class="profile-user-img img-fluid img-circle" src="<?php echo $loc; ?>"  style="height:150px; width:150px; border-radius:20px">
</div>
<h4 class="profile-username text-center"><?php echo $na; ?></h4>
<p class="text-muted text-center"><?php echo $un; ?> Member</p>
<ul class="list-group list-group-unbordered mb-3" style="font-size:11px">
<li class="list-group-item">
<b>PHONE NO</b> <a style="float:right;"><?php echo $ph; ?></a>
</li>
<li class="list-group-item">
<b>LOAN ACCT</b> <a style="float:right;"><?php echo $ln; ?></a>
</li>
<li class="list-group-item">
<b>TOTAL LOAN PROFILE</b> <a style="float:right;"> 
<?php
include '../config/db.php';
$sql="SELECT count(*) AS sar FROM register  WHERE BVN = '$bv' AND Status = 'Disbursed'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$coun = $data['sar'];
echo $coun; 
?>
</a>
</li>
</ul>
<div class="row">
<div class="col-sm-6" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $idd; ?>" name="repid" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $reg_id; ?>" name="reg_id" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $el_id; ?>" name="id" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $rq_type; ?>" name="typ" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $tr; ?>" name="tr" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $res; ?>" name="re" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $send; ?>" name="snd" required="required">
<button class="btn btn-outline-success btn-block btn-sm w-100" onclick="data()" >Approve</button>
</form>
</div>
<div class="col-sm-6" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="uploads">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $reg_id; ?>" name="regid" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $el_id; ?>" name="id" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $rq_type; ?>" name="typ" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $tr; ?>" name="tr" required="required">
<button class="btn btn-outline-danger btn-block btn-sm w-100" onclick="data()" >Decline</button>
</form>
</div>
</div>
</div>
<div class="col-12 col-sm-12 col-md-9" style="font-size:12px;">
<div >
<div >

</div><!-- /.card-header -->
<div>

<div class="tab-content">
<div class="active tab-pane" id="activity">
<div class="row">
<div class="col-sm-3">
<b>Request Sent By: [ <?php echo $send; ?> ]</b>
</div>
<div class="col-sm-3">
<b>Date Sent: [ <?php echo $drt; ?> ]</b>
</div>
<div class="col-sm-3">
<b>Date Disbursed: [ <?php echo $dd; ?> ]</b>
</div>
</div>
<br>
<br>
<br>
<br>

<div class="row">
<div class="col-12 col-sm-12 col-md-6">
<div >
<div >
<div class="card border-primary border border-dashed">
<br>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6" >
<small style="font-size:12px;"><b>LOAN ACCT:</b> <?php echo $ln; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:12px;"><b>PRINCIPAL AMT:</b> <?php echo number_format($la,2); ?></small>
</div>
</div>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6">
<small><b>INTEREST AMT:</b> <?php echo number_format($int,2); ?></small>
</div>
<div class="col-sm-6">
<small><b>LOAN AMT:</b> <?php echo number_format($la + $int,2); ?></small>
</div>
</div>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6">
<small><b>AMT PAID:</b> <?php echo number_format($pd,2); ?></small>
</div>
<div class="col-sm-6">
<small><b>BALANCE:</b> <?php echo number_format($tb,2); ?></small>
</div>
</div>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6">
<small><b>OVERDUE:</b> 0</small>
</div>
<div class="col-sm-6">
<small><b>EXPT AMOUNT:</b> <?php echo number_format($er,2); ?></small>
</div>
</div>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-12">
<small><b>LAST AMT PAID: </b><?php echo number_format($lamt,2); ?></small>
</div>
</div>
<br>
</div>

</div>
</div>

</div>
<div class="col-12 col-sm-12 col-md-6">
<div >
<div>
<div class="card border-primary border border-dashed">
<br>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6">
<small><b>GROUP NAME:</b> <?php echo $un; ?></small>
</div>
<div class="col-sm-6">
<small><b>BRANCH:</b> <?php echo $br; ?></small>
</div>
</div>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6">
<small><b>PRODUCT:</b> <?php echo $pr; ?></small>
</div>
<div class="col-sm-6">
<small><b>FREQUENCY: </b><?php echo $fr; ?></small>
</div>
</div>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6">
<small><b>RATE:</b> <?php echo $ten; ?>%</small>
</div>
<div class="col-sm-6">
<small><b>DURATION:</b> <?php echo $du; ?></small>
</div>
</div>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6">
<small><b>LOAN OFFICER:</b> <?php echo $of; ?></small>
</div>
<div class="col-sm-6">
<small><b>TEAM LEADER:</b> <?php echo $tn; ?></small>
</div>
</div>
<div class="row" style="font-size:12px; margin-left:8px">
<div class="col-sm-6">
<small><b>STATUS:</b> <?php echo $st; ?></small>
</div>
</div>
<br>
</div>
</div>
</div>
</div>

</div>
<div id="myDIV" style="display:none">
<div class="table-responsive">
<a href="dno.php?ln=<?php echo $ln; ?>&&us=<?php echo $us; ?>">
<button class="btn btn-outline-success btn-sm">Download Excel</button>
</a>
<br><br>
<table id='example2' class="table table-sm table table-bordered" style="font-size:8px">
<thead>
<tr>
<th>LOAN ACCOUNT</th>
<th>CLIENT NAME</th>
<th>GROUP</th>
<th>PRODUCT</th>
<th>PRINCIPAL AMT</th>
<th>INTEREST AMT</th>
<th>AMOUNT PAID</th>
<th>EXPECTED AMT</th>
<th>DATE PAID</th>
</tr>
</thead>
<?php 
include 'db.php';
//Get Transactions Details
$Query = "SELECT * FROM history WHERE Loan_Account_No='$ln' AND User = '$us' AND Status='Paid' ORDER BY id DESC LIMIT 10";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$fn = $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname'];
$lon = $rows['Loan_Account_No'];
$uns = $rows['Unions'];
$pr = $rows['Loan_Type'];
$la = $rows['Loan_Amount'];
$am = $rows['Amount'];
$int = $rows['Interest_Amt'];
$exp = $rows['Expected_Amount'];
$dp = $rows['Date_Paid'];


?>
<tr>
<td><?php echo $ln; ?></td>
<td><?php echo $fn; ?></td>
<td><?php echo $uns; ?></td>
<td><?php echo $pr; ?></td>
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int,2); ?></td>
<td><?php echo number_format($am,2); ?></td>
<td><?php echo number_format($exp,2); ?></td>
<td><?php echo $dp; ?></td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo" <small>No History Record Found  </small> ";       
}
?>
</tr>
</table>
</div>
</div>

<div id="my" style="display:none">
<div class="table-responsive">
<table id='example2' class="table table-sm table table-bordered" style="font-size:8px">
<thead>
<tr>
<th>REG ID</th>
<th>LOAN AMOUNT</th>
<th>INTEREST AMT</th>
<th>EXPECTED AMT</th>
<th>AMOUNT PAID</th>
<th>STATUS</th>
<th>DATE EXPECTED</th>
<th>DATE PAID</th>
</tr>
</thead>
<?php 
include 'db.php';
//Get Transactions Details
$Query = "SELECT * FROM schedule WHERE Loan_Account_No='$ln' AND User = '$us'";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id = $rows['Regs_id'];
$la = $rows['Loan_Amount'];
$am = $rows['Amount_Paid'];
$int = $rows['Interest'];
$exp = $rows['Expecting_Amount'];
$ed = $rows['Expected_Date'];
$dp = $rows['Date_Paid'];
$ps = $rows['Payment_Status'];


?>
<tr>
<td><?php echo $cl_id; ?></td>
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int,2); ?></td>
<td><?php echo number_format($exp,2); ?></td>
<td><?php
if(empty($am)){
  echo '0.00';
  }else{
  echo number_format($am,2);
  }; ?></td>
<td><?php 
  if($am == 0){
  echo "<small style='color:red'>No Payment Yet</small>";
  }else{
  echo "<small style='color:green'>Paid</small>";
  }
 ?></td>
<td><?php echo $ed; ?></td>
<td><?php echo $dp; ?></td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo"<small> No Repayment Schedule Record Found  </small> ";       
}
?>
</tr>
</table>
</div>
</div>
<br>
<br>
<br>
<span>REASON FOR CLOSURE: <small style="color:red">[ <?php echo $res; ?> ] </small></span>
<hr>
</div>
</div>
</div>
</div>

</section>
<div class="modal" id="please" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-sm">
<div class="modal-content">
<div class="modal-body">
<center>
<i>
<img src="loader.gif" style="height:20px"> Approving Request ! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>
<div class="modal" id="dece" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-sm">
<div class="modal-content">
<div class="modal-body">
<center>
<i>
<img src="loader.gif" style="height:20px"> Declining Request ! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>
<script src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "Are you sure you want to approve this request.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModals").modal('hide');
$("#please").show();
$.ajax({
url: "approve_write_off.php",
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
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert("" + data)
}
},
error: function(){
}
});
}
}));
});
</script>

<script src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function (e){
$("#uploads").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "Are you sure you want to decline this request.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModals").modal('hide');
$("#please").show();
$.ajax({
url: "writeoff_decline.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").css("display", "block");
$("#toasts").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
$("#please").hide();
alert("" + data)
}
},
error: function(){
}
});
}
}));
});
</script>
