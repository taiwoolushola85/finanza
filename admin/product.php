<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Product Successfully Created
</div>
</div>
</div>


<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast1" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i> Product Successfully Deleted
</div>
</div>
</div>



<!-- TOP RIGHT (original) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
<div class="toast" role="alert" id="toast2" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="display:none;">
<div class="toast-header">
<small class="fa fa-bell"></small>
<strong class="me-auto" style="margin-left:8px;">Finanza</strong>
<img src="../assets/images/logo-sm.png" class="rounded me-2" style="height:20px; width:20px" alt="Finanza icon">
<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
<i class="fa fa-check"></i>  Product Configuration Set Successfully
</div>
</div>
</div>


<?php include 'header.php'; ?>
<!-- Left Sidebar End -->
<div class="sidebar-backdrop" id="sidebar-backdrop"></div>
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
<h3 class="mb-sm-0">Product</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Product</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<div class="card border-0 mb-3 overflow-hidden bg-gray-800">
<div class="card-body">
<h6><b><b><i class="fa fa-star"></i> LOAN PRODUCT FORM</b></h6><hr>
<b>* Step 1</b>
<br><br>
<form action="" method="post" id="uploadProduct">
<div class="row">
<div class="col-12 col-sm-12 col-md-6">
<label style="font-size:11px">Product Name</label>
<input type="text" class="form-control form-control-sm" placeholder="Product Name" name="name" >
</div>
<div class="col-12 col-sm-12 col-md-6">
<label style="font-size:11px">Repayment Frequency</label>
<select type="text" class="form-control form-control-sm"  name="fre" required>
<option value="">Select Frequency</option>
<option value="Daily">Daily</option>
<option value="Weekly">Weekly</option>
<option value="Monthly">Monthly</option>
<option value="Yearly">Yearly</option>
</select>
</div>
</div>
<hr>
<div class="row">
<div class="col-sm-2">
<div class="d-grid gap-2 mb-2">
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Create Product</button>
</div>
</form>
</div>
<div class="col-sm-2">
<div class="d-grid gap-2 mb-2">
<button type="button" data-bs-toggle="modal" data-bs-target="#productModal" class="btn btn-outline-info btn-sm btn-block" style="font-size: 10px;"><i class="fa fa-list"></i> Product List</button>
</div>
</div>
<div class="col-sm-8">
<span style="display:none; color:red" id="exit"><i class="fa fa-exclamation-triangle"></i> Product name already exist! please use another name..</span>
<span style="display:none; color:green" id="update"><i class="fa fa-check"></i> Loan Product Updated Successfully..</span>
</div>
</div>
</div>
</div>



<div class="card border-0 mb-3 overflow-hidden bg-gray-800">
<div class="card-body">
<b><i class="fa fa-cog"></i> Product Configuration Setting</b><hr>
<b>* Step 2</b>
<br><br>
<form id="productConfig" name="form1" method="POST">
<div class="row">
<div class="col-12 col-sm-12 col-md-3">
<div id="product">
<label style="font-size:11px">Select Product</label>
<select type="text" class="form-control form-control-sm"  name="pro" required>
<option value="">Select Loan Product</option>
<?php 
include '../config/db.php';
$Query = "SELECT  id, Product_Name FROM product WHERE Status = 'Activated' ORDER BY Product_Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Product_Name'];
?>
<option value="<?php echo $pp; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
</div>
<br>
<div class="row">
<div class="col-12 col-sm-12 col-md-4">
<label style="font-size:11px">Tenure</label>
<input type="text" class="form-control form-control-sm" placeholder="Tenure" name="ten" >
</div>
<div class="col-12 col-sm-12 col-md-4">
<label style="font-size:11px">Interest Rate %</label>
<input type="text" class="form-control form-control-sm" placeholder="Interest Rate" name="int">
</div>
<div class="col-12 col-sm-12 col-md-4">
<label style="font-size:11px">Inssurance %</label>
<input type="text" class="form-control form-control-sm" placeholder="Inssurance"name="ins">
</div>
</div>
<hr>
<div class="row">
<div class="col-sm-2">
<div class="d-grid gap-2 mb-2">
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size: 10px;"><i class="fa fa-plus"></i> Create Product</button>
</div>
</form>
</div>
<div class="col-sm-10">
<span style="display:none; color:red" id="exits"><i class="fa fa-exclamation-triangle"></i> Configuration setting already exist ! Please check product list..</span>
</div>
</div>



</div>


</div>

<div class="modal" id="productModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">PRODUCT LIST TABLE</h5>
</div>
<div class="modal-body">
<form action="" method="post" id="uploadForm">
<div class="row">
<div class="col-sm-6">
<label>Product</label>
<input type="hidden" class="form-control form-control-sm" required="required" name="id" id="stid">
<input type="hidden" class="form-control form-control-sm" required="required" name="prid" id="stno">
<input type="text" class="form-control form-control-sm" required="required" name="pr" id="name" placeholder="Enter Product Name">
</div>
<div class="col-sm-6">
<label>Tenure</label>
<input type="text" class="form-control form-control-sm" required="required" name="ten" id="tenure" placeholder="Enter Tenure">
</div>
</div>
<div class="row">
<div class="col-sm-12">
<label>Insurance</label>
<input type="text" class="form-control form-control-sm" required="required" name="in" id="in" placeholder="Enter Insurance">
</div>
</div>
<div class="row">
<div class="col-sm-6">
<label>Rate</label><i style="color:red"> [ % ]</i>
<input type="text" class="form-control form-control-sm" required="required" name="rt" id="rate" placeholder="Enter Rate">
</div>
<div class="col-sm-6">
<label>Frequency</label>
<select class="form-control form-control-sm" name="fr" id="frequency" required="required">
<option value="">Select Option</option>
<option value="Daily">Daily</option>
<option value="Weekly">Weekly</option>
<option value="Monthly">Monthly</option>
<option value="Yearly">Yearly</option>
</select>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-2">
<div class="d-grid gap-2 mb-2">
<button type="submit" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i> Update</button>
</form>
</div>
</div>
<div class="col-sm-8">
<span style="display:none; color:green" id="updatep"><i class="fa fa-check"></i> Loan Product Updated Successfully..</span>
</div>
</div>
</br>
<div class="row">
<div class="col-sm-9">
<label>Show Entries</label>
<select class="form-control form-control-sm" id="maxRows" style="width:50px;" oninput="getEntry()">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div class="col-sm-3">
<div>
<label>Search</label>
<input type="text" class="form-control form-control-sm" id="search" placeholder="Type here to search..." >
</div>
</div>
</div>
<br>
<div id="result"></div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>


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
url: "load_product_json.php",
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
url: "load_product_json.php",
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
url: "load_product_json.php",
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
url: "load_product_json.php",
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
$("#uploadProduct").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to create a new loan product..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#tst").css("display", "block");
$("#please").show();
$.ajax({
url: "create_product.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#uploadProduct")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#exit").show();
$('#product').load('product.php #product');// to reload zone without refreshing the page
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#exit").hide();
}, 7000);
}else if(data == 2){
setTimeout(function(){
$("#uploadProduct")[0].reset();
$("#please").hide();
$("#toast").show();
$('#product').load('product.php #product');// to reload zone without refreshing the page
load();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
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
$("#productConfig").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to create a product configuration for this product..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#tst").css("display", "block");
$("#please").show();
$.ajax({
url: "create_product_config.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#productConfig")[0].reset();
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
$("#uploadProduct")[0].reset();
$("#please").hide();
$("#toast2").show();
load();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast2").hide();
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