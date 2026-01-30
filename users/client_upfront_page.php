
<?php 
include_once '../config/db.php';
$id = $_GET['id']; // reg id// Register info
$query = "SELECT * FROM register WHERE id = '$id' ORDER BY id ASC LIMIT 1";
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
$type = $row['Upfront_Types'];
$loan_status = $row['Loan_Status'];
$tm = $row['Team_Leader'];
//
$query = "SELECT Name, Phone, Branch FROM users WHERE Username = '$tm' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $query);
$rok = mysqli_fetch_assoc($result);
$team_name = $rok['Name'];
$team_phone = $rok['Phone'];
$team_branch = $rok['Branch'];
// Guarantor info
$query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $query);
$rows = mysqli_fetch_assoc($result);
$gid = $rows['id'];
//

$Query = "SELECT Inssurance FROM product_list WHERE Product_id='$pr' AND Tenure = '$ten'";
$result = mysqli_query($con, $Query);
$data = mysqli_fetch_array($result);
$ins = $data['Inssurance'];
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
// Calculate the upfront interest
//
$upfront = round($lum * $rt / 100);
$inssurance = round($lum * $ins / 100);

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
//
$upfront = round($lum * $rt / 100);
$inssurance = round($lum * $ins / 100);

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
*/

?>
<div class="row">
<div class="col-sm-3" style="margin-top:10px;">
<button class="btn btn-light w-100" onclick="clientDash()"><i class="fa fa-user"></i> Customer Profile</button>
</div>
<div class="col-sm-3" style="margin-top:10px; display:none">
<button class="btn btn-light w-100" onclick="updateDoc()"><i class="fa fa-eye"></i> Review Document</button>
</div>
<div class="col-sm-3" style="margin-top:10px; display:none">
<button class="btn btn-light w-100" onclick="updateVerification()"><i class="fa fa-briefcase"></i> Business Image</button>
</div>
<div class="col-sm-3" style="margin-top:10px; display:none">
<button class="btn btn-light w-100" onclick="updateLoan()"><i class="fa fa-plus"></i> Update Loan Amount</button>
</div>
<div class="col-sm-3" style="margin-top:10px; display:none">
<button class="btn btn-light w-100" onclick="updateCRC()"><i class="fa fa-file"></i> Customer CRC Data </button>
</div>
<div class="col-sm-3" style="margin-top:10px;">
<button class="btn btn-light w-100" onclick="updateUpfront()"><i class="fa fa-money-bill"></i> Upfront Payment </button>
</div>
<div class="col-sm-3" style="margin-top:10px; display:none">
<button class="btn btn-light w-100" onclick="updateRemark()"><i class="fa fa-comment"></i> Remark/Coment</button>
</div>
<div class="col-sm-3" style="margin-top:10px; display:none">
<button class="btn btn-light w-100" onclick="updateDisburse()"><i class="fa fa-star"></i> Disbursement</button>
</div>
<div class="col-sm-3" style="margin-top:10px; display:none">
<form action="" method="POST" enctype="multipart/form-data" id="goBack">
<input type="number" class="form-control form-control-md" name="id" value="<?php echo $regid; ?>" hidden required="required">
<button class="btn btn-light w-100"><i class="fa fa-exclamation-triangle"></i> Reverse Application</button>
</form>
</div>
</div>
<br>
<center>
<i style="display:none" id="up"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Updating Payment Mode.! Please wait..</i>
<i style="color: green; display:none" id="update"><i class="fa fa-check"></i> Application has been reversed back to the team lead..</i>
<i style="display:none" id="ups"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Processing payment.! Please wait..</i>
<i style="color: green; display:none" id="updates"><i class="fa fa-check"></i> Payment has been deducted from the saving account...</i>
</center>
<br>
<br>
<div class="row">
<div class="col-sm-4">
<b>Application Date Reg:</b> <?php echo $row['Date_Reg'];?>
</div>
<div class="col-sm-4">
<b>Team Lead:</b> <?php echo $team_name;?>
</div>
<div class="col-sm-4">
<b>Team Lead Phone No:</b> <?php echo $team_phone;?>
</div>
</div>
<br>
<br>

<div id="firsts" style="display:block; font-size:11px">
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
<span style="margin-left:8px;"><b>Interest Per Repayment:</b> <?php echo  number_format($row['Monthly_Interest'],2); ?></span>
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





<div id="crc" style="display:none;">
<br><br>
CRC REPORT
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

<div id="fifth" style="display:none;">



<div class="row">
<div class="col-sm-4" style="margin-top:10px;">
<form action="" method="POST" enctype="multipart/form-data" id="uploadUpfront">
<div class="row">
<div class="col-sm-6" style="margin-top:10px;">
<label style="font-size:13px"><i style="color:red">*</i> Upfront Payment Mode</label>
<input type="number" class="form-control form-control-md" name="id" value="<?php echo $regid; ?>" hidden required="required">
<select type="text" class="form-control form-control-md" name="type" required="required">
<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
<option value="Deduction">Deduction</option>
<option value="Virtual Payment">Virtual Payment</option>
<option value="Monie Point Payment">Monie Point Payment</option>
<option value="Saving For Upfront">Saving For Upfront</option>
</select>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-5" style="margin-top:10px;">
<button type="submit" class="btn btn-info btn-sm">Change Mode</button>
</form>
</div>
<div class="col-sm-7" style="margin-top:10px;">
<i style="display:none" id="up"><i class="fa fa-refresh"></i><img src="../loader/loader.gif" style="height:18px">  Updating Payment Mode..</i>
<i style="color: green; display:none" id="update"><i class="fa fa-check"></i> Upfront Payment Mode Updated..</i>
</div>
</div>
</form>




