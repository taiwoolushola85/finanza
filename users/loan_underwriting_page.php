<?php 
include_once '../config/db.php';

$id = intval($_GET['id']); // reg id

// Register info
$query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$regid = $row['id'];
$reg_status = $row['Status'];
$un = $row['Unions'];
$bvn = $row['BVN'];
$pr = $row['Product_id'];
$ten = $row['Tenure'];
$frq = $row['Frequency'];
$lum = $row['Loan_Amount'];

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
      <i class="fa fa-comment"></i> Comment & Approval
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
<span style="margin-left:8px;"><b>Acct Name:</b> <?php echo $row['Account_Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Acct No:</b> <?php echo $row['Account_No']; ?></span>
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
<div style="height:350px; overflow-y:auto; overflow-x:hidden;">
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
<b>Repayment Day:</b> <?php echo $row['Repayment_Day']; ?>
<br>
<br>
<form action="" method="post" id="uploadRole">
<div class="row">
<div class="col-sm-6">
<small>No Of Installments</small>
<input type="number" hidden="hidden" class="form-control form-control-md" value="<?php echo $row['Tenure']; ?>" placeholder="number of days" required="required" name="no">
<input type="number" disabled="disabled" class="form-control form-control-md" value="<?php echo $row['Tenure']; ?>" placeholder="number of days" required="required">
</div>
<div class="col-sm-6">
<small>First Payment Date</small>
<input type="text" class="form-control form-control-md" hidden required="required" name="id" value="<?php echo $regid; ?>">
<input type="date" class="form-control form-control-md" required="required" name="ft">
</div>
</div><br>
<div class="row">
<div class="col-sm-4" style="margin-top:10px">
<button type="submit" class="btn btn-outline-info btn-block btn-sm" name="calculate" onclick="data()">Calculate Date</button>
</form>
</div>
<div class="col-sm-8">
<i style="display:none" id="sche"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Saving loan repayment schedule.! Please wait..</i>
<i style="color: green; display:none" id="yes"><i class="fa fa-check"></i> Loan schedule successfully saved, please proceed for comment & approval.!!.</i>
</div>
</div>
<br>
<i style="display:none" id="wait"><img src="../loader/loader.gif" style="height:20px"> Loading Data ! Please wait...</i>
<div id="results"></div>




</div>

<div id="upfront" class="section">
<h4>Document</h4>
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
$vid = $rows['Location'];
?>
<div class="col-sm-4">
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
<h4>Application Comment</h4>




<div class="col-xl-12 col-xxl-12 col-sm-12">
<div class="d-flex justify-content-between align-items-center">
</div>
<div>
<div class="px-4 mx-n4 simplebar-scrollable-y" data-simplebar="init" style="max-height:200px;">
<div class="simplebar-wrapper" style="margin: 0px -16px;">
<div class="simplebar-height-auto-observer-wrapper">
<div class="simplebar-height-auto-observer"></div>
</div>
<div class="simplebar-mask">
<div class="simplebar-offset" style="right: 0px; bottom: 0px;">
<div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
<div class="simplebar-content" style="padding: 0px 16px;">
<div class="timeline">
<?php 
include '../config/db.php';
$Query = "SELECT Comment, Comment_By, User_Role, Date_Comment, Time_Comment FROM comment WHERE Reg_No = '$regid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
?>
<div class="timeline-item">
<div class="timeline-pin">
<i class="marker marker-circle text-info"></i>
</div>
<p class="rich-list-title text-muted lh-lg">
<strong class="text-body"><?php echo $rows['Comment_By']; ?>:</strong>
<a href="#!" class="text-body fw-medium">Comment:</a> <?php echo $rows['Comment']; ?>
<span class="badge badge-label-info">[ <?php echo $rows['User_Role']; ?> ]</span>.
</p>
<span class="rich-list-subtitle mb-2"><?php echo $rows['Date_Comment']; ?> <a href="#!"><?php echo $rows['Time_Comment']; ?></a></span>
</div>

<?php
}
}
?>

</div>
</div>
</div>
</div>
</div>
<div class="simplebar-placeholder" style="width: 920px; height: 437px;">
</div>
</div>
<div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
<div class="simplebar-scrollbar" style="width: 0px; display: none;">
</div>
</div>
<div class="simplebar-track simplebar-vertical" style="visibility: visible;">
<div class="simplebar-scrollbar" style="height: 335px; transform: translate3d(0px, 47px, 0px); display: block;"></div>
</div>
</div>
</div>





<b>Loan Application Remark Box</b>
<br><br>
<form action="" method="POST" enctype="multipart/form-data" id="loanRemark">
<label style="font-size:13px"><i style="color:red">*</i> Remark/Comment</label>
<input type="number" class="form-control form-control-md" name="id" value="<?php echo $regid; ?>" hidden required="required">
<textarea type="text" class="form-control form-control-sm" name="remark" cols="6" rows="6" required></textarea><br>
<div class="row">
<div class="col-sm-3" style="margin-top:10px;">
<div class="d-grid gap-2 mb-2">
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"> </i> Submit & Approve Application</button>
</div>
</form>
</div>
<div class="col-sm-3" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="deleteLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-danger btn-sm" style="font-size:10px;"><i class="fa fa-exclamation-triangle"></i> Cancel Application</button>
</div>
</form>
</div>
</div>

</div>
<br>








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
}, 1000);
// ajax function ends here
});
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRole").on('submit',(function(e){ e.preventDefault();
$("#wait").show();
$.ajax({
url: "schedule_load.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#wait").show();
setTimeout(function(){
$("#wait").hide();
$('#results').html(data);
}, 1000);
},
error: function(){
}
});
}));
});
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#uploadAmt").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update principal loan amount ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#waits").show();
$.ajax({
url: "update_principal.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#prin").show();
$("#waits").hide();
}, 4000);
setTimeout(function(){
$("#prin").hide();
$("#waits").hide();
$("#uploadAmt")[0].reset();
}, 7000);
}else if(data ==2){
$("#waits").show();
setTimeout(function(){
$("#firsts").load( "loan_underwriting_page.php?id=<?php echo $id; ?> #firsts" );// 
$("#prin").show();
$("#waits").hide();
}, 5000);
setTimeout(function(){
$("#prin").hide();
}, 10000);
}else{
$("#uploadAmt")[0].reset();
$("#waits").hide();
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
$("#loanRemark").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to submit and approve loan application for disbursement..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "approve_first_underwriting.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#loanRemark")[0].reset();
if(data == 1){
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
$("#deleteLoan").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete this loan application from database..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "delete_first_underwriting.php",
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
$("#toasts").show();
loads();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
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
function loads()  {
$.ajax({
method: "POST",
url: "load_underwriting_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 