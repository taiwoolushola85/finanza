
<div style="display: none;">
<?php 
include '../config/db.php';
$id = intval($_GET['id']);
$Query = "SELECT * FROM register WHERE id='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$reg_id = $row['id'];
$lli = $row['Location'];
$two = $row['Firstname']." ".$row['Middlename'];
$fll = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
$ad = $row['Address'];
$ed = $row['Education'];
$ph = $row['Phone'];
$gn = $row['Gender'];
$br = $row['Branch'];
$yr = $row['Years'];
$ms = $row['Maritial_Status'];
$sta = $row['State'];
$tw = $row['Town'];
$pr = $row['Product'];
$tn = $row['Tenure'];
$fr = $row['Frequency'];
$rt = $row['Rate'];
$un = $row['Unions'];
$la = $row['Loan_Amount'];
$bnk = $row['Bank'];
$acn = $row['Account_Name'];
$acc = $row['Account_No'];
$bv = $row['BVN'];
$bz = $row['Business'];
$bt = $row['Biz_Type'];
$bs = $row['Biz_State'];
$sd = $row['Start_Date'];
$cf = $row['Cash_Flow'];
$ba = $row['Biz_Address'];
$bo = $row['Biz_Owner'];
$sh = $row['Shop_Owner'];
$dr = $row['Date_Reg'];
$tt = $row['Time_Reg'];
$vs = $row['Verification_Status'];
$vb = $row['Verified_By'];
$dv = $row['Date_Verified'];
$ofn = $row['Officer_Name'];
$tm_ll = $row['Team_Leader'];
$pr = $row['Product'];
$ten = $row['Tenure'];// duration
$rt = $row['Rate'];
$tmn = $row['Team_Name'];
$uzzer = $row['User'];
$rc = $row['Reciver_Username'];
$vbb = $row['Verified_By'];
$int_amt = $row['Interest_Amt'];
$rep_amt = $row['Repayment_Amt'];
$to_loan = $row['Total_Loan'];
$paid = $row['Date_Paid'];
$ss = $row['Schedule_Status'];
$under = $row['Underwriter'];
$bus = $row['Disbursed_By'];
$re_sta = $row['Status'];

// form update query
$id = $row['id'];
$lok = $row['Location'];
$fn = $row['Firstname'];
$ln = $row['Lastname'];
$md = $row['Middlename'];
$full = $row['Firstname']. " ".$row['Middlename']. " ".$row['Lastname'];
$la = $row['Loan_Amount'];
$ph = $row['Phone'];
$gn = $row['Gender'];
$ad = $row['Address'];
$ed = $row['Education'];
$gps = $row['Unions'];
$br = $row['Branch'];
$pr = $row['Product'];
$te = $row['Tenure'];
$bk = $row['Bank'];
$act = $row['Account_No'];
$ac = $row['Account_Name'];
$bn = $row['Business'];
$dr = $row['Date_Reg'];
$ttr = $row['Time_Reg'];
$st = $row['Status'];
$ofn = $row['Officer_Name'];
$int = $row['Interest_Amt'];
$rp = $row['Repayment_Amt'];
$tl = $row['Total_Loan'];
$up = $row['Upfront'];
$in = $row['Inssurance'];
$fm = $row['Form'];
$crd = $row['Card'];
$agee = $row['Years'];
$ms = $row['Maritial_Status'];
$do = $row['Document'];
$dno = $row['Document_No'];
$sta = $row['State'];
$tw = $row['Town'];
$bow = $row['Biz_Owner'];
$sh = $row['Shop_Owner'];

// repayment 
$Query = "SELECT * FROM repayments WHERE Reg_id = '$reg_id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$gdd = $row['id'];
$vrt = $row['Account_Number'];
$lon = $row['Loan_Account_No'];
$tr = $row['Transaction_id'];
$dis = $row['Disbursement_No'];
$did = $row['Date_Disbursed'];
$sid = $row['Savings_Account_No'];
$reg_rep = $row['Reg_id'];

