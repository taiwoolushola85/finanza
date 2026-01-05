<?php 
$gr = $_POST['gr'];// saving type
?>

<?php 
if($gr == 'Express'){
// code for express saving type
?>


<br>
<br>
<br>
<br>
<br>
<b>
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 5C2 4.44772 2.44772 4 3 4H8.66667H21C21.5523 4 22 4.44772 22 5V8H15.3333H8.66667H2V5Z" fill="currentColor" stroke="currentColor" />
<path d="M6 8H2V11M6 8V20M6 8H14M6 20H3C2.44772 20 2 19.5523 2 19V11M6 20H14M14 8H22V11M14 8V20M14 20H21C21.5523 20 22 19.5523 22 19V11M2 11H22M2 14H22M2 17H22M10 8V20M18 8V20" stroke="currentColor" />
</svg>
Customer's List
</b>
<br>
<br>
<div style="display:none;">
</div>
<div class="row">
<div class="col-sm-3">
<?php 
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$sql = "SELECT COUNT(*) AS overs FROM savings WHERE User = '$User' AND Status = 'Active'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo "Total Record: ".$over;
?>
</div>
</div>

<br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Reg_id, Firstname, Middlename, Lastname, Unions, Loan_Account_No, Savings_Account_No, Product, Balance, Status, Date_Opend
FROM savings WHERE User = '$User' AND Status = 'Active' ORDER BY Firstname ASC ") or die("Bad Query.");


mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/express.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-responsive" style="overflow: auto; height:300px; font-size:9px">
<table>
<thead>
<tr style="font-size:8px" id="table1"> 
<th>LOAN ACCT NO</th> 
<th>SAVING ACCT NO</th> 
<th>ACCOUNT NAME</th> 
<th>GROUP</th> 
<th>PRODUCT</th> 
<th>SAVINGS</th> 
<th>STATUS</th> 
<th>DATE OPENED</th> 
</tr> 
<tbody>
<?php
$url = '../data/express.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr  class="invks" data-bs-toggle="modal" data-bs-target="#updateModal" id="<?php echo $member->id?>">
<td class="sort border-top"><?php echo $member->Loan_Account_No?></td>
<td class="sort border-top"><?php echo $member->Savings_Account_No?></td>
<td class="sort border-top" style="text-transform: uppercase;"><?php echo $member->Firstname ." ". $member->Middlename ." ". $member->Lastname?></td>
<td class="sort border-top" ><?php echo $member->Unions?></td>
<td class="sort border-top" ><?php echo $member->Product?></td>
<td class="sort border-top" ><?php echo number_format($member->Balance,2) ?></td>
<td class="sort border-top" ><?php echo $member->Status?></td>
<td class="sort border-top">
<?php 
$date=date_create($member->Date_Opend);
echo date_format($date,"d-M-Y");
?>    
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
</div> 





<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm" style="display:none; width:400px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" style="font-size:15px; text-transform:uppercase">EXPRESS POSTING FORM</h6>
<button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<center>
<p><img src="" id="customerImg" style="height: 100px; width:100px; border-radius:50px;" class="img-thumbnail" /></p>
[ <b id="des"></b> ]<br><br>
</center>
<form action="" method="POST" enctype="multipart/form-data" id="updateForm"> 
<div class="row">
<div class="col-sm-12">
<label class="form-label"><i style="color: red;">*</i> Enter Saving</label>
<input type="text" name="id" class="form-control" id="stid" hidden required>
<input type="text" name="tba" class="form-control" id="tba" hidden required>
<input type="number" name="sa"  class="form-control" placeholder="Enter Saving">
</div>
<div class="col-sm-12" id="reciept" style="margin-top:10px">
<label style="font-size:13px"><i style="color:red">*</i> Upload Reciept</label>
<input type="file" class="form-control form-control-md" id="furls" required name="Pic" >
</div>
</div>
<br>
<button type="submit" disabled class="btn btn-outline-success btn-sm" style="float:left;">Post Saving</button>
</form>
</div>
</div>
</div>
</div>


<div class="modal" id="please" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-sm">
<div class="modal-content">
<div class="modal-body">
<center>
<i>
<img src="loader.gif" style="height:20px"> Processing Transaction! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.invks').on('click', function() {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'saving_pick.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
$('#stid').val(data.cusId);
$('#des').text(data.cusName);
$('#tba').val(data.cusBal);
$('#customerImg').attr('src', data.photo || 'https://via.placeholder.com/150');
}
});
}else{
alert ("🚫" + data)
}
});
});
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#updateForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to make posting for this client..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "express_saving_posting.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){ 
$('#updateForm')[0].reset()
if(data==11){
$("#please").hide();
alert("🚫 Amount entered is higher than loan balance");
}else if(data==7){
$("#please").hide();
alert(" 🚫 Payment reciept size is greater than 2MB !..");
location.reload(true);
}else if(data==4){
$("#please").hide();
alert(" 🚫 You have already posted saving for a client in this group for today. Please check..");
}else if(data==8){
$("#please").hide();
alert(" 🚫 You attempting to make a double posting on a client savings account, please check..");
}else if(data==9){
$("#please").hide();
alert(" 🚫 You attempting to make a double posting on a client repayment, please check..");
}else if(data==10){
$("#please").hide();
alert(" 🚫 You have already done posting for a client in this group for today. Please try again..");
}else if(data==20){
$("#please").hide();
alert(" 🚫 Do not enter zero for repayments amount, instead leave the field empty");
}else if(data==21){
$("#please").hide();
alert(" 🚫 Do not enter zero for savings amount, instead leave the field empty");
}else if(data==15){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
alert(data);
$("#please").hide();
}
},
error: function(){
}
});
}
}));
});
</script>




