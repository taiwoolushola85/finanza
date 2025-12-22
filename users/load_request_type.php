<?php 
$types = $_GET['types'];
//echo $types;
include '../config/user_session.php';
?>

<div class="row">
<div class="col-sm-4">
<b>Withdrawal Request: 
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM withdraw WHERE Status = 'Processing' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</b>
</div>
<div class="col-sm-4">
<b>Savings For Repayment Request:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM saving_rep WHERE Status = 'Processing' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
?>
</b>
</div>
<div class="col-sm-4">
<b>Total Request:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT COUNT(*) FROM withdraw WHERE Status = 'Processing' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total1 = $row[0];
//
$result = mysqli_query($con, "SELECT COUNT(*) FROM saving_rep WHERE Status = 'Processing' AND Team_Leader ='$User'");
$row = mysqli_fetch_array($result);
$total2 = $row[0];
echo $total1 + $total2;
?>
</b>
</div>
</div>



<br>
<br>
<?php
//
if($types == "Withdraw"){
?>

<div style="overflow-y:auto; height:300px;">
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';

$result = mysqli_query($con, "SELECT id, Saving_Account_No, Firstname, Middlename, Lastname, Unions, Amount_Withdraw, Date_Withdraw, Status, Officer_Name,
Loan_Account_No FROM withdraw WHERE Team_Leader = '$User' AND Status= 'Processing' ORDER BY Firstname ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/team_withdraw_saving.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-responsive">
<table>
<thead>
<tr> 
<th style="font-size:8px">SAVINGS ACCT NO</th>
<th style="font-size:8px">LOAN ACCT</th>
<th style="font-size:8px">ACCOUNT NAME</th>
<th style="font-size:8px">GROUPS</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">INITATED BY</th>
<th style="font-size:8px">DATE REQUESTED</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
$url = '../data/team_withdraw_saving.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px; text-transform:capitalize">
<td ><?php echo $member->Saving_Account_No?></td>
<td ><?php echo $member->Loan_Account_No?></td>
<td style="text-transform:capitalize"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
<td><?php echo $member->Unions?></td>
<td><?php echo number_format($member->Amount_Withdraw,2)?></td>
<td><?php echo $member->Officer_Name?></td>
<td ><?php echo date("d-M-Y", strtotime($member->Date_Withdraw))?></td>
<td ><?php echo $member->Status?></td>
<td>
<a class="invk" href="#!" data-bs-toggle="modal" data-bs-target="#updateModals" data-id="<?php echo $member->id; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>







<?php 
}else if($types == "Repayment"){
?>

<div style="overflow-y:auto; height:300px">
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';

$result = mysqli_query($con, "SELECT id, Reg_id, Saving_Account_No, Loan_Account_No, Reciever_Loan_No, Firstname, Middlename, Lastname, Unions, Amount, Date_Sent, 
Status, Officer_Name FROM saving_rep WHERE Team_Leader = '$User' AND Status = 'Processing' ORDER BY Firstname ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/team_rep_saving.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-responsive">
<table>
<thead>
<tr> 
<th style="font-size:8px">SENDER SAVINGS ACCT</th>
<th style="font-size:8px">SENDER LOAN ACCT</th>
<th style="font-size:8px">ACCOUNT NAME</th>
<th style="font-size:8px">GROUPS</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">RECIEVER LOAN ACCT</th>
<th style="font-size:8px">DATE REQUESTED</th>
<th style="font-size:8px">INITIATED BY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
$url = '../data/team_rep_saving.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px; text-transform:capitalize">
<td><?php echo $member->Saving_Account_No?></td>
<td><?php echo $member->Loan_Account_No?></td>
<td style="text-transform:capitalize"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
<td><?php echo $member->Unions?></td>
<td ><?php echo number_format($member->Amount,2)?></td>
<td><?php echo $member->Reciever_Loan_No?></td>
<td ><?php echo date("d-M-Y", strtotime($member->Date_Sent))?></td>
<td><?php echo $member->Officer_Name?></td>
<td><?php echo $member->Status?></td>
<td>
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $member->id; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>




<?php 
}else{
echo "<i style='color:red'>No request selected from the option provided</i>"; 
}
?>








<script>
// Display data in modal
$(document).ready(function() {
$('.invk').on('click', function(e) {e.preventDefault();
$("#updateModals").hide();
$("#view").show();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'client_saving_withdraw_page.php',
type: "GET",
data: {'id': id},
success: function(data) { 
setTimeout(function() {
$("#updateModals").show();
$("#view").hide();
$('#profiles').html(data);
}, 1000);
},
error: function(xhr, status, error) {
alert('Error loadingrequest page : ' + error);
$("#view").hide();
}
});
} else {
alert('Invalid ID');
$("#view").hide();
}
});
});
</script>



<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'client_saving_repayment_page.php',
type: "GET",
data: {'id': id},
success: function(data) { 
setTimeout(function() {
$("#updateModal").show();
$("#view").hide();
$('#profile').html(data);
}, 1000);
},
error: function(xhr, status, error) {
alert('Error loadingrequest page : ' + error);
$("#view").hide();
}
});
} else {
alert('Invalid ID');
$("#view").hide();
}
});
});
</script>

<script type="text/javascript">
function loads() {
$.ajax({
method: "GET",
url: "load_request_type.php",
data: { types: "<?php echo $types; ?>" },
dataType: "html",
success: function(data) {
setTimeout(function() {
$('#result').html(data);
}, 1000);
},
error: function(xhr, status, error) {
console.error("Load error: " + error);
}
});
}
</script> 