// guarantor info 
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$reg_id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$gdd = $row['id'];
$bng = $row['Firstname']." ".$row['Middlename']." ".$row['Lastname'];
$fng = $row['Firstname'];
$mdg = $row['Middlename'];
$lng = $row['Lastname'];
$btg = $row['Phone'];
$sesg = $row['Relationship'];
$sdg = $row['Gender'];
$lmmg = $row['ID_No'];
$cfg = $row['ID_Type'];
$bmag = $row['Location'];
$cardg = $row['ID_Image'];
$rgd = $row['Regis_id'];
$dress = $row['Address'];
$gst = $row['Status'];
$gbvn = $row['Gaurantor_BVN'];
$cbvn = $row['Client_BVN'];


?>
</div>



<div class="row">
<div class="col-sm-3">
<div>
<div>
<div style="display: block;" id="client">
<div class="d-flex flex-column align-items-center text-center">
<img src="<?php echo $lli; ?>" class="rounded-circle" width="120" height="120px">
<div class="mt-3">
<h4><b style="text-transform: capitalize;"><?php echo $fll; ?></b></h4>
<p class="text-secondary mb-1"><?php echo $un; ?> Group</p>
</div>
</div>
</div>

<div style="display: none;" id="ga">
<div class="d-flex flex-column align-items-center text-center">
<img src="<?php echo $bmag; ?>" alt="Admin" class="rounded-circle" width="120" height="120px">
<div class="mt-3" id="gaurantor">
<h4><b style="text-transform: capitalize;"><?php echo $bng; ?></b></h4>
<p class="text-secondary mb-1"><?php echo $sesg; ?></p>
</div>
</div>
</div>

</div>
</div>
<div>
<div>
<button class="btn btn-outline-success btn-sm w-100" style="font-size: 12px; margin-top:10px" onclick="myDash()">Dashboard</button><br>
<button class="btn btn-outline-info btn-sm w-100" style="font-size: 12px; margin-top:10px" onclick="myClient()">Update Client Info</button><br>
<button class="btn btn-outline-primary btn-sm w-100" style="font-size: 12px; margin-top:10px" onclick="myGua()">Update Guarantor Info</button><br>
<button class="btn btn-outline-info btn-sm w-100" style="font-size: 12px; margin-top:10px" onclick="myBizs()">Update Business Info</button><br>
<form action="" method="POST" enctype="multipart/form-data" id="deleteapp">
<input type="text" hidden class="form-control form-control-md"  name="id" required = "required" value="<?php echo $reg_id; ?>">
<button type="submit"  class="btn btn-outline-danger w-100 btn-sm" style="font-size: 12px; margin-top:10px" >Delete Record </button>
</form>
</div>
</div>
</div>


<div class="col-sm-9">
<div>
<div>

<div id="dashboard" style="display: block;">
<b>
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M4.54 2H7.92C9.33 2 10.46 3.15 10.46 4.561V7.97C10.46 9.39 9.33 10.53 7.92 10.53H4.54C3.14 10.53 2 9.39 2 7.97V4.561C2 3.15 3.14 2 4.54 2ZM4.54 13.4697H7.92C9.33 13.4697 10.46 14.6107 10.46 16.0307V19.4397C10.46 20.8497 9.33 21.9997 7.92 21.9997H4.54C3.14 21.9997 2 20.8497 2 19.4397V16.0307C2 14.6107 3.14 13.4697 4.54 13.4697ZM19.4601 2H16.0801C14.6701 2 13.5401 3.15 13.5401 4.561V7.97C13.5401 9.39 14.6701 10.53 16.0801 10.53H19.4601C20.8601 10.53 22.0001 9.39 22.0001 7.97V4.561C22.0001 3.15 20.8601 2 19.4601 2ZM16.0801 13.4697H19.4601C20.8601 13.4697 22.0001 14.6107 22.0001 16.0307V19.4397C22.0001 20.8497 20.8601 21.9997 19.4601 21.9997H16.0801C14.6701 21.9997 13.5401 20.8497 13.5401 19.4397V16.0307C13.5401 14.6107 14.6701 13.4697 16.0801 13.4697Z" fill="currentColor" />
</svg>    
DASHBOARD
</b><br>
<br>
<br>

