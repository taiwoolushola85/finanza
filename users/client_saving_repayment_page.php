<?php 
$d = date('Y-m-d');
include '../config/db.php';
$id = $_GET['id'];
$types = "Repayment";
$Query = "SELECT * FROM saving_rep WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];
$reg_id = $row['Reg_id'];
$st = $row['Status'];
$amt = $row['Amount'];
$ds = $row['Date_Sent'];
$lan = $row['Loan_Account_No'];
$rlan = $row['Reciever_Transaction_id'];
$reclo = $row['Reciever_Loan_No'];
$sv = $row['Saving_Account_No'];
$ofn = $row['Officer_Name'];
$ful = $row['Firstname']." ". $row['Middlename']. " ". $row['Lastname'];
//
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$reclo' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pmp = $row['Firstname']." ". $row['Middlename']. " ". $row['Lastname'];
$total_bal = $row['Total_Bal'];
//
$Query = "SELECT * FROM savings WHERE Savings_Account_No = '$sv'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$savv = $row['Savings_Paid'];
$bal_savv = round($row['Balance']);


$Query = "SELECT * FROM register WHERE id = '$reg_id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$pic = $row['Location'];
$la = $row['Total_Loan'];
$gr = $row['Unions'];
$ph = $row['Phone'];
$em = $row['Education'];
$gn = $row['Gender'];
$bnk = $row['Bank'];
$ac = $row['Account_Name'];
$ann = $row['Account_No'];
$bv = $row['BVN'];
$br = $row['Branch'];
$pr = $row['Product'];
$fr = $row['Tenure'];
$rt = $row['Rate'];
$du = $row['Frequency'];
$int = $row['Interest_Amt'];
$rp = $row['Repayment_Amt'];
$dc = $row['Date_Reg'];
$stt = $row['Status'];
?>
<div class="text-center">
<img class="profile-user-img img-fluid img-circle" src="<?php echo $pic; ?>" alt="User profile picture" style="width:100px; height:100px; border-radius:14px">
</div>
<br>
<center>
<h6 class="profile-username text-center"><?php echo $ful; ?></h6>
<br>
<div class="btn-group">
<?php 
if($st == 'Waiting For Approval'){
?>
<button class="btn btn-light btn-sm" disabled="disabled"><i class="fa fa-check"></i> Approve Request</button>
<?php 
}else{
?>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<input type="text" hidden class="form-control form-control-sm" placeholder="Account Name" name="id" value="<?php echo $id; ?>" required="required">
<?php 
if($amt <= $bal_savv){
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
<b style="margin-left: 8px;">Loan Account No:</b> <?php echo $lan; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Saving Account:</b> <?php echo $sv; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Gender:</b> <?php echo $gn; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Group:</b> <?php echo $gr; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Branch:</b> <?php echo $br; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Status:</b> <i style="color:red"><?php echo $st; ?></i>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left: 8px;">Balance:</b> <?php echo number_format($bal_savv,2); ?>
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
<b style="margin-left: 8px;">Product:</b> <?php echo $pr; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Frequecy:</b> <?php echo $fr; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Duration:</b> <?php echo $du; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Rate:</b> <?php echo $rt; ?>%
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left: 8px;">Initiated By:</b> <?php echo $ofn; ?>
</div>
<div class="col-sm-6">
<b style="margin-left: 8px;">Date Initiated:</b> <?php echo $ds; ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left: 8px;">Amount:</b> <?php echo number_format($amt,2); ?>
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
<b><i class="fa fa-star"></i> Reciever Info</b><br>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<div class="card border-primary border border-dashed">
<br>
<b style="margin-left: 8px;">Acct Name: <?php echo $pmp; ?></b> 
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
<b style="margin-left: 8px;">Reciever Loan Acct: <?php echo $reclo; ?></b> 
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
<b style="margin-left: 8px;">Loan Acct Outstanding: <?php echo number_format($total_bal,2); ?></b> 
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
url: "team_lead_saving_repayment_approval.php",
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
url: "team_lead_saving_repayment_delecine.php",
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


