<?php 
require '../config/db.php';
$id = $_GET['id']; // reg id
// 
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$reg_status = $row['Status'];
$bvn = $row['BVN'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
//active repayment
$Query = "SELECT * FROM repayments WHERE Reg_id = '$regid' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$rep = mysqli_fetch_array($result);
if($rep == null){
$repid = 0;
$total_loan = 0;
$bal = 0;
}else{
$repid = $rep['id'];
$total_loan = $rep['Total_Loan'];
$bal = $rep['Total_Bal'];
}
?>

<div class="row">
<div class="col-sm-3">
<br>
<center>
<img src="<?php echo $row['Location']; ?>" class="rounded-circle" width="200" height="200px"><br><br>
<h4><b style="text-transform:capitalize"><?php echo $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; ?></b></h4>
<p class="text-secondary mb-1">[ <?php echo $row['Status']; ?> ]</p><br>
<button class="btn btn-outline-success btn-sm w-100" style="font-size: 12px; margin-top:5px" onclick="customerInfo()">Customer Info</button>
<button class="btn btn-outline-info btn-sm w-100" style="font-size: 12px; margin-top:5px" onclick="customerLoan()">Loan History</button>
<button class="btn btn-outline-warning btn-sm w-100" style="font-size: 12px; margin-top:5px" onclick="customerGua()">Gaurantor Info</button>
<button class="btn btn-outline-primary btn-sm w-100" style="font-size: 12px; margin-top:5px" onclick="customerCRC()">CRC Report</button>
<button class="btn btn-outline-info btn-sm w-100" style="font-size: 12px; margin-top:5px;" onclick="customerBiz()">Document & Business Gallery</button>
</center>
</div>
<div class="col-sm-9">

<div id="client" style="display:block;">
<br>
<br>
<h5><i class="fa fa-user"></i> CUSTOMER PROFILE</h5>
<br>
<b>Status:
<?php 
include '../config/db.php';
$sql = "SELECT COUNT(*) AS overs FROM register WHERE BVN = '$bvn'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
if($over > 1){
echo "Existing Customer";
}else{
echo "New Customer";
}
?>
</b>
<br>
<br>
<div class="row">
<div class="col-sm-6">
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
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Virtual Acct:</b>  <?php echo $row['Virtual_Account']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Birthday Month:</b>  <?php echo $row['Birthday_Month']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Marital Status:</b>  <?php echo $row['Maritial_Status']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Group:</b>  <?php echo $row['Unions']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>BVN:</b>  <?php echo $row['BVN']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>State:</b>  <?php echo $row['State']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Town:</b>  <?php echo $row['Town']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Credit Officer:</b>  <?php echo $row['Officer_Name']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Team Lead:</b>  <?php echo $row['Team_Name']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Date Registered:</b>  <?php echo $row['Date_Reg']; ?></span>
</div>
</div>
<br>

</div>

</div>
</div>





<div class="row">
<div class="col-sm-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Product:</b>  <?php echo $row['Product']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Frequency:</b>  <?php echo $row['Frequency']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Tenure:</b>  <?php echo $row['Tenure']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Rate:</b>  <?php echo $row['Rate']; ?>%</span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Amount:</b>  <?php echo number_format($row['Loan_Amount'],2); ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Repayment Amt:</b>  <?php echo number_format($row['Repayment_Amt'],2);; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Interest Amount:</b>  <?php echo number_format($row['Interest_Amt'],2); ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Total Loan:</b>  <?php echo number_format($row['Total_Loan'],2);; ?></span>
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
<span style="margin-left:8px;"><b>Bank:</b>  <?php echo $row['Bank']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Acct No:</b>  <?php echo $row['Account_No']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Acct Name:</b>  <?php echo $row['Account_Name']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Amt Recieved:</b>  <?php echo number_format($row['Loan_Amount'],2); ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Approved By:</b>  <?php echo $row['Approved_By']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Disbursed By:</b>  <?php echo $row['Disbursed_By']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Date Disbursed:</b>  <?php echo $row['Date_Disbursed']; ?></span>
</div>
</div>
<br>

</div>

</div>
</div>

<table>
<thead>
<tr>
<th style="font-size:8px">BUSSINESS</th>
<th style="font-size:8px">TYPE</th>
<th style="font-size:8px">STATE</th>
<th style="font-size:8px">START DATE</th>
<th style="font-size:8px">OWNERSHIP</th>
<th style="font-size:8px">ADDRESS</th>
</tr>
</thead>
<tbody>
<tr>
<td ><?php echo $row['Business']; ?></td>
<td ><?php echo $row['Biz_Type']; ?></td>
<td ><?php echo $row['Biz_State']; ?></td>
<td ><?php echo $row['Start_Date']; ?></td>
<td ><?php echo $row['Shop_Owner']; ?></td>
<td ><?php echo $row['Biz_Address']; ?></td>
</tr>
</tbody>
</table>



</div>

<div id="gua" style="display:none;">
<br>
<br>
<h5><i class="fa fa-user"></i> GAURANTOR INFO</h5>
<br>

<div class="row">
<div class="col-sm-6">
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
<span style="margin-left:8px;"><b>Gaurantor ID:</b>  <?php echo $rows['id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Reg ID:</b>  <?php echo $row['id']; ?></span>
</div>
</div>
<br>
</div>



</div>
<div class="col-sm-6">
<br><br>
<div class="card border-primary border border-dashed">
<br>
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
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $rows['Address']; ?></span>
</div>
</div>
<br>
</div>

</div>
</div>

<b>Gaurantor List</b>
<div id="table-container" style="height:195px;">
<table>
<thead>
<tr style="font-size:8px;">
<th>NIN</th>
<th>NAME</th>
<th>GENDER</th>
<th>PHONE</th>
<th>RELATIONSHIP</th>
<th>OCCUPATION</th>
<th>CLIENT BVN</th>
</tr>
</thead>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT Gaurantor_BVN, Firstname, Lastname, Middlename, Gender, Phone, Relationship, Occupation, Client_BVN FROM gaurantors WHERE Client_BVN = '$bvn'
ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$gbvn = $rows['Gaurantor_BVN'];
$name = $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname'];
$gen = $rows['Gender'];
$ph = $rows['Phone'];
$rel = $rows['Relationship'];
$ocu = $rows['Occupation'];
$clbvn = $rows['Client_BVN'];
?>
<td><?php echo $gbvn; ?></td>
<td><?php echo $name; ?></td>
<td><?php echo $gen; ?></td>
<td><?php echo $ph; ?></td>
<td><?php echo $rel; ?></td>
<td><?php echo $ocu; ?></td>
<td><?php echo $clbvn; ?></td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo" No Record Found";       
}
?>
</table>
</div>

</div>


<div id="crc" style="display:none;">
<br>
<br>
<h5><i class="fa fa-file"></i> CRC REPORT</h5>
<br>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT id, Location FROM document WHERE BVN = '$bvn' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bn = $rows['id'];
$crc = $rows['Location'];
?>
<embed src="<?php echo $crc; ?>" type="application/pdf" width="100%" height="430px" />.
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo " No CRC Report Found  <br/> ";        
}
?>





