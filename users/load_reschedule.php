<?php 
include '../config/db.php';
$lon = $_GET['lon'];// loan account no
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$lon' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row == 0){
?>
<div class="card">
<div class="card-body">
<?php
echo "<i>🚫 Record Not Found..!!</i>";
exit();
?>
</div>
</div>
<?php
}else{
?>


<?php
include '../config/db.php';
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$lon' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$repid = $rows['id'];
$paid = $rows['Paid'];
$nam = $rows['Firstname']." ".$rows['Lastname'];
?>




<div class="row">
<div class="col-sm-4">
<div class="d-flex flex-column align-items-center text-center">
<img src="<?php echo $rows['Location']; ?>" class="rounded-circle" width="130" height="130px">
<div class="mt-3">
<h4><b style="text-transform:capitalize"><?php echo $nam; ?></b></h4>
</div>
</div>

<br>
<div class="row">
<div class="col-sm-6">
<span>Loan Acct : <?php echo $rows['Loan_Account_No']; ?></span>
</div>
<div class="col-sm-6">
<span>Saving Acct : <?php echo $rows['Savings_Account_No']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span>BVN : <?php echo $rows['BVN']; ?></span>
</div>
<div class="col-sm-6">
<span>Rep ID : <?php echo $rows['id']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span>Principal Amt : <?php echo number_format($rows['Loan_Amount'],2); ?></span>
</div>
<div class="col-sm-6">
<span>Expected Amt : <?php echo number_format($rows['Expected_Amount'],2); ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span>Paid Amt : <?php echo number_format($rows['Paid'],2); ?></span>
</div>
<div class="col-sm-6">
<span>Outstanding : <?php echo number_format($rows['Total_Bal'],2); ?></span>
</div>
</div>
</div>

<div class="col-sm-8">

<b>
<svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="currentColor"></path>
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z" fill="currentColor"></path>
</svg>    
Reschedule Form</b><hr>
<div class="row">
<div class="col-sm-4">
<span>Current Principal Amt: <?php echo number_format($rows['Loan_Amount'],2); ?></span>
</div>
<div class="col-sm-4">
<span>Current Product: <?php echo $rows['Product']; ?></span>
</div>
<div class="col-sm-4">
<span>Current Interest Rate: <?php echo $rows['Rate']; ?>%</span>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-6">
<span>Virtual Account No</span>
<input type="text" disabled class="form-control form-control" required value="<?php echo $rows['Account_Number']; ?>">
</div>
<div class="col-sm-6">
<span>Current Balance</span>
<input type="text" disabled class="form-control form-control" required value="<?php echo $rows['Total_Bal']; ?>">
</div>
</div>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadFm">
<div class="row">
<div class="col-sm-3">
<span>New Principal Amt</span>
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $repid; ?>" name="repid" required="required">
<input type="text" class="form-control form-control-sm" hidden  value="<?php echo $paid; ?>" name="pd" required="required">
<input type="text" name="amt" hidden class="form-control form-control" value="<?php echo $rows['Total_Bal']; ?>" required placeholder="Enter Principal Loan Amount">
<input type="text" disabled class="form-control form-control" value="<?php echo $rows['Total_Bal']; ?>" required placeholder="Enter Principal Loan Amount">
</div>
<div class="col-sm-3">
<span>New Product</span>
<select type="text" name="pr" class="form-control form-control" required>
<option value="">Select Loan Product</option>
<?php 
include '../config/db.php';
$Query = "SELECT * FROM product WHERE Status = 'Activated' ORDER BY Product_Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Product_Name'];
?>
<option value="<?php echo $pp; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-3">
<label style="font-size:13px"><i style="color:red">*</i> Duration</label>
<input type="text" class="form-control form-control-md" name="ten" placeholder="Enter New Loan Duration" required="required">
</div>
<div class="col-sm-3">
<span>New Interest Rate [%]</span>
<input type="text" name="int" class="form-control form-control" required placeholder="Enter New Interest Rate">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-primary btn-sm">Proceed</button>
</form>
</div>
</div>


<?php
}
?>





<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "load_reschedule.php?lon=<?php echo $lon; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 

<script type="text/javascript">
$(document).ready(function (e){
$("#uploadFm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to send this request for approval..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "reschedule_request.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){ 
$("#please").show(); 
if (data == 1){
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
$("#uploadFm")[0].reset();
} else {
$("#please").hide();
alert ("🚫 " + data)
$("#uploadFm")[0].reset();
}
},
error: function(){
}
});
}
}));
});
</script>
