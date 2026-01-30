<?php 
include_once '../config/db.php';
$id = $_GET['id']; // reg id

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
$rt = $row['Rate'];
$ten = $row['Tenure'];
$frq = $row['Frequency'];
$lum = $row['Loan_Amount'];
$up = $row['Upfront'];
$inss = $row['Inssurance'];
$form = $row['Form'];
$card = $row['Card'];


// Guarantor info
$query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $query);
$rows = mysqli_fetch_assoc($result);
$gid = $rows['id'];
//

$Query = "SELECT Inssurance FROM product_list WHERE Product_id='$pr' AND Tenure = '$ten'";
$result = mysqli_query($con, $Query);
$data = mysqli_fetch_array($result);
$ins = $data['Inssurance'];

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
$sql = "UPDATE register SET Loan_Amount = '$lum', Interest_Amt = '0', Monthly_Interest = '0', Repayment_Amt = '$dailyrnd_rep', Total_Loan = '$dailyrnd_tloan'
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
$sql = "UPDATE register SET Loan_Amount = '$lum', Interest_Amt = '$rnds_int', Monthly_Interest = '$int_per_repayment', Repayment_Amt = '$rnd_rep', 
Total_Loan = '$rnd_tloan' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
//echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
} 

?>
<div class="row">
<div class="col-sm-4" style="margin-top: 10px;">
<button class="btn btn-light w-100" onclick="clientDash()"><i class="fa fa-user"></i> <br>Loan Profile</button>
</div>
<div class="col-sm-4"style="margin-top: 10px;">
<button class="btn btn-light w-100" onclick="updateMode()"><i class="fa fa-star"></i> <br>Payment Mode</button>
</div>
<div class="col-sm-4"style="margin-top: 10px;">
<button class="btn btn-light w-100" onclick="updateRemark()"><i class="fa fa-upload"></i> <br> Upfront Update</button>
</div>
</div>
<br>
</div>
<div class="col-sm-4">
<div class="row" style="display:none;">
<div class="col-sm-6" style="margin-top:5px;">
<form action="" method="POST" enctype="multipart/form-data" id="approveLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"> </i> Approve Application</button>
</div>
</form>
</div>
<div class="col-sm-6" style="margin-top:5px;">
<form action="" method="POST" enctype="multipart/form-data" id="declineLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-warning btn-sm" style="font-size:10px;"><i class="fa fa-exclamation-triangle"></i> Reverse Application</button>
</div>
</form>
</div>
</div>
</div>

</div>
</div>

<div id="firsts" style="display:block;">
<div class="row" style="font-size:11px;">
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
<span style="margin-left:8px;"><b>Name:</b> <?php echo $row['Firstname']." ".$row['Lastname']; ?></span>
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



<div class="row" style="font-size:11px;">
<div class="col-sm-6">

