<?php include 'head.php'; ?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h3 class="mb-sm-0">Birthday</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Birthday</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Birthday</a></li>
<li class="breadcrumb-item active" aria-current="page">Birthday</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->


<br>
<br>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm"> 
<div class="row">
<div class="col-sm-3">
<label class="form-label"><i style="color: red;">*</i> Select Month:</label>
<select name="mnth" class="form-control" required>
<option value="">Select Month</option>
<option value="Jan">Jan</option>
<option value="Feb">Feb</option>
<option value="Mar">Mar</option>
<option value="Apr">Apr</option>
<option value="May">May</option>
<option value="Jun">Jun</option>
<option value="Jul">Jul</option>
<option value="Aug">Aug</option>
<option value="Sept">Sept</option>
<option value="Oct">Oct</option>
<option value="Nov">Nov</option>
<option value="Dec">Dec</option>
</select>
</div>
<div class="col-sm-3">
<button type="submit" class="btn btn-outline-success btn-sm" style="margin-top:30px"><i class="fa fa-search"></i> Search</button>
</div>
</div>
<br>
</form>

<div id="hey"></div>




<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
$("#please").show();
$.ajax({
url: "birth_list.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){ 
$("#please").show();
setTimeout(function(){
$("#please").hide();
$("#hey").html(data);
}, 3000);
},
error: function(){
}
});
}));
});
</script>











<?php include '../footer.php'; ?>