<div class="row" style="font-size: 11px;">
<div class="col-sm-6">
<br>
<b>
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path d="M17.9184 14.32C17.6594 14.571 17.5404 14.934 17.5994 15.29L18.4884 20.21C18.5634 20.627 18.3874 21.049 18.0384 21.29C17.6964 21.54 17.2414 21.57 16.8684 21.37L12.4394 19.06C12.2854 18.978 12.1144 18.934 11.9394 18.929H11.6684C11.5744 18.943 11.4824 18.973 11.3984 19.019L6.96839 21.34C6.74939 21.45 6.50139 21.489 6.25839 21.45C5.66639 21.338 5.27139 20.774 5.36839 20.179L6.25839 15.259C6.31739 14.9 6.19839 14.535 5.93939 14.28L2.32839 10.78C2.02639 10.487 1.92139 10.047 2.05939 9.65C2.19339 9.254 2.53539 8.965 2.94839 8.9L7.91839 8.179C8.29639 8.14 8.62839 7.91 8.79839 7.57L10.9884 3.08C11.0404 2.98 11.1074 2.888 11.1884 2.81L11.2784 2.74C11.3254 2.688 11.3794 2.645 11.4394 2.61L11.5484 2.57L11.7184 2.5H12.1394C12.5154 2.539 12.8464 2.764 13.0194 3.1L15.2384 7.57C15.3984 7.897 15.7094 8.124 16.0684 8.179L21.0384 8.9C21.4584 8.96 21.8094 9.25 21.9484 9.65C22.0794 10.051 21.9664 10.491 21.6584 10.78L17.9184 14.32Z" fill="currentColor" />
</svg>    
CLIENT INFO</b><br>
<br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Name:</b> <?php echo $fll; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Phone No:</b> <?php echo $ph; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Gender:</b> <?php echo $gn; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Date Of Birth:</b> <?php echo $yr; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Maritial Status:</b> <?php echo $ms; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Branch:</b> <?php echo $br; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Reg ID:</b> <?php echo $reg_id; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Virtual Acct:</b> <?php echo $vrt; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Acc Name:</b> <?php echo $ac; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Acct No:</b> <?php echo $act; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Bank:</b> <?php echo $bk; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Amt Recieved:</b> <?php echo number_format($la,2); ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Town:</b> <?php echo $tw; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Date Reg:</b> <?php echo $dr; ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left:8px;">Address:</b> <?php echo $ad; ?>
</div>
</div>
<br>
</div>
</div>

<div class="col-sm-6">
<br>
<b>
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path d="M17.9184 14.32C17.6594 14.571 17.5404 14.934 17.5994 15.29L18.4884 20.21C18.5634 20.627 18.3874 21.049 18.0384 21.29C17.6964 21.54 17.2414 21.57 16.8684 21.37L12.4394 19.06C12.2854 18.978 12.1144 18.934 11.9394 18.929H11.6684C11.5744 18.943 11.4824 18.973 11.3984 19.019L6.96839 21.34C6.74939 21.45 6.50139 21.489 6.25839 21.45C5.66639 21.338 5.27139 20.774 5.36839 20.179L6.25839 15.259C6.31739 14.9 6.19839 14.535 5.93939 14.28L2.32839 10.78C2.02639 10.487 1.92139 10.047 2.05939 9.65C2.19339 9.254 2.53539 8.965 2.94839 8.9L7.91839 8.179C8.29639 8.14 8.62839 7.91 8.79839 7.57L10.9884 3.08C11.0404 2.98 11.1074 2.888 11.1884 2.81L11.2784 2.74C11.3254 2.688 11.3794 2.645 11.4394 2.61L11.5484 2.57L11.7184 2.5H12.1394C12.5154 2.539 12.8464 2.764 13.0194 3.1L15.2384 7.57C15.3984 7.897 15.7094 8.124 16.0684 8.179L21.0384 8.9C21.4584 8.96 21.8094 9.25 21.9484 9.65C22.0794 10.051 21.9664 10.491 21.6584 10.78L17.9184 14.32Z" fill="currentColor" />
</svg>    
GUARANTOR INFO</b><br>
<br>