<div class="card border-primary border border-dashed">
<br>
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
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Bank:</b> <?php echo $row['Bank']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Account Name:</b> <?php echo $row['Account_Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Account No:</b> <?php echo $row['Account_No']; ?></span>
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
<span style="margin-left:8px;"><b>Rate:</b> <?php echo $row['Rate']; ?></span>
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


<br>
<b><i class="fa fa-star"></i> BUSINESS INFO</b>
<br><br>
<div class="table-responsive">
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
</div>
</div>




<div id="seconds" style="display:none;">
<br><br>
<b>UPFRONT PAYMENT MODE</b>
<br><br>
<form action="" method="POST" enctype="multipart/form-data" id="updateMode">
<div class="row">
<div class="col-sm-3" style="margin-top:10px;">
<label style="font-size:13px"><i style="color:red">*</i> Upfront Payment Mode</label>
<input type="number" class="form-control form-control-md" name="id" value="<?php echo $regid; ?>" hidden required="required">
<select type="text" class="form-control form-control-md" name="type" required="required">
<option value="<?php echo $row['Upfront_Types']; ?>"><?php echo $row['Upfront_Types']; ?></option>
<option value="Deduction">Deduction</option>
<option value="Virtual Payment">Virtual Payment</option>
<option value="Monie Point Payment">Monie Point Payment</option>
<option value="Saving For Upfront">Saving For Upfront</option>
</select>

</div>
</div>
<div class="row">
<div class="col-sm-2" style="margin-top:10px;">
<button type="submit" class="btn btn-info btn-sm">Change Mode</button>
</div>
<div class="col-sm-10" style="margin-top:10px;">
<i style="display:none" id="up"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Updating Payment Mode.! Please wait..</i>
<i style="color: green; display:none" id="update"><i class="fa fa-check"></i> Upfront Payment Mode Updated..</i>
</div>
</div>
</form>



</div>



<div id="crc" style="display:none;">
<br><br>
CRC REPORT
<br><br>

<?php 
if($row['Approval_Type'] == 'CRC Approval'){
?>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT id, Location FROM document WHERE BVN = '$bvn' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$crcrecord = mysqli_fetch_array($result);
$bn = $crcrecord['id'];
$crc = $crcrecord['Location'];
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


<?php 
}else{
?>

<span>Approval Status:</span> <b style="color:chocolate"><?php echo $row['Approval_Type']; ?></b>
<br>
<?php 
include '../config/db.php';
//
$Query = "SELECT * FROM reason WHERE RegNo='$regid'";
$result = mysqli_query($con, $Query);
$reasons = mysqli_fetch_array($result);
$reason = $reasons['Reason'];
$reason_by = $reasons['Stated_By'];
$reason_bvn = $reasons['BVN_ID'];
?>
<hr>
<b>Reason:</b> <?php echo $reason; ?><br>
<b>Stated By:</b> <?php echo $reason_by; ?><br>








<?php 
}
?>


</div>



<div id="fourth" style="display:none;">
<br><br>
<b>CLIENT DOCUMENT REVIEW</b>
<br><br>

</div>


<div id="thirds" style="display:none;">
<br><br>
<b>BUSINESS IMAGE</b><br><br>

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
echo "<span style='color:red'>No Business Image Uploaded...  </span> ";       
}
?>
</div>
</div>


<div id="mydiv">

<div id="sixth" style="display:none;">
<br><br>

