<div style="margin-top:10px;">
<div >
<?php
include '../config/db.php';
$loan = $_GET['id'];// loan account
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$loan'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$repid = $row['id'];
$status = $row['Status'];
$vrt = $row['Account_Number'];
$loanacct = $row['Loan_Account_No'];
$reg = $row['Reg_id'];
$na = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
//
if($status == 'Active'){
?>
<br>
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
<img src="<?= htmlspecialchars($imgPath) ?>" style="height:150px; width:150px; border-radius:100px;" onerror="this.src='../assets/no-image.png';">
<br>
</center>
<br>
<div id="mydiv">
<div class="row">
<div class="col-sm-6">
<b><i class="fa fa-star"></i> Client Details</b>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>NAME:</b> <?php echo $na; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>REG ID:</b> <?php echo $row['Reg_id']; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>PHONE:</b> <?php echo $row['Phone']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>BVN NO:</b> <?php echo $row['BVN']; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="margin-left: 8px;"><b>LOAN ACCOUNT:</b> <?php echo $row['Loan_Account_No']; ?></small>
</div>
</div>
<br>
</div>
</div>

<div class="col-sm-6">
<b><i class="fa fa-star"></i> Product Details</b>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>PRODUCT:</b> <?php echo $row['Product']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>DURATION:</b> <?php echo $row['Tenure']; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>FREQUENCY:</b> <?php echo $row['Frequency']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>RATE:</b> <?php echo $row['Frequency']; ?>%</small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>GROUP:</b> <i><?php echo $row['Unions']; ?></i></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>STATUS:</b> <i style="color:red"><?php echo $status; ?></i></small>
</div>
</div>
<br>
</div>
</div>


</div>
<div class="row">
<div class="col-sm-6">
<b><i class="fa fa-star"></i> Loan Officer Details</b>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>NAME:</b> <?php echo $row['Officer_Name']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>BRANCH:</b> <?php echo $row['Branch']; ?></small>
</div>
</div>
<br>
</div>
</div>

<div class="col-sm-6">
<b><i class="fa fa-star"></i> Team Leader Details</b>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>NAME:</b> <?php echo $row['Team_Name']; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>BRANCH:</b> <?php echo $row['Branch']; ?></small>
</div>
</div>
<br>
</div>
</div>
</div>
</div>

<?php 
if($status != "Disbursed"){
?>
<button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal" id="tra"> Proceed</button>
<?php 
}else{
echo "<small style='color:red'>Client can not be transfer</small>";
}
?>




<?php
}else{
//echo 1;
echo "<b style='color:red; font-size:12px'>Client loan account is closed.! Please use an active loan account to proceed...</b>";
}
mysqli_close($con);
?>
</div>
</div>




<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm" style="display:none; width:400px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" style="font-size:12px; text-transform:uppercase"> Select Credit Officer</h6>
<button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form action="" method="POST" enctype="multipart/form-data" id="uploadApp">
<div class="row">
<div class="col-sm-6">
<input type="text" class="form-control form-control-sm" value="<?php echo $repid; ?>" hidden name="id" required >
<input type="text" class="form-control form-control-sm" value="<?php echo $loanacct; ?>" hidden name="la" required >
<input type="text" class="form-control form-control-sm" value="<?php echo $reg; ?>" hidden name="reg" required >
<input type="text" class="form-control form-control-sm" value="<?php echo $vrt; ?>" hidden name="vrt" required >
<select type="text" class="form-control form-control-sm" name="us" id="us" required="required" oninput="getGroup()"><br>
<option value="">Select Credit Officer</option>
<?php 
include '../config/db.php';
$Query = "SELECT Username, Name FROM users WHERE User_Group = 'Loan Officers' ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bids= $rows['Username'];
$name= $rows['Name'];
?>
<option value="<?php echo $bids; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-6">
<select type="text" class="form-control form-control-sm" name="gr" id="heys" required="required"><br>
<option value="">Select Group</option>
</select>
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm"> Transfer</button>
</form>
</div>
</div>
</div>
</div>

<br>
<br>


<script type="text/javascript">
function getGroup()  {
var us = document.getElementById("us").value;// user id
// ajax function start here
$.ajax({
method: "POST",
url: "get_client_group.php",
dataType: "html",  
data: {
'us': us
},
success:function(data){
setTimeout(function(){
$("#heys").html(data);
}, 100);
}
});
// ajax function ends here
}
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadApp").on('submit',(function(e){ e.preventDefault();
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "client_transfer_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if (data == 1){
alert ("🚫 Invalid loan acccount no.! Please check..") 
$("#please").hide();
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
$("#mydiv").load("check_client_info.php?id=<?php echo $id; ?>" + " #mydiv");
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
} else {
alert ("🚫 Error" + data)
$("#please").hide();
}
},
error: function(){
}
});
}));
});
</script>
