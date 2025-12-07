<?php 
include_once '../config/db.php';
$id = $_GET['id']; // rep id
// 
$Query = "SELECT * FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$reprow = mysqli_fetch_array($result);
$repid = $reprow['id'];
$bvn = $reprow['BVN'];
$regid = $reprow['Reg_id'];
// client info
$Query = "SELECT * FROM register WHERE id = '$regid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$biz = $row['Biz_Type'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$regid'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$gid = $rows['id'];
$gb = $rows['Gaurantor_BVN'];
?>


<div class="row">
<div class="col-sm-3">
<div class="card">
<div class="card-body">
<div class="bg-primary-subtle h-24 rounded position-relative overflow-hidden">
<img src="../assets/images/pages/profile-bg.png" class="img-fluid w-100 h-100 object-fit-cover" alt="Background">
<div class="position-absolute top-0 start-0 w-100 h-100 bg-black bg-opacity-40"></div>
</div>
<div class="d-flex align-items-center justify-content-between px-4 profile-img mb-5 position-relative">
<div class="avatar avatar-xl avatar-border shadow-lg">
<img src="<?php  echo $reprow['Location']; ?>" alt="Avatar Image" class="avatar-lg">
</div>
<span class="badge bg-body-secondary border text-body px-4 rounded-2 shadow-lg">
<img src="../assets/images/pages/active.png" alt="Active Icon" width="14" class="me-2 align-middle"><?php echo $reprow['Status']; ?></span>
</div>
<div class="d-flex justify-content-between align-items-center mb-6">
<div>
<h6 class="mb-1 fs-14 "><?php  echo $reprow['Firstname']." ".$reprow['Middlename']." ".$reprow['Lastname']; ?></h6>
<p class="text-muted mb-0"><?php echo $biz; ?></p>
</div>
<button type="button" class="btn btn-outline-success btn-icon" aria-label="bookmark">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-bookmark-outline ">
<g data-name="Layer 2">
<g data-name="bookmark">
<rect width="24" height="24" opacity="0"></rect>
<path d="M6.09 21.06a1 1 0 0 1-1-1L4.94 5.4a2.26 2.26 0 0 1 2.18-2.35L16.71 3a2.27 2.27 0 0 1 2.23 2.31l.14 14.66a1 1 0 0 1-.49.87 1 1 0 0 1-1 0l-5.7-3.16-5.29 3.23a1.2 1.2 0 0 1-.51.15zm5.76-5.55a1.11 1.11 0 0 1 .5.12l4.71 2.61-.12-12.95c0-.2-.13-.34-.21-.33l-9.6.09c-.08 0-.19.13-.19.33l.12 12.9 4.28-2.63a1.06 1.06 0 0 1 .51-.14z">
</path>
</g>
</g>
</svg>
</button>
</div>
<div class="d-flex gap-2">
<hr>
<b>Virtual Acct:</b> <?php echo $reprow['Account_Number']; ?>
<hr>
</div>
</div>
</div>
<div class="row g-4">
<div class="col-md-6">
<a href="#!" class="border h-24 d-flex justify-content-center align-items-center flex-column rounded bg-primary text-center text-body">
<h3 class="mb-3 fw-normal">
<?php 
include '../config/db.php';
$sql = "SELECT COUNT(*) AS overs FROM repayments WHERE BVN = '$bvn' AND Status = 'Active' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$count= $data['overs'];
echo $count;
?>
</h3>
<p class="mb-0">Active Loans</p>
</a>
</div>
<div class="col-md-6">
<a href="#!" class="border h-24 d-flex justify-content-center align-items-center flex-column rounded  bg-danger text-center text-body">
<h3 class="mb-3 fw-normal">
<?php 
include '../config/db.php';
$sql = "SELECT COUNT(*) AS overs FROM repayments WHERE BVN = '$bvn' AND Status = 'Closed' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$count= $data['overs'];
echo $count;
?>
</h3>
<p class="mb-0" >Closed Loans</p>
</a>
</div>
</div>

</div>
<div class="col-sm-9">
<div class="row g-3">
<div class="nav nav-pills custom-tab mb-4" id="card-tab-4" role="tablist">
<a class="nav-item nav-link active" id="card-custom-tab-home" data-bs-toggle="tab" href="#card-custom-home" aria-selected="false" role="tab">
<i class="fa fa-home"></i> Dashboard</a>
<a class="nav-item nav-link" id="card-custom-tab-profile" data-bs-toggle="tab" href="#card-custom-profile" aria-selected="true" role="tab" tabindex="-1">
<i class="fa fa-user"></i> Customer & Gaurantor Info</a>
<a class="nav-item nav-link" id="card-custom-tab-contact" data-bs-toggle="tab" href="#card-custom-contact" aria-selected="false" role="tab" tabindex="-1">
<i class="fa fa-file"></i> Loan Info</a>
<a class="nav-item nav-link" id="card-custom-tab-history" data-bs-toggle="tab" href="#card-custom-history" aria-selected="false" role="tab" tabindex="-1">
<i class="fa fa-list"></i> Payment History</a>
<a class="nav-item nav-link" id="card-custom-tab-gallery" data-bs-toggle="tab" href="#card-custom-gallery" aria-selected="false" role="tab" tabindex="-1">
<i class="fa fa-star"></i> Business Gallery</a>
</div>
<div class="tab-content">
<div class="tab-pane active show" id="card-custom-home" role="tabpanel" aria-labelledby="card-custom-tab-home">
<b><i class="fa fa-home"></i> DASHBOARD</b>
<br>
<div class="row">
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<div class="avatar avatar-sm avatar-label-primary mb-6">
<i class="fa fa-star"></i>
</div>
<h6 class="mb-1 text-truncate">Principal Amount</h6>
<p class="text-muted mb-5"><?php echo number_format($reprow['Total_Loan'],2)?></p>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<div class="avatar avatar-sm avatar-label-success mb-6">
<i class="fa fa-star"></i>
</div>
<h6 class="mb-1 text-truncate">Amount Paid</h6>
<p class="text-muted mb-5"><?php echo number_format($reprow['Paid'],2)?></p>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<div class="avatar avatar-sm avatar-label-danger mb-6">
<i class="fa fa-star"></i>
</div>
<h6 class="mb-1 text-truncate">Outstanding Balance</h6>
<p class="text-muted mb-5"><?php echo number_format($reprow['Total_Bal'],2)?></p>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<div class="avatar avatar-sm avatar-label-warning mb-6">
<i class="fa fa-star"></i>
</div>
<h6 class="mb-1 text-truncate">Interest Amount</h6>
<p class="text-muted mb-5"><?php echo number_format($reprow['Interest_Amt'],2)?></p>
</div>
</div>
</div>
</div>

