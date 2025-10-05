<?php include 'header.php'; ?>

<div class="card border-0 mb-3 overflow-hidden bg-gray-800 text-white">
<div class="card-body">
<b>Add menu to user page </b>
<hr>
<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-4">
<label>User Role</label>
<input type="text" class="form-control form-control-md" required="required" name="rl" placeholder="Enter Role Title">
</div>
<div class="col-sm-4">
<label>Role Category</label>
<select type="text" class="form-control form-control-md" required="required" name="ro">
<option value="">Select Option</option>
<option value="Administrator">Administrator</option>
<option value="Field Operations">Field Operations</option>
<option value="Branch Operations">Branch Operations</option>
<option value="Managements">Managements</option>
</select>
</div>
</div>
<hr>
<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Role</button>
</form>
</div>
</div>

<div class="card">
<div class="card-body">
<br>
<div class="row">
<div class="col-sm-10">
<label>Show Entries</label>
<select class="form-control form-control-sm" id="maxRows" style="width:50px;" oninput="getEntry()">
<option value="5">5</option>
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-2">
<div>
<label>Search</label>
<input type="text" class="form-control form-control-sm" id="search" placeholder="Type here to search..." >
</div>
</div>
</div>
<br>
<div id="result"></div>
</div>
</div>


</div>








<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "role_analysis.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$("#loader").hide();
$('#result').html(data);
}, 1000);
}
});
// ajax function ends here
});
</script>


<script type="text/javascript">
function getEntry()  {
$("#loader").show();
$("result").hide();
var maxRows = document.getElementById("maxRows").value;
// ajax function start here
$.ajax({
method: "POST",
url: "role_analysis.php",
dataType: "html",  
data: {
'maxRows': maxRows
},
success:function(data){
$("result").show();
setTimeout(function(){
$("#loader").hide();
$('#result').html(data);
}, 1000);
}
});
// ajax function ends here
}
</script>



<script type="text/javascript">
$(document).ready(function(){
$("#search").keydown(function(){
var search = document.getElementById("search").value;
// ajax function start here
$.ajax({
method: "POST",
url: "role_analysis.php",
dataType: "html",  
data: {
'search': search
},
success:function(data){
$('#result').html(data);
}
});
// ajax function ends here
});
});
</script>

<script type="text/javascript">
function load()  {
$.ajax({
method: "POST",
url: "role_analysis.php",
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
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to send the request..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "create_role_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#uploadRole")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
Swal.fire({
toast: true,
icon: 'success',
title: 'Role Created Successfully!',
html: '<small style="color: rgba(255,255,255,0.9);">The role has been created and saved</small>',
position: 'top-end',
showConfirmButton: false,
timer: 4000,
timerProgressBar: true,
backdrop: false,  // No overlay/backdrop
customClass: {
popup: 'minimal-toast'
}
});
load();
}, 3000);
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