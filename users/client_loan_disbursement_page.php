<?php 
include_once '../config/db.php';

$id = intval($_GET['id']); // reg id

// Register info
$query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$regid = $row['id'];
$vrt = $row['Virtual_Account'];
$reg_status = $row['Status'];
$un = $row['Unions'];
$bvn = $row['BVN'];
$pr = $row['Product_id'];
$ten = $row['Tenure'];
$frq = $row['Frequency'];
$lum = $row['Loan_Amount'];
$up = $row['Upfront'];
$inss = $row['Inssurance'];
$form = $row['Form'];
$card = $row['Card'];
$upty = $row['Upfront_Types'];


// Guarantor info
$query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $query);
$rows = mysqli_fetch_assoc($result);
$gid = $rows['id'];
//

$Query = "SELECT Rate, Inssurance FROM product_list WHERE Product_id='$pr' AND Tenure = '$ten'";
$result = mysqli_query($con, $Query);
$data = mysqli_fetch_array($result);
$ins = $data['Inssurance'];
$rt = $data['Rate'];

/*
//
if($frq == 'Daily'){
// expected repayment
// expected repayment
$dd = $lum + 0; // the intererst is 0
$dailyrep_amt = $lum / $ten;// repayment amt
$dailyrnd_rep = round($dailyrep_amt);// rounding up repayment amt
// total loan balance
$dailyt_loan = $lum + 0;
$dailyrnd_tloan = round($dailyt_loan);// rounding up total loan

// inserting the customer information
$sql = "UPDATE register SET Rate = '$rt', Loan_Amount = '$lum', Interest_Amt = '0', Monthly_Interest = '0', Repayment_Amt = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan'
WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
//echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}


}else{
// interest
// interest
$rr = 100 / $rt;
$in_amt = $lum / $rr;// interest amt
$rnds_int = round($in_amt); /// rounding up interest amount
// expected repayment
$dd = $lum + $in_amt; 
$rep_amt = $dd / $ten;// repayment amt
$rnd_rep = round($rep_amt);// rounding up repayment amt
// total loan balanceRepayment_Day
$t_loan = $lum + $in_amt;
$rnd_tloan = round($t_loan);// rounding up total loan
$int_per_repayment = round($rnds_int/$ten);

// inserting the customer information
$sql = "UPDATE register SET Rate = '$rt', Loan_Amount = '$lum', Interest_Amt = '$rnds_int', Monthly_Interest = '$int_per_repayment', Repayment_Amt = '$rnd_rep', 
Total_Loan = '$rnd_tloan' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
//echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
} 
*/
?>

<style>
.section {
  display: none;
  margin-top: 20px;
  padding: 15px;
  border-radius: 5px;
}
</style>


<!-- BUTTONS -->
<div class="row">

  <div class="col-sm-3 mt-2">
    <button class="btn btn-light w-100" onclick="showSection('customer')">
      <i class="fa fa-user"></i> Customer Profile
    </button>
  </div>

  <div class="col-sm-3 mt-2">
    <button class="btn btn-light w-100" onclick="showSection('loan')">
      <i class="fa fa-list"></i> Loan History
    </button>
  </div>

  <div class="col-sm-3 mt-2">
    <button class="btn btn-light w-100" onclick="showSection('business')">
      <i class="fa fa-image"></i> Business History
    </button>
  </div>

  <div class="col-sm-3 mt-2">
  <button class="btn btn-light w-100" onclick="showSection('upfront')">
      <i class="fa fa-file"></i> Document
    </button>
  </div>

  <div class="col-sm-3 mt-2">
  <button class="btn btn-light w-100" onclick="showSection('repayment')">
      <i class="fa fa-calendar"></i> Repayment Schedule
    </button>
  </div>

  <div class="col-sm-3 mt-2">
    <button class="btn btn-light w-100" onclick="showSection('adjustment')">
      <i class="fa fa-edit"></i> Loan Amount Adjustment
    </button>
  </div>

  <div class="col-sm-3 mt-2">
    <button class="btn btn-light w-100" onclick="showSection('crc')">
      <i class="fa fa-file"></i> CRC Record
    </button>
  </div>

  <div class="col-sm-3 mt-2">
    <button class="btn btn-light w-100" onclick="showSection('approval')">
      <i class="fa fa-star"></i> Disbursement
    </button>
  </div>

