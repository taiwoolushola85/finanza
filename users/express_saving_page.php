<?php 
include_once '../config/db.php';
include_once '../config/user_session.php';
$id = $_GET['id']; // saving id
// client saving info
$Query = "SELECT * FROM savings WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$savid = $row['id'];
$regid = $row['Reg_id'];
$clbvn = $row['Client_BVN'];
$sv = $row['Savings_Account_No'];
//
$Query = "SELECT * FROM repayments WHERE Reg_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$repid = $rows['id'];
$fr = $rows['Frequency'];
$loan = $rows['Loan_Account_No'];
$status = $rows['Status'];
$exp_amt = $rows['Expected_Amount'];
// register
$Query = "SELECT * FROM register WHERE id = '$regid'";
$result = mysqli_query($con, $Query);
$reg = mysqli_fetch_array($result);
$reg_id = $reg['id'];
$up = $reg['Upfront'];
?>

<center>
<img src="<?php echo $rows['Location']; ?>" alt="Header Avatar" class="img-fluid" style=" height:120px; width:120px; border-radius:100px">
<br><br>
<span style="font-size:15px; text-transform:capitalize">[ <?php echo $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname']; ?> ] </span>
<br><br>
<div class="btn-group">
<button class="btn btn-light" onclick="clickDash()"><i class="fa fa-star"></i> Profile</button>
<button class="btn btn-light" onclick="clickHis()"><i class="fa fa-list"></i> History</button>
<button class="btn btn-light" onclick="clickReq()"><i class="fa fa-plus"></i> Account Marging</button>
</div>
</center>
<br><br>

<div id="firsts" style="display:block;">

<div class="row">
<div class="col-sm-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Savings Account:</b> <?php echo $row['Savings_Account_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Reg ID:</b> <?php echo $row['Reg_id']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Balance:</b> <span id="mydivs"><?php echo number_format($row['Balance'],2); ?></span></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Phone:</b> <?php echo $row['Phone']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Team Lead:</b> <?php echo $row['Team_Name']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b> Credit Officer:</b> <?php echo $row['Officer_Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Status:</b> <?php echo $row['Status']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Initial Deposit:</b> 
<?php 
if($fr == 'Daily'){
?>
<?php echo number_format(0,2); ?>
<?php  
}else{
?>
<?php echo number_format($up,2); ?>
<?php  
}
?>
</span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Repayment ID:</b> <?php echo $reg['id']; ?></span>
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
<span style="margin-left:8px;"><b>Branch:</b> <?php echo $rows['Branch']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Account No:</b>  <?php echo $rows['Loan_Account_No']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Transaction ID:</b>  <?php echo $rows['Transaction_id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Union:</b> <?php echo $rows['Unions']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>BVN:</b>  <?php echo $rows['BVN']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Product:</b>  <?php echo $rows['Product']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Saving ID:</b> <?php echo $row['id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Balance:</b>   <?php echo number_format($rows['Total_Bal'],2); ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $reg['Address']; ?></span>
</div>
</div>

<br>

</div>
</div>

</div>
</div>




<div id="seconds" style="display:none;">

<div id="myTable">
<div class="tab-pane" id="pro-nav-profile" role="tabpanel" aria-labelledby="pro-nav-profile-tab">
<div class="bd-example">
<ul class="nav nav-pills" data-toggle="slider-tab" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link active d-flex align-items-center" data-bs-toggle="tab" data-bs-target="#pills-home1" type="button" role="tab" aria-selected="true">
<span style="color: black;">Deposited</span></button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link d-flex align-items-center" data-bs-toggle="tab" data-bs-target="#pills-profile1" type="button" role="tab" aria-selected="false">
<span style="color: black;">Withdrawed</span></button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link d-flex align-items-center" data-bs-toggle="tab" data-bs-target="#pills-profile2" type="button" role="tab" aria-selected="false">
<span style="color: black;">Repayment</span></button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pills-contact1" type="button" role="tab" aria-selected="false">
<span style="color: black;">Transfered</span></button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pills-contact3" type="button" role="tab" aria-selected="false">
<span style="color: black;">Upfront</span></button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pills-contact2" type="button" role="tab" aria-selected="false">
<span style="color: black;">Recieved</span></button>
</li>
</ul>
<div class="tab-content iq-tab-fade-up">
<div class="tab-pane show active" id="pills-home1" role="tabpanel">
<br>
<span style="margin-left:10px">
Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Savings) AS overs FROM save WHERE Saving_Account = '$sv' AND Status = 'Paid'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?>
</span>
<br>
<div class="table-responsive" style="overflow: auto; height:250px">
<table  style="font-size:8px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">SAVING ACCT</th>
<th style="font-size:8px">LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">METHOD</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">OFFICER NAME</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM save WHERE Saving_Account = '$sv' AND Status = 'Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Register_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$lan= $rows['Loan_Account_No'];
$svs= $rows['Savings'];
$dp= $rows['Date_Paid'];
$ofd= $rows['Officer_Name'];
$stt= $rows['Status'];
$mt= $rows['Posting_Method'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $mt; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $ofd; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<span style='margin-left:10px'> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>
</div>
<div class="tab-pane" id="pills-profile1" role="tabpanel">
<br>
<span style="margin-left:10px">
Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount_Withdraw) AS overs FROM withdraw WHERE Saving_Account_No = '$sv' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?>
<br>
</span>
<div class="table-responsive" style="overflow: auto; height:250px">
<table  style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">SAVING ACCT</th>
<th style="font-size:8px">LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">OFFICER NAME</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM withdraw  WHERE Saving_Account_No = '$sv' AND  Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Register_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$lan= $rows['Loan_Account_No'];
$svs= $rows['Amount_Withdraw'];
$dp= $rows['Date_Approved'];
$stt= $rows['Status'];
$off= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $off; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<span style='margin-left:10px'> No Record Found  </small> ";      
}
?>
</tbody>
</table>
</div>

