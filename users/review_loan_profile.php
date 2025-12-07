<?php 
include_once '../config/db.php';
$id = $_GET['id']; // user id
// 
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$reg_status = $row['Status'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
?>


<?php 
if($reg_status == 'Under Review'){
?>
<div class="btn-group">
<a class="approve" href="#!" id="<?php echo $regid; ?>"><button class="btn btn-success"><i class="fa fa-check"></i> Approve Application</button></a>
<button class="btn btn-info"><i class="fa fa-book"></i> CRC Record</button>
<a href="#!" class="decline" href="#!" id="<?php echo $regid; ?>"><button hidden class="btn btn-warning"><i class="fa fa-exclamation-triangle"></i> Decline Application</button></a>
<a href="#!" class="delete" href="#!" id="<?php echo $regid; ?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> Delete Application</button></a>
</div>
<?php 
}else{

}
?>

<div class="row">
<div class="col-sm-6">
<br><br>
<b><i class="fa fa-star"></i> CLIENT INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Name:</b> <?php echo $row['Firstname']." ". $row['Middlename']." ".$row['Lastname']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Phone:</b> <?php echo $row['Phone']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gender:</b> <?php echo $row['Gender']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Branch:</b> <?php echo $row['Branch']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Marriage Status:</b> <?php echo $row['Maritial_Status']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b> Client BVN:</b> <?php echo $row['BVN']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Education:</b> <?php echo $row['Education']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Document:</b> <?php echo $row['Document']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Document No:</b> <?php echo $row['Document_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Registration ID:</b> <?php echo $row['id']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $row['Address']; ?></span>
</div>
</div>
<br>
</div>

</div>
<div class="col-sm-6">
<br><br>
<b><i class="fa fa-star"></i> GAURANTOR INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Name:</b> <?php echo $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Phone:</b>  <?php echo $rows['Phone']; ?></span>
</div>
</div>




<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Relationship:</b>  <?php echo $rows['Relationship']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gender:</b> <?php echo $rows['Gender']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>BVN/NIN:</b>  <?php echo $rows['Gaurantor_BVN']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Occupation:</b>  <?php echo $rows['Occupation']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>ID No:</b> <?php echo $rows['ID_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>ID Type:</b>   <?php echo $rows['ID_Type']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gaurantor ID:</b>  <?php echo $rows['id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Reg ID:</b>  <?php echo $row['id']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $rows['Address']; ?></span>
</div>
</div>
<br>

</div>

</div>
</div>

<?php 
if($reg_status == "Under Review"){

}else{
?>
<div id="prlist">
<div class="row">
<div class="col-sm-6">

<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Principal Amt:</b> <?php echo number_format($row['Loan_Amount'],2); ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Interest  Amt:</b> <?php echo number_format($row['Interest_Amt'],2); ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Repayment Amt:</b> <?php echo number_format($row['Repayment_Amt'],2); ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Total Loan:</b> <?php echo number_format($row['Total_Loan'],2); ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Bank:</b> <?php echo $row['Bank']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Account Name:</b> <?php echo $row['Account_Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Account No:</b> <?php echo $row['Account_No']; ?></span>
</div>
</div>
<br>
</div>
</div>
<div class="col-sm-6">

<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Product:</b> <?php echo $row['Product']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Frequency:</b> <?php echo $row['Frequency']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Tenure:</b> <?php echo $row['Tenure']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Rate:</b> <?php echo $row['Rate']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Product ID:</b> <?php echo $row['Product_id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Status:</b> <?php echo $row['Status']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Officer:</b> <?php echo $row['Officer_Name']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Team Leader:</b> <?php echo $row['Team_Name']; ?></span>
</div>
</div>
<br>
</div>

</div>
</div>
<?php 
}
?>
</div>


</div>
</div>

<br>
<b><i class="fa fa-star"></i> BUSINESS INFO</b>
<br><br>
<div>
<table>
<thead>
<tr style="font-size:8px;">
<th>BUSSINESS</th>
<th>TYPE</th>
<th>STATE</th>
<th>START DATE</th>
<th>CASH FLOW</th>
<th>OWNERSHIP</th>
<th>ADDRESS</th>
</tr>
</thead>
<tbody>
<tr>
<td ><?php echo $row['Business']; ?></td>
<td ><?php echo $row['Biz_Type']; ?></td>
<td ><?php echo $row['Biz_State']; ?></td>
<td ><?php echo $row['Start_Date']; ?></td>
<td ><?php echo $row['Cash_Flow']; ?></td>
<td ><?php echo $row['Shop_Owner']; ?></td>
<td ><?php echo $row['Biz_Address']; ?></td>
</tr>
</tbody>
</table>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.approve').on('click', function() {
WRN_PROFILE_DELETE = "You are about to approve this loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: 'approve_review.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
load();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
alert (data)
}
}
});
}else{
alert (data)
}
}
});
});
</script>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.decline').on('click', function() {
WRN_PROFILE_DELETE = "You are about to decline this loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: 'decline_loan_review.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
load();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
alert (data)
}
}
});
}else{
alert (data)
}
}
});
});
</script>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.delete').on('click', function() {
WRN_PROFILE_DELETE = "You are about to delete this loan application from the database..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: 'delete_loan_review.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toaste").show();
load();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toaste").hide();
}, 6000);
}else{
alert (data)
}
}
});
}else{
alert (data)
}
}
});
});
</script>