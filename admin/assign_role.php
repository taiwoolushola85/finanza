<?php include 'header.php'; ?>

<div class="card">
<div class="card-body">
<h6><b class="fa fa-cog"></b> USER MENU CONTROL PANEL</h6>
<hr>
<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-4">
<label>User Role</label>
<select type="text" class="form-control form-control-md" required="required" name="lv">
<option value="">Select Option</option>
<?php
include_once '../config/db.php';
$Query = "SELECT  * FROM role ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$name= $rows['Name'];
?>
<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
<?php
}
}
mysqli_close($con);
?>
</select>
</div>
</div>
<hr>
<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</button>
</form>
</div>
</div>

<div id="result"></div>


</div>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
$("#please").show();
$.ajax({
url: "all_role.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
setTimeout(function(){
$("#please").hide();
$("#menu").show();
$('#result').html(data);
}, 3000);
},
error: function(){
}
});
}));
});
</script>

<?php include '../footer.php'; ?>