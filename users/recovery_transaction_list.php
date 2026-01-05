
<?php 
$d = date('Y-m-d');
include '../config/db.php';
$username = $_GET['id'];
$Query = "SELECT Location, Name, Phone, Branch FROM users WHERE Username = '$username'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$img = $row['Location'];
$name = $row['Name'];
$ph = $row['Phone'];
$branch = $row['Branch'];
?>
<br>

<div class="row" >
<div class="col-sm-9" style="margin-top: 10px;">
<div class="row" >
<div class="col-sm-2">
<center>
<img src="<?php echo $img; ?>" alt="" class="img-fluid rounded-pill avatar-5" loading="lazy" style="width:100px; height:100px">
</center>
</div>
<div class="col-sm-10">
<i>[ Credit Officer Information ]</i>
<hr>
<div class="row" >
<div class="col-5">
<small><b>Name:</b> <?php echo $name; ?></small>
</div>
<div class="col-5">
<small><b>Phone:</b> <?php echo $ph; ?></small>
</div>
</div>
<div class="row" >
<div class="col-5">
<small><b>Branch:</b> <?php echo $branch; ?></small>
</div>
</div>
</div>

</div>




<hr>
<h5><b>Repayments Posting</b></h5><hr>
<div class="row" >
<div class="col-sm-3" style="margin-top: 10px;">
<div class="d-grid gap-2">
<button type="button" class="btn btn-outline-success btn-sm btn-block" id="approve">Approve Transactions</button>
</div>
</div>
<div class="col-sm-3" style="margin-top: 10px;">
<div class="d-grid gap-2">
<button type="button" class="btn btn-outline-danger btn-sm btn-block" id="decline">Decline Transactions</button>
</div>
</div>
</div>
<br>
<div class="row" id="cnt">
<div class="col-sm-3">
<?php 
include '../config/db.php';
$username = $_GET['id'];
$sql = "SELECT COUNT(*) AS overs FROM recover WHERE User = '$username' AND Status = 'Waiting For Approval'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo "Total Clients: ".$over;
mysqli_close($con);
?>
</div>
<div class="col-sm-3">
<?php 
include '../config/db.php';
$username = $_GET['id'];
$sql = "SELECT COALESCE(SUM(Amount), 0) AS overs FROM recover WHERE User = '$username' AND Status ='Waiting For Approval' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo "Total Repayment: ".number_format($over,2);
mysqli_close($con);
?>
</div>
<div class="col-sm-3">
<?php 
echo "Total Posting: ".number_format($over + 0,2);
?>
</div>

</div>

<br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$username = $_GET['id'];// username
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Name, Unions, Product, Amount, Payment_Method, Reciept, Officer_Name, Date_Pay, Time_Pay FROM recover 
WHERE User = '$username' AND Status = 'Waiting For Approval' ORDER BY Time_Pay ASC") or die("Bad Query.");


mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/recovery_postings.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-responsive" style="overflow: auto; height:250px;">
<table>
<thead>
<tr style="font-size:8px">
<th>MARK</th>
<th>NAME</th>
<th>PRODUCT</th>
<th>AMOUNT</th>
<th>DATE</th>
<th>TIME</th>
<th>RECIEPT</th>
</tr>
<tbody>
<?php
$url = '../data/recovery_postings.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td><input type="checkbox" class="emp_checkbox" name="id[]" value="<?php echo $member->id; ?>" ></td>
<td class="sort border-top" style="text-transform:uppercase"><?php echo $member->Name?></td>
<td class="sort border-top" style="text-transform:uppercase"><?php echo $member->Product?></td>
<td class="sort border-top" ><?php echo number_format($member->Amount,2)?></td>
<td class="sort border-top" >
<?php 
$date=date_create($member->Date_Pay);
echo date_format($date,"d-M-Y");
?>
</td>
<td class="sort border-top" style="text-transform:uppercase"><?php echo $member->Time_Pay?></td>
<td class="sort border-top" >
<?php
if ($member->Payment_Method == 'Cash Payment'){
?>  
<span>No Reciept</span></td>
<?php 
}else{
?>  
<a href="#" class = "invk" data-toggle="modal" data-target="#recieptdata" id="<?php echo $member->id?>">View Reciept</a>
<?php 
}
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
<div class="col-sm-3" style="margin-top: 10px;">
<center>
<img src="" alt="" id="recp" style="height:520px" width="300px" class="img-thumbnail">
</center>
</div>
</div>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.invk').on('click', function() {
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'recovery_reciept.php',
type: "POST",
data: {'id':recID},
dataType: "json",
success:function(data) {
$('#recp').val(data.recieptLocation);
$("#recp").attr("src",data.recieptLocation);
}
});
}else{
$('#full').empty();
$('#hid').empty();
$('#hidd').empty();
$('#samt').empty();
}
});
});
</script>



<script type="text/javascript">
$("#approve").on('click', function () {
WRN_PROFILE_DELETE = "Are you sure you want to approve this transactions.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
var ids = [];
$(".emp_checkbox").each(function () {
if ($(this).is(":checked")) {
ids.push($(this).val());
}
});
if (ids.length) {
$("#approve").attr("disabled", true);
$("#decline").attr("disabled", true);
$.ajax({
type: 'POST',
url: "recovery_repayment_approval.php",
data: {id: ids},
success:function (data) {
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
loads();
load();
}, 6000);
}
});
} else {
$("#please").hide();
$("#updateModal").modal('show');
alert("Please mark transaction to approve.");
}
}
});
</script>



<script type="text/javascript">
$("#decline").on('click', function () {
WRN_PROFILE_DELETE = "Are you sure you want to decline this transactions.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var ids = [];
$(".emp_checkbox").each(function () {
if ($(this).is(":checked")) {
ids.push($(this).val());
}
});
if (ids.length) {
$.ajax({
type: 'POST',
url: 'recovery_posting_decline.php',
data: {id: ids},
success:function (data) {
setTimeout(function(){
loads();
load();
}, 10);
}
});
} else {
$("#dece").hide();
$("#updateModal").modal('show');
alert("Please mark transaction to decline.");
}
}
});
</script>


<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "transaction_list.php?id=<?php echo $username; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 