<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Name:</b> <?php echo $bng; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Phone No:</b> <?php echo $btg; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Relationship:</b> <?php echo $sesg; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">BVN/NIN:</b> <?php echo $gbvn; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Gender:</b> <?php echo $sdg; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">ID Type:</b> <?php echo $cfg; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Guarantor ID:</b> <?php echo $gdd; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Client BVN:</b> <?php echo $cbvn; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Client Name:</b> <?php echo $two; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Status:</b> <?php echo $re_sta; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">ID No:</b> <?php echo $lmmg; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Status:</b> <?php echo $gst; ?>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<b style="margin-left:8px;">Team Leader:</b> <?php echo $tmn; ?>
</div>
<div class="col-sm-6">
<b style="margin-left:8px;">Loan Officer:</b> <?php echo $ofn; ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<b style="margin-left:8px;">Business Address:</b> <?php echo $dress; ?>
</div>
</div>
<br>
</div>
</div>


</div>




</div>









<div style="display: none" id="cl">
<b>
<i class="fa fa-file"></i> CLIENT INFO FORM</b><br><br>
<form action="" method="POST" enctype="multipart/form-data" id="uploads">
<div class="row">
<div class="col-sm-4">
<small>Loan Account No</small>
<input type="text" hidden class="form-control form-control-sm" name="repid" placeholder="Repayment id" required="required" value="<?php echo $gdd; ?>">
<input type="text" hidden class="form-control form-control-sm" name="id" placeholder="id" required="required" value="<?php echo $reg_id; ?>">
<input type="text" hidden class="form-control form-control-sm" name="vrt" placeholder="Enter Virtual Account No" value="<?php echo $vrt; ?>">
<input type="text" class="form-control form-control-sm" name="lon" placeholder="Enter Loan Account No"  value="<?php echo $lon; ?>">
</div>
<div  class="col-sm-4">
<small>Disbursement No</small>
<input type="text" class="form-control form-control-sm" name="dis" placeholder="Enter Disburement No" value="<?php echo $dis; ?>">
</div>
<div  class="col-sm-4">
<small>BVN No</small>
<input type="text" class="form-control form-control-sm" name="bv" placeholder="Enter BVN No" value="<?php echo $bv; ?>">
</div>
</div>


<div class="row">
<div  class="col-sm-4">
<small>Transaction ID</small>
<input type="text" class="form-control form-control-sm" name="tr" placeholder="Enter Transaction ID"  value="<?php echo $tr; ?>">
</div>
<div  class="col-sm-4">
<small>Savings Account No</small>
<input type="text" class="form-control form-control-sm" name="siv" placeholder="Enter Saving Account No" value="<?php echo $sid; ?>">
</div>
<div  class="col-sm-4">
<small>Document No</small>
<input type="text" class="form-control form-control-sm" hidden placeholder="Enter Repayment ID" value="<?php echo $gdd; ?>">
<input type="text" class="form-control form-control-sm" name="dno" placeholder="Enter Document No" value="<?php echo $dno; ?>">
</div>
</div>

<div class="row">
<div  class="col-sm-4">
<small>Firstname</small>
<input type="text" class="form-control form-control-sm" name="fn" placeholder="Enter Firstname" value="<?php echo $fn; ?>">
</div>
<div  class="col-sm-4">
<small>Middlename</small>
<input type="text" class="form-control form-control-sm" name="md" placeholder="Enter Lastname" value="<?php echo $md; ?>">
</div>
<div  class="col-sm-4">
<small>Lastname</small>
<input type="text" class="form-control form-control-sm" name="ln" placeholder="Enter Lastname" value="<?php echo $ln; ?>">
</div>
</div>

