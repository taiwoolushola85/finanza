<?php 
$d = date('Y-m-d');
include '../config/db.php';
$id = $_GET['id'];
$type = "Flexi";
//get request details
$Query = "SELECT * FROM flexi_withdraw WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];
$flexid = $row['Flexi_id'];
$acct = $row['Flexi_Accounts'];
//
$Query = "SELECT * FROM flexi_reg WHERE id = '$flexid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
//get saving balance
//
$sql = "SELECT COALESCE(SUM(Amount), 0) AS lm FROM flexi_history WHERE Flexi_Account = '$acct' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$flex = mysqli_fetch_assoc($result);
$pm = $flex['lm'];
//
$sql = "SELECT COALESCE(SUM(Amount), 0) AS lm FROM flexi_withdraw WHERE Flexi_Accounts = '$acct' AND Status = 'Paid'";
$result=mysqli_query($con,$sql);
$fles = mysqli_fetch_assoc($result);
$pmt = $fles['lm'];

$tot = $pm - $pmt;


?>
<div class="text-center">
<img class="profile-user-img img-fluid img-circle" src="<?php echo $rows['Location']; ?>" alt="User profile picture" style="width:100px; height:100px; border-radius:14px">
</div>
<br>
<center>
<h6 class="profile-username text-center"><?php echo $row['Name']; ?></h6>
<br>
<div class="btn-group">
<?php 
if($row['Status'] == 'Waiting For Approval'){
?>
<button class="btn btn-light btn-sm" disabled="disabled"><i class="fa fa-check"></i> Approve Request</button>
<?php 
}else{
?>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<input type="text" hidden class="form-control form-control-sm" placeholder="Account Name" name="id" value="<?php echo $id; ?>" required="required">
<?php 
if($row['Amount'] <= $tot){
?>
<button class="btn btn-light btn-sm"><i class="fa fa-check"></i> Approve Request</button>
<?php
}else{
?>
<button class="btn btn-light btn-sm" disabled="disabled"><i class="fa fa-check"></i> Insufficient Balance</button>
<?php
}
?>
</form>
<?php 
}
?>
<form action="" method="POST" enctype="multipart/form-data" id="reDecline">
<input type="text" hidden class="form-control form-control-sm" placeholder="Account Name" name="id" value="<?php echo $id; ?>" required="required">
<button type="submit" class="btn btn-light btn-sm" onclick="updateDoc()"><i class="fa fa-trash"></i> Decline Request</button>
</form>
</div>
</center>

<br>
<div class="row" style="font-size:12px">
<div class="col-12 col-sm-12 col-md-6">
<b><i class="fa fa-star"></i> Sender Info</b><br>
<div class="card">
<div class="card-body">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Flexi Account No:</b> <?php echo $row['Flexi_Accounts']; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Request ID:</b> <?php echo $row['id']; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Gender:</b> <?php echo $rows['Gender']; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">BVN:</b> <?php echo $rows['Client_BVN']; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Branch:</b> <?php echo $rows['Branch']; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Status:</b> <i style="color:red"><?php echo $row['Status']; ?></i>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left: 8px;">Balance:</b> <?php echo number_format($tot,2); ?>
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
<b style="margin-left: 8px;">Product:</b> <?php echo $rows['Plan']; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Frequecy:</b> <?php echo $rows['Frequency']; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Duration:</b> <?php echo $rows['Duration']; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Rate:</b> 0 %
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Initiated By:</b> <?php echo $rows['Officer_Name']; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Date Initiated:</b> <?php echo $row['Date_Withdraw']; ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left: 8px;">Amount To Withdraw:</b> <?php echo number_format($row['Amount'],2); ?>
</div>
</div>
<br>
</div>
</div>


</div>
</div>
</div>

<div id="myDIV" style="display:block">
<div class="row" style="font-size:12px">
<b><i class="fa fa-star"></i> Bank Info</b><br>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="card border-primary border border-dashed">
<br>
<b style="margin-left: 8px;">Acct Name: <?php echo $row['Account_Name']; ?></b> 
<br>
</div>
</div>
</div>
</div>

<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="card border-primary border border-dashed">
<br>
<b style="margin-left: 8px;">Account No: <?php echo $row['Account_No']; ?></b> 
<br>
</div>
</div>
</div>
</div>

<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="card border-primary border border-dashed">
<br>
<b style="margin-left: 8px;">Bank: <?php echo $row['Bank'];; ?></b> 
<br>
</div>
</div>
</div>
</div>
</div>




<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to approve this request.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "team_lead_flexi_approval.php",
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
alert ("🚫 " +  data)
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
$("#reDecline").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to decline this request.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "team_lead_flexi_decline.php",
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
alert ("🚫" + data )
}
},
error: function(){
}
});
}
}));
});
</script>


