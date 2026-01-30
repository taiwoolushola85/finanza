<?php 
include_once '../config/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // ONE QUERY: Joining repayments (r) and register (reg)
    $sql = "SELECT 
                r.id, r.Location, r.Firstname, r.Lastname, r.Unions, r.Phone, r.Reg_id, r.BVN, 
                r.Interest_Amt, r.Loan_Amount, r.Total_Loan, r.Branch, r.Officer_Name, 
                r.Team_Name, r.Gender, r.Status,
                reg.id AS reg_id_val, reg.Address, reg.Years, reg.State, reg.Middlename, 
                reg.Document, reg.Document_No, reg.Maritial_Status, reg.Date_Reg, 
                reg.Time_Reg, reg.Bank, reg.Account_Name, reg.Account_No, reg.Loan_Amount AS reg_loan
            FROM repayments r
            LEFT JOIN register reg ON r.Reg_id = reg.id
            WHERE r.id = ? 
            LIMIT 1";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // --- Repayment Variables ---
        $id      = $row['id'];
        $loc     = $row['Location'];
        $fst     = $row['Firstname'];
        $nam     = $row['Firstname']." ".$row['Lastname'];
        $un      = $row['Unions'];
        $ph      = $row['Phone'];
        $reg_id  = $row['Reg_id'];
        $bv      = $row['BVN'];
        $int     = $row['Interest_Amt'];
        $la      = $row['Loan_Amount'];
        $tlo     = $row['Total_Loan'];
        $br      = $row['Branch'];
        $of      = $row['Officer_Name'];
        $tn      = $row['Team_Name'];
        $gen     = $row['Gender'];
        $st      = $row['Status'];

        // --- Register Variables ---
        $regid   = $row['reg_id_val'];
        $cad     = $row['Address'];
        $clad    = $row['Address'];
        $dob     = $row['Years'];
        $sta     = $row['State'];
        $fn      = $row['Firstname'];
        $md      = $row['Middlename'];
        $ls      = $row['Lastname'];
        $do      = $row['Document'];
        $doc     = $row['Document_No'];
        $mts     = $row['Maritial_Status'];
        $dg      = $row['Date_Reg'];
        $tg      = $row['Time_Reg'];
        $bnk     = $row['Bank'];
        $acct    = $row['Account_Name'];
        $act     = $row['Account_No'];
        $lon     = $row['reg_loan'];
    }
    mysqli_stmt_close($stmt);
}
?>
<div >

<div class="row">
<div class="col-sm-6">
<div>
<div >
<b style="font-size:12px;">CLIENT DETAILS</b><hr>
<?php
$img = $loc ?? '';
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
<img src="<?php echo $imgPath; ?>" style="width:40px; height:40px; margin-left:6px" class="img-fluid rounded-pill avatar-50" loading="lazy">
<br><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>FIRSTNAME:</b> <?php echo $fst; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"> <b>OTHER NAME:</b> <?php echo $md." ".$ls; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px" ><b>PHONE:</b> <?php echo $ph; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>BRANCH:</b> <?php echo $br; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>DOCUMENT:</b> <?php echo $do; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>DOCUMENT NO:</b> <?php echo $doc; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>GENDER:</b> <?php echo $gen; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>STATE:</b> <?php echo $sta; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>BANK NAME:</b> <?php echo $bnk; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>ACCT NO:</b> <?php echo $act; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>ACCT NAME:</b> <?php echo $acct; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>AMT RECIEVED:</b> <?php echo number_format($la,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="font-size:10px; margin-left:8px"><b>ADDRESS:</b> <?php echo $clad; ?></small>
</div>
</div>
<br>
</div>
</div>
</div>
</div>




<div class="col-sm-6" >
<div>
<div>
<b style="font-size:12px;">GUARANTOR DETAILS</b><hr>
<?php 
include_once '../config/db.php';

// Ensure $reg_id is available from your previous logic
$reg_id = isset($reg_id) ? $reg_id : '';

if (!empty($reg_id)) {
    // 1. Prepared Statement for security and speed
    // Fetching specific columns only (no ORDER BY needed for unique limit 1 matches)
    $Query = "SELECT id, Location, Firstname, Middlename, Lastname, Gender, Regis_id, Phone, 
                     Address, Relationship, ID_No, ID_Type, Client_BVN, Status, 
                     Gaurantor_BVN, Client_Name, Date_Reg, Time_Reg, ID_Image 
              FROM gaurantors 
              WHERE Regis_id = ? 
              LIMIT 1";

    $stmt = mysqli_prepare($con, $Query);
    mysqli_stmt_bind_param($stmt, "s", $reg_id); // Assuming Regis_id is a string/varchar
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // --- Mapping Variables ---
        $idd    = $row['id'];
        $pic    = $row['Location'];
        $frst   = $row['Firstname'];
        $mid    = $row['Middlename'];
        $las    = $row['Lastname'];
        $gn     = $row['Gender'];
        $reg_id = $row['Regis_id'];
        $ph2    = $row['Phone'];
        $ad     = $row['Address'];
        $re     = $row['Relationship'];
        $idn    = $row['ID_No'];
        $idt    = $row['ID_Type'];
        $cl_bvn = $row['Client_BVN'];
        $st     = $row['Status'];
        $gb     = $row['Gaurantor_BVN'];
        $clt    = $row['Client_Name'];
        $gdg    = $row['Date_Reg'];
        $gtg    = $row['Time_Reg'];
        $gids   = $row['ID_Image'];

        // --- Computed Name Variables ---
        $oth    = $mid . " " . $las;
        $fn     = $frst;
        $ot     = $mid . " " . $las;
        $ott    = $frst . " " . $mid;
        $gn2    = $gn;
    }
    mysqli_stmt_close($stmt);
}
?>
<?php
$img = $pic ?? '';
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
<img src="<?php echo $imgPath; ?>" style="width:40px; height:40px; margin-left:6px" class="img-fluid rounded-pill avatar-50" loading="lazy">
<br><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>FIRSTNAME:</b> <?php echo $frst; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>OTHER NAME:</b> <?php echo $oth; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>RELATIONSHIP:</b> <?php echo $re; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>BVN/NIN:</b> <?php echo $gb; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>PHONE:</b> <?php echo $ph2; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>GENDER:</b> <?php echo $gn2; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>CLIENT BVN:</b> <?php echo $cl_bvn; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>CLIENT ID:</b> <?php echo $reg_id; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>ID NO:</b> <?php echo $idn; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>ID TYPE:</b> <?php echo $idt; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>GUARANTOR ID:</b> <?php echo $idd; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>REG DATE:</b> <?php echo $dg; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="font-size:10px; margin-left:8px"><b>ADDRESS:</b> <?php echo $ad; ?></small>
</div>
</div>
<br>
</div>
</div>
</div>
</div>


</div>

<b style="font-size:11px;">BUSINESS DETALS</b><br><br>
<div class="table-container" style="height:62px">
<table style="font-size:8px;">
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
include 'db.php';
//Get Transactions Details
$Query = "SELECT Business,Biz_Type,Biz_State,Start_Date,Cash_Flow,Biz_Address,Town FROM register WHERE id='$reg_id' ORDER BY id ASC LIMIT 1";
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
$cfs = $rows['Cash_Flow'];
$bas = $rows['Biz_Address'];
$tnws = $rows['Town'];
///$bims = $rows['Biz_Image'];
?>
<td><?php echo $bns; ?></td>
<td><?php echo $bts; ?></td>
<td><?php echo $sess; ?></td>
<td><?php echo $sds; ?></td>
<td><?php echo number_format($cfs,2); ?></td>
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