<?php 
if($row['Upfront_Types'] == 'Deduction' ){
?>

<br>

<div class="row">
<div class="col-sm-4">
<center>
<p><img src="" id="client" style="height:400px; width:300px;" class="img-thumbnail" /></p>
</center>
</div>
<div class="col-sm-8">
<div class="row">
<div class="col-sm-3">
<div id="mode">
<b>Payment Mode:</b>
<?php 
echo $row['Upfront_Types'];
?>
</div>
</div>
<div class="col-sm-3">
<b>Loan Amount:</b>
<span>
<?php 
echo number_format($row['Loan_Amount'],2);
?>
</span>
</div>
<div class="col-sm-3">
<b>Upfront Amt:</b>
<span>
<?php 
$fee = $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form'];
echo number_format($fee,2);
?>
</span>
</div>
<div class="col-sm-3">
<b>Amt To Disburse:</b>
<span>
<?php 
if($row['Upfront_Types'] == 'Deduction'){
$fee = $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form'];
echo number_format($row['Loan_Amount'] - $fee,2);
}else{
echo number_format($row['Loan_Amount'],2);
}
?>
</span>
</div>
</div>
<br><br>

<b style="color:red;">Note:</b><i> Upload customer registration fee and comment on the loan</i>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRem">
<div class="row">
<div class="col-sm-3">
<label>Initial Saving</label>
<input type="number" class="form-control form-control-sm" name="up" value="<?php echo $up; ?>" placeholder="Enter Initial Saving" required>
</div>
<div class="col-sm-3">
<label>Insurance</label>
<input type="number" class="form-control form-control-sm" name="ins" value="<?php echo $inss; ?>" placeholder="Enter Inssurance" required>
</div>
<div class="col-sm-3">
<label>Form</label>
<input type="number" class="form-control form-control-sm" name="form" value="<?php echo $form; ?>" placeholder="Enter Form" required>
</div>
<div class="col-sm-3">
<label>Card</label>
<input type="number" class="form-control form-control-sm" name="card" value="<?php echo $card; ?>"placeholder="Enter Card" required>
</div>
</div>
<br>
<input type="text" class="form-control form-control-md" hidden name="type" value="<?php echo $row['Upfront_Types']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<div class="row">
<div class="col-sm-3">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"></i> Update</button>
</form>
</div>
</div>
<div class="col-sm-6">
<div id="pls" style="display:none;">
<i><img src="../loader/loader.gif" style="height:18px"> Updating Upfront ! Please wait...</i>
</div>
<div id="done" style="display:none;">
<span style="height:18px; color:green"><i class="fa fa-check"></i> Upfront Payment Updated</span>
</div>
<div id="exit" style="display:none;">
<span style="height:18px; color:red"><i class="fa fa-exclamation-triangle"></i> You have already save a comment/remark for this application</span>
</div>
</div>
</div>
</div>
</div>


<?php
}else if($row['Upfront_Types'] == 'Virtual Payment'){
?>

<div class="row">
<div class="col-sm-4">
<center>
<p><img src="" id="client" style="height:500px; width:300px;" class="img-thumbnail" /></p>
</center>
</div>
<div class="col-sm-8">
<div class="row">
<div class="col-sm-3">
<div id="mode">
<b>Payment Mode:</b>
<?php 
echo $row['Upfront_Types'];
?>
</div>
</div>
<div class="col-sm-3">
<b>Loan Amount:</b>
<span>
<?php 
echo number_format($row['Loan_Amount'],2);
?>
</span>
</div>
<div class="col-sm-3">
<b>Amt To Disburse:</b>
<span>
<?php 
if($row['Upfront_Types'] == 'Deduction'){
$fee = $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form'];
echo number_format($row['Loan_Amount'] - $fee,2);
}else{
echo number_format($row['Loan_Amount'],2);
}
?>
</span>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-12">
<br>
<b style="color:red;">Note:</b><i> Upload customer registration fee and comment on the loan</i>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRem">
<div class="row">
<div class="col-sm-3">
<label>Initial Saving</label>
<input type="number" class="form-control form-control-sm" name="up" value="<?php echo $up; ?>" placeholder="Enter Initial Saving" required>
</div>
<div class="col-sm-3">
<label>Insurance</label>
<input type="number" class="form-control form-control-sm" name="ins" value="<?php echo $inss; ?>" placeholder="Enter Inssurance" required>
</div>
<div class="col-sm-3">
<label>Form</label>
<input type="number" class="form-control form-control-sm" name="form" value="<?php echo $form; ?>" placeholder="Enter Form" required>
</div>
<div class="col-sm-3">
<label>Card</label>
<input type="number" class="form-control form-control-sm" name="card" value="<?php echo $card; ?>"placeholder="Enter Card" required>
</div>
</div>
<br>
<input type="text" class="form-control form-control-md" hidden name="type" value="<?php echo $row['Upfront_Types']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<div class="row">
<div class="col-sm-3">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"></i> Update</button>
</form>
</div>
</div>
<div class="col-sm-6">
<div id="pls" style="display:none;">
<i><img src="../loader/loader.gif" style="height:18px"> Updating Upfront ! Please wait...</i>
</div>
<div id="done" style="display:none;">
<span style="height:18px; color:green"><i class="fa fa-check"></i> Upfront Payment Updated</span>
</div>
<div id="exit" style="display:none;">
<span style="height:18px; color:red"><i class="fa fa-exclamation-triangle"></i> You have already save a comment/remark for this application</span>
</div>
</div>
</div>
</div>
</div>

<?php 
}else if($row['Upfront_Types'] == 'Monie Point Payment'){
?>


<div class="row">
<div class="col-sm-4">
<center>
<p><img src="" id="client" style="height:500px; width:300px;" class="img-thumbnail" /></p>
</center>
</div>
<div class="col-sm-8">
<div class="row">
<div class="col-sm-3">
<div id="mode">
<b>Payment Mode:</b>
<?php 
echo $row['Upfront_Types'];
?>
</div>
</div>
<div class="col-sm-3">
<b>Loan Amount:</b>
<span>
<?php 
echo number_format($row['Loan_Amount'],2);
?>
</span>
</div>
<div class="col-sm-3">
<b>Amt To Disburse:</b>
<span>
<?php 
if($row['Upfront_Types'] == 'Deduction'){
$fee = $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form'];
echo number_format($row['Loan_Amount'] - $fee,2);
}else{
echo number_format($row['Loan_Amount'],2);
}
?>
</span>
</div>
</div>
<br>
<b style="color:red;">Note:</b><i> Upload customer registration fee and comment on the loan</i>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRem">
<label>Upload Reciept Payment</label><i style="color:red">only [jpg, png, jpeg]</i>
<input type="text" hidden class="form-control form-control-sm" name="type" placeholder="" value="<?php echo $row['Upfront_Types']; ?>">
<input type="text" hidden class="form-control form-control-sm" name="sta" placeholder="" value="<?php echo $row['Loan_Status']; ?>">
<input type="file" class="form-control form-control-sm" onchange="loadClient(event)" name="Pic" required>
<br>
<div class="row">
<div class="col-sm-3">
<label>Initial Saving</label>
<input type="number" class="form-control form-control-sm" name="up" value="<?php echo $up; ?>" placeholder="Enter Initial Saving" required>
</div>
<div class="col-sm-3">
<label>Insurance</label>
<input type="number" class="form-control form-control-sm" name="ins" value="<?php echo $inss; ?>" placeholder="Enter Inssurance" required>
</div>
<div class="col-sm-3">
<label>Form</label>
<input type="number" class="form-control form-control-sm" name="form" value="<?php echo $form; ?>" placeholder="Enter Form" required>
</div>
<div class="col-sm-3">
<label>Card</label>
<input type="number" class="form-control form-control-sm" name="card" value="<?php echo $card; ?>"placeholder="Enter Card" required>
</div>
</div>
<br>
<input type="text" class="form-control form-control-md" hidden name="type" value="<?php echo $row['Upfront_Types']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<div class="row">
<div class="col-sm-4">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"></i> Update</button>
</form>
</div>
</div>
<div class="col-sm-6">
<div id="pls" style="display:none;">
<i><img src="../loader/loader.gif" style="height:18px"> Updating Upfront ! Please wait...</i>
</div>
<div id="done" style="display:none;">
<span style="height:18px; color:green"><i class="fa fa-check"></i> Upfront Payment Updated</span>
</div>
<div id="exit" style="display:none;">
<span style="height:18px; color:red"><i class="fa fa-exclamation-triangle"></i> You have already save a comment/remark for this application</span>
</div>
</div>
</div>
</div>
</div>


<?php 
}else if($row['Upfront_Types'] == 'Saving For Upfront'){
?>


<div class="row">
<div class="col-sm-4">
<center>
<p><img src="" id="client" style="height:500px; width:300px;" class="img-thumbnail" /></p>
</center>
</div>
<div class="col-sm-8">
<div class="row">
<div class="col-sm-3">
<div id="mode">
<b>Payment Mode:</b>
<?php 
echo $row['Upfront_Types'];
?>
</div>
</div>
<div class="col-sm-3">
<b>Loan Amount:</b>
<span>
<?php 
echo number_format($row['Loan_Amount'],2);
?>
</span>
</div>
<div class="col-sm-3">
<b>Amt To Disburse:</b>
<span>
<?php 
if($row['Upfront_Types'] == 'Deduction'){
$fee = $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form'];
echo number_format($row['Loan_Amount'] - $fee,2);
}else{
echo number_format($row['Loan_Amount'],2);
}
?>
</span>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-12">
<br>
<b style="color:red;">Note:</b><i> Upload customer registration fee and comment on the loan</i>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRem">
<div class="row">
<div class="col-sm-3">
<label>Initial Saving</label>
<input type="number" class="form-control form-control-sm" name="up" value="<?php echo $up; ?>" placeholder="Enter Initial Saving" required>
</div>
<div class="col-sm-3">
<label>Insurance</label>
<input type="number" class="form-control form-control-sm" name="ins" value="<?php echo $inss; ?>" placeholder="Enter Inssurance" required>
</div>
<div class="col-sm-3">
<label>Form</label>
<input type="number" class="form-control form-control-sm" name="form" value="<?php echo $form; ?>" placeholder="Enter Form" required>
</div>
<div class="col-sm-3">
<label>Card</label>
<input type="number" class="form-control form-control-sm" name="card" value="<?php echo $card; ?>"placeholder="Enter Card" required>
</div>
</div>
<br>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="type" value="<?php echo $row['Upfront_Types']; ?>" required>
<div class="row">
<div class="col-sm-4">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"></i> Update</button>
</form>
</div>
</div>
<div class="col-sm-6">
<div id="pls" style="display:none;">
<i><img src="../loader/loader.gif" style="height:18px"> Updating Upfront ! Please wait...</i>
</div>
<div id="done" style="display:none;">
<span style="height:18px; color:green"><i class="fa fa-check"></i> Upfront payment updated</span>
</div>
<div id="exit" style="display:none;">
<span style="height:18px; color:red"><i class="fa fa-exclamation-triangle"></i> You have already save a comment/remark for this application</span>
</div>
</div>
</div>
</div>
</div>

<?php
}else{
echo "Invalid Payment Mode";
}
?>