</div>

<!-- SECTIONS -->

<div id="customer" class="section">

<div id="firsts">

<div class="row">
<div class="col-sm-6">
<br>
<b><i class="fa fa-star"></i> CLIENT INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<?php
$img = $row['Location'] ?? '';
$defaultImage = '../assets/no-image.png';
if (!empty($img)) {
// Check if path starts with ../
if (strpos($img, '../') === 0) {
$imgPath = $img;
} else {
$imgPath = '../' . $img;
}
} else {
$imgPath = $defaultImage;
}
?>
<img src="<?= htmlspecialchars($imgPath) ?>" style="height:50px; width:50px; border-radius:50px; margin-left:8px;" onerror="this.src='../assets/no-image.png';">
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
<br>
<b><i class="fa fa-star"></i> GAURANTOR INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>

<?php
$img = $rows['Location'] ?? '';
$defaultImage = '../assets/no-image.png';
if (!empty($img)) {
// Check if path starts with ../
if (strpos($img, '../') === 0) {
$imgPath = $img;
} else {
$imgPath = '../' . $img;
}
} else {
$imgPath = $defaultImage;
}
?>
<img src="<?= htmlspecialchars($imgPath) ?>" style="height:50px; width:50px; border-radius:50px; margin-left:8px;" onerror="this.src='../assets/no-image.png';">
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



<div class="row">
<div class="col-sm-6">

