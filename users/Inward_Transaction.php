
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
<i class="fa fa-check"></i> Notification removed successfully
</div>
</div>
</div>


<?php include 'head.php'; ?>
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
<h3 class="mb-sm-0">Inward Transaction</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Home</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Inward Transaction</li>
</ol>
</nav>
</div>
</div>
</div>
<!-- end page title -->
<br>



<div id="list"></div>

<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "POST",
url: "recent_notification.php",
dataType: "html",  
success:function(data){
setTimeout(function(){
$('#list').html(data);
}, 100);
}
});
// ajax function ends here
});
</script>



<br>
<div class="row">
<div class="col-sm-12">
<input type="text"  placeholder="Search..." style="float:right; display:none">
<i id="ld" style="display:none"><img src="../loader/loader.gif" style="height:14px"> Reloading Notification ! Please wait...</i>
<br>
<br>
<div id="result"></div>
</div>
</div>




<div class="modal" id="exampleModalDefault" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-xl" style="display:none; width:1000px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Search Modal</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form action="" method="POST" enctype="multipart/form-data" id="searchTran">
<div class="row">
<div class="col-sm-4">
<div>
<input type="text" id="nm" name="nm" placeholder="Search..." id="nm">
<button type="submit" class="btn btn-info btn-sm">Search</button>
</div>
</div>
</div>
</form>
<hr>
<i id="sch" style="display:none">
<img src="../loader/loader.gif" style="height:17px"> Searching ! Please wait...
</i>
<i id="lds" style="display:none"><img src="../loader/loader.gif" style="height:14px"> Reloading Notification ! Please wait...</i>
<div id="search"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>




<script type="text/javascript">
$(document).ready(function(){
$("#ld").show();
setInterval(function(){
// ajax function start here
$.ajax({
method: "POST",
url: "load_notification.php",
dataType: "html",  
success:function(data){
$("#ld").hide();
$('#result').html(data);
}
});
}, 10000);
// ajax function ends here
});
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#searchTran").on('submit',(function(e){ e.preventDefault();
var nm = document.getElementById("nm").value;
$("#search").hide();
$("#sch").show();
$.ajax({
url: 'search_notification.php?nm=' + nm,
type: "GET",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#sch").show();
setTimeout(function(){
$("#sch").hide();
$("#search").show();
$('#search').html(data);
}, 3000);
},
error: function(){
}
});
}));
});
</script>



<?php include '../footer.php'; ?>