<div aria-live="polite" aria-atomic="true" class="position-relative">
<div class="toast-container position-absolute top-0 end-0 p-3">
<!-- Then put toasts within -->
<div class="toast" role="alert" id="toast" aria-live="assertive" aria-atomic="true">
<div class="toast-header">
<small class="fa fa-bell"> </small>
<strong class="me-auto" style="margin-left:8px;"> Finanza</strong>
<img src="../assets/images/favicon.ico" class="rounded me-2" style="height:20px; width:20px">
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Group Created Successfully
</div>
</div>
</div>
</div>

<?php include 'head.php'; ?>

<div class="card border-0 mb-3 overflow-hidden bg-gray-800">
<div class="card-body">

<b>Create Group </b>
<hr>
<form action="" method="post" id="createGroup">
<div class="row">
<div class="col-sm-4">
<label>Group Name</label>
<input type="text" class="form-control form-control-md" required="required" name="gr" placeholder="Enter Group Name">
</div>
</div>
<br>
<span style="display:none; color:red" id="exit"><i class="fa fa-exclamation-triangle"></i> Group name already exist! please use another name..</span>
<hr>
<div class="row">
<div class="col-sm-2">
<?php
if($mapped != 'No'){
?>
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Create Group</button>
<?php
}else{
?>
<button disabled class="btn btn-outline-success btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Create Group</button>
<?php
}
?>
</form>
</div>
<div class="col-sm-10">
<?php
if($mapped != 'No'){
?>

<?php
}else{
?>
<span style="color:red"><i class="fa fa-exclamation-triangle"></i> Your account need to be mapped to a team leader. please contact Administrator</span>
<?php
}
?>
</div>
</div>
</div>
</div>



<div class="card border-0 mb-3 overflow-hidden bg-gray-800">
<div class="card-body">
<div id="not"></div>
</div>
</div>







</div>




<script type="text/javascript">
$(document).ready(function (e){
$.ajax({
method: "POST",
url: "load_group_notification_json.php",
dataType: "html",
success:function(data){
$('#not').html(data);
}
});
});
</script> 


<script type="text/javascript">
function loadNotification() {
$.ajax({
method: "POST",
url: "load_group_notification_json.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#not').html(data);
}, 100);
}
});
}
</script> 





<script type="text/javascript">
$(document).ready(function (e){
$("#createGroup").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to create group for repayments collection ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "create_group_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#createGroup")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#exit").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#exit").hide();
}, 6000);
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
loadNotification();
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

<?php include '../footer.php'; ?>