<div class="card border-primary border border-dashed">
<br>
<div id="myDiv">
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
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Account No:</b> <?php echo $row['Account_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Interest Per Repayment:</b> <?php echo number_format($row['Monthly_Interest'],2); ?></span>
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
<span style="margin-left:8px;"><b>Total Rate:</b> <?php echo $row['Rate']; ?></span>
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

</div>


<br>
<b><i class="fa fa-star"></i> BUSINESS INFO</b>
<br><br>
<div>
<table>
<thead>
<tr>
<th style="font-size:8px;">BUSSINESS</th>
<th style="font-size:8px;">TYPE</th>
<th style="font-size:8px;">STATE</th>
<th style="font-size:8px;">START DATE</th>
<th style="font-size:8px;">OWNERSHIP</th>
<th style="font-size:8px;">ADDRESS</th>
</tr>
</thead>
<tbody>
<tr style="font-size:8px;">
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



</div>

<div id="loan" class="section">
<h4>Loan History</h4>
<div class="container-fluid mt-4">
<!-- ================= SUMMARY DASHBOARD ================= -->
<div class="row mb-4">
<div class="col-md-3">
<div class="card card-summary shadow-sm">
<div class="card-body text-center">
<h6>Total Loans</h6>
<h3>
<?php 
include '../config/db.php';
$sql = "SELECT count(*)  AS overs FROM repayments WHERE BVN = '$bvn' AND Status != 'Cancelled'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$closed = $data['overs'];
echo $closed;
?>
</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card card-summary shadow-sm">
<div class="card-body text-center">
<h6>Total Loan Amount</h6>
<h3>
<?php 
include '../config/db.php';
$sql = "SELECT SUM(Loan_Amount)  AS overs FROM repayments WHERE BVN = '$bvn' AND Status != 'Cancelled'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$closed = $data['overs'];
echo number_format($closed,2);
?>
</h3>
</div>
</div>
</div>
<div class="col-md-3">
<div class="card card-summary shadow-sm">
<div class="card-body text-center">
<h6>Total Paid</h6>
<h3>
<?php 
include '../config/db.php';
$sql = "SELECT SUM(Paid)  AS overs FROM repayments WHERE BVN = '$bvn' AND Status != 'Cancelled'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$closed = $data['overs'];
echo number_format($closed,2);
?>
</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card card-summary shadow-sm">
<div class="card-body text-center">
<h6>Outstanding</h6>
<h3>
<?php 
include '../config/db.php';
$sql = "SELECT SUM(Total_Bal)  AS overs FROM repayments WHERE BVN = '$bvn' AND Status != 'Cancelled'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$closed = $data['overs'];
echo number_format($closed,2);
?>
</h3>
</div>
</div>
</div>

</div>

<!-- ================= LOAN HISTORY TABLE ================= -->

<div id="table-container" style="height:280px;">
<table>
<thead>
<tr style="font-size:8px">
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
<tbody>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT Loan_Account_No, Savings_Account_No, BVN, Loan_Amount, Total_Bal, Status, Date_Disbursed, Date_Closed FROM repayments 
WHERE BVN='$bvn' ORDER BY Date_Disbursed ASC";
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
</tbody>
</table>
</div>
</div>

</div>




</div>

<div id="business" class="section">

<h4>Business History</h4>

<br>
<br>
<div class="row">
<div class="col-6">
<span style="color: #FF8C00;"><input type="checkbox" id="crcCheck"> New Upload</span>
</div>
<div class="col-6">
<span style="color:orangered"> <input type="checkbox" id="expCheck"> Previous Upload</span>
</div>
</div>

<br>
<br>
<div style="height:300px; overflow-y:auto; overflow-x:hidden;">
<div style="display:none;" id="upload">

<div class="row">
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM verify WHERE Reg_id ='$regid' ORDER BY id ASC LIMIT 3";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$vid = $rows['id'];
$bn = $rows['Reg_id'];
$bt = $rows['Bvn'];
$ses = $rows['Comment_By'];
$lmm = $rows['Status'];
$img = $rows['F_Image'];
?>
<div class="col-sm-4">
<?php
$img = $rows['F_Image'] ?? '';
$defaultImage = '../assets/no-image.png';
if (!empty($img)) {
// Check if path starts with ../
if (strpos($img, '../') === 0) {
$imgPath = $img;
} else {
$imgPath = '../' . $img;
}
} else {
$imgPath = $defaultImage;
}
?>
<img src="<?= htmlspecialchars($imgPath) ?>" class="d-block w-100" style="height:50vh; margin:10px;" onerror="this.src='../assets/no-image.png';">
</div>
<?php
}
}else {
//No Transaction History for the account
$Available = false; 
echo "<span style='color:red'>No New Business Image Uploaded...  </span> ";       
}
?>
</div>
</div>

<div style="display:none;" id="exp">

<div class="row">
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM verify WHERE Bvn ='$bvn' ORDER BY id DESC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$vid = $rows['id'];
$bn = $rows['Reg_id'];
$bt = $rows['Bvn'];
$ses = $rows['Comment_By'];
$lmm = $rows['Status'];
$img = $rows['F_Image'];
?>
<div class="col-sm-4">
<?php
$img = $rows['F_Image'] ?? '';
$defaultImage = '../assets/no-image.png';
if (!empty($img)) {
// Check if path starts with ../
if (strpos($img, '../') === 0) {
$imgPath = $img;
} else {
$imgPath = '../' . $img;
}

} else {
$imgPath = $defaultImage;
}
?>
<img src="<?= htmlspecialchars($imgPath) ?>" class="d-block w-100" style="height:50vh; margin:10px;" onerror="this.src='../assets/no-image.png';">
</div>
<?php
}
}else {
//No Transaction History for the account
$Available = false; 
echo "<span style='color:red'>No previous Business Image Uploaded...  </span> ";       
}
?>
</div>

</div>





</div>

</div>


</div>

<div id="repayment" class="section">
<h4>Repayment Schedule</h4>
<br>