<div class="row">
<div  class="col-sm-4">
<small>Gender</small>
<input type="text" class="form-control form-control-sm"  name="der" placeholder="Enter Gender" value="<?php echo $gn; ?>">
</div>
<div  class="col-sm-4">
<small>Phone No</small>
<input type="number" class="form-control form-control-sm" name="ph" placeholder="Enter Phone No" value="<?php echo $ph; ?>">
</div>
<div  class="col-sm-4">
<small>Education</small>
<input type="text" class="form-control form-control-sm" name="ed" placeholder="Education" value="<?php echo $ed; ?>">
</div>
</div>

<div class="row">
<div  class="col-sm-4">
<small>Address</small>
<input type="text" class="form-control form-control-sm" name="ad" placeholder="Enter Address" value="<?php echo $ad; ?>">
</div>
<div  class="col-sm-4">
<small>Bank</small>
<input type="text" class="form-control form-control-sm" name="bn" placeholder="Enter Bank Name" value="<?php echo $bk; ?>">
</div>
<div  class="col-sm-4">
<small>Account No</small>
<input type="number" class="form-control form-control-sm" name="ac" placeholder="Enter Account No" value="<?php echo $act; ?>">
</div>
</div>
<div class="row">
<div  class="col-sm-4">
<small>Date Of Birth</small>
<input type="text" class="form-control form-control-sm" name="db" placeholder="Enter Date Of Birth" value="<?php echo $agee; ?>">
</div>
<div  class="col-sm-4">
<small>Maritial Status</small>
<input type="text" class="form-control form-control-sm" name="ms" placeholder="Enter Maritial Status" value="<?php echo $ms; ?>">
</div>
<div  class="col-sm-4">
<small>State Of Origin</small>
<input type="text" class="form-control form-control-sm" name="sta" placeholder="Enter State Of Origin" value="<?php echo $sta; ?>">
</div>
</div>


<div class="row">
<div  class="col-sm-4">
<small>Account Name</small>
<input type="text" class="form-control form-control-sm" name="an" placeholder="Enter Account Name" value="<?php echo $ac; ?>">
</div>
<div  class="col-sm-4">
<small>Client Town</small>
<input type="text" class="form-control form-control-sm" name="tw" placeholder="Enter Document Expired Date" value="<?php echo $tw; ?>">
</div>
<div  class="col-sm-4">
<small>Document Type</small>
<input type="text" class="form-control form-control-sm" name="do" placeholder="Enter Document Type" value="<?php echo $do; ?>">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-primary btn-sm"   onclick="data()" id="butsave" >Update Info</button>
</form>







</div>







