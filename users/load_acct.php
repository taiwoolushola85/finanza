
<?php 
include '../config/db.php';
$id = $_POST['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT * FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$loc = $row['Location'];
$na = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
$nam = $row['Firstname']." ".$row['Lastname'];
$un = $row['Unions'];
$fst = $row['Firstname'];
$tr = $row['Transaction_id'];
$dis = $row['Disbursement_No'];
$ln = $row['Loan_Account_No'];
$sv = $row['Savings_Account_No'];
$ph = $row['Phone'];
$reg_id = $row['Reg_id'];
$bv = $row['BVN'];
$int = $row['Interest_Amt'];
$la = $row['Loan_Amount'];
$pd = $row['Paid'];
$tb = $row['Total_Bal'];
$tlo = $row['Total_Loan'];
$er = $row['Expected_Amount'];
$br = $row['Branch'];
$pr = $row['Product'];
$fr = $row['Frequency'];
$of = $row['Officer_Name'];
$tn = $row['Team_Name'];
$gen = $row['Gender'];
$st = $row['Status'];
$lamt = $row['Last_Amount'];
$dd = $row['Date_Disbursed'];
$vrt = $row['Account_Number'];
$td = $row['Transaction_Date'];
$ten = $row['Rate'];
$du = $row['Duration'];
$mtd = $row['Maturity_Date'];//maturity date
// getting total sum of payment history
$sql = "SELECT SUM(Amount) AS lm FROM history WHERE Status ='Paid' AND Loan_Account_No = '$ln' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmt = $data['lm'];
// savings history
$sql = "SELECT SUM(Savings) AS lm FROM save WHERE Status ='Paid' AND Saving_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmd = $data['lm'];
// withdraw history
$sql = "SELECT SUM(Amount_Withdraw) AS lm FROM withdraw WHERE Status ='Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmw = $data['lm'];
// saving transfer
$sql = "SELECT SUM(Amount) AS lm FROM transfers WHERE Status ='Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmtr = $data['lm'];
// savings for repayment
$sql = "SELECT SUM(Amount) AS lm FROM saving_rep WHERE Status ='Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmr = $data['lm'];
//savings upfront
$sql = "SELECT SUM(Amount) AS lm FROM saving_upfront WHERE Status ='Paid' AND Saving_Account_No = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmu = $data['lm'];
/// credit savings
$sql = "SELECT SUM(Amount) AS lm FROM credit WHERE Status ='Paid' AND Reciever_Account = '$sv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmc = $data['lm'];
// getting total balance
$bals = ($pmd - $pmw - $pmr - $pmtr - $pmu)  + $pmc;
?>
<div class="row">
<div class="col-sm-3">
<div class="d-flex flex-column align-items-center text-center">
<img src="<?php echo $loc; ?>"  class="rounded-circle" width="120" height="120px">
<div class="mt-3">
<h4><b><?php echo $nam; ?></b></h4>
<p class="text-secondary mb-1"><?php echo $pr; ?> </p>
</div>
</div>
<br>
<div class="bd-example">
<ul class="list-group">
<li class="list-group-item d-flex justify-content-between align-items-center" style="font-size:14px">
<span>Loan Amt: </span><span style="float:right;"><?php echo number_format($tlo,2); ?></span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center" style="font-size:14px">
<span>Paid:</span><span style="float:right;"><?php echo number_format($pd,2); ?></span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center" style="font-size:14px">
<span>Saving Balance:</span><span style="float:right;"><?php echo number_format($bals,2); ?></span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center" style="font-size:14px">
<span>Outstanding:</span><span style="float:right;"><?php echo number_format($tb,2); ?></span>
</li>
</ul>
</div>
<br>
<div class="row">
<div class="col-sm-6">
<form action="" method="POST" enctype="multipart/form-data" id="loanClosed"> 
<input type="text" name="id" class="form-control" value="<?php echo $id; ?>" hidden required>
<input type="text" name="br" id="br" class="form-control" value="<?php echo $br; ?>" hidden required>
<button type="submit" class="btn btn-outline-success btn-sm w-100">Confirm</button>
</form>
</div>
<div class="col-sm-6">
<form action="" method="POST" enctype="multipart/form-data" id="loanReverse"> 
<input type="text" name="id" class="form-control" value="<?php echo $id; ?>" hidden required>
<input type="text" name="br" id="br" class="form-control" value="<?php echo $br; ?>" hidden required>
<button type="submit" class="btn btn-outline-warning btn-sm w-100">Reverse</button>
</form>
</div>
</div>

</div>
<div class="col-sm-9">


<div class="bd-example">
<nav>
<div class="mb-3 nav nav-tabs nav-iconly gap-3" id="nav-tab" role="tablist">
<button class="nav-link active" id="pro-nav-home-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-home" type="button" role="tab" aria-controls="pro-nav-home" aria-selected="true">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z" fill="currentColor" />
</svg>
<span style="font-size:12px">REPAYMENTS ANALYSIS</span>
</button>
<button class="nav-link" id="pro-nav-profile-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-profile" type="button" role="tab" aria-controls="pro-nav-profile" aria-selected="false">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z" fill="currentColor" />
</svg>
<span style="font-size:12px">SAVINGS ANALYSIS</span>
</button>
</div>
</nav>
<div class="tab-content iq-tab-fade-up" id="simple-tab-content">
<div class="tab-pane show active" id="pro-nav-home" role="tabpanel" aria-labelledby="pro-nav-home-tab">


<div class="container">
<span style="font-size:12px">
<?php 
echo 'Total: '. number_format($pmt,2);
?>
</span>
<div class="table-responsive" style="overflow: auto; height:340px"><br>
<table style="font-size:7px">
<thead>
<tr>
<th>PRINCIPAL</th>
<th>INTEREST</th>
<th>AMT PAID</th>
<th>EXP AMT</th>
<th>TYPES</th>
<th>DATE</th>
<th>RECIEPTS</th>
</tr>
</thead>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM history WHERE Register_id='$reg_id' AND Status='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$h_id = $rows['id'];
$fn = $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname'];
$dis = $rows['Disbursement_No'];
$lon = $rows['Loan_Account_No'];
$uns = $rows['Unions'];
$pr = $rows['Loan_Type'];
$la = $rows['Loan_Amount'];
$am = $rows['Amount'];
$int = $rows['Interest_Amt'];
$exp = $rows['Expected_Amount'];
$of = $rows['Officer_Name'];
$dp = $rows['Date_Paid'];
$bb = $rows['Balance'];
$pm = $rows['Payment_Method'];
$po = $rows['Post_Method'];
?>
<tr>
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int,2); ?></td>
<td><?php echo number_format($am,2); ?></td>
<td><?php echo number_format($exp,2); ?></td>
<td><?php echo $pm; ?></td>
<td><?php echo $dp; ?></td>
<td>
<?php 
if ($pm == 'Cash Payment'){
?>  
<span>No Reciept</span></td>
<?php 
}else{
?>  
<a href="#" class="reciept" data-bs-toggle="modal" data-bs-target="#updateReciept" id="<?php echo htmlspecialchars($h_id); ?>">View Reciept</a>
</td>
<?php 
}
?> 
</tr>
<?php
} 
}else {
echo" <small style='color:red'>No payment record </small>";       
}
?>
</tr>
</table>
</div>
</div>