<br><br>
<b style="font-size:11px">
<?php 
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT COUNT(*) AS overs FROM schedule WHERE Regs_id = '$regid'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
?>
Total Record: <?php echo $over; ?>
</b>
<br><br>
<div style="overflow-x: auto; height:300px">
<table style="font-size:9px;">
<thead>
<tr>
<th style="font-size:8px">CLIENT ID</th>
<th style="font-size:8px">PRINCIPAL AMT</th>
<th style="font-size:8px">INTEREST AMT</th>
<th style="font-size:8px">REPAYMENT AMT</th>
<th style="font-size:8px">EXPECTED DATE</th>
<th style="font-size:8px">STATUS</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM schedule WHERE Regs_id = '$regid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$s_id= $rows['id'];
$regg_id= $rows['Regs_id'];
$nnm= $rows['Firstname']. " ".$rows['Middlename']." ".$rows['Lastname'];
$unn= $rows['Loan_Amount'];
$svs= $rows['Interest'];
$dp= $rows['Loan_Amount'];
$in= $rows['Interest'];
$eam= $rows['Expecting_Amount'];
$eds= $rows['Expected_Date'];
$stt= $rows['Status'];
$d_ap= $rows['Date_Paid'];
$ap= $rows['Amount_Paid'];
$pm= $rows['Payment_Method'];
$i=0;
if($i%2==0)
$classname="evenRow";
else
$classname="oddRow";
?>
<tr style="font-size: 9px" class="<?php if(isset($classname)) echo $classname;?>">
<td  style="font-size:9px"><?php echo $regg_id; ?></td>
<td  style="font-size:9px"><?php echo number_format($unn,2); ?></td>
<td  style="font-size:9px"><?php echo number_format($svs,2); ?></td>
<td  style="font-size:9px"><?php echo number_format($eam,2); ?></td>
<td  style="font-size:9px"><?php echo $eds; ?></td>
<td  style="font-size:9px"><?php echo $stt; ?></td>
</tr>
<?php  
}
}else {
//$Available = false; 
//echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>
</div>





</div>

<div id="upfront" class="section" >



<h4>Document</h4>
<div style="overflow-x:auto; height:380px">

<div class="row">
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT Location FROM document WHERE BVN = '$bvn' ORDER BY id ASC ";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$vid = $doc['Location'];
?>
<div class="col-sm-4">
<?php
$img = $doc['Location'] ?? '';
$defaultImage = '../assets/no-image.png';
if (!empty($img)) {
// Check if path starts with ../
if (strpos($img, '../') === 0) {
$imgPath = $img;
} else {
$imgPath = '../' . $img;
}

} else {
$imgPath = $defaultImage;
}
?>
<img src="<?= htmlspecialchars($imgPath) ?>" class="d-block w-100" style="height:50vh; margin:10px;" onerror="this.src='../assets/no-image.png';">
</div>
<?php
}
}else {
//No Transaction History for the account
$Available = false; 
echo "<span style='color:red'>No document Image Uploaded...  </span> ";       
}
?>
</div>


</div>

</div>




<div id="adjustment" class="section">
<h4>Loan Amount Adjustment</h4>

<br><br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadAmt">
<div class="col-sm-4">
<label><i style="color:red">*</i> Loan Amount</label>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="pr" value="<?php echo $row['Product_id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="ten" value="<?php echo $row['Tenure']; ?>" required>
<input type="number" class="form-control form-control-md" name="lum" value="<?php echo $row['Loan_Amount']; ?>" required placeholder="Enter Principal Amount">
</div>
<br>
<div class="row">
<div class="col-sm-2">
<button type="submit" class="d-block btn btn-outline-info btn-sm"> Update Amount</button>
</div>
<div class="col-sm-10">
<i style="display:none" id="waits"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Updating Principal Amount.! Please wait..</i>
<i style="color: green; display:none" id="prin"><i class="fa fa-check"></i> Principal Amount Updated..</i>
</div>
</div>
</div>
</form>

</div>

