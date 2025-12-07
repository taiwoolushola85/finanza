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
<i class="fa fa-check"></i> Payment Successfully Posted
</div>
</div>
</div>

<?php include 'head.php'; ?>


<!-- MAIN CONTENT -->
<div class="main-content">
<div class="page-content">
<div class="container-fluid">

<!-- PAGE TITLE -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h3 class="mb-sm-0">Receipt Posting</h3>
<nav aria-label="breadcrumb" class="page-title-right">
<ol class="breadcrumb border-0">
<li class="breadcrumb-item">
<a href="#!">
<i class="mdi mdi-home-outline fs-18 lh-1"></i>
<span class="visually-hidden">Posting</span>
</a>
</li>
<li class="breadcrumb-item"><a href="#!">Posting</a></li>
<li class="breadcrumb-item active" aria-current="page">Receipt Posting</li>
</ol>
</nav>
</div>
</div>
</div>

<br>

<!-- GROUP SELECT -->
<div class="row">
<div class="col-md-3">
<label>Select Group</label>
<div class="input-group mb-3">
<select class="form-control form-control-md" id="gr" required onchange="myFunction()">
<option value="">Select Option</option>
<?php 
include '../config/db.php';
// sanitize $user only AFTER it is available
$user_safe = mysqli_real_escape_string($con, $user); 
$Query = "SELECT id, Name FROM groups WHERE User = ? AND Status = 'Activated' ORDER BY id ASC";
$stmt = mysqli_prepare($con, $Query);
mysqli_stmt_bind_param($stmt, "s", $user_safe);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($rows = mysqli_fetch_assoc($result)) {
$grid = $rows['id'];
$name = htmlspecialchars($rows['Name']);
echo "<option value='$grid'>$name</option>";
}
mysqli_stmt_close($stmt);
?>
</select>
</div>
</div>
</div>

<div class="card">
<div class="card-body">

<p id="not">
<i class="fa fa-bell" style="color:red;"></i> Note: Please select the group you want to post repayment for.
</p>

<div id="result"></div>

</div>
</div>

</div>
</div>
</div> <!-- END MAIN CONTENT -->


<script>
function myFunction() {
var gr = $("#gr").val();
$.ajax({
method: "POST",
url: "load_customer_by_group.php",
data: { gr: gr },
dataType: "html",
success: function (response) {
$("#not").hide();
$("#result").html(response);
},
error: function (xhr, status, error) {
console.error("AJAX Error:", error);
$("#result").html(
"<div class='alert alert-danger'>Failed to load customers.</div>"
);
}
});
}
</script>


<?php include '../footer.php'; ?>
