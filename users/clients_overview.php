<?php 
include '../config/db.php';
$id = $_GET['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT id,Location,Firstname,Lastname,Unions,Phone,Reg_id,BVN,Interest_Amt,Loan_Amount,Total_Loan,Branch,Officer_Name,
Team_Name,Gender,Status FROM repayments WHERE id = '$id' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$loc = $row['Location'];
$nam = $row['Firstname']." ".$row['Lastname'];
$un = $row['Unions'];
$fst = $row['Firstname'];
$ph = $row['Phone'];
$reg_id = $row['Reg_id'];
$bv = $row['BVN'];
$int = $row['Interest_Amt'];
$la = $row['Loan_Amount'];
$tlo = $row['Total_Loan'];
$br = $row['Branch'];
$of = $row['Officer_Name'];
$tn = $row['Team_Name'];
$gen = $row['Gender'];
$st = $row['Status'];
// getting registration info
$Query = "SELECT id,Address,Years,State,Firstname,Middlename,Lastname,Document,Document_No,Maritial_Status,Date_Reg,Time_Reg,Bank,Account_Name,Account_No,
Loan_Amount FROM register WHERE id = '$reg_id' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$cad = $row['Address'];
$dob = $row['Years'];
$sta = $row['State'];
$fn = $row['Firstname'];
$md = $row['Middlename'];
$ls = $row['Lastname'];
$do = $row['Document'];
$doc = $row['Document_No'];
$mts = $row['Maritial_Status'];
$dg = $row['Date_Reg'];
$tg = $row['Time_Reg'];
$bnk = $row['Bank'];
$acct = $row['Account_Name'];
$act = $row['Account_No'];
$lon = $row['Loan_Amount'];
$clad = $row['Address'];
?>
<div >

<div class="row" style="font-size:12px; text-transform:capitalize">
<div class="col-sm-6" style="margin-top:10px">
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>FIRSTNAME:</b> <?php echo $fst; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>OTHER NAME:</b> <?php echo $md." ".$ls; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>PHONE:</b> <?php echo $ph; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>BRANCH:</b> <?php echo $br; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>DOCUMENT:</b> <?php echo $do; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>DOCUMENT NO:</b> <?php echo $doc; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>GENDER:</b> <?php echo $gen; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>STATE:</b> <?php echo $sta; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>BANK NAME:</b> <?php echo $bnk; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>ACCT NO:</b> <?php echo $act; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>ACCT NAME:</b> <?php echo $acct; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>AMT RECIEVED:</b> <?php echo number_format($la,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="margin-left:8px;"><b>ADDRESS:</b> <?php echo $clad; ?></small>
</div>
</div>
<br>
</div>
</div>





<div class="col-sm-6" style="margin-top:10px">
<?php 
include '../config/db.php';
$Query = "SELECT id,Location,Firstname,Middlename,Lastname,Gender,Regis_id,Phone,Address,Relationship,ID_No,ID_Type,Client_BVN,Status,Gaurantor_BVN,
Client_Name,Date_Reg,Time_Reg,ID_Image FROM gaurantors WHERE Regis_id = '$reg_id' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$idd = $row['id'];
$pic = $row['Location'];
$frst = $row['Firstname'];
$mid = $row['Middlename'];
$las = $row['Lastname'];
$oth = $row['Middlename']." ".$row['Lastname'];
$gn = $row['Gender'];
$reg_id = $row['Regis_id'];
$fn = $row['Firstname'];
$ot = $row['Middlename']." ".$row['Lastname'];
$ott = $row['Firstname']." ".$row['Middlename'];
$ph2 = $row['Phone'];
$gn2 = $row['Gender'];
$ad = $row['Address'];
$re = $row['Relationship'];
$idn = $row['ID_No'];
$idt = $row['ID_Type'];
$cl_bvn = $row['Client_BVN'];
$st = $row['Status'];
$gb = $row['Gaurantor_BVN'];
$clt = $row['Client_Name'];
$gdg = $row['Date_Reg'];
$gtg = $row['Time_Reg'];
$gids = $row['ID_Image'];
?>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>FIRSTNAME:</b> <?php echo $frst; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>OTHERNAME:</b> <?php echo $oth; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>RELATIONSHIP:</b> <?php echo $re; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>BVN/NIN:</b> <?php echo $gb; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>PHONE:</b> <?php echo $ph2; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>GENDER:</b> <?php echo $gn2; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>CLIENT BVN:</b> <?php echo $cl_bvn; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>CLIENT ID:</b> <?php echo $reg_id; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>ID NO:</b> <?php echo $idn; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>ID TYPE:</b> <?php echo $idt; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="margin-left:8px;"><b>GUARANTOR ID:</b> <?php echo $idd; ?></small>
</div>
<div class="col-sm-6">
<small style="margin-left:8px;"><b>REG DATE:</b> <?php echo $dg; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="margin-left:8px;"><b>ADDRESS:</b> <?php echo $ad; ?></small>
</div>
</div>
<br>
</div>
</div>



</div>
<hr>
<b style="font-size:11px;">BUSINESS DETALS</b><br>
<div class="table-responsive">
<table style="font-size:8px; margin-top:5px">
<thead>
<tr >
<th>BUSINESS NAME</th>
<th>TYPE</th>
<th>STATE</th>
<th>START DATE</th>
<th>DAILY TURN OVER AMT</th>
<th>ADDRESS</th>
</tr>
</thead>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT Business,Biz_Type,Biz_State,Start_Date,Biz_Address,Town FROM register WHERE id='$reg_id' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$bns = $rows['Business'];
$bts = $rows['Biz_Type'];
$sess = $rows['Biz_State'];
$sds = $rows['Start_Date'];
$bas = $rows['Biz_Address'];
$tnws = $rows['Town'];
///$bims = $rows['Biz_Image'];
?>
<td><?php echo $bns; ?></td>
<td><?php echo $bts; ?></td>
<td><?php echo $sess; ?></td>
<td><?php echo $sds; ?></td>
<td><?php echo number_format(0,2); ?></td>
<td><?php echo $bas; ?></td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
echo" No Record Found";       
}
?>
</table>
</div>






</div>