<div id="crc" class="section">
<h4>CRC Record</h4>
<br>
<br>
<?php 
if($row['Approval_Type'] == 'CRC Approval'){
?>
<?php 
include '../config/db.php';
// Get CRC document
$query = "SELECT id, Location FROM document WHERE Reg_ID = '$regid' AND Type = 'CRC Document' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$crc = $row['Location'];
// Determine correct path
if (!empty($crc)) {
if (strpos($crc, '../') === 0) {
$crcPath = $crc;
} else {
$crcPath = '../' . $crc;
}
} else {
$crcPath = '';
}
if (!empty($crcPath)) {
?>
<embed src="<?= htmlspecialchars($crcPath) ?>" type="application/pdf" width="100%" height="430px">
<?php
} else {
echo "No CRC Report Found<br>";
}
} else {
echo "No CRC Report Found<br>";
}
?>



<?php 
}else if ($row['Approval_Type'] == 'Exceptional Approval'){
?>

<span>Approval Status:</span> <b style="color:chocolate"><?php echo $row['Approval_Type']; ?></b>
<br>
<?php 
include '../config/db.php';
//
$Query = "SELECT * FROM reason WHERE RegNo='$regid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$reason = $row['Reason'];
$reason_by = $row['Stated_By'];
$reason_bvn = $row['BVN_ID'];
?>
<hr>
<b>Reason:</b> <?php echo $reason; ?><br>
<b>Stated By:</b> <?php echo $reason_by; ?><br>

<?php 
}else{
?>


<?php 
include '../config/db.php';
// Get CRC document
$query = "SELECT id, Location FROM document WHERE Reg_ID = '$regid' AND Type = 'CRC Document' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$crc = $row['Location'];
// Determine correct path
if (!empty($crc)) {
if (strpos($crc, '../') === 0) {
$crcPath = $crc;
} else {
$crcPath = '../' . $crc;
}
} else {
$crcPath = '';
}
if (!empty($crcPath)) {
?>
<embed src="<?= htmlspecialchars($crcPath) ?>" type="application/pdf" width="100%" height="430px">
<?php
} else {
echo "No CRC Report Found<br>";
}
} else {
echo "No CRC Report Found<br>";
}
?>


<?php
}
?>



</div>

<div id="approval" class="section">
<h4>Disbursement</h4>

<br>
<div class="row">
<div class="col-sm-4">
<b>Principal Amount:</b>
<?php echo number_format($lum,2); ?>
</div>
<div class="col-sm-4">
<b>Total Upfront:</b>
<span>
<?php echo number_format($up + $inss + $form + $card,2); ?>
</span>
</div>
<div class="col-sm-4">
<b>Amt To Disburse:</b>
<span>
<?php 
if($upty == 'Deduction'){
$fee = $up + $inss + $form + $card;
echo number_format($lum - $fee,2);
}else{
echo number_format($lum,2);
}
?>
</span>
</div>
</div>
<br><br>
<form action="" method="POST" enctype="multipart/form-data" id="approveLoan">
<div class="row">
<div  class="col-sm-6">
<small>Loan Account No [From Germini]</small>
<input type="text" class="form-control form-control-md" name="id" hidden value="<?php echo $regid; ?>" required>
<input type="text" class="form-control form-control-md" name="bv" hidden value="<?php echo $bvn; ?>" required>
<input type="text" class="form-control form-control-md" name="vrt" hidden value="<?php echo $vrt; ?>" required>
<input type="number" class="form-control form-control-md" name="lon" placeholder="Enter Loan Account No" required>
</div>
<div  class="col-sm-6">
<small>Disbursement No [From Germini]</small>
<input type="number" class="form-control form-control-md" name="dis" placeholder="Enter Disbursement No" required>
</div>
</div>
<div id="disbtn">
<hr>
<?php 
if($upty == "Deduction"){
?>
<button type="submit" class="btn btn-outline-success btn-sm" onclick="data()" id="save">Disburse Loan</button>
<?php 
}else{
?>
<?php 
include '../config/db.php';
$Query = "SELECT * FROM fee WHERE Reg_id = '$regid' AND Reciept_Status = 'Reciept Confirmed'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row != 0){
?>
<button type="submit" class="btn btn-outline-success btn-sm" onclick="data()" id="save">Disburse Loan</button>
<?php 
}else{
?>
<b style="color:red;">Upfront payment need to be confirm by you before disbursing the loan</b>
<?php
}
?>
<?php
}
?>
</div>


