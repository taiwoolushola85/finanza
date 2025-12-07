<div>
<b><i class="fa fa-table"></i> Active Customer Table</b>
<br><br>

<div class="row">
<div class="col-sm-3">
<?php 
include '../config/db.php';
include '../config/user_session.php';
// Validate input
if (!isset($_POST['gr']) || empty($_POST['gr'])) {
echo "<div class='text-danger'>Group not selected.</div>";
exit;
}

$gr = $_POST['gr'];

// Prepare statement - count records
$stmt = $con->prepare("SELECT COUNT(*) AS overs FROM repayments WHERE Union_id = ? AND Status = 'Active' AND Recovery_Status = 'No'");
$stmt->bind_param("s", $gr);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$over = $data['overs'];
echo "Total Records: <span>$over</span>";
$stmt->close();
?>
</div>
</div>

<br>

<?php
$d = date('Y-m-d');
// Fetch repayment list
$stmt = $con->prepare("SELECT id, Firstname, Middlename, Lastname, Unions, Loan_Account_No, Product, Expected_Amount, Paid, Total_Loan, Total_Bal, Signed_Date, 
Maturity_Date, Maturity_Status FROM repayments WHERE User = ? AND Union_id = ? AND Status = 'Active' AND Recovery_Status = 'No' ORDER BY id ASC");
$stmt->bind_param("ss", $User, $gr);
$stmt->execute();
$result = $stmt->get_result();
?>

<div id="table-container" style="height:350px;">
<table>
<thead>
<tr>
<th style="font-size:8px">LOAN ACCT NO</th> 
<th style="font-size:8px">ACCOUNT NAME</th> 
<th style="font-size:8px">GROUP</th> 
<th style="font-size:8px">PRODUCT</th> 
<th style="font-size:8px">TOTAL LOAN</th> 
<th style="font-size:8px">AMOUNT PAID</th> 
<th style="font-size:8px">EXPECTED AMT</th> 
<th style="font-size:8px">BALANCE</th> 
<th style="font-size:8px">EXPIRED DATE</th> 
<th style="font-size:8px">LOAN STATUS</th> 
</tr> 
</thead>

<tbody>
<?php while ($member = $result->fetch_assoc()) { ?>
<tr style="font-size:8px" class="invks" data-bs-toggle="modal" data-bs-target="#updateModal" id="<?php echo $member['id']; ?>">
<td><?php echo $member['Loan_Account_No']; ?></td>
<td style="text-transform:uppercase;">
<?php echo $member['Firstname']." ".$member['Middlename']." ".$member['Lastname']; ?>
</td>
<td><?php echo $member['Unions']; ?></td>
<td><?php echo $member['Product']; ?></td>
<td><?php echo number_format($member['Total_Loan'], 2); ?></td>
<td><?php echo number_format($member['Paid'], 2); ?></td>
<td><?php echo number_format($member['Expected_Amount'], 2); ?></td>
<td><?php echo number_format($member['Total_Bal'], 2); ?></td>
<td><?php $date = date_create($member['Maturity_Date']);
echo date_format($date, "d-M-Y");
?>
</td>
<td>
<?php 
if ($member['Maturity_Date'] < $d) {
echo "<span style='color:red'>Expired</span>";
} else {
echo "<span style='color:green'>Running</span>";
}
?>
</td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

</div>


<div class="modal" id="updateModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-md" style="display:none; width:400px; display: flex !important; align-items: center; justify-content: center;">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" style="font-size:12px; text-transform:uppercase"> [ <span id="des"></span> ] Posting Form</h6>
<button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<span id="man"></span>
<center>
<p><img src="" id="reciept" style="height: 350px; width:350px; border-radius:5px;" class="img-thumbnail"  /></p>
</center>
<form action="" method="POST" enctype="multipart/form-data" id="reciptUpload"> 
<div class="col-sm-12" id="reciept" style="margin-top:10px">
<label style="font-size:13px"><i style="color:red">*</i> Upload Reciept</label>
<input type="file" class="form-control form-control-sm" name="Pic" id="receiptFile" required="required" onchange="loadClient(event)" accept="image/*">
</div>
<div class="row">
<div class="col-sm-12">
<label class="form-label"><i style="color: red;">*</i> Enter Repayment</label>
<input type="text" name="id" class="form-control" id="stid" hidden required>
<input type="text" name="tba" class="form-control" id="tba" hidden required>
<input type="number" name="am" class="form-control" placeholder="Enter Repayment Amount">
</div>
<div class="col-sm-12">
<label class="form-label"><i style="color: red;">*</i> Enter Savings</label>
<input type="number" name="sa" class="form-control" placeholder="Enter Saving Amount">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" style="float:left;">Post Repayment</button>
</form>
</div>
</div>
</div>
</div>

<script>
var loadClient = function(event) {
var image = document.getElementById('reciept');
if (event.target.files && event.target.files[0]) {
image.src = URL.createObjectURL(event.target.files[0]);
}
};
</script>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.invks').on('click', function() {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'rep_pick.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
$('#stid').val(data.cusId);
$('#des').text(data.cusName);
$('#tba').val(data.cusBal);
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
$("#reciptUpload").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to submit this repayment posting for approval..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "repayment_posting_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$('#reciept').attr('src', '');
$("#reciptUpload")[0].reset();
if(data == 1){
$("#please").hide();
alert("🚫 Do not put zero as an amount for repayments amount..");
}else if (data == 2){
$("#please").hide();
alert("🚫 Do not put zero as an amount for saving amount..");   
}else if (data == 3){
$("#please").hide();
alert("🚫 Reciept size is more than 5MB, Please crop the image..");   
}else if (data == 4){
$("#please").hide();
alert("🚫 You have posted repayment for this customer today. please try again next day.");   
}else if (data == 5){
$("#please").hide();
alert("🚫 This customer has a pending repayment posted waiting for approval. please confirm from your lead");   
}else if (data == 6){
$("#please").hide();
alert("🚫 You have posted saving for this customer today. please try again next day.");   
}else if (data == 7){
$("#please").hide();
alert("🚫 This customer has a pending savings posted waiting for approval. please confirm from your lead");  
}else if (data == 8){
$("#please").hide();
alert("🚫 The amount you entered is higher than the customer current loan balance");  
}else if (data == 9){
$("#please").hide();
alert("🚫 You are not allowed to post only savings, for this customer. please include the repayment amount.");   
}else if(data == 10){
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