<div style="display: none;" id="gra">
<b>
<svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.4" d="M16.6643 21.9897H7.33488C5.88835 22.0796 4.46781 21.5781 3.3989 20.6011C2.4219 19.5312 1.92041 18.1107 2.01032 16.6652V7.33482C1.92041 5.88932 2.4209 4.46878 3.3979 3.39889C4.46781 2.42189 5.88835 1.92041 7.33488 2.01032H16.6643C18.1089 1.92041 19.5284 2.4209 20.5973 3.39789C21.5733 4.46878 22.0758 5.88832 21.9899 7.33482V16.6652C22.0788 18.1107 21.5783 19.5312 20.6013 20.6011C19.5314 21.5781 18.1109 22.0796 16.6643 21.9897Z" fill="currentColor"></path>
<path d="M17.0545 10.3976L10.5018 16.9829C10.161 17.3146 9.7131 17.5 9.24574 17.5H6.95762C6.83105 17.5 6.71421 17.4512 6.62658 17.3634C6.53895 17.2756 6.5 17.1585 6.5 17.0317L6.55842 14.7195C6.56816 14.261 6.75315 13.8317 7.07446 13.5098L11.7189 8.8561C11.7967 8.77805 11.9331 8.77805 12.011 8.8561L13.6399 10.4785C13.747 10.5849 13.9028 10.6541 14.0683 10.6541C14.4286 10.6541 14.7109 10.3615 14.7109 10.0102C14.7109 9.83463 14.6428 9.67854 14.5357 9.56146C14.5065 9.52244 12.9554 7.97805 12.9554 7.97805C12.858 7.88049 12.858 7.71463 12.9554 7.61707L13.6078 6.95366C14.2114 6.34878 15.1851 6.34878 15.7888 6.95366L17.0545 8.22195C17.6485 8.81707 17.6485 9.79268 17.0545 10.3976Z" fill="currentColor"></path>
</svg>
GUARANTOR UPDATE FORM
</b><br><br>
<form action="" method="POST" enctype="multipart/form-data" id="guarantor">
<div class="row">
<div  class="col-sm-4">
<input type="text"  hidden = "hidden" class="form-control form-control-sm" name="id" placeholder="" value="<?php echo $rgd; ?>">
<small>Firstname</small>
<input type="text" class="form-control form-control-sm" name="fn" placeholder="Enter Account Name" value="<?php echo $fng; ?>">
</div>
<div  class="col-sm-4">
<small>Middlename</small>
<input type="text" class="form-control form-control-sm" name="md" placeholder="Enter Principal Amount" value="<?php echo $mdg; ?>">
</div>
<div  class="col-sm-4">
<small>Lastname</small>
<input type="text" class="form-control form-control-sm" name="ln" placeholder="Enter Principal Amount" value="<?php echo $lng; ?>">
</div>
</div>
<div class="row">
<div  class="col-sm-4">
<small>Phone No</small>
<input type="text" class="form-control form-control-sm" name="ph" placeholder="Enter Account Name" value="<?php echo $btg; ?>">
</div>
<div  class="col-sm-4">
<small>Relationship</small>
<input type="text" class="form-control form-control-sm" name="rel" placeholder="Enter Principal Amount" value="<?php echo $sesg; ?>">
</div>
<div  class="col-sm-4">
<small>Gender</small>
<input type="text" class="form-control form-control-sm" name="gn" placeholder="Enter Principal Amount" value="<?php echo $sdg; ?>">
</div>
</div>
<div class="row">
<div  class="col-sm-4">
<small>ID CARD NO</small>
<input type="text" class="form-control form-control-sm" name="idd" placeholder="Enter Account Name" value="<?php echo $lmmg; ?>">
</div>
<div  class="col-sm-4">
<small>ID TYPE</small>
<input type="text" class="form-control form-control-sm" name="dt" placeholder="Enter Principal Amount" value="<?php echo $cfg; ?>">
</div>
<div  class="col-sm-4">
<small>BVN NO</small>
<input type="text" class="form-control form-control-sm" name="gbvn" placeholder="Enter BVN" value="<?php echo $gbvn; ?>">
</div>
</div>
<div class="row">
<div  class="col-sm-6">
<small>Address</small>
<input type="text" class="form-control form-control-sm" name="dress" placeholder="Enter Address" value="<?php echo $dress; ?>">
</div>
<div  class="col-sm-6">
<small>Status</small>
<select type="text" class="form-control form-control-sm" name="gst">
<option value="<?php echo $gst; ?>"><?php echo $gst; ?></option>
<option value="Active">Active</option>
<option value="Loan Closed">Loan Closed</option>
<option value="Pending">Pending</option>
</select>
</div>
</div>
<hr>
<button type="submit" class="btn btn-outline-primary btn-sm"  id = "dd" onclick="data_gua()">Update</button>
</form>




</div>





