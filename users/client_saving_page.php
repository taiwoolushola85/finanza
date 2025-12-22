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
$saving_bal = $row['Balance'];
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
<button class="btn btn-light" onclick="clickReq()"><i class="fa fa-box"></i> Request</button>
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
<span style="margin-left:8px;"><b>Balance:</b> <span id="mydivs"><?php echo number_format($saving_bal,2); ?></span></span>
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
$sql = "SELECT SUM(Savings) AS overs FROM save WHERE Saving_Account = '$sv' AND Status = 'Paid' ";
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
$Query = "SELECT * FROM save WHERE Saving_Account = '$sv' AND Status ='Paid' ORDER BY id ASC";
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
$sql = "SELECT SUM(Amount_Withdraw) AS overs FROM withdraw WHERE Saving_Account_No = '$sv' AND Status = 'Paid'  ";
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
$Query = "SELECT * FROM transfers WHERE Saving_Account_No = '$sv' AND Status ='Paid'  ORDER BY id ASC";
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
$sql = "SELECT SUM(Amount) AS overs FROM saving_upfront WHERE Saving_Account_No = '$sv' AND Status = 'Paid'";
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




<div id="thirds" style="display:none;">

<div style="margin: auto; width:250px">
<label style="font-size:13px"><i style="color:red">*</i> Select Request</label>
<select type="text" class="form-control form-control-md" id="type" required="required" oninput="selectRequest()">
<option value="">Select Option</option>
<option value="Withdrawal">Withdrawal</option>
<option value="Repayment">Savings For Repayment</option>
</select>
</div>
<br>


<div id="myDIV" style="display:none">
<span><b>Savings Withdraw Form</b></span><hr>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div class="row">
<div class="col-sm-3">
<input type="text" name="id" class="form-control" hidden value="<?php echo $id;?>" required="required">
<input type="text" name="ln" class="form-control" hidden value="<?php echo $loan;?>" required="required">
<input type="text" class="form-control" hidden placeholder="Amount" name="bl" value="<?php echo $saving_bal;?>" required="required">
<label>Amount</label><br>
<input type="number" class="form-control" placeholder="Amount" name="am"  required="required">
</div>
<div class="col-sm-3">
<label>Bank</label><br>
<select type="text" class="form-control form-control-md" name="bnk" required="required">
<option value="">Select Bank</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Bank_Name FROM bank ORDER BY Bank_Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Bank_Name'];// product
?>
<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-3">
<label>Acoount No</label><br>
<input type="number" class="form-control" placeholder="Account No" name="acct"  required="required">
</div>
<div class="col-sm-3">
<label>Acoount Name</label><br>
<input type="text" class="form-control" placeholder="Account Name" name="actname"  required="required">
</div>
</div>
<div class="row">
<div class="col-sm-12">
<label>Reason For Withdrawal</label><br>
<textarea class="form-control" placeholder="State reason for withdrawal" name="reason" required="required"></textarea>
</div>
</div>
<br>
<?php 
if($status == 'Active'){
?>
<input type="submit" disabled class="btn btn-outline-info btn-sm" value="Send Request" id="butsave" onclick="data()" >
<i style="color:red;">Note:</i> Customer can not withdraw saving if the loan is still runing
<?php 
}else{
?>
<input type="submit" class="btn btn-outline-info btn-sm" value="Send Request" id="butsave" onclick="data()" >
<?php 
}
?>
</form>
</div>

<div id="my" style="display:none">
<span><b>Savings For Repayment Form</b></span><hr>
<small><b>Loan Expected Repayment Amount:</b></small> <?php echo number_format($exp_amt,2); ?><br><br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForms">
<div class="row">
<div class="col-sm-6">
<input type="text" name="id" hidden class="form-control" value="<?php echo $id;?>" required="required">
<input type="text" name="sav" hidden class="form-control" placeholder="Amount" value="<?php echo $sv;?>" required="required">
<input type="text" name="ln" hidden class="form-control" value="<?php echo $loan;?>" required="required">
<input type="text" class="form-control" hidden placeholder="Amount" name="bl" value="<?php echo $saving_bal;?>" required="required">
<label>Amount</label><br>
<input type="number" name="amt" class="form-control" placeholder="Amount" required="required">
</div>
<div class="col-sm-6">
<label>Loan Account</label> <i style="color:pink">[Note: this loan account must be an active loan.]</i><br>
<input type="number" name="acct" class="form-control" placeholder="Enter Reciver's Active Loan Account No" required="required">
</div>
</div><br>
<input type="submit"  class="btn btn-outline-success btn-sm" value="Send Request" onclick="data()" >
</form>
</div>


</div>




<script>
function selectRequest() {
var x = document.getElementById("type").value;
if(x == "Withdrawal"){
document.getElementById("myDIV").style.display = 'block';
document.getElementById("my").style.display = 'none';
} else if(x == "Repayment"){
document.getElementById("myDIV").style.display = 'none';
document.getElementById("my").style.display = 'block';
} else {
// Optional: hide both if neither option is selected
document.getElementById("myDIV").style.display = 'none';
document.getElementById("my").style.display = 'none';
}
}
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
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to send this request for approval.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "withdraw_request.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
$("#please").hide();
alert("🚫  Amount enter is greater than saving balance ");
$("#updateModal").modal('show');
}else if(data==2){
$("#please").hide();
alert(" 🚫  Invalid amount ");
$("#updateModal").modal('show');
}else if(data == 6){
$("#please").hide();
alert(" 🚫  Request has been sent already, Please waiting for approval");
$("#updateModal").modal('show');
}else if(data==4){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
$("#updateModal").modal('show');
}, 6000);
}else if(data==5){
$("#please").hide();
alert(" 🚫  Sql error found");
}else{
$("#please").hide();
alert("🚫" + data);
$("#updateModal").modal('show');
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
$("#uploadForms").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to send this request for approval.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "saving_repayament_request.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data==1){
$("#please").hide();
alert("🚫  Amount enter is greater than saving balance ");
$("#updateModal").modal('show');
}else if(data == 2){
$("#please").hide();
alert(" 🚫  Invalid amount ");
$("#updateModal").modal('show');
}else if(data == 3){
$("#please").hide();
alert(" 🚫  Loan account number entered is incorrect. please check ");
$("#updateModal").modal('show');
}else if(data == 6){
$("#please").hide();
alert(" 🚫  Request has been sent already, Please waiting for approval");
$("#updateModal").modal('show');
}else if(data == 4){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
$("#updateModal").modal('show');
}, 6000);
}else if(data == 9){
$("#please").hide();
alert(" 🚫  Customer loan account is closed, please look for the active loan acct.");
$("#updateModal").modal('show');
}else if(data == 5){
$("#please").hide();
alert(" 🚫  Sql error found");
}else{
$("#please").hide();
alert(" 🚫  You entered an invalid loan account!  Please check...");
$("#updateModal").modal('show');
}
},
error: function(){
}
});
}
}));
});
</script>