</div>







<div id="loan" style="display:none;">
<br>
<br>
<h5><i class="fa fa-list"></i> LOAN HISTORY</h5>
<br>
<b><i class="fa fa-star"></i> Recent Loan</b>
<hr>
<div class="row">
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<span class="float-end fw-semibold"><?php echo number_format($total_loan,2)?></span>
<div class="d-flex align-items-end gap-3">
<div class="avatar avatar-sm bg-pink-subtle">
<i class="fa fa-star"></i>
</div>
<div>
<h6 class="mb-1">Total Loan</h6>
<p class="mb-0 text-muted">Principal & Interest</p>
</div>
</div>

</div>
</div>
</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<span class="float-end fw-semibold">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
//public sector
$result = mysqli_query($con, "SELECT SUM(Amount) AS overs FROM history WHERE Register_id = '$regid' AND Status = 'Paid'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo number_format($total,2);
?>
</span>
<div class="d-flex align-items-end gap-3">
<div class="avatar avatar-sm bg-pink-subtle">
<i class="fa fa-star"></i>
</div>
<div>
<h6 class="mb-1">Amount Paid</h6>
<p class="mb-0 text-muted">Total Repayment Paid</p>
</div>
</div>

</div>
</div>
</div>
<div class="col-sm-4">
<div class="card">
<div class="card-body">
<span class="float-end fw-semibold">
<?php 
include '../config/db.php';
$d = date('Y-m-d');
//public sector
$result = mysqli_query($con, "SELECT SUM(Amount) AS overs FROM history WHERE Register_id = '$regid' AND Status = 'Paid'");
$row = mysqli_fetch_array($result);
$total = $row[0];
$balance = $total_loan - $total;
echo number_format($balance,2);
?>
</span>
<div class="d-flex align-items-end gap-3">
<div class="avatar avatar-sm bg-pink-subtle">
<i class="fa fa-star"></i>
</div>
<div>
<h6 class="mb-1">Outstanding</h6>
<p class="mb-0 text-muted">Loan Outstanding</p>
</div>
</div>
</div>
</div>
</div>

</div>
<hr>

<b><i class="fa fa-history"></i> Loan Cycle</b><br>
<div id="table-container" style="height:195px;">
<table>
<thead>
<tr style="font-size:8px;">
<th>LOAN ACCT</th>
<th>TOTAL LOAN</th>
<th>AMT PAID</th>
<th>OUTSTANDING</th>
<th>STATUS</th>
</tr>
</thead>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT Loan_Account_No, Total_Loan, Paid, Total_Bal, Status FROM repayments WHERE Reg_id = '$regid' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$loan_acct = $rows['Loan_Account_No'];
$total_loan = $rows['Total_Loan'];
$paid = $rows['Paid'];
$bal = $rows['Total_Bal'];
$st = $rows['Status'];
?>
<td><?php echo $loan_acct; ?></td>
<td><?php echo number_format($total_loan,2); ?></td>
<td><?php echo number_format($paid,2); ?></td>
<td><?php echo number_format($bal,2); ?></td>
<td><?php echo $st; ?></td>
</tr>
<?php
} 
}else {
      
}
?>
</table>
</div>


