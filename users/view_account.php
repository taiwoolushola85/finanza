<div id="mydiv"> 
<?php 
include_once '../config/db.php';
$id = $_GET['id']; // user id
// 
$Query = "SELECT * FROM users WHERE id = '$id' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$users = $row['Username'];
?>
<div id="info" style="display:block;">
<hr>

<div class="row">
<div class="col-sm-4">
<center>
<img src="<?php echo $row['Location']; ?>" alt="" id="output" class="rounded-circle" width="200" height="200px">
</center>
<br>
</div>
<div class="col-sm-8">
<div class="row">
<div class="col-8">
<b><i class="fa fa-star"></i> PROFILE INFO</b>
</div>
<div class="col-4">
<a onclick="myInfo()" class="btn btn-primary btn-sm w-100"><i class="fa fa-edit"></i>Update Info</a>
</div>
</div>

<div class="card border-primary border border-dashed" style="margin-top: 10px;">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Name:</b> <?php echo $row['Name']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Email:</b> <?php echo $row['Email']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Phone:</b> <?php echo $row['Phone']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Role:</b> <?php echo $row['User_Group']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Staff ID:</b> <?php echo $row['Staff_ID']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Branch:</b> <?php echo $row['Branch']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Town:</b> <?php echo $row['Town']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Zone:</b> <?php echo $row['Zone']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $row['Address']; ?></span>
</div>
</div>
<br>
</div>
</div>

<hr>
</div>

</div>

<!-- edit info modal -->
<div id="edit" style="display: none;">

<div class="alert alert-success alert-dismissible fade show" role="alert" id="up" style="display:none">
<center><i class="fa fa-check"></i> <?php echo $row['Name']?> Record has been updated.! </center>
</div>
<hr>
<form action="" method="post" id="updateUser">
<div class="row">
<div class="form-group col-md-6">
<label class="form-label" for="fname">Upload Image:</label>
<input type="text" class="form-control" name="id" placeholder="id" hidden value="<?php echo $row['id']; ?>" required="required">
<input type="text" class="form-control" name="gr" placeholder="User Group" hidden value="<?php echo $row['User_Group']; ?>" required="required">
<input type="file" class="form-control" name="Pic" onchange="loadUp(event)" value="<?php echo $row['Location']; ?>" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="lname">Name:</label>
<input type="text" class="form-control" name="nm" placeholder="Name" value="<?php echo $row['Name']; ?>" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="add1">Sex</label>
<select  class="selectpicker form-control" name="gender" required="required">
<option value="<?php echo $row['Gender']; ?>" ><?php echo $row['Gender']; ?></option>
<option Value ="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>
<div class="form-group col-md-6">
<label class="form-label" for="add2">Address</label>
<input type="text" class="form-control" name="ad" value="<?php echo $row['Address']; ?>"  placeholder="Address" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="mobno">Mobile No:</label>
<input type="number" class="form-control" name="ph" placeholder="Mobile No" value="<?php echo $row['Phone']; ?>" required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="altconno">Town/City:</label>
<input type="text" class="form-control" name="st" placeholder="Town/City" value="<?php echo $row['Town']; ?>"  required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="email">Email:</label>
<input type="email" class="form-control" name="em" placeholder="Email" value="<?php echo $row['Email']; ?>"  required="required">
</div>
<div class="form-group col-md-6">
<label class="form-label" for="pno">Staff ID:</label>
<input type="number" class="form-control" name="staffid" placeholder="Staff ID" value="<?php echo $row['Staff_ID']; ?>"  required="required">
</div>
</div>

<div class="row">
<div class="form-group col-md-12">
<label class="form-label">Branch:</label>
<select class="selectpicker form-control" name="br" required="required">
<option value="<?php echo $row['Branch_id']; ?>" ><?php echo $row['Branch']; ?> </option>
<?php
include '../config/db.php';
$Query = "SELECT  * FROM branch ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bri= $rows['id'];
$name= $rows['Name'];
?>
<option value="<?php echo $bri; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-3">
<button type="submit" class="btn btn-outline-success btn-sm w-100" onclick="data()"><i class="fa fa-edit"></i> Update</button>
</form>
</div>
<div class="col-sm-3">
<button type="button" class="btn btn-outline-info btn-sm w-100" onclick="myView()"><i class="fa fa-eye"></i> View Profile</button>
</div>
<div class="col-sm-6">
<span style="display:none" id="wait"> <img src="../loader/loader.gif" style="height:16px"> Record Updating ! Please wait..</span>  
<small style="display:none; color:red" id="check"><i class="fa fa-exclamation-circle"></i>
Email OR Staff ID has already been taken by another staff, Please check..</small>  
</div>
</div>
</div>



</div>













<script>
var loadUp = function(event) {
var image = document.getElementById('outputs');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>

<script>
//
function myInfo(){
document.getElementById('info').style.display = 'none';
document.getElementById('edit').style.display = 'block';
}
//
function myView(){
document.getElementById('info').style.display = 'block';
document.getElementById('edit').style.display = 'none';
}
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#updateUser").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this staff record..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: "update_staff_record.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#wait").show();
if(data == 1){
$("#wait").hide();
$("#check").show();
setTimeout(function(){
$("#wait").hide();
$("#check").hide();
}, 3000);
}else if(data == 2){
setTimeout(function(){
$("#updateUser")[0].reset();
$("#wait").hide();
$("#up").show();
load();
}, 3000);
setTimeout(function(){
$("#wait").hide();
$("#up").hide();
$("#mydiv").load('view_account.php?id=<?php echo $id; ?>' + " #mydiv");
}, 5000);
}else{
$("#wait").hide();
$("#updateUser")[0].reset();
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