</form>
<hr>

<br>
<div class="row">
<div class="col-sm-3" style="margin-top:10px; display:none">

</div>
<div class="col-sm-3" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="declineLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-warning btn-sm" style="font-size:10px;"><i class="fa fa-exclamation-triangle"></i> Reverse Application</button>
</div>
</form>
</div>
<div class="col-sm-3" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="deleteLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-danger btn-sm" style="font-size:10px;"><i class="fa fa-trash"></i> Delete Application</button>
</div>
</form>
</div>
</div>
</div>

</div>

<!-- JAVASCRIPT -->
<script>
function showSection(sectionId) {
  // hide all
  document.querySelectorAll('.section').forEach(div => {
    div.style.display = 'none';
  });

  // show selected
  document.getElementById(sectionId).style.display = 'block';
}

// default view
document.getElementById('customer').style.display = 'block';
</script>




<script>
$(document).ready(function () {
$('#crcCheck').on('change', function () {
if (this.checked) {
// Uncheck other checkbox
$('#expCheck').prop('checked', false);
// Show CRC section, hide Exceptional
$('#upload').slideDown();
$('#exp').slideUp();
} else {
$('#upload').slideUp();
}
});

$('#expCheck').on('change', function () {
if (this.checked) {
// Uncheck other checkbox
$('#crcCheck').prop('checked', false);
// Show Exceptional section, hide CRC
$('#exp').slideDown();
$('#upload').slideUp();
} else {
$('#exp').slideUp();
}
});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
setTimeout(function(){
///alert(data)
$("#myDiv").load( "client_loan_disbursement_page.php?id=<?php echo $id; ?> #myDiv" );// 
$("#amt").load( "client_loan_disbursement_page.php?id=<?php echo $id; ?> #amt" );// 
//$("#hey").html(data);
}, 100);
// ajax function ends here
});
</script>








