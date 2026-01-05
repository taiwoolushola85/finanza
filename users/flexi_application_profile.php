
<?php 
include '../config/db.php';
$id = mysqli_real_escape_string($con, $_GET['id']);
$Query = "SELECT * FROM flexi_reg WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
//
$Query = "SELECT * FROM process_fee WHERE Flex_id = '$id'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
?>
<br>
<br>
<div>
<center>
<img src="<?php echo $row['Location']; ?>" height="100" width="100" style="border-radius:50px">
<br>
<br>
<div class="row">
<div class="col-sm-3">
<button class="btn btn-light btn-sm w-100" onclick="infoData()"><i class="fa fa-star"></i> Application Info</button>
</div>
<div class="col-sm-3">
<button class="btn btn-light btn-sm w-100" onclick="paymentData()"><i class="fa fa-eye"></i> Preview Payment</button>
</div>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<input type="text" hidden class="form-control form-control-sm" name="id" placeholder="id" required="required" value="<?php echo $id; ?>"> 
<input type="text" hidden class="form-control form-control-sm" name="deposit" placeholder="deposit" required="required" value="<?php echo $rows['Deposit']; ?>"> 
<input type="text" hidden class="form-control form-control-sm" name="reciept" placeholder="reciept" required="required" value="<?php echo $rows['Location']; ?>">  
<button type="submit" class="btn btn-light btn-sm w-100"><i class="fa fa-check"></i> Approve Application</button>
</form>
</div>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="uploadDec">
<input type="text" hidden class="form-control form-control-sm" name="id" placeholder="id" required="required" value="<?php echo $id; ?>">  
<button type="submit" class="btn btn-light btn-sm w-100"><i class="fa fa-exclamation-triangle"></i> Decline Application</button>
</form>
</div>
</div>
</center>
<br>
<div class="container">
<div id="info" style="display:block">
<div >
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<div >
<div >
<b>CLIENT INFO</b><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Surname:</b> <?php echo $row['Surname']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Othername:</b> <?php echo $row['Firstname']; ?> <?php echo $row['Othername']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Phone:</b> <?php echo $row['Phone']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>BVN:</b> <?php echo $row['Client_BVN']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Marital Status:</b> <?php echo $row['Marital_Status']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Bank:</b> <?php echo $row['Bank']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Account No:</b> <?php echo $row['Account_No']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Account Name:</b> <?php echo $row['Account_Name']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-12">
<small style="margin-left:8px;"><b>Addresss:</b> <?php echo $row['Address']; ?></small>
</div>
</div>
<br>

</div>
</div>
</div>

</div>
<div class="col-sm-6">
<div >
<div >
<b>OTHER INFO</b><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Saving Plan:</b> <?php echo $row['Plan']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Freqeuncy:</b> <?php echo $row['Frequency']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Interest:</b> <?php echo $row['Interest']; ?>%</small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Duration:</b> <?php echo $row['Duration']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>ID Type:</b> <?php echo $row['ID_Type']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>ID No:</b> <?php echo $row['ID_No']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Branch:</b> <?php echo $row['Branch']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Status:</b> <span style="color:orange"><?php echo $row['Status']; ?></span></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-12">
<small style="margin-left:8px;"><b>Business Address:</b> <?php echo $row['Biz_Address']; ?></small>
</div>
</div>
<br>



</div>
</div>
</div>

</div>
</div>
<br>

<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<div >
<div >
<b>NEXT OF KIN INFO</b><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Surname:</b> <?php echo $row['NOK_Surname']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Othername:</b> <?php echo $row['NOK_Firstname']; ?> <?php echo $row['NOK_Othername']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Relationship:</b> <?php echo $row['Relationship']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Phone No:</b> <?php echo $row['NOK_Phone']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-12">
<small style="margin-left:8px;"><b>Address:</b> <?php echo $row['NOK_Address']; ?></small>
</div>
</div>
<br>

</div>
</div>
</div>

</div>

<div class="col-sm-6">
<div >
<div >
<b>OTHER INFO</b><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Occupation:</b> <?php echo $row['Occupation']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Nationality:</b> <?php echo $row['Nationality']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Loan Officer:</b> <?php echo $row['Officer_Name']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Team Leader:</b> <?php echo $row['Team_Name']; ?></small>
</div>
</div>
<div class="row" style="text-transform: capitalize;">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Date Reg:</b> <?php echo $row['Date_Reg']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>Time Reg:</b> <?php echo $row['Time_Reg']; ?></small>
</div>
</div>
<br>

</div>
</div>

</div>
</div>
</div>
<br>



</div>

</div>

</div>

<div id="payment" style="display:none">
<div class="container">
<h6>Payment Preview</h6>
<div class="row">
<div class="col-sm-4">
Card Fee: <?php echo number_format($rows['Card'],2); ?>
</div>
<div class="col-sm-4">
Initail Deposit: <?php echo number_format($rows['Deposit'],2); ?>
</div>
<div class="col-sm-4">
Total Payment: <?php echo number_format($rows['Card'] + $rows['Deposit'],2); ?>
</div>
</div>
<br><br>
<center>
<p><img src="<?php echo $rows['Location']; ?>" id="reciept" style="height: 400px; width:350px; border-radius:5px;" class="img-thumbnail"  /></p>
</center>

</div>
</div>


<script>
//preview info
function infoData(){
var x = document.getElementById("info");
var y = document.getElementById("payment");
x.style.display = 'block';
y.style.display = 'none';
}
//preview payment
function paymentData(){
var x = document.getElementById("info");
var y = document.getElementById("payment");
y.style.display = 'block';
x.style.display = 'none';
}
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to approve the application";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "flexi_activation.php",
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
load();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert ("Error" + data)
}
},
error: function(){
}
});
};
}));
});
</script>





<script type="text/javascript">
$(document).ready(function (e){
$("#uploadDec").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to decline the application";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "flexi_decline.php",
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
load()
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
$("#please").hide();
alert ("Error" + data)
}
},
error: function(){
}
});
};
}));
});
</script>




