<div class="card">
<div class="card-body">
<fieldset>
<div class="row">
<div class="col-md-12">
<marquee><i><b style="color:red">Notice:</b> Please mark the roles that you want to restrict from users before clicking the restrict access button</i></marquee>
<br>
<legend><h5><b>Role Details</b></h5></legend>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRec">
<?php
extract($_POST);
include('../config/db.php');
$cu = $_GET['cu'];
//Get roles Details
$Query = "SELECT  * FROM  control WHERE Groups = '$cu'";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$id= $rows['id'];
$rl = $rows['role'];
?>
<div class="card" style="display:inline-block">
<div class="card-body">
<input type="text" name="cu" value="<?php echo $cu;?>" hidden="hidden">
<label style="font-size:10px"><?php echo $rl;?></label>
<input type="checkbox" name="id[]" value="<?php echo $id;?>" style="margin: 20px">
</div>
</div>

<?php
}
}else {
//No result found
$Available = false;
echo" No Roles Found  <br/> ";
}
?>

<hr>
<button type="submit" class="btn btn-outline-info btn-sm" style="float:right; font-size:10px" name="restrict" onclick="data()"><i class="fa fa-edit"></i> Restrict Access</button>
</form>
</div>
</div>
</fieldset>

</div>
</div>
</div>
</div>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRec").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to restrict this user role.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#tst").css("display", "block");
$("#please").show();
$.ajax({
url: "restrict_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
load();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
load();
}, 6000);
},
error: function(){
}
});
}
}));
});
</script>

<script type="text/javascript">
function load()  {
$.ajax({
method: "POST",
url: "menu_configuration_bck.php?cu=<?php echo $cu; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 