<div class="card" style="margin-top:10px;">
<div class="card-body">
<?php
include '../config/db.php';
$id = $_GET['id'];
$Query = "SELECT * FROM register WHERE id = '$id' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$reg = $row['id'];
$ad = $row['Address'];
$ph = $row['Phone'];
$bv = $row['BVN'];
$un = $row['Unions'];
$pr = $row['Product'];
$du = $row['Tenure'];
$fr = $row['Frequency'];
$rt = $row['Rate'];
$br = $row['Branch'];
$ofn = $row['Officer_Name'];
$tm = $row['Team_Name'];
$loc = $row['Location'];
$status = $row['Status'];
$na = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
?>
<br>
<center>
<img src="<?php echo $loc; ?>" style="height:100px" class="img-fluid rounded-pill" loading="lazy">
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
<small style="margin-left: 8px;"><b>REG ID:</b> <?php echo $reg; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>PHONE:</b> <?php echo $ph; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>BVN NO:</b> <?php echo $bv; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="margin-left: 8px;"><b>AADRESS:</b> <?php echo $ad; ?></small>
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
<small style="margin-left: 8px;"><b>PRODUCT:</b> <?php echo $pr; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>DURATION:</b> <?php echo $du; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>FREQUENCY:</b> <?php echo $fr; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>RATE:</b> <?php echo $rt; ?>%</small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>GROUP:</b> <i><?php echo $un; ?></i></small>
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
<small style="margin-left: 8px;"><b>NAME:</b> <?php echo $ofn; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>BRANCH:</b> <?php echo $br; ?></small>
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
<small style="margin-left: 8px;"><b>NAME:</b> <?php echo $tm; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left: 8px;"><b>BRANCH:</b> <?php echo $br; ?></small>
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
echo "<small style='color:red'>Client Application can not be  transfer</small>";
}
?>




<?php
}else{
//echo 1;
echo "<b style='color:red; font-size:12px'>User Application not found..</b>";
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
<input type="text" class="form-control form-control-sm" value="<?php echo $id; ?>" hidden name="id" required >
<select type="text" class="form-control form-control-sm" name="usid" id="usid" required="required" oninput="getGroup()"><br>
<option value="">Select Credit Officer</option>
<?php 
include '../config/db.php';
$Query = "SELECT  * FROM users WHERE  Status = 'Activate' AND User_Group = 'Loan Officers' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bids= $rows['id'];
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
<select type="text" class="form-control form-control-sm" name="gr" id="hey" required="required"><br>
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




<script type="text/javascript">
function getGroup()  {
var usid = document.getElementById("usid").value;// user id
// ajax function start here
$.ajax({
method: "POST",
url: "get_group.php",
dataType: "html",  
data: {
'usid': usid
},
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
$("#uploadApp").on('submit',(function(e){ e.preventDefault();
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "application_transfer.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if (data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
$("#mydiv").load("check_client.php?id=<?php echo $id; ?>" + " #mydiv");
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
