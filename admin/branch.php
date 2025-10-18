<div aria-live="polite" aria-atomic="true" class="position-relative" >
<div class="toast-container position-absolute top-0 end-0 p-3" id="tst" style="display: none;">
<!-- Then put toasts within -->
<div class="toast bg-success" role="alert" id="toast" aria-live="assertive" aria-atomic="true">
<div class="toast-header">
<small class="fa fa-bell"> </small>
<strong class="me-auto" style="margin-left:8px;"> Finanza</strong>
<img src="../assets/images/favicon.ico" class="rounded me-2" style="height:20px; width:20px">
</div>
<div class="toast-body">
<span style="color: white;"><i class="fa fa-check"></i> Branch Created Successfully</span>
</div>
</div>
</div>
</div>


<div aria-live="polite" aria-atomic="true" class="position-relative">
<div class="toast-container position-absolute top-0 end-0 p-3" id="tst1" style="display: none;">
<!-- Then put toasts within -->
<div class="toast bg-success" role="alert" id="toast1" aria-live="assertive" aria-atomic="true">
<div class="toast-header">
<small class="fa fa-bell"> </small>
<strong class="me-auto" style="margin-left:8px;"> Finanza</strong>
<img src="../assets/images/favicon.ico" class="rounded me-2" style="height:20px; width:20px">
</div>
<div class="toast-body">
<span style="color: white;"><i class="fa fa-check"></i> Branch Deleted Successfully</span>
</div>
</div>
</div>
</div>

<?php include 'header.php'; ?>

<div class="card border-0 mb-3 overflow-hidden bg-gray-800">
<div class="card-body">
<b>Create Branch </b>
<hr>
<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-4">
<label>Branch Title</label>
<input type="text" class="form-control form-control-md" required="required" name="nm" placeholder="Enter Branch Title">
</div>
<div class="col-sm-4">
<div id="zone">
<label>Branch Zone</label>
<select class="selectpicker form-control" data-style="py-0" name="zn" required="required">
<option value="">Select Option</option>
<?php
include_once '../config/db.php';
$Query = "SELECT id, Name FROM zone WHERE Status = 'Activated' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bri= $rows['id'];// zone id
$name= $rows['Name'];// zone name
?>
<option value="<?php echo $bri; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<div class="col-sm-4">
<label>Branch State</label>
<input type="text" class="form-control form-control-md" required="required" name="st" placeholder="Enter Branch State">
</div>
</div>
<br>
<span style="display:none; color:red" id="exit"><i class="fa fa-exclamation-triangle"></i> Branch name already exist! please use another name..</span>
<span style="display:none; color:red" id="exits"><i class="fa fa-exclamation-triangle"></i> Zone name already exist! please use another name..</span>
<span style="display:none; color:green" id="toasts"><i class="fa fa-check"></i> Branch zone successfully created. !!</span>
<hr>
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Create Branch</button>
<button type="button" class="btn btn-outline-info btn-sm" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#centermodal"><i class="fa fa-star"></i> Create Zone</button>

</form>
</div>
</div>

<div class="card">
<div class="card-body">
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






<!-- Center modal content -->
<div class="modal" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myCenterModalLabel">Zone Form</h4>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form action="" method="post" id="uploadZone">
<label>Zone Title</label>
<input type="text" class="form-control form-control-md" required="required" name="zn" placeholder="Enter Zone Title">
<br>
<button type="submit" class="btn btn-outline-primary btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Create Zone</button>
</form>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
$(document).ready(function(){
$("#tst").hide();// hide toast
$("#tst1").hide();// hide toast
});
</script>


<script type="text/javascript">
$(document).ready(function(){
$("#loader").show();
// ajax function start here
$.ajax({
method: "POST",
url: "load_branch_json.php",
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
url: "load_branch_json.php",
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
url: "load_branch_json.php",
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
url: "load_branch_json.php",
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
$("#uploadZone").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to send the request..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#centermodal").modal('hide');
$("#please").show();
$.ajax({
url: "create_zone_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#uploadZone")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#exits").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#exits").hide();
}, 7000);
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
//load();
$('#zone').load('branch.php #zone');// to reload zone without refreshing the page
}, 7000);
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






<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to send the request..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#tst").css("display", "block");
$("#please").show();
$.ajax({
url: "add_branch_bck.php",
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
$("#exit").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#exit").hide();
}, 7000);
}else if(data == 2){
setTimeout(function(){
$("#uploadRole")[0].reset();
$("#please").hide();
$("#toast").show();
load();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
load();
}, 7000);
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