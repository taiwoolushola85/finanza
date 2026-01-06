<?php 
include_once '../config/db.php';
$id = $_GET['id']; // reg id
// 
$Query = "SELECT * FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$bvn = $row['BVN'];
$reg_status = $row['Status'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
?>
<div class="row">
<div class="col-sm-8" style="margin-top:10px;">
<div style="overflow-x: auto;">
<div class="btn-group">
<button class="btn btn-light" onclick="clientDash()"><i class="fa fa-user"></i> Loan Profile</button>
<button class="btn btn-light" onclick="updateDoc()"><i class="fa fa-eye"></i> Review Document</button>
<button class="btn btn-light" onclick="updateVerification()"><i class="fa fa-briefcase"></i> Business Image</button>
<button class="btn btn-light" onclick="updateCRC()"><i class="fa fa-file"></i> CRC Report</button>
<button class="btn btn-light" onclick="updateRemark()"><i class="fa fa-upload"></i> Upload Reciept / Comment</button>
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
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRem">
<input type="text" hidden class="form-control form-control-sm" name="type" placeholder="" value="<?php echo $row['Upfront_Types']; ?>">
<input type="text" hidden class="form-control form-control-sm" name="sta" placeholder="" value="<?php echo $row['Loan_Status']; ?>">
<input type="file" class="form-control form-control-sm" onchange="loadClient(event)" name="Pic" hidden>
<br>
<b>Loan Application Approval Comment</b>
<br><br>
<label>Remark/Comment</label>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="bvn" value="<?php echo $row['BVN']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="name" value="<?php echo $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; ?>" required>
<textarea class="form-control form-control-sm" name="remark" cols="8" rows="8" required placeholder="type here...."></textarea>
<br>
<div class="row">
<div class="col-sm-3">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"></i> Submit & Approve</button>
</form>
</div>
</div>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="declineLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-warning btn-sm" style="font-size:10px;"><i class="fa fa-exclamation-triangle"></i> Reverse Application</button>
</div>
</form>
</div>
<div class="col-sm-6">
<div id="pls" style="display:none;">
<i><img src="../loader/loader.gif" style="height:18px"> Saving Remark ! Please wait...</i>
</div>
<div id="done" style="display:none;">
<span style="height:18px; color:green"><i class="fa fa-check"></i> Application approval remark has been saved</span>
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
<br>
<div class="row">
<div class="col-sm-12">
<br>
<b style="color:red;">Note:</b><i> Upload customer registration fee and comment on the loan</i>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRem">
<input type="text" hidden class="form-control form-control-sm" name="type" placeholder="" value="<?php echo $row['Upfront_Types']; ?>">
<input type="text" hidden class="form-control form-control-sm" name="sta" placeholder="" value="<?php echo $row['Loan_Status']; ?>">
<input type="file" class="form-control form-control-sm" onchange="loadClient(event)" name="Pic" hidden>
<br>
<b>Loan Application Approval Comment</b>
<br><br>
<label>Remark/Comment</label>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="bvn" value="<?php echo $row['BVN']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="name" value="<?php echo $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; ?>" required>
<textarea class="form-control form-control-sm" name="remark" cols="8" rows="8" required placeholder="type here...."></textarea>
<br>
<div class="row">
<div class="col-sm-3">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"></i> Submit & Approve</button>
</form>
</div>
</div>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="declineLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-warning btn-sm" style="font-size:10px;"><i class="fa fa-exclamation-triangle"></i> Reverse Application</button>
</div>
</form>
</div>
<div class="col-sm-6">
<div id="pls" style="display:none;">
<i><img src="../loader/loader.gif" style="height:18px"> Saving Remark ! Please wait...</i>
</div>
<div id="done" style="display:none;">
<span style="height:18px; color:green"><i class="fa fa-check"></i> Application approval remark has been saved</span>
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
<br>
<b style="color:red;">Note:</b><i> Upload customer registration fee and comment on the loan</i>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRem">
<label>Upload Reciept Payment</label>
<input type="text" hidden class="form-control form-control-sm" name="type" placeholder="" value="<?php echo $row['Upfront_Types']; ?>">
<input type="text" hidden class="form-control form-control-sm" name="sta" placeholder="" value="<?php echo $row['Loan_Status']; ?>">
<input type="file" class="form-control form-control-sm" onchange="loadClient(event)" name="Pic" required>
<br>
<b>Loan Application Approval Comment</b>
<br><br>
<label>Remark/Comment</label>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="bvn" value="<?php echo $row['BVN']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="name" value="<?php echo $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; ?>" required>
<textarea class="form-control form-control-sm" name="remark" cols="8" rows="8" required placeholder="type here...."></textarea>
<br>
<div class="row">
<div class="col-sm-3">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"></i> Submit & Approve</button>
</form>
</div>
</div>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="declineLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-warning btn-sm" style="font-size:10px;"><i class="fa fa-exclamation-triangle"></i> Reverse Application</button>
</div>
</form>
</div>
<div class="col-sm-6">
<div id="pls" style="display:none;">
<i><img src="../loader/loader.gif" style="height:18px"> Saving Remark ! Please wait...</i>
</div>
<div id="done" style="display:none;">
<span style="height:18px; color:green"><i class="fa fa-check"></i> Application approval remark has been saved</span>
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
<br>
<div class="row">
<div class="col-sm-12">
<br>
<b style="color:red;">Note:</b><i> Upload customer registration fee and comment on the loan</i>
<br>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="uploadRem">
<input type="text" hidden class="form-control form-control-sm" name="type" placeholder="" value="<?php echo $row['Upfront_Types']; ?>">
<input type="text" hidden class="form-control form-control-sm" name="sta" placeholder="" value="<?php echo $row['Loan_Status']; ?>">
<input type="file" class="form-control form-control-sm" onchange="loadClient(event)" name="Pic" hidden>
<br>
<b>Loan Application Approval Comment</b>
<br><br>
<label>Remark/Comment</label>
<input type="text" class="form-control form-control-md" hidden name="id" value="<?php echo $row['id']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="bvn" value="<?php echo $row['BVN']; ?>" required>
<input type="text" class="form-control form-control-md" hidden name="name" value="<?php echo $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']; ?>" required>
<textarea class="form-control form-control-sm" name="remark" cols="8" rows="8" required placeholder="type here...."></textarea>
<br>
<div class="row">
<div class="col-sm-3">
<div class="d-grid gap-2">
<button type="submit" class="d-block btn btn-outline-success btn-sm" style="font-size:10px;"><i class="fa fa-check"></i> Submit & Approve</button>
</form>
</div>
</div>
<div class="col-sm-3">
<form action="" method="POST" enctype="multipart/form-data" id="declineLoan">
<div class="d-grid gap-2 mb-2">
<input type="text" name="id" hidden value="<?php echo $regid; ?>">
<button type="submit" class="btn btn-outline-warning btn-sm" style="font-size:10px;"><i class="fa fa-exclamation-triangle"></i> Reverse Application</button>
</div>
</form>
</div>
<div class="col-sm-6">
<div id="pls" style="display:none;">
<i><img src="../loader/loader.gif" style="height:18px"> Saving Remark ! Please wait...</i>
</div>
<div id="done" style="display:none;">
<span style="height:18px; color:green"><i class="fa fa-check"></i> Application approval remark has been saved</span>
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
x.style.display = 'block';
y.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
b.style.display = 'none';
k.style.display = 'none';
}
function updateDoc(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
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
x.style.display = 'none';
z.style.display = 'block';
y.style.display = 'none';
a.style.display = 'none';
b.style.display = 'none';
k.style.display = 'none';
}
function updateApprove(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
a.style.display = 'block';
y.style.display = 'none';
b.style.display = 'none';
k.style.display = 'none';
}
function updateRemark(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
b.style.display = 'block';
a.style.display = 'none';
y.style.display = 'none';
k.style.display = 'none';
}
function updateCRC(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("fourth");
var b = document.getElementById("sixth");
var k = document.getElementById("crc");
x.style.display = 'none';
z.style.display = 'none';
k.style.display = 'block';
b.style.display = 'none';
a.style.display = 'none';
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
WRN_PROFILE_DELETE = "You are about to submit and approve loan ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "approve_loan_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#approveLoan")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#approve").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
loads();
$("#approve").hide();
}, 6000);
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
WRN_PROFILE_DELETE = "You are about to submit and reverse this application ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "decline_loan_bck.php",
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
$("#decline").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
loads();
$("#decline").hide();
}, 6000);
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
$("#uploadRem").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to submit and approve loan ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "save_remark_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#uploadRem")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#approve").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
loads();
$("#approve").hide();
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
function loads()  {
$.ajax({
method: "POST",
url: "load_application_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#results').html(data);
}, 1000);
}
});
}
</script> 
