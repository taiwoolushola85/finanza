<?php 
$d = date('Y-m-d');
include '../config/db.php';
$grid = Intval($_GET['id']);
$Query = "SELECT id, Name, User, Team_Name, Status, Date_Register FROM groups WHERE id = '$grid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$nmm = $row['Name'];
$ur = $row['User'];
$tc = $row['Team_Name'];
$gst = $row['Status'];
$gd = $row['Date_Register'];
///
$Query = "SELECT id,Name,Location,Branch FROM users WHERE Username = '$ur'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$zid = $row['id'];
$znb = $row['Name'];
$ll = $row['Location'];
$xb = $row['Branch'];
?>

<br>
<center>
<img src="<?php echo $ll; ?>" style="height:100px; width:100px; border-radius:50px; margin-left:8px;">
<br><br>
<?php 
include '../config/db.php';
// getting the total number of groups
$sql="SELECT COUNT(*) AS total FROM repayments WHERE User = '$ur' AND Status = 'Active' AND Unions = '$nmm'";
$result=mysqli_query($con, $sql);
$rows=mysqli_fetch_assoc($result);
$cus_no = $rows['total'];
echo "Total Customer: ".$cus_no;
?>
<br><br>
<?php 
include '../config/db.php';
// getting the total number of groups
$sql="SELECT COUNT(*) AS total FROM repayments WHERE User = '$ur' AND Status = 'Active' AND Unions = '$nmm'";
$result=mysqli_query($con, $sql);
$rows=mysqli_fetch_assoc($result);
$cus_no = $rows['total'];
?>
<div class="row">
<div class="col-sm-12" style="margin-top:10px;">
<div style="overflow-x: auto;">
<div class="btn-group">
<button class="btn btn-light" onclick="groupProfile()">Group Profile</button>
<?php 
if($cus_no == '0'){
?>
<a class="grDel" href="#!" data-id="<?php echo htmlspecialchars($grid); ?>">
<button type="submit" class="btn btn-light">Delete Group</button>
</a>
<?php 
}else{
?>
<button hidden class="btn btn-light" >Delete Group</button>
<?php
}
?>
<button class="btn btn-light" onclick="groupTransfer()">Transfer Group</button>
</div>
</div>
<br>
</div>
</div>
</center>
<br>
<div id="info" style="display:block;">
<div class="row" style="font-size:11px">
<div class="col-12 col-sm-12 col-md-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left: 8px;"><b>GROUP:</b> <?php echo $nmm; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left: 8px;"><b>BRANCH:</b> <?php echo $xb; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left: 8px;"><b>CREATED BY:</b> <?php echo $znb; ?></span>
</div>
</div>
<br>
</div>
</div>

<div class="col-12 col-sm-12 col-md-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left: 8px;"><b>GROUP ID: </b> <?php echo $id; ?>
</span>
</div>
<div class="col-sm-6">
<span style="margin-left: 8px;"><b>STATUS: </b><?php echo $gst; ?>
</span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left: 8px;"><b>TEAM LEADER: </b> <?php echo $tc; ?></span>
</div>
</div>
<br>
</div>
</div>
</div>
</div>


<div id="transfer" style="display:none;">
<h6><b>Group Transfer Form</b></h6>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div class="row">
<div class="col-sm-6">
<select name="lo" required="required" class="form-control form-control-md">
<option value="">Select Credit Officer</option>
<?php 
include_once '../config/db.php';
$Query = "SELECT  * FROM users WHERE User_Group = 'Loan Officers' AND Status = 'Activate' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$names= $rows['Name'];
$us= $rows['Username'];
?>
<option value="<?php echo $us; ?>"><?php echo $names; ?></option>
<?php
}
}
?>
</select>
</div>

<div class="col-sm-6">
<input type="text" value="<?php echo $grid; ?>" hidden class="form-control form-control-md" name="gr" required="required">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-primary btn-sm btn-block" name="group_transfer" onclick="data()">Transfer</button>
</form>

</div>



<script>
function groupProfile(){
var a = document.getElementById("info");
var b = document.getElementById("transfer");
a.style.display = 'block';
b.style.display = 'none';
}
function groupTransfer(){
var a = document.getElementById("info");
var b = document.getElementById("transfer");
b.style.display = 'block';
a.style.display = 'none';
}
</script>


<script>
$(document).ready(function() {
$('.grDel').on('click', function(e) {e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete all group record from database";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
var id = $(this).data('id');
if (id) {
$.ajax({
url: "group_delete_profile.php",
type: "GET",
data: {'id': id},
success: function(data) { 
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
loads();
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert("🚫" + data);
}
},
error: function(xhr, status, error) {
alert('Error deleting group: ' + error);
}
});
} else {
alert('Invalid ID');
}
}
});
});
</script>




<script src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "Are you sure you want to transfer this group.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "group_transfer_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
setTimeout(function(){
$("#please").hide();
$("#toasts").css("display", "block");
loads();
$("#toasts").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫 " + data)
}
},
error: function(){
}
});
}
}));
});
</script>