</div>
<div class="col-sm-8" style="margin-top:10px;">
<div class="row">
<div class="col-sm-3">
<span>Initial Saving: <?php echo number_format($up,2); ?></span>
</div>
<div class="col-sm-3">
<span>Insurance: <?php echo number_format($inss,2); ?></span>
</div>
<div class="col-sm-3">
<span>Form: <?php echo number_format($form,2); ?></span>
</div>
<div class="col-sm-3">
<span>Card: <?php echo number_format($card,2); ?></span>
</div>
<div class="col-sm-3">
<span>Total: <?php echo number_format($up +  $inss + $form + $card,2); ?></span>
</div>
<div class="col-sm-3">
<span>Client Status: <?php echo $loan_status; ?></span>
</div>
</div>



</div>
</div>




<hr>
<div id="checks">
<div class="row">
<div class="col-sm-3">
<div id="mode">
<b>Payment Mode:</b>
<?php 
echo $type;
?>
</div>
</div>
<div class="col-sm-3">
<b>Virtual Acct: <?php echo $vrt; ?></b>
<span>
<?php 
echo $row['Virtual_Account'];
?>
</span>
</div>
<div class="col-sm-3">
<b>Loan Amount:</b>
<span>
<?php 
echo number_format($lum,2);
?>
</span>
</div>
<div class="col-sm-3">
<b>Amt To Disburse:</b>
<span>
<?php 
if($type == 'Deduction'){
$fee = $up + $ins + $card + $form;
echo number_format($lum - $fee,2);
}else{
echo number_format($lum,2);
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
if($type == 'Deduction' ){
echo "<i>Upfront payment need to be remove from the principal amount</i>";
?>


<?php
}else if($type == 'Virtual Payment'){
?>
<span>Virtual Payment History</span>




<?php 
}else if($type == 'Monie Point Payment'){
?>
<i id="chk" style="display:none"><img src="../loader/loader.gif" style="height:15px"> Loading ! Please wait...</i>
<div id="list"></div>
<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$("#chk").show();
$.ajax({
method: "POST",
url: "upfront_list.php?id=<?php echo $id;?>",
dataType: "html",  
success:function(data){
$("#chk").hide();
$('#list').html(data);
}
});
// ajax function ends here
});
</script>


<script type="text/javascript">
function loadList()  {
$("#chk").show();
$.ajax({
method: "POST",
url: "upfront_list.php?id=<?php echo $id;?>",
dataType: "html",
success:function(data){
$("#chk").hide();
$('#list').html(data);
}
});
}
</script> 

<?php 
}else if($type == 'Saving For Upfront'){
?>

<span >Saving Balance: <i id="lod" style="margin-left:8px; display:none"><img src="../loader/loader.gif" style="height:15px"> Loading Balance ! Please wait...</i> 
<span id="bal">0.00</span></span>
<hr>
<form action="" method="POST" enctype="multipart/form-data" id="uploadSaving">
<div class="row">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Select Savings Acct No</label>
<input type="text" class="form-control form-control-md" name="regid" value="<?php echo $id; ?>" hidden required>
<select type="text" class="form-control form-control-md" name="sav"  id="sav" oninput="getBalance()" required>
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
<input type="text" class="form-control form-control-sm" name="amt" hidden value="<?php echo $up +  $inss + $form + $card; ?>" required>
<input type="text" class="form-control form-control-sm" disabled value="<?php echo $up +  $inss + $form + $card; ?>" required>
</div>
</div>
<br>
<button type="submit" class="btn btn-primary btn-sm">Confirm & Proceed</button>
</form>

<?php
}else{
?>


<?php
}
?>
</div>

</div>

</div>

<br>
<br>

</div>




<script type="text/javascript">
function getBalance()  {
var sav = document.getElementById("sav").value;
// ajax function start here
$("#bal").hide();
$("#lod").show();
$.ajax({
method: "POST",
url: "get_saving_balance.php",
dataType: "html",  
data: {
'sav': sav
},
success:function(data){
setTimeout(function(){
$("#lod").hide();
$("#bal").show();
$('#bal').html(data);
}, 100);
}
});
// ajax function ends here
}
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
$("#myDiv").load( "client_upfront_page.php?id=<?php echo $id; ?> #myDiv" );// 
$("#amt").load( "client_upfront_page.php?id=<?php echo $id; ?> #amt" );// 
//$("#hey").html(data);
}, 100);
// ajax function ends here
});
</script>







<script type="text/javascript">
$(document).ready(function (e){
$("#goBack").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to revserse the loan back to the team lead ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "goback.php",
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
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
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
$("#uploadSaving").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to deduct saving from the customer balance ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "deduction.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
$("#please").hide();
alert("Inssuffient balance in customer saving account.. please check");
$("#updateModal").modal('show');
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data);
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
function loads()  {
$.ajax({
method: "POST",
url: "load_upfront_list.php",
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
$("#mode").load( "client_upfront_page.php?id=<?php echo $regid; ?> #mode" );// 
$("#page").load( "client_upfront_page.php?id=<?php echo $regid; ?> #page" );// 
$("#check").load( "client_upfront_page.php?id=<?php echo $regid; ?> #check" );// 
$("#checks").load( "client_upfront_page.php?id=<?php echo $regid; ?> #checks" );// 
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