</div>
<div class="tab-pane" id="pro-nav-profile" role="tabpanel" aria-labelledby="pro-nav-profile-tab">

<hr>
<div class="bd-example" style="font-size:11px">
<ul class="nav nav-pills" data-toggle="slider-tab" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link active d-flex align-items-center" data-bs-toggle="tab" data-bs-target="#pills-home1" type="button" role="tab" aria-selected="true">Deposited</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link d-flex align-items-center" data-bs-toggle="tab" data-bs-target="#pills-profile1" type="button" role="tab" aria-selected="false">Withdrawed</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link d-flex align-items-center" data-bs-toggle="tab" data-bs-target="#pills-profile2" type="button" role="tab" aria-selected="false">Repayment</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pills-contact1" type="button" role="tab" aria-selected="false">Transfered</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pills-contact3" type="button" role="tab" aria-selected="false">Upfront</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pills-contact2" type="button" role="tab" aria-selected="false">Recieved</button>
</li>
</ul>
<div class="tab-content iq-tab-fade-up">
<div class="tab-pane show active" id="pills-home1" role="tabpanel">
<br>
<span style="font-size:10px">Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Savings) AS overs FROM save WHERE Saving_Account = '$sv' AND Status = 'Paid'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?></span>
<div class="table-responsive" style="overflow: auto; height:240px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">SAVING ACCT</th>
<th style="font-size:8px">LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
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
$Query = "SELECT Register_id, Firstname, Loan_Account_No, Middlename, Lastname, Unions, Savings, Date_Paid, Officer_Name, Status, Posting_Method
FROM save WHERE Saving_Account = '$sv' AND Status ='Paid' ORDER BY id ASC";
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
$pos= $rows['Posting_Method'];
?>
<tr>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $pos; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $ofd; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>
</div>
<div class="tab-pane" id="pills-profile1" role="tabpanel">
<br>
<span style="font-size:10px">Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount_Withdraw) AS overs FROM withdraw WHERE Saving_Account_No = '$sv'  AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?></span>
<div class="table-responsive" style="overflow: auto; height:240px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">SAVING ACCT</th>
<th style="font-size:8px">LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
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
$Query = "SELECT Reg_id, Firstname, Loan_Account_No, Middlename, Lastname, Unions, Amount_Withdraw, Date_Approved, Status, Officer_Name
FROM withdraw  WHERE Saving_Account_No = '$sv' AND Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$lan= $rows['Loan_Account_No'];
$unn= $rows['Unions'];
$svs= $rows['Amount_Withdraw'];
$dp= $rows['Date_Approved'];
$stt= $rows['Status'];
$off= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $off; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>

