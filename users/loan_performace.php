<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-4">
<label>Start Date</label>
<input type="date" class="form-control form-control-md" name="st" required="required">
</div>
<div class="col-sm-4">
<label>End Date</label>
<input type="date" class="form-control form-control-md" name="en" required="required">
</div>
<div class="col-sm-4">
<label style="font-size:13px">Branch</label>
<select type="text" class="form-control form-control-md" name="br" id="br" oninput="getGroup()">
<option value="All">All</option>
<?php 
include_once '../config/db.php';
$Query = "SELECT  * FROM branch WHERE Name != 'Head Office' ORDER BY Name ASC";
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
</div>
<br>
<button class="btn btn-success btn-sm btn-flat" type="submit"  onclick="data()">Run Report</button>
</form>



<br>
<i id="loads" style="display:none;"><img src="../loader/loader.gif" style="height:14px"> Loading Data ! Please wait.....</i>
<div id="result"></div>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
$("#result").hide();
$("#loads").show();
$.ajax({
url: "show_performace.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#loads").show();
setTimeout(function(){
$("#loads").hide();
$("#result").show();
$('#result').html(data);
}, 1000);
},
error: function(){
}
});
}));
});
</script>