</div>




<div id="biz" style="display:none;">
<br>
<br>
<div class="row">
<div class="col-sm-9">
<h5><i class="fa fa-star"></i> DOCUMENT & BUSINESS GALLERY</h5>
</div>
<div class="col-sm-3">
<input type="number" class="form-control for-control-sm" hidden id="regid" value="<?php echo $regid; ?>">
<select class="form-control for-control-sm" id="document" oninput="getDocument()">
<option value="">Select Gallery</option>
<option value="Document">Document Gallery</option>
<option value="Business">Business Gallery</option>
</select>
</div>
</div>


<br><br>
<div id="documentview"></div>







</div>



</div>
</div>







<script>
function customerInfo(){
var a = document.getElementById("client");
var b = document.getElementById("gua");
var c = document.getElementById("loan");
var d = document.getElementById("biz");
var x = document.getElementById("crc");
a.style.display = 'block';
b.style.display = 'none';
c.style.display = 'none';
d.style.display = 'none';
x.style.display = 'none';
}

function customerLoan(){
var a = document.getElementById("client");
var b = document.getElementById("gua");
var c = document.getElementById("loan");
var d = document.getElementById("biz");
var x = document.getElementById("crc");
a.style.display = 'none';
b.style.display = 'none';
c.style.display = 'block';
d.style.display = 'none';
x.style.display = 'none';
}


function customerGua(){
var a = document.getElementById("client");
var b = document.getElementById("gua");
var c = document.getElementById("loan");
var d = document.getElementById("biz");
var x = document.getElementById("crc");
a.style.display = 'none';
b.style.display = 'block';
c.style.display = 'none';
d.style.display = 'none';
x.style.display = 'none';
}


function customerBiz(){
var a = document.getElementById("client");
var b = document.getElementById("gua");
var c = document.getElementById("loan");
var d = document.getElementById("biz");
var x = document.getElementById("crc");
a.style.display = 'none';
b.style.display = 'none';
c.style.display = 'none';
x.style.display = 'none';
d.style.display = 'block';
}



function customerCRC() {
var a = document.getElementById("client");
var b = document.getElementById("gua");
var c = document.getElementById("loan");
var d = document.getElementById("biz");
var x = document.getElementById("crc");
a.style.display = 'none';
b.style.display = 'none';
c.style.display = 'none';
d.style.display = 'none';
x.style.display = 'block';
}


</script>



<script type="text/javascript">
function getDocument()  {
var regid = document.getElementById("regid").value;
var document_type = document.getElementById("document").value;
// ajax function start here
$.ajax({
method: "POST",
url: "gallery_type_bck.php",
dataType: "html",  
data: {
'regid': regid,
'document_type': document_type
},
success:function(data){
setTimeout(function(){
$('#documentview').html(data);
}, 100);
}
});
// ajax function ends here
}
</script>