</div>
<div class="tab-pane" id="pills-profile2" role="tabpanel">
<br>
<span style="font-size:10px">Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM saving_rep WHERE Saving_Account_No = '$sv' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?></span>
<div class="table-responsive" style="overflow: auto; height:240px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">SENDER SAVING ACCT</th>
<th style="font-size:8px">SENDER LOAN ACCT</th>
<th style="font-size:8px">NAME</th>
<th  style="font-size:8px">AMOUNT</th>
<th  style="font-size:8px">RECIEVER LOAN ACCT NO </th>
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
$Query = "SELECT Reg_id, Firstname, Loan_Account_No, Middlename, Lastname, Unions, Amount, Date_Approved, Status, Officer_Name
FROM saving_rep  WHERE Saving_Account_No = '$sv' AND Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$lan= $rows['Loan_Account_No'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$dp= $rows['Date_Approved'];
$stt= $rows['Status'];
$rc= $rows['Reciever_Loan_No'];
$ofg= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $lan; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $rc; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $ofg; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found.</small> ";       
}
?>
</tbody>
</table>
</div>
</div>
<div class="tab-pane " id="pills-contact1" role="tabpanel">
<br>
<span style="font-size:10px">Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM transfers WHERE Saving_Account_No = '$sv' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?></span>
<div class="table-responsive" style="overflow: auto; height:240px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">SENDER SAVING ACCT</th>
<th style="font-size:8px">NAME</th>
<th  style="font-size:8px">AMOUNT</th>
<th  style="font-size:8px">RECIEVER NAME</th>
<th  style="font-size:8px">RECIEVER SAVINGS ACCT</th>
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
$Query = "SELECT Reg_id, Firstname, Middlename, Lastname, Unions, Amount, Date_Approved, Status, Officer_Name, Reciever_Name, Reciever_Loan_Acct
FROM transfers WHERE Saving_Account_No = '$sv' AND Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$dp= $rows['Date_Approved'];
$stt= $rows['Status'];
$reck= $rows['Reciever_Name'];
$recks= $rows['Reciever_Loan_Acct'];
$oh= $rows['Officer_Name'];
?>
<tr>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $reck; ?></td>
<td  style="font-size:9px"><?php echo $recks; ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $oh; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>
</div>
<div class="tab-pane" id="pills-contact3" role="tabpanel">
<br>
<span style="font-size:10px">Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM saving_upfront WHERE Saving_Account_No = '$sv' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?></span>
<div class="table-responsive" style="overflow: auto; height:240px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">SAVING ACCT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">DATE</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT Reg_id, Firstname, Middlename, Lastname, Unions, Amount, Date_Sent, Status, Officer_Name, Saving_Account_No
FROM saving_upfront WHERE Saving_Account_No = '$sv' AND  Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Reg_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Unions'];
$svs= $rows['Amount'];
$dp= $rows['Date_Sent'];
$stt= $rows['Status'];
$dx= $rows['Officer_Name'];
$svv= $rows['Saving_Account_No'];
?>
<tr>
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $nnm; ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo $dp; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>
</div>

