
<?php 
include '../config/db.php';
$id = $_GET['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT id,Unions,Transaction_id,Disbursement_No,Loan_Account_No,Phone,Reg_id,Interest_Amt,Loan_Amount,Paid,Total_Bal,Total_Loan,Status,
Expected_Amount,Branch,Product,Frequency,Officer_Name,Team_Name,Gender,Last_Amount,Date_Disbursed,Transaction_Date,Rate,Duration,Maturity_Date,Maturity_Status
FROM repayments WHERE id = '$id'  ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$un = $row['Unions'];
$tr = $row['Transaction_id'];
$dis = $row['Disbursement_No'];
$ln = $row['Loan_Account_No'];
$ph = $row['Phone'];
$reg_id = $row['Reg_id'];
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
$td = $row['Transaction_Date'];
$ten = $row['Rate'];
$du = $row['Duration'];
$mtd = $row['Maturity_Date'];//maturity date
$mts = $row['Maturity_Status'];
?>
<!-- Loan Overview start-->
<div id="loan">
<div class="row">
<div class="col-sm-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>DISBURSED NO:</b> <?php echo $dis; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>TRANSACTION ID:</b> <?php echo $tr; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>LOAN ACCT:</b> <?php echo $ln; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>PRINCIPAL AMT:</b> <?php echo number_format($la,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>INTEREST AMT:</b> <?php echo number_format($int,2); ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>LOAN AMT:</b> <?php echo number_format($la + $int,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>AMT PAID:</b> <?php echo number_format($pd,2); ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>OUTSTANDING:</b> <?php echo number_format($tb,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>LAST AMT PAID:</b> <?php echo number_format($lamt,2); ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>EXPECTED AMT:</b> <?php echo number_format($er,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="margin-left:8px;"><b>TRANSACTION DATE:</b> <?php echo date("d-M-Y", strtotime($td)); ?></small>
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
<small style="margin-left:8px;"><b>GROUP NAME:</b> <?php echo $un; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>BRANCH:</b> <?php echo $br; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>PRODUCT:</b> <?php echo $pr; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>FREQUENCY:</b> <?php echo $fr; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>RATE:</b> <?php echo $ten; ?>%</small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>DURATION:</b> <?php echo $du; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>LOAN OFFICER:</b> <?php echo $of; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>TEAM LEADER:</b> <?php echo $tn; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>MATURITY DATE:</b> <?php echo $mtd; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b> STATUS:</b> <?php 
if($d < $mtd){
echo "<span style='color:green'>Runing</span>";
}else{
echo "<span style='color:red'>Expired</span>";
}
?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>DATE DISBURSED:</b> <?php echo $dd; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>OVERDUE DAYS:</b> 
<?php 
if($row['Frequency'] == 'Daily' && $row['Maturity_Status'] == 'Expired'){
$diff = abs(strtotime($d) - strtotime($row['Maturity_Date']));
$years   = floor($diff / (365*60*60*24));
$days  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$over =  $days." "."Days";
}elseif($row['Frequency']  == 'Weekly' && $row['Maturity_Status'] == 'Expired'){
$weeks = (int)date("W", strtotime($d)) - (int)date("W", strtotime($row['Maturity_Date']));
$over =  $weeks." "."Weeks";
}elseif($row['Frequency']  == 'Monthly' && $row['Maturity_Status'] == 'Expired'){
$diff = abs(strtotime($d) - strtotime($row['Maturity_Date']));
$years   = floor($diff / (365*60*60*24));
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$over =  $months." "."Months";
}else{
if($row['Frequency'] == 'Daily'){
$over =  "0"." "."Day";
}elseif($row['Frequency'] == 'Weekly'){
$over =  "0"." "."Week"; 
}elseif($row['Frequency'] == 'Monthly'){
$over =  "0"." "."Month";
}
}
echo $over;
?>
</small>
</div>
</div>
<br>
</div>
</div>

</div>
 

<hr>
<?php 
include '../config/db.php';
$id = $_GET['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT id,Reg_id,BVN
FROM repayments WHERE id = '$id'  ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$bv = $row['BVN'];
?>
<div >
<?php 
include '../config/db.php';
$sql = "SELECT count(*)  AS overs FROM repayments WHERE BVN = '$bv' AND Status = 'Closed'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$closed = $data['overs'];

$sql = "SELECT count(*)  AS overs FROM repayments WHERE BVN = '$bv' AND Status = 'Active'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$active = $data['overs'];

$sql = "SELECT count(*)  AS overs FROM repayments WHERE BVN = '$bv' AND Status = 'Cancelled'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$cancel = $data['overs'];
?>
<div class="row">
<div class="col-sm-4">
No Of Closed Loans: <?php  echo $closed; ?>
</div>
<div class="col-sm-4">
No Of Active Loans: <?php  echo $active; ?>
</div>
<div class="col-sm-4">
No Of Cancelled Loans: <?php  echo $cancel; ?>
</div>
</div>
<hr>
<h5 style="font-size:11px;"><b>LOAN HISTORY</b></h5><hr>
<div class="table-responsive" style="height:100px; overflow:auto">
<table id='example2' class="table table-sm table table-bordered" style="font-size:8px">
<thead>
<tr >
<th>LOAN ACCOUNT</th>
<th>SAVING ACCOUNT</th>
<th>BVN</th>
<th>PRINCIPAL AMT</th>
<th>OUTSTANDING</th>
<th>STATUS</th>
<th>DATE DISBURSED</th>
<th>DATE CLOSED</th>
</tr>
</thead>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT Loan_Account_No,Savings_Account_No,BVN,Loan_Amount,Total_Bal,Status,Date_Disbursed,Date_Closed FROM repayments WHERE BVN='$bv' ORDER BY id DESC LIMIT 10";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bn = $rows['Loan_Account_No'];
$saa = $rows['Savings_Account_No'];
$bt = $rows['BVN'];
$ses = $rows['Loan_Amount'];
$bal = $rows['Total_Bal'];
$sd = $rows['Status'];
$cf = $rows['Date_Disbursed'];
$ba = $rows['Date_Closed'];
?>
<td><?php echo $bn; ?></td>
<td><?php echo $saa; ?></td>
<td><?php echo $bt; ?></td>
<td><?php echo number_format($ses,2); ?></td>
<td><?php echo number_format($bal,2); ?></td>
<td><?php echo $sd; ?></td>
<td><?php echo $cf; ?></td>
<td><?php echo $ba; ?></td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo " No Record Found  <br/> ";       
}
?>
</table>
</div>
</div>
</div>


<!-- Loan Overview end-->