<div id="biz" style="display: none;">
<b>
<svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.14373 20.7821V17.7152C9.14372 16.9381 9.77567 16.3067 10.5584 16.3018H13.4326C14.2189 16.3018 14.8563 16.9346 14.8563 17.7152V20.7732C14.8562 21.4473 15.404 21.9951 16.0829 22H18.0438C18.9596 22.0023 19.8388 21.6428 20.4872 21.0007C21.1356 20.3586 21.5 19.4868 21.5 18.5775V9.86585C21.5 9.13139 21.1721 8.43471 20.6046 7.9635L13.943 2.67427C12.7785 1.74912 11.1154 1.77901 9.98539 2.74538L3.46701 7.9635C2.87274 8.42082 2.51755 9.11956 2.5 9.86585V18.5686C2.5 20.4637 4.04738 22 5.95617 22H7.87229C8.19917 22.0023 8.51349 21.8751 8.74547 21.6464C8.97746 21.4178 9.10793 21.1067 9.10792 20.7821H9.14373Z" fill="currentColor"></path>
</svg>
BUSINESS UPDATE FORM
</b>
<br><br>
<div id="business">
<div class="row">
<div class="col-sm-12" style="margin-top:10px;">
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM register WHERE id='$id' ";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bn = $rows['Business'];
$bt = $rows['Biz_Type'];
$ses = $rows['Biz_State'];
$sd = $rows['Start_Date'];
$cf = $rows['Cash_Flow'];
$ba = $rows['Biz_Address'];
$sh = $rows['Shop_Owner'];
?>
<div class="row">
<div class="col-sm-4">
<span style="font-size:11px"><b>Business:</b> <?php echo $bn; ?></span>
</div>
<div class="col-sm-4">
<span style="font-size:11px"><b>Business Type:</b> <?php echo $bt; ?></span>
</div>
<div class="col-sm-4">
<span style="font-size:11px"><b>State:</b> <?php echo $ses; ?></span>
</div>
<div class="col-sm-4">
<span style="font-size:11px"><b>Date Start:</b> <?php echo $sd; ?></span>
</div>
<div class="col-sm-4">
<span style="font-size:11px"><b>Ownership:</b> <?php echo $sh; ?></span>
</div>
<div class="col-sm-4">
<span style="font-size:11px"><b>Address:</b> <?php echo $ba; ?></span>
</div>
</div>
<hr>
<form action="" method="POST" enctype="multipart/form-data" id="uploadbiz">
<div class="row">
<div  class="col-sm-6">
<input type="text"  hidden = "hidden" class="form-control form-control-sm" name="id" placeholder="Enter Account Name" value="<?php echo $id; ?>">
<small>Business Name</small>
<input type="text" class="form-control form-control-sm" name="bns" placeholder="Enter Account Name" value="<?php echo $bz; ?>">
</div>
<div  class="col-sm-6">
<small>Business Type</small>
<input type="text" class="form-control form-control-sm" name="bts" placeholder="Enter Principal Amount" value="<?php echo $bt; ?>">
</div>
</div>
<div class="row">
<div  class="col-sm-12">
<small>Start Date</small>
<input type="text" class="form-control form-control-sm" name="sds" placeholder="Enter Principal Amount" value="<?php echo $sd; ?>">
</div>
</div>
<div class="row">
<div  class="col-sm-6">
<small>Address</small>
<input type="text" class="form-control form-control-sm" name="bas" placeholder="Enter Account Name" value="<?php echo $ba; ?>">
</div>
<div  class="col-sm-6">
<small>State</small>
<input type="text" class="form-control form-control-sm" name="sess" placeholder="Enter Principal Amount" value="<?php echo $bs; ?>">
</div>
</div>
<div class="row">
<div  class="col-sm-6">
<small>Business Owner</small>
<input type="text" class="form-control form-control-sm" name="bow" placeholder="Enter Business Owner" value="<?php echo $bow; ?>">
</div>
<div  class="col-sm-6">
<small>Shop Ownership</small>
<input type="text" class="form-control form-control-sm" name="sh" placeholder="Enter Shop Ownership" value="<?php echo $sh; ?>">
</div>
</div>
<hr>
<button type="submit" class="btn btn-outline-primary btn-sm"  name="bz" onclick="data_biz()" >Update Info</button>
</form>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
//echo" No Record Found  <br/> ";       
}
?>
</div>
<br>

