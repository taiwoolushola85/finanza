<?php 
include_once '../config/db.php';
$id = $_GET['id']; // reg id
// getting group info
$Query = "SELECT * FROM groups WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$grid = $row['id'];
//
?>

<br><br><br>
<div class="row">
<div class="col-sm-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Group ID:</b> <?php echo $row['id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Group Name:</b> <?php echo $row['Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Branch:</b> <?php echo $row['Branch']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Officer:</b> <?php echo $row['Officer_Name']; ?></span>
</div>
</div>
<br>
</div>
</div>
<div class="col-sm-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Date Created:</b> <?php echo $row['Date_Register']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Team Lead:</b> <?php echo $row['Team_Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;" ><b>Status:</b> <span class='badge badge-label badge-soft-info'><?php echo $row['Status']; ?></span></span>
</div>
</div>
<br>
</div>
</div>
</div>

<div class="btn-group">
<a class="approve" href="#!" data-id="<?php echo htmlspecialchars($row['id']); ?>"><button class="btn btn-success"><i class="fa fa-check"></i> Approve</button></a>
<a class="decline" href="#!" data-id="<?php echo htmlspecialchars($row['id']); ?>"><button class="btn btn-warning"><i class="fa fa-exclamation-triangle"></i> Deactivate</button></a>
<a class="delete" href="#!" data-id="<?php echo htmlspecialchars($row['id']); ?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></a>
</div>






<script>
// Modal data loading
$(document).ready(function() {
$('.approve').on('click', function(e) {e.preventDefault();
WRN_PROFILE_DELETE = "You are about to approve this group for easy access by the loan officer ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
var id = $(this).data('id');
if (id) {
$.ajax({
url: 'approve_group_bck.php',
type: "GET",
data: {'id': id},
success: function(data) { 
if(data == 1){
setTimeout(function() {
$("#please").hide();
$("#toast").show();
load();
}, 3000);
setTimeout(function() {
$("#please").hide();
$("#toast").hide();
}, 8000);
}else{

}
},
error: function(xhr, status, error) {
alert('Error approving group: ' + error);
$("#please").hide();
}
});
} else {
alert('Invalid ID');
$("#please").hide();
}
}
});
});
</script>



<script>
// Modal data loading
$(document).ready(function() {
$('.decline').on('click', function(e) {e.preventDefault();
WRN_PROFILE_DELETE = "You are about to deactivate group status for easy access ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
var id = $(this).data('id');
if (id) {
$.ajax({
url: 'decline_group_bck.php',
type: "GET",
data: {'id': id},
success: function(data) { 
if(data == 1){
setTimeout(function() {
$("#please").hide();
$("#toasts").show();
load();
}, 3000);
setTimeout(function() {
$("#please").hide();
$("#toasts").hide();
}, 8000);
}else{

}
},
error: function(xhr, status, error) {
alert('Error approving group: ' + error);
$("#please").hide();
}
});
} else {
alert('Invalid ID');
$("#please").hide();
}
}
});
});
</script>



<script>
// Modal data loading
$(document).ready(function() {
$('.delete').on('click', function(e) {e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete group info from the database..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
var id = $(this).data('id');
if (id) {
$.ajax({
url: 'delete_group_bck.php',
type: "GET",
data: {'id': id},
success: function(data) { 
if(data == 1){
setTimeout(function() {
$("#please").hide();
$("#dele").show();
load();
}, 3000);
setTimeout(function() {
$("#please").hide();
$("#dele").hide();
}, 8000);
}else{

}
},
error: function(xhr, status, error) {
alert('Error approving group: ' + error);
$("#please").hide();
}
});
} else {
alert('Invalid ID');
$("#please").hide();
}
}
});
});
</script>