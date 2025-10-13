<div id="mydiv"> 
<?php 
include_once '../config/db.php';
$id = $_GET['id']; // user id
// 
$Query = "SELECT * FROM users WHERE id = '$id' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
?>
<div class="row">
<div class="col-sm-3">
<div class="card">
<div class="card-body">
<center>
<img src="<?php echo $row['Location']; ?>" alt="" id="output" class="rounded-circle" width="205" height="205px">
</center>
</div>
</div>
<div class="alert alert-success alert-dismissible fade show" role="alert" id="up" style="display:none">
<center><i class="fa fa-check"></i> Record Updated.! </center>
</div>
</div>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-8">
Account Status: 
[ <b><?php 
if($row['Status'] == 'Activate'){
echo "<i style='color:green'>".$row['Status']. "</i>";
}else{
echo "<i style='color:red'>".$row['Status']. "</i>";
}

?></b> ]
</div>
<div class="col-sm-2">
User ID: <?php echo $row['id']; ?>
</div>
<div class="col-sm-2">
<button  class="btn btn-outline-info btn-sm" onclick="myInfo()"  style="font-size: 9px;" id="showinfo"><i class="fa fa-edit"></i> Update Info</button>
<button  class="btn btn-outline-primary btn-sm" onclick="myView()" style="font-size: 9px; display:none" id="viewinfo"><i class="fa fa-eye"></i> View Info</button>
</div>
</div>
<br>
<div id="info" style="display:block;">
<div class="row">
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<br>
<b><i class="fa fa-star"></i> PROFILE INFO</b><br><br>
<div class="row">
<div class="col-sm-6">
<span><b>Name:</b> <?php echo $row['Name']; ?></span>
</div>
<div class="col-sm-6">
<span><b>Email:</b> <?php echo $row['Email']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span><b>Phone:</b> <?php echo $row['Phone']; ?></span>
</div>
<div class="col-sm-6">
<span><b>User Role:</b> <?php echo $row['User_Group']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span><b>Address:</b> <?php echo $row['Address']; ?></span>
</div>
</div>
<br><br>

</div>
</div>
</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<br>
<b><i class="fa fa-star"></i> PROFILE INFO</b><br><br>
<div class="row">
<div class="col-sm-6">
<span><b>Staff ID:</b> <?php echo $row['Staff_ID']; ?></span>
</div>
<div class="col-sm-6">
<span><b>Branch:</b> <?php echo $row['Branch']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span><b>Town:</b> <?php echo $row['Town']; ?></span>
</div>
<div class="col-sm-6">
<span><b>Zone:</b> <?php echo $row['Zone']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span><b>Country:</b> <?php echo $row['Country']; ?></span>
</div>
</div>
<br><br>
</div>

</div>
</div>

</div>

</div>
<!-- edit info modal -->
<div id="edit" style="display: none;">

<form action="" method="post" id="updateUser">
<div class="row">
<div class="form-group col-md-6">
<label class="form-label" for="fname">Upload Image:</label>
<input type="text" class="form-control" name="id" placeholder="id" hidden value="<?php echo $row['id']; ?>" required="required">
<input type="file" class="form-control" id="furl" name="Pic" onchange="loadFile(event)" value="<?php echo $row['Location']; ?>" required="required">
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
<div class="form-group col-md-6">
<label class="form-label">User Role:</label>
<select class="selectpicker form-control" data-style="py-0" disabled required="required">
<option value="<?php echo $row['Role_id']; ?>" ><?php echo $row['User_Group']; ?> </option>
<?php
include '../config/db.php';
$Query = "SELECT  * FROM role ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$grid= $rows['id'];
$name= $rows['Name'];
?>
<option value="<?php echo $grid; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="form-group col-md-6">
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
<div class="col-sm-2">
<button type="submit" class="btn btn-outline-success btn-sm" onclick="data()"><i class="fa fa-edit"></i> Update</button>
</form>
</div>
<div class="col-sm-10">
<span style="display:none" id="wait"> <img src="../loader/loader.gif" style="height:16px"> Record Updating ! Please wait..</span>  
<span style="display:none; color:red" id="check"><i class="fa fa-exclamation-circle"></i> Email OR Staff ID has already been taken by another staff, Please check..</span>  
</div>
</div>
</div>


</div>

</div>
</div>
















</div>

<script>
var loadFile = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>

<script>
//
function myInfo(){
document.getElementById('info').style.display = 'none';
document.getElementById('showinfo').style.display = 'none';
document.getElementById('viewinfo').style.display = 'block';
document.getElementById('edit').style.display = 'block';
}
//
function myView(){
document.getElementById('info').style.display = 'block';
document.getElementById('showinfo').style.display = 'block';
document.getElementById('viewinfo').style.display = 'none';
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