<script>
var load = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
var loadClient = function(event) {
var image = document.getElementById('client');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>
<script>
function clientDash(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'block';
y.style.display = 'none';
b.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
c.style.display = 'none';
d.style.display = 'none';
e.style.display = 'none';
k.style.display = 'none';
}
function updateDoc(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'none';
b.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
c.style.display = 'none';
d.style.display = 'none';
e.style.display = 'none';
k.style.display = 'none';
y.style.display = 'block';
}
function updateVerification(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'none';
b.style.display = 'none';
z.style.display = 'block';
y.style.display = 'none';
a.style.display = 'none';
c.style.display = 'none';
d.style.display = 'none';
k.style.display = 'none';
e.style.display = 'none';
}
function updateApprove(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
a.style.display = 'block';
y.style.display = 'none';
b.style.display = 'none';
c.style.display = 'none';
d.style.display = 'none';
k.style.display = 'none';
e.style.display = 'none';
}
function updateLoan(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
b.style.display = 'block';
a.style.display = 'none';
y.style.display = 'none';
c.style.display = 'none';
k.style.display = 'none';
d.style.display = 'none';
e.style.display = 'none';
}
function updateUpfront(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
c.style.display = 'block';
b.style.display = 'none';
a.style.display = 'none';
y.style.display = 'none';
d.style.display = 'none';
k.style.display = 'none';
e.style.display = 'none';
}
function updateRemark(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
d.style.display = 'block';
c.style.display = 'none';
b.style.display = 'none';
a.style.display = 'none';
y.style.display = 'none';
e.style.display = 'none';
k.style.display = 'none';
}
function updateDisburse(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
e.style.display = 'block';
c.style.display = 'none';
b.style.display = 'none';
a.style.display = 'none';
d.style.display = 'none';
k.style.display = 'none';
y.style.display = 'none';
}
function updateCRC(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("loan");
var c = document.getElementById("fifth");
var d = document.getElementById("sixth");
var e = document.getElementById("disburse");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
k.style.display = 'block';
e.style.display = 'none';
c.style.display = 'none';
b.style.display = 'none';
a.style.display = 'none';
d.style.display = 'none';
y.style.display = 'none';
}
</script>


<script type="text/javascript">
function getDocument()  {
var regid = document.getElementById("regid").value;
var document_type = document.getElementById("document").value;
// ajax function start here
$.ajax({
method: "POST",
url: "preview_document_bck.php",
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




<script type="text/javascript">
$(document).ready(function (e){
$("#approveLoan").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to disburse this customer loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "disburse_loan_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#approveLoan")[0].reset();
if(data == 1){
$("#please").hide();
alert("Disbursement number already exist.! Please check and try again...");
$("#updateModal").modal('show');
}else if(data == 2){
$("#please").hide();
alert("Loan account number already exist.! Please check and try again...");
$("#updateModal").modal('show');
}else if(data == 3){
$("#please").hide();
alert("Customer still has an runing loan.! Please check and try again...");
$("#updateModal").modal('show');
}else if(data == 4){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
loads();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 7000);
}else{
$("#please").hide();
alert ("🚫" + data);
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
$("#goBack").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to disburse this customer loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "loan_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
loads();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 7000);
}else{
$("#please").hide();
alert ("🚫" + data);
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
$("#declineLoan").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to reverse this loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "reverse_loan_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#declineLoan")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
loads();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 7000);
}else{
$("#please").hide();
alert ("🚫" + data);
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
function loads()  {
$.ajax({
method: "POST",
url: "load_disbursement_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadAmt").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update principal loan amount ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: "update_principal_amt.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#prins").show();
$("#wait").hide();
}, 4000);
setTimeout(function(){
$("#prins").hide();
$("#wait").hide();
$("#uploadAmt")[0].reset();
}, 7000);
}else if(data ==2){
$("#wait").show();
setTimeout(function(){
$("#firsts").load( "client_loan_disbursement_page.php?id=<?php echo $regid; ?> #firsts" );// 
$("#prin").show();
$("#wait").hide();
}, 5000);
setTimeout(function(){
$("#prin").hide();
}, 10000);
}else{
$("#uploadAmt")[0].reset();
$("#wait").hide();
alert ("🚫" + data);
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
$("#deleteLoan").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete this loan application from database..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "delete_loan_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#deleteLoan")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toas").show();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toas").hide();
loads();
}, 7000);
}else{
$("#please").hide();
alert ("🚫" + data);
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
$("#uploadUpfront").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to change upfront payments mode ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#up").show();
$.ajax({
url: "update_upfront_mode.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#up").hide();
$("#mode").load( "client_loan_disbursement_page.php?id=<?php echo $regid; ?> #mode" );// 
$("#page").load( "client_loan_disbursement_page.php?id=<?php echo $regid; ?> #page" );// 
$("#check").load( "client_loan_disbursement_page.php?id=<?php echo $regid; ?> #check" );// 
$("#checks").load( "client_loan_disbursement_page.php?id=<?php echo $regid; ?> #checks" );// 
$("#update").show();
}, 3000);
setTimeout(function(){
$("#up").hide();
$("#update").hide();
}, 6000);
}else{
$("#up").hide();
alert ("🚫" + data);
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
$("#recieptUpload").on('submit',(function(e){ e.preventDefault();
$("#confirm").show();
$.ajax({
url: "upload_reciept_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#confirm").show();
$("#recieptUpload")[0].reset();
if(data == 1){
setTimeout(function(){
$("#confirm").hide();
$("#upload").show();
$("#btnload").load("client_loan_disbursement_page.php?id=<?php echo $regid; ?> #btnload");// 
$("#disbtn").load("client_loan_disbursement_page.php?id=<?php echo $regid; ?> #disbtn");// 
}, 3000);
setTimeout(function(){
$("#confirm").hide();
$("#upload").hide();
}, 6000);
}else{
$("#confirm").hide();
alert ("🚫" + data)
}
},
error: function(){
}
});
}));
});
</script>
