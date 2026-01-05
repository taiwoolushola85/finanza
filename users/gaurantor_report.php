
<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-6">
<label>Start Date</label>
<input type="date" name="st" required class="form-control form-control-sm">
</div>
<div class="col-sm-6">
<label>End Date</label>
<input type="date" name="en" required class="form-control form-control-sm">
</div>
</div>
<button type="submit" class="btn btn-info btn-block btn-sm" style="margin-top: 25px;"><i class="fa fa-file"></i> Run Report</button>
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
url: "show_guarantor.php",
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