<div class="tab-pane" id="pills-contact2" role="tabpanel">
<br>
<span style="font-size:10px">Total:
<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Amount) AS overs FROM credit WHERE Reciever_Account = '$sv' AND Status = 'Paid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo number_format($over,2);
?></span>
<div class="table-responsive" style="overflow: auto; height:240px">
<table style="font-size:9px">
<thead>
<tr>
<th style="font-size:8px">SAVING ACCOUNT</th>
<th style="font-size:8px">NAME</th>
<th style="font-size:8px">GROUP</th>
<th  style="font-size:8px">AMOUNT</th>
<th  style="font-size:8px">SENDER NAME</th>
<th  style="font-size:8px">SENDER ACCOUNT</th>
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
$Query = "SELECT Reg_id,Firstname,Middlename,Lastname,Unions,Amount,Reciever_Name,Reciever_Account,Date_Transfer,Officer_Name,Status,
Savings_Account_No FROM credit WHERE Reciever_Account = '$sv' AND Status ='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id= $rows['Reg_id'];
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
<td  style="font-size:9px"><?php echo $sv; ?></td>
<td  style="font-size:9px"><?php echo $rn; ?></td>
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
//$Available = false; 
echo"<small> No Record Found  </small> ";       
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




</div>
</div>




<script>
// to show data on a modal box
$(document).ready(function() {
$('.reciept').on('click', function() {
var recID = $(this).attr('id');
if(recID) {
$("#updateModal").modal('hide');
$.ajax({
url: 'show_reciept.php',
type: "POST",
data: {'id':recID},
dataType: "json",
success:function(data) {
$('#full').text(data.fullName);
$('#hid').val(data.historyId);
$('#hidd').val(data.historyId);
$('#recp').val(data.recieptLocation);
$("#recip").attr("src", data.recieptLocation);
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

<!-- Payment history end -->

<script>
// to show data on a modal box
$(document).ready(function() {
$('#bck').on('click', function() {
$("#updateReciept").modal('hide');
$("#updateModal").modal('show');
});
});
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#loanClosed").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to close this customer loan!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "auditing_close.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
$("#please").hide();
loads();
alert(" 🚫 Sorry.! this loan still has an outstanding balance, please check.");
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert("Error" + data)
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
$("#loanClosed").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to reverse this customer loan!!?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "reverse_loan_audit.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").css("display", "block");
$("#toasts").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
$("#please").hide();
alert("Error" + data)
}
},
error: function(){
}
});
}
}));
});
</script>