<?php 
}else if ($gr == 'Flexi'){
// code for flexi saving type
?>





<br>
<br>
<br>
<br>
<br>
<b>
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 5C2 4.44772 2.44772 4 3 4H8.66667H21C21.5523 4 22 4.44772 22 5V8H15.3333H8.66667H2V5Z" fill="currentColor" stroke="currentColor" />
<path d="M6 8H2V11M6 8V20M6 8H14M6 20H3C2.44772 20 2 19.5523 2 19V11M6 20H14M14 8H22V11M14 8V20M14 20H21C21.5523 20 22 19.5523 22 19V11M2 11H22M2 14H22M2 17H22M10 8V20M18 8V20" stroke="currentColor" />
</svg>
Customer's List
</b>
<br>
<br>
<div style="display:none;">
</div>
<div class="row">
<div class="col-sm-3">
<?php 
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$sql = "SELECT COUNT(*) AS overs FROM flexi_account WHERE User = '$User' AND Status = 'Active'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo "Total Record: ".$over;
?>
</div>
</div>

<br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Firstname, Surname, Othername, Plan, Flexi_Account_No, Frequency, Total_Bal, Status, Date_Start
FROM flexi_account WHERE User = '$User' AND Status = 'Active' ORDER BY Surname ASC ") or die("Bad Query.");


mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/flexi.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-responsive" style="overflow: auto; height:300px; font-size:9px">
<table>
<thead>
<tr style="font-size:8px" id="table1"> 
<th>FLEXI ACCT NO</th> 
<th>ACCOUNT NAME</th> 
<th>PLAN</th> 
<th>FREQUENCY</th> 
<th>BALANCE</th> 
<th>STATUS</th> 
<th>DATE START</th> 
</tr> 
<tbody>
<?php
$url = '../data/flexi.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr  class="invks" data-bs-toggle="modal" data-bs-target="#updateModal" id="<?php echo $member->id?>">
<td class="sort border-top"><?php echo $member->Flexi_Account_No?></td>
<td class="sort border-top" style="text-transform: uppercase;"><?php echo $member->Surname ." ". $member->Firstname ." ". $member->Othername?></td>
<td class="sort border-top" ><?php echo $member->Plan?></td>
<td class="sort border-top" ><?php echo $member->Frequency?></td>
<td class="sort border-top" ><?php echo number_format($member->Total_Bal,2) ?></td>
<td class="sort border-top" ><?php echo $member->Status?></td>
<td class="sort border-top">
<?php 
$date=date_create($member->Date_Start);
echo date_format($date,"d-M-Y");
?>    
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
</div> 





<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm" style="display:none; width:400px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" style="font-size:15px; text-transform:uppercase">FLEXI POSTING FORM</h6>
<button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<center>
<p><img src="" id="fcustomerImg" style="height: 100px; width:100px; border-radius:50px;" class="img-thumbnail" /></p>
[ <b id="fdes"></b> ]<br><br>
</center>
<form action="" method="POST" enctype="multipart/form-data" id="updateFlexi"> 
<div class="row">
<div class="col-sm-12">
<label class="form-label"><i style="color: red;">*</i> Enter Saving</label>
<input type="text" name="id" class="form-control" id="fstid" hidden required>
<input type="text" name="tba" class="form-control" id="ftba" hidden required>
<input type="number" name="sa"  class="form-control" placeholder="Enter Saving" required>
</div>
<div class="col-sm-12" id="reciept" style="margin-top:10px">
<label style="font-size:13px"><i style="color:red">*</i> Upload Reciept</label>
<input type="file" class="form-control form-control-md" id="furls" required name="Pic" >
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" style="float:left;">Post Saving</button>
</form>
</div>
</div>
</div>
</div>


<div class="modal" id="please" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-sm">
<div class="modal-content">
<div class="modal-body">
<center>
<i>
<img src="loader.gif" style="height:20px"> Processing Transaction! Please wait...
</i>
</center>
</div>
</div>
</div>
</div>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.invks').on('click', function() {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'flexi_pick.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
$('#fstid').val(data.cusId);
$('#fdes').text(data.cusName);
$('#ftba').val(data.cusBal);
$('#fcustomerImg').attr('src', data.cusLoc || 'https://via.placeholder.com/150');
}
});
}else{
alert ("🚫" + data)
}
});
});
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#updateFlexi").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to make posting for this client..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "flexi_saving_posting.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){ 
$('#updateFlexi')[0].reset()
if(data==11){
$("#please").hide();
alert("🚫 Amount entered is higher than loan balance");
}else if(data==7){
$("#please").hide();
alert(" 🚫 Payment reciept size is greater than 2MB !..");
location.reload(true);
}else if(data==4){
$("#please").hide();
alert(" 🚫 You have already posted saving for a client in this group for today. Please check..");
}else if(data==8){
$("#please").hide();
alert(" 🚫 You attempting to make a double posting on a client savings account, please check..");
}else if(data==9){
$("#please").hide();
alert(" 🚫 You attempting to make a double posting on a client repayment, please check..");
}else if(data==10){
$("#please").hide();
alert(" 🚫 You have already done posting for a client in this group for today. Please try again..");
}else if(data==20){
$("#please").hide();
alert(" 🚫 Do not enter zero for repayments amount, instead leave the field empty");
}else if(data==21){
$("#please").hide();
alert(" 🚫 Do not enter zero for savings amount, instead leave the field empty");
}else if(data==15){
setTimeout(function(){
$("#please").hide();
$("#toasts").css("display", "block");
$("#toasts").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
alert(data);
$("#please").hide();
}
},
error: function(){
}
});
}
}));
});
</script>





<?php 
}else{
echo "<span style='color:red'><i class='fa fa-exclamation-triangle'></i> Invalid saving type selected.</span>";
}
?>