</div>

</div>






<div id="seconds" style="display:none;">
<br><br>
<b>UPFRONT PAYMENT MODE</b>
<br><br>
<form action="" method="POST" enctype="multipart/form-data" id="updateMode">
<div class="row">
<div class="col-sm-3" style="margin-top:10px;">
<label style="font-size:13px"><i style="color:red">*</i> Upfront Payment Mode</label>
<input type="number" class="form-control form-control-md" name="id" value="<?php echo $regid; ?>" hidden required="required">
<select type="text" class="form-control form-control-md" name="type" required="required">
<option value="<?php echo $row['Upfront_Types']; ?>"><?php echo $row['Upfront_Types']; ?></option>
<option value="Deduction">Deduction</option>
<option value="Virtual Payment">Virtual Payment</option>
<option value="Monie Point Payment">Monie Point Payment</option>
<option value="Saving For Upfront">Saving For Upfront</option>
</select>

</div>
</div>
<div class="row">
<div class="col-sm-2" style="margin-top:10px;">
<button type="submit" class="btn btn-info btn-sm">Change Mode</button>
</div>
<div class="col-sm-10" style="margin-top:10px;">
<i style="display:none" id="up"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Updating Payment Mode.! Please wait..</i>
<i style="color: green; display:none" id="update"><i class="fa fa-check"></i> Upfront Payment Mode Updated..</i>
</div>
</div>
</form>



