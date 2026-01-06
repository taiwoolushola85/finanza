
<?php 
include_once '../config/db.php';
$id = $_GET['id']; // reg id
// 
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$reg_status = $row['Status'];
$bvn = $row['BVN'];
$upty = $row['Upfront_Types'];
$la = $row['Loan_Amount'];
$vrt = $row['Virtual_Account'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
?>
<div class="row">
<div class="col-sm-12" style="margin-top:10px;">
<div style="overflow-x: auto;">
<div class="btn-group">
<button class="btn btn-light" onclick="clientDash()"><i class="fa fa-user"></i> Customer Profile</button>
<button class="btn btn-light" onclick="updateDoc()"><i class="fa fa-eye"></i> Review Document</button>
<button class="btn btn-light" onclick="updateVerification()"><i class="fa fa-briefcase"></i> Business Image</button>
<button class="btn btn-light" onclick="updateLoan()"><i class="fa fa-plus"></i> Update Loan Amount</button>
<button class="btn btn-light" onclick="updateCRC()"><i class="fa fa-file"></i> Customer CRC Data </button>
<button class="btn btn-light" onclick="updateUpfront()"><i class="fa fa-money-bill"></i> Upfront Payment </button>
<button class="btn btn-light" onclick="updateRemark()"><i class="fa fa-comment"></i> Remark/Coment</button>
<button class="btn btn-light" onclick="updateDisburse()"><i class="fa fa-star"></i> Disbursement</button>
</div>
</div>
<br>
</div>
</div>

<div id="firsts" style="display:block; font-size:12px">
<div class="row">
<div class="col-sm-6">
<br>
<b><i class="fa fa-star"></i> CLIENT INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<img src="<?php echo $row['Location']; ?>" style="height:50px; width:50px; border-radius:50px; margin-left:8px;">
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
<img src="<?php echo $rows['Location']; ?>" style="height:50px; width:50px; border-radius:50px; margin-left:8px;">
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
</div>



<div id="seconds" style="display:none;">
<br><br>
<b>CLIENT DOCUMENT REVIEW</b>
<br><br>
<b>Select client document to review</b>
<br><br>
<div class="row">
<div class="col-sm-4">
<label>Select Document</label>
<input type="number" class="form-control for-control-sm" hidden id="regid" value="<?php echo $regid; ?>">
<select class="form-control for-control-sm" id="document" oninput="getDocument()">
<option value="">Select Option</option>
<option value="Loan Form">Loan Form</option>
<option value="Utility Bill">Utility Bill</option>
<option value="ID Card">ID Card</option>
<option value="KYC Form">KYC Form</option>
<option value="Other Documents">Other Documents</option>
</select>
</div>
</div>
<br><br>
<div id="documentview"></div>
</div>





<div id="crc" style="display:none;">
<br><br>
CRC REPORT
<br><br>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT id, Location FROM document WHERE Reg_ID = '$regid' ORDER BY id DESC LIMIT 1";
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
<br><br>
<b>UPDATE PRINCIPAL AMOUNT</b>
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
<i style="display:none" id="wait"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Updating Principal Amount.! Please wait..</i>
<i style="color: green; display:none" id="prin"><i class="fa fa-check"></i> Principal Amount Updated..</i>
</div>
</div>
</div>
</form>
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
<img src="<?php echo $img?>" class="d-block w-100" alt="..." style="height:50vh; margin:10px">
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

<div id="fifth" style="display:none;">

<div class="row">
<div class="col-sm-3" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="uploadUpfront">
<div style="width:250px">
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
<br>
<div class="row">
<div class="col-sm-5" style="margin-top:10px;">
<button type="submit" class="btn btn-info btn-sm">Change Mode</button>
</form>
</div>
<div class="col-sm-7" style="margin-top:10px;">
<i style="display:none" id="up"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Updating Payment Mode.! Please wait..</i>
<i style="color: green; display:none" id="update"><i class="fa fa-check"></i> Upfront Payment Mode Updated..</i>
</div>
</div>
</div>


<br>
<div id="checks">
<div class="row">
<div class="col-sm-3">
<div id="mode">
<b>Payment Mode:</b>
<?php 
echo $row['Upfront_Types'];
?>
</div>
</div>
<div class="col-sm-2">
<b>Virtual Acct:</b>
<span>
<?php 
echo $row['Virtual_Account'];
?>
</span>
</div>
<div class="col-sm-2">
<b>Loan Amount:</b>
<span>
<?php 
echo number_format($row['Loan_Amount'],2);
?>
</span>
</div>
<div class="col-sm-2">
<b>Upfront Amt:</b>
<span>
<?php 
$fee = $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form'];
echo number_format($fee,2);
?>
</span>
</div>
<div class="col-sm-2">
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
</div>
<hr>



<div class="col-sm-12" style="margin-top:10px;">
<div id="check">
<?php 
if($row['Upfront_Types'] == 'Deduction' ){
echo "<i>Upfront payment need to be remove from the principal amount</i>";
}else if($row['Upfront_Types'] == 'Virtual Payment'){
?>
<span>Virtual Payment History</span>




<?php 
}else if($row['Upfront_Types'] == 'Monie Point Payment'){
?>



<table style="font-size:9px;">
<thead>
<tr>
<th style="font-size:8px">PAYMENT ID</th>
<th style="font-size:8px">UPFRONT</th>
<th style="font-size:8px">INSSURANCE</th>
<th style="font-size:8px">FORM</th>
<th style="font-size:8px">CARD</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">RECIEPT</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>
<tbody>
<?php
include('../config/db.php');
$d = date('Y-m-d');
//Get branch Details
$Query = "SELECT * FROM fee WHERE Reg_id = '$regid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$feeid= $rows['id'];
$regg_id= $rows['Reg_id'];
$up = $rows['Upfront'];
$in = $rows['Inssurance'];
$form = $rows['Form'];
$card = $rows['Card'];
$status = $rows['Reciept_Status'];
$reci = $rows['Reciept'];
?>
<tr style="font-size: 9px">
<td  style="font-size:9px"><?php echo $feeid; ?></td>
<td  style="font-size:9px"><?php echo number_format($up,2); ?></td>
<td  style="font-size:9px"><?php echo number_format($in,2); ?></td>
<td  style="font-size:9px"><?php echo number_format($form,2); ?></td>
<td  style="font-size:9px"><?php echo number_format($card,2); ?></td>
<td  style="font-size:9px"><?php echo $status; ?></td>
<td  style="font-size:9px"><a href="#" class = "invk" data-toggle="modal" data-target="#recieptdata" id="<?php echo $feeid; ?>">
<i class="fa fa-eye"></i> View Reciept</a></td>
<td  style="font-size:9px"><a href="#" class = "inv" id="<?php echo $regg_id; ?>" style="color:green;"><i class="fa fa-check"></i> Confirm Payment</a></td>
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



<?php 
}else if($row['Upfront_Types'] == 'Saving For Upfront'){
?>

<span>Deduct Saving For Upfront</span>
<hr>
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Select Savings Acct No</label>
<select type="text" class="form-control form-control-md" name="sav" required>
<option value="">Select Account</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Savings_Account_No FROM savings WHERE Client_BVN='$bvn' AND Status = 'Active' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$nx= $rows['id']; // id
$name= $rows['Savings_Account_No'];
?>
<option value="<?php echo $nx; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Amount To Deduct</label>
<input type="text" class="form-control form-control-sm" name="amt" hidden value="<?php echo $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form']; ?>" required>
<input type="text" class="form-control form-control-sm" disabled value="<?php echo $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form']; ?>" required>
</div>
</div>
<br>
<button type="submit" class="btn btn-primary btn-sm">Confirm & Upload</button>


<?php
}else{
echo "Invalid Payment Mode";
}
?>
</div>

</div>

</div>

<br>
<br>

</div>


<div id="sixth" style="display:none;">

<div class="col-xl-12 col-xxl-12 col-sm-12">
<div class="d-flex justify-content-between align-items-center">
<h5 class="card-title mb-0">Recent Comment</h5>
</div>
<div>
<div class="px-4 mx-n4 simplebar-scrollable-y" data-simplebar="init" style="max-height:350px;">
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
<a href="#!" class="text-body fw-medium">Comment:</a> <?php echo $rows['Comment']; ?><br>
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
</div>

</div>



<div id="disburse" style="display:none;">
<div id="page">
<br>
<div class="row">
<div class="col-sm-4">
<b>Loan Disbursement</b>
</div>
<div class="col-sm-4">

</div>
<div class="col-sm-4">
<b>Amt To Disburse:</b>
<span>
<?php 
if($upty == 'Deduction'){
$fee = $row['Upfront'] + $row['Inssurance'] + $row['Card'] + $row['Form'];
echo number_format($row['Loan_Amount'] - $fee,2);
}else{
echo number_format($la,2);
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
</div>

</form>
<hr>


<b class="fa fa-table"> Client Repayment Schedule Table</b>
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
<div style="overflow-x: auto; height:200px">
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
echo"<small> No Record Found  </small> ";       
}
?>
</tbody>
</table>


</div>



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










<script>
// to show data on a modal box
$(document).ready(function() {
$('.invk').on('click', function() {
var recID = $(this).attr('id');
if(recID) {
$("#recieptdata").modal('show');
$.ajax({
url: 'upfront_reciept.php',
type: "POST",
data: {'id':recID},
dataType: "json",
success:function(data) {
$('#recp').val(data.recieptLocation);
$("#recp").attr("src",data.recieptLocation);
}
});
}else{

}
});
});
</script>



<script>
// confirming upfront fee payment
$(document).ready(function() {
$('.inv').on('click', function() {
WRN_PROFILE_DELETE = "You are about to disburse this customer loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var recID = $(this).attr('id');
if(recID) {
$.ajax({
url: 'confirm_upfront.php',
type: "POST",
data: {'id':recID},
success:function(data) {
if(data == 1){
$("#check").load( "client_loan_disbursement_page.php?id=<?php echo $regid; ?> #check" );// 
$("#disbtn").load( "client_loan_disbursement_page.php?id=<?php echo $regid; ?> #disbtn" );// 
}else{
alert(data);
}
}
});
}else{

}
}
});
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
$("#declineLoan").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to decline this loan application..";
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