</div>
<div class="tab-pane" id="pills-profile2" role="tabpanel">
<br>
<span style="margin-left:10px">
Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM saving_rep WHERE Saving_Account_No = '$sv' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?>
</span>
<br>
<div class="table-responsive" style="overflow: auto; height:250px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">SENDER SAVING ACCT</th>
<th style="font-size:8px">SENDER LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th  style="font-size:8px">AMOUNT</th>
<th  style="font-size:8px">RECIEVER LOAN ACCT</th>
<th  style="font-size:8px">DATE</th>
<th  style="font-size:8px">OFFICER NAME</th>
<th  style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM saving_rep  WHERE Saving_Account_No = '$sv' AND Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$lan= $rows['Loan_Account_No'];
$unn= $rows['Unions'];
$lan= $rows['Reciever_Loan_No'];
$svs= $rows['Amount'];
$dp= $rows['Date_Approved'];
$stt= $rows['Status'];
$ofg= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $ofg; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
echo"<span style='margin-left:10px'> No Record Found  </small> ";     
}
?>
</tbody>
</table>
</div>
</div>
<div class="tab-pane " id="pills-contact1" role="tabpanel">
<br>
<span style="margin-left:10px">
Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM transfers WHERE Saving_Account_No = '$sv' AND Status = 'Paid'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?>
</span>
<br>
<div class="table-responsive" style="overflow: auto; height:250px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">SENDER SAVING ACCT</th>
<th style="font-size:8px">SENDER LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th  style="font-size:8px">AMOUNT</th>
<th  style="font-size:8px">RECIEVER SAVING ACCT</th>
<th  style="font-size:8px">DATE</th>
<th  style="font-size:8px">OFFICER NAME</th>
<th  style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM transfers WHERE Saving_Account_No = '$sv' AND Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Register_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$rc= $rows['Reciever_Account'];
$lan= $rows['Loan_Account_No'];
$svs= $rows['Amount'];
$dp= $rows['Date_Approved'];
$stt= $rows['Status'];
$oh= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $rec; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $oh; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
echo"<span style='margin-left:10px'> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>
</div>
<div class="tab-pane" id="pills-contact2" role="tabpanel">
<br>
<span style="margin-left:10px">
Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM credit WHERE Reciever_Account = '$sv' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?>
</span>
<br>
<div class="table-responsive" style="overflow: auto; height:250px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">REG ID</th>
<th style="font-size:8px">RECIEVER SAVING ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th  style="font-size:8px">AMOUNT</th>
<th  style="font-size:8px">SENDER NAME</th>
<th  style="font-size:8px">SENDER SAVING ACCT</th>
<th  style="font-size:8px">DATE</th>
<th  style="font-size:8px">OFFICER NAME</th>
<th  style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM credit WHERE Reciever_Account = '$sv' AND Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Register_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$rn= $rows['Reciever_Name'];
$ra= $rows['Reciever_Account'];
$dp= $rows['Date_Transfer'];
$ok= $rows['Officer_Name'];
$stt= $rows['Status'];
$svv= $rows['Savings_Account_No'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $rn; ?></td>
<td  style="font-size:9px"><?php echo $un; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $svv; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $ok; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
echo"<span style='margin-left:10px'> No Record Found  </small> ";      
}
?>
</tbody>
</table>
</div>
</div>
<div class="tab-pane" id="pills-contact3" role="tabpanel">
<br>
<span style="margin-left:10px">
Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM saving_upfront WHERE Saving_Account_No = '$sv' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?>
</span>
<br>
<div class="table-responsive" style="overflow: auto; height:250px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">OLD REG ID</th>
<th style="font-size:8px">SAVING ACCT</th>
<th style="font-size:8px">LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">NEW REG ID</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM saving_upfront WHERE Saving_Account_No = '$sv' AND  Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$lan= $rows['Loan_Account_No'];
$dp= $rows['Date_Sent'];
$stt= $rows['Status'];
$dx= $rows['Officer_Name'];
$svv= $rows['Saving_Account_No'];
$new= $rows['New_Reg'];
?>
<tr>
<td  style="font-size:9px"><?php echo $cl_id; ?></td>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo $unn; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $new; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
echo"<span style='margin-left:10px'> No Record Found  </small> ";    
}
?>
</tbody>
</table>
</div>
</div>

