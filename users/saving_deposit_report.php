<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-3">
<label>Start Date</label>
<input type="date" class="form-control form-control-md" name="st" required="required">
</div>
<div class="col-sm-3">
<label>End Date</label>
<input type="date" class="form-control form-control-md" name="en" required="required">
</div>
<div class="col-sm-3">
<label style="font-size:13px">Branch</label>
<select type="text" class="form-control form-control-md" name="br" id="br" oninput="getGroup()">
<option value="">All</option>
<?php 
include '../config/db.php';
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
<div class="col-sm-3">
<label style="font-size:13px">Loan Officer</label> <i id="load" style="display:none; float:right"><img src="../loader/loader.gif" style="height:14px"> Loading.....</i>
<select class="form-control form-control-md" name="ln" id="hey">
<option value="">All</option>
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
function getGroup()  {
var br = document.getElementById("br").value;
// ajax function start here
$.ajax({
method: "POST",
url: "crp.php",
dataType: "html",  
data: {
'br': br
},
success:function(data){
//alert(data);
$("#load").show();
setTimeout(function(){
$("#load").hide();
$("#hey").html(data);
}, 2200);
}
});
// ajax function ends here
}
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
$("#result").hide();
$("#loads").show();
$.ajax({
url: "show_deposit.php",
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