</div>
<div class="tab-pane" id="card-custom-profile" role="tabpanel" aria-labelledby="card-custom-tab-profile">

<div class="row">
<div class="col-sm-6">
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

<b><i class="fa fa-star"></i> BUSINESS INFO</b>
<br><br>
<div class="table-responsive" style="height:100px; overflow:auto">
<table style="font-size:8px">
<thead>
<tr >
<th>BUSSINESS</th>
<th>TYPE</th>
<th>STATE</th>
<th>START DATE</th>
<th>OWNERSHIP</th>
<th>ADDRESS</th>
</tr>
</thead>
<tr style="font-size:10px">
<td ><?php echo $row['Business']; ?></td>
<td ><?php echo $row['Biz_Type']; ?></td>
<td ><?php echo $row['Biz_State']; ?></td>
<td ><?php echo $row['Start_Date']; ?></td>
<td ><?php echo $row['Shop_Owner']; ?></td>
<td ><?php echo $row['Biz_Address']; ?></td>
</tr>
</table>
</div>



</div>
<div class="tab-pane" id="card-custom-history" role="tabpanel" aria-labelledby="card-custom-tab-history">

<b>
<i class="fa fa-list"></i>
CLIENT PAYMENT HISTORY
</b>
<br><br>
Total: <?php 
include '../config/db.php';
$sql = "SELECT SUM(Amount) AS lm FROM history WHERE Status = 'Paid' AND Register_id='$regid' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmt = $data['lm'];
echo number_format($pmt,2);
?>
<br><br>
<div class="table-responsive" style="height:100px; overflow:auto">
<table style="font-size:8px">
<thead>
<tr >
<th>PRINCIPAL</th>
<th>INTEREST</th>
<th>AMT PAID</th>
<th>EXP AMT</th>
<th>BALANCE</th>
<th>TYPES</th>
<th>DATE</th>
</tr>
</thead>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM history WHERE Register_id = '$regid' AND Status='Paid' ORDER BY id ASC";
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
$reci = $rows['Reciept_No'];
?>
<tr>
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int,2); ?></td>
<td><?php echo number_format($am,2); ?></td>
<td><?php echo number_format($exp,2); ?></td>
<td><?php echo number_format($bb,2); ?></td>
<td><?php echo $pm; ?></td>
<td><?php echo $dp; ?></td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo" <small style='color:red'>No payment record </small> ";       
}
?>
</tr>
</table>
</div>


</div>


<div class="tab-pane" id="card-custom-gallery" role="tabpanel" aria-labelledby="card-custom-tab-gallery">
<i class="fa fa-star"></i>
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
<img src="<?php echo $img?>" class="d-block w-100" alt="..." style="height:40vh; margin:10px">
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
<div class="tab-pane" id="card-custom-contact" role="tabpanel" aria-labelledby="card-custom-tab-contact">
<b><i class="fa fa-star"></i> LOAN INFORMATION DETAILS</b>
<div class="row">
<div class="col-sm-6">
<br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Acct No:</b> <?php echo $reprow['Loan_Account_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Disbursement No:</b> <?php echo $reprow['Disbursement_No']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Transaction ID:</b> <?php echo $reprow['Transaction_id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Savings Acct No:</b> <?php echo $reprow['Savings_Account_No']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Virtual Acct:</b> <?php echo $reprow['Account_Number']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Repayment ID:</b> <?php echo $reprow['id']; ?></span>
</div>
</div>
<br>
</div>
</div>
<div class="col-sm-6">
<br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>BVN:</b> <?php echo $reprow['BVN']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Registration ID:</b> <?php echo $row['id']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gaurantor ID:</b> <?php echo $rows['id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gaurantor NIN:</b> <?php echo $gb; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Disbursed By:</b> <?php echo $reprow['Disbursed_By']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Team Lead:</b> <?php echo $reprow['Team_Name']; ?></span>
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
<br>
</div>
</div>
<div class="col-sm-6">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Bank:</b> <?php echo $row['Bank']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Acct Name:</b> <?php echo $row['Account_Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Acct No:</b> <?php echo $row['Account_No']; ?></span>
</div>
</div>
<br>
</div>

</div>
</div>


<br>
<h5 style="font-size:11px;"><b>LOAN HISTORY</b></h5>
<div class="table-responsive" style="height:100px; overflow:auto">
<table style="font-size:8px">
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
$Query = "SELECT Loan_Account_No, Savings_Account_No, BVN, Loan_Amount, Total_Bal, Status, Date_Disbursed, Date_Closed FROM repayments 
WHERE BVN = '$bvn' ORDER BY id DESC LIMIT 10";
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
                                       




</div>
</div>