</div>
</div>













</div>

</div>
</div>



</div>






<script>
function myDash() {
var x = document.getElementById("dashboard");// dashboard
var y = document.getElementById("cl");// client update form
var c = document.getElementById("client");//client pic
var a = document.getElementById("gra");// gaurantor form
var b = document.getElementById("biz");// bissiness image
var g = document.getElementById("ga");// guarantor image
var d = document.getElementById("de");
if (x.style.display === "none") {
x.style.display = "block";
c.style.display = "block";
y.style.display = "none";
a.style.display = "none";
g.style.display = "none";
b.style.display = "none";
} else {
x.style.display = "block";
}
}

function myClient() {
var x = document.getElementById("dashboard");// dashboard
var y = document.getElementById("cl");// client update form
var c = document.getElementById("client");//client pic
var a = document.getElementById("gra");// gaurantor form
var b = document.getElementById("biz");// bissiness image
var g = document.getElementById("ga");// guarantor image
var d = document.getElementById("de");
if (y.style.display === "none") {
y.style.display = "block";
c.style.display = "block";
x.style.display = "none";
a.style.display = "none";
g.style.display = "none";
b.style.display = "none";
} else {
y.style.display = "block";
}
}

function myGua() {
var x = document.getElementById("dashboard");// dashboard
var y = document.getElementById("cl");// client update form
var c = document.getElementById("client");//client pic
var a = document.getElementById("gra");// gaurantor form
var b = document.getElementById("biz");// bissiness image
var g = document.getElementById("ga");// guarantor image
var d = document.getElementById("de");
if (a.style.display === "none") {
c.style.display = "none";
b.style.display = "none";
x.style.display = "none";
y.style.display = "none";
a.style.display = "block";
g.style.display = "block";

} else {
a.style.display = "block";
}
}

function myBizs() {
var x = document.getElementById("dashboard");// dashboard
var y = document.getElementById("cl");// client update form
var c = document.getElementById("client");//client pic
var a = document.getElementById("gra");// gaurantor form
var b = document.getElementById("biz");// bissiness image
var g = document.getElementById("ga");// guarantor image
var d = document.getElementById("de");
if (b.style.display === "none") {
c.style.display = "block";
b.style.display = "block";
x.style.display = "none";
y.style.display = "none";
a.style.display = "none";
g.style.display = "none";

} else {
b.style.display = "block";
}
}

</script>

</div>



<script type="text/javascript">
$(document).ready(function (e){
$("#uploads").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this client info.!!";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "client_update_record.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
loads();
$( "#client" ).load( "manager_profile.php?id=<?php echo $id; ?> #client" );// 
$( "#dashboard" ).load( "manager_profile.php?id=<?php echo $id; ?> #dashboard" );// 
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
$("#updateModal").modal('show');
}, 6000);
}else{
alert ("Error" + data);
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
$("#guarantor").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this guarantor info.!!";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "update_gaurantor_info.php",
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
$( "#gaurantor" ).load( "manager_profile.php?id=<?php echo $id; ?> #gaurantor" );// 
$("#ga").show();//
$( "#dashboard" ).load( "manager_profile.php?id=<?php echo $id; ?> #dashboard" );// 
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
$("#updateModal").modal('show');
}, 6000);
}else{
alert ("Error" + data);
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
$("#uploadbiz").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this business info.!!";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "update_business_record.php",
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
$( "#business" ).load( "manager_profile.php?id=<?php echo $id; ?> #business" );//  
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
$("#updateModal").modal('show');
}, 6000);
}else{
alert ("Error" + data);
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
$("#deleteapp").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to delete this record from database";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "record_delete.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasti").css("display", "block");
$("#toasti").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasti").hide();
}, 6000);
}else{
alert ("Error" + data);
}
},
error: function(){
}
});
}
}));
});
</script>