</div>
</div>
</div>

</div>

</div>




<div id="thirds" style="display:none;">
<?php 
include '../config/db.php';
$sql = "SELECT COUNT(*) AS overs FROM savings WHERE Client_BVN = '$clbvn' AND Status = 'Active' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
if($over == 1){
echo "<span style='color:red'>Customer has only one saving account. there is no need for merging</span>";
}else{
$Query = "SELECT * FROM repayments WHERE BVN = '$clbvn'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row == 0){
echo "<i>🚫 BVN Record Not Found..!!</i>";
exit();
}else{
?>
<div class="row">
<div class="col-sm-4">
<small><b>Total Closed Acct Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$clbvn'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-4">
<small><b>Total Active Acct Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$clbvn' AND Status = 'Active'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
</div>
<br>

<form action="" method="POST" enctype="multipart/form-data" id="uploadMerge">
<div class="row">
<div class="col-sm-6">
<label>Old Saving Account</label>
<select class = "form-control form-control-sm" required name="old">
<option value="">Select Saving</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Savings_Account_No FROM repayments WHERE BVN = '$clbvn' AND Status != 'Active' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$nx= $rows['id']; // union id
$name= $rows['Savings_Account_No'];
?>
<option value="<?php echo $nx; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>

<div class="col-sm-6">
<label>Active Saving Account</label>
<select class = "form-control form-control-sm" required name="new">
<option value="">Select Saving</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Savings_Account_No FROM repayments WHERE BVN = '$clbvn' AND Status = 'Active' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$nx= $rows['id']; // union id
$name= $rows['Savings_Account_No'];
?>
<option value="<?php echo $nx; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<hr>
<button type="submit" class="btn btn-success btn-sm">Merged Account</button>
<button type="reset" class="btn btn-danger btn-sm" style="float:right">Reset Input Form</button>
</form>



<?php
}
}
?>





</div>




<script>

function clickDash(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
x.style.display = 'block';
y.style.display = 'none';
z.style.display = 'none';
}
function clickHis(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
y.style.display = 'block';
x.style.display = 'none';
z.style.display = 'none';
}
function clickReq(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
z.style.display = 'block';
y.style.display = 'none';
x.style.display = 'none';
}
</script>


<script type="text/javascript">
$(document).ready(function(){
setTimeout(function () {
// ajax function start here to load table data
$.ajax({
method: "GET",
url: "gens.php?id=<?php echo $id; ?>",
dataType: "html",
success:function(data){
$("#mydivs").load("client_saving_page.php?id=<?php echo $id; ?>" + " #mydivs");
}
});
}, 100);
// ajax function ends here
});
</script>



<script type="text/javascript">
function loadAll()  {
// ajax function start here to load table data
$.ajax({
method: "GET",
url: "gens.php?id=<?php echo $id; ?>",
dataType: "html",
success:function(data){
$("#mydivs").load("express_saving_page.php?id=<?php echo $id; ?>" + " #mydivs");
$("#myTable").load("express_saving_page.php?id=<?php echo $id; ?>" + " #myTable");
}
});
// ajax function ends here
}
</script> 

<script type="text/javascript">
$(document).ready(function (e){
$("#uploadMerge").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to merge this saving to a loan account.!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "merged.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
$("#please").hide();
alert("Invalid operation: same account can not be merged together..");
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toasts").css("display", "block");
$("#toasts").show();
loadAll();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
$("#please").hide();
alert(data);
}
},
error: function(){
}
});
}
}));
});
</script>
