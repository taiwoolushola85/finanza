<?php 
include '../config/db.php';
include '../config/user_session.php';
$bvn = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", " "), '', $_POST['bvn']);// bvn number
$d = date('Y-m-d');
//
$d = date('Y-m-d');
$Query = "SELECT * FROM register WHERE BVN = '$bvn' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$register_id = $rows['id'];
$bvn_no = $rows['BVN'];
//
$Query = "SELECT * FROM repayments WHERE BVN = '$bvn'";
$result = mysqli_query($con, $Query);
$rowk = mysqli_num_rows($result);
if($rowk == 0){
echo "<i style='color:red'>Customer bvn does not have an exist record in our database to proceed for this application. please try new customer registration</i>";
}else{
//
$Query = "SELECT * FROM repayments WHERE BVN = '$bvn_no' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$loc = $row['Location'];
$bv = $row['BVN'];
$uzer = $row['User'];
$ofn = $row['Officer_Name'];
$loan_status = $row['Status'];
if($loan_status == 'Closed' && $uzer == $User){
    

?>




<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div style="margin: auto; width:250px">
<label style="font-size:13px"><i style="color:red">*</i> Fee Type</label>
<input type="number" class="form-control form-control-md" name="id" value="<?php echo $register_id ; ?>" hidden required="required">
<select type="text" class="form-control form-control-md" name="type" required="required">
<option value="">Select Option</option>
<option value="Deduction">Deduction</option>
<option value="Upfront Payment">Upfront Payment</option>
</select>
</div>
<br>
<b>Loan Product Information</b><br><br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Loan Products</label>
<select type="text" class="form-control form-control-md" name="pr" id="pr" oninput="getProduct()" required="required">
<option value="">Select Loan Product</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Product_Name FROM product WHERE Status = 'Activated' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Product_Name'];// product
?>
<option value="<?php echo $pp; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Tenure</label>
<select type="text" class="form-control form-control-md" name="ten" id="hey"required="required">
<option value="">Select Option</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Principal Amount</label>
<input type="number" class="form-control form-control-md" name="lum"  placeholder="Principal Amount" required="required">
</div>
</div>
<hr>
<b>Bank Details</b><br><br>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Bank Name</label>
<input type="text" class="form-control form-control-md" placeholder="Bank Name" name="bn" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Account No</label>
<input type="number" class="form-control form-control-md" placeholder="Account No" name="an" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Account Name</label>
<input type="text" class="form-control form-control-md" placeholder="Account Name" name="ann" required="required">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" id="submit" style="float:right; "><i class="fa fa-plus"></i> Create Loan</button>
</form>


<?php 
}else if($loan_status == 'Active'){
echo "<i style='color:red'>Customer still has a runing loan, please check your active account.</i>";
}else if($loan_status == 'Ready For Auditing'){
echo "<i style='color:red'>Customer previous loan record is waiting for clearance from your zone auditor. please contact your auditor for clearance....</i>";
}else if($loan_status == ''){
echo "<i style='color:red'>Customer bvn does not have an exist record in our database to proceed for this application. please try new customer registration</i>";
}else if($uzer != $User){
echo "<i style='color:red'>Client record show's that the client belong to Account Officer: $ofn.</i>"."<br/>";
}else{
echo "<i style='color:red'>Unkown error occured. please contact IT</i>";
}
}
?>






<script type="text/javascript">
function getProduct()  {
var pr = document.getElementById("pr").value;
// ajax function start here
$.ajax({
method: "POST",
url: "load_tenure.php",
dataType: "html",  
data: {'pr': pr},
success:function(data){
setTimeout(function(){
$("#hey").html(data);
}, 100);
}
});
// ajax function ends here
}
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to create a loan profile ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "create_loan_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#uploadForm")[0].reset();
if(data == 1){
alert("🚫 Please fill all required fields before creating loan profile.!");
$("#please").hide();
$("#updateModal").modal('show');
}else if(data == 2){
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

