<?php 
$d = date('Y-m-d');
include '../config/db.php';
$id = $_GET['id'];
$Query = "SELECT * FROM withdraw WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];
$sv = $row['Saving_Account_No'];
$lon = $row['Loan_Account_No'];
$st = $row['Status'];
$br = $row['Branch'];
$un = $row['Unions'];
$ofn = $row['Officer_Name'];
$amt = $row['Amount_Withdraw'];
$dr = $row['Date_Withdraw'];
$st = $row['Status'];
$tr = $row['Transaction_id'];
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$lon'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pic = $row['Location'];
$pd = $row['Paid'];
$tb = $row['Total_Bal'];
$to = $row['Total_Loan'];
$ful = $row['Firstname']." ". $row['Middlename']. " ". $row['Lastname'];
$Query = "SELECT * FROM savings WHERE Loan_Account_No = '$lon'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$bl = $row['Balance'];

?>

<div class="text-center">
<img class="profile-user-img img-fluid img-circle" src="<?php echo $pic; ?>" alt="User profile picture" style="height:100px; width:100px; border-radius:14px">
</div>
<br>
<h6 class="profile-username text-center"><?php echo $ful; ?></h6>
<br>
<center>
<div class="btn-group">
<?php 
if($st == 'Waiting For Approval'){
?>
<button class="btn btn-outline-success btn-sm btn-block"  disabled="disabled">Approve Request</button>
<?php 
}else{
?>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<input type="text" hidden class="form-control form-control-sm" placeholder="Account Name" name="id" value="<?php echo $id; ?>" required="required">
<?php 
if($amt <= $bl){
?>
<button class="btn btn-outline-success btn-sm btn-block"  onclick="data()">Approve Request</button>
<?php
}else{
?>
<button class="btn btn-outline-success btn-sm btn-block"  disabled onclick="data()">Insufficient Balance</button>
<?php
}
?>
</form>
<?php 
}
?>
<form action="" method="POST" enctype="multipart/form-data" id="upload">
<input type="text" hidden class="form-control form-control-sm" placeholder="Account Name" name="id" value="<?php echo $id; ?>" required="required">
<button class="btn btn-outline-danger btn-sm btn-block"  onclick="data()">Decline Request</button>
</form>
</div>
</center>
<div class="row" style="font-size:10px">
<div class="col-12 col-sm-12 col-md-6">
<div class="card">
<div class="card-body">
<b><i class="fa fa-star"></i> Withdrawal Info</b>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Savings Account: </b><?php echo $sv; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Branch:</b> <?php echo $br; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Group:</b> <?php echo $un; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Initiated By:</b> <?php echo $ofn; ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left: 8px;">Balance:</b> <?php echo number_format($bl,2); ?>
</div>
</div>
<br>
</div>
</div>
</div>
</div>

<div class="col-12 col-sm-12 col-md-6">
<br>
<div class="card">
<div class="card-body">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Amount To Withdraw:</b> <?php echo number_format($amt,2); ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Date Requested: </b><?php echo $dr; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Transaction id:</b> <?php echo $tr; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Status:</b> <?php echo $st; ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left: 8px;">Initiated By:</b> <?php echo $ofn; ?>
</div>
</div>
<br>
</div>
</div>
</div>

</div>
</div>
<hr>
<div id="myDIV" style="display:none">
<div class="row" style="font-size:12px">
<div class="col-sm-4">
<div class="card" >
<div class="card-body">
<b>Loan Amount:</b> <?php echo number_format($to,2); ?>
</div>
</div>
</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<b>Amount Paid:</b> <?php echo number_format($pd,2); ?>
</div>
</div>
</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<b>Outstanding:</b> <?php echo number_format($tb,2); ?>
</div>
</div>
</div>







<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to approve this request.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModals").modal('hide');
$("#please").show();
$.ajax({
url: "team_lead_withdraw_approve.php",
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
alert ("🚫" + data)
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
$("#upload").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to decline this request.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModals").modal('hide');
$("#please").show();
$.ajax({
url: "team_lead_withdraw_decline.php",
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
alert ("🚫" + data)
}
},
error: function(){
}
});
}
}));
});
</script>