</div>



<div id="list" style="display:none;">
<br>
<b>LOAN HISTORY</b>
<br>
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
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
var f = document.getElementById("list");
x.style.display = 'block';
y.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
b.style.display = 'none';
k.style.display = 'none';
f.style.display = 'none';
}
function updateMode(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
var f = document.getElementById("list");
x.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
y.style.display = 'block';
b.style.display = 'none';
k.style.display = 'none';
}
function updateVerification(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
var f = document.getElementById("list");
x.style.display = 'none';
z.style.display = 'block';
y.style.display = 'none';
a.style.display = 'none';
b.style.display = 'none';
k.style.display = 'none';
f.style.display = 'none';
}
function updateApprove(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
var f = document.getElementById("list");
x.style.display = 'none';
z.style.display = 'none';
a.style.display = 'block';
y.style.display = 'none';
b.style.display = 'none';
f.style.display = 'none';
k.style.display = 'none';
}
function updateRemark(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
var f = document.getElementById("list");
x.style.display = 'none';
z.style.display = 'none';
b.style.display = 'block';
a.style.display = 'none';
y.style.display = 'none';
k.style.display = 'none';
f.style.display = 'none';
}
function updateCRC(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
var f = document.getElementById("list");
x.style.display = 'none';
z.style.display = 'none';
k.style.display = 'block';
b.style.display = 'none';
a.style.display = 'none';
f.style.display = 'none';
y.style.display = 'none';
}
function updateHistory(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
var f = document.getElementById("list");
x.style.display = 'none';
z.style.display = 'none';
f.style.display = 'block';
k.style.display = 'none';
b.style.display = 'none';
a.style.display = 'none';
y.style.display = 'none';
}
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploadRem").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update the upfront payment ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#pls").show();
$.ajax({
url: "update_upfront.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#pls").hide();
$("#done").show();
loads();
$("#mode").load( "app_loan_profile.php?id=<?php echo $regid; ?> #mode" );// 
}, 3000);
setTimeout(function(){
$("#pls").hide();
$("#done").hide();
}, 6000);
}else{
$("#pls").hide();
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
$("#updateMode").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update the upfront payment mode ..";
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
$("#mydiv").load( "app_loan_profile.php?id=<?php echo $regid; ?> #mydiv" );// 
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
function loads()  {
$.ajax({
method: "POST",
url: "load_application_tracker.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#results').html(data);
}, 1000);
}
});
}
</script> 
