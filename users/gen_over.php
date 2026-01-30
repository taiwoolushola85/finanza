<?php 
include_once '../config/db.php';

// 1. Sanitize and validate the ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // 2. Prepared Statement: Faster and Secure
    // We fetch only the specific columns to save memory and network bandwidth
    $sql = "SELECT 
                id, Unions, Transaction_id, Disbursement_No, Loan_Account_No, Phone, Reg_id, 
                Interest_Amt, Loan_Amount, Paid, Total_Bal, Total_Loan, Status, 
                Expected_Amount, Branch, Product, Frequency, Officer_Name, Team_Name, 
                Gender, Last_Amount, Date_Disbursed, Transaction_Date, Rate, 
                Duration, Maturity_Date, Maturity_Status 
            FROM repayments 
            WHERE id = ? 
            LIMIT 1";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // 3. Use fetch_assoc for better performance than fetch_array
    if ($row = mysqli_fetch_assoc($result)) {
        // Mapping variables
        $id      = $row['id'];
        $un      = $row['Unions'];
        $tr      = $row['Transaction_id'];
        $dis     = $row['Disbursement_No'];
        $ln      = $row['Loan_Account_No'];
        $ph      = $row['Phone'];
        $reg_id  = $row['Reg_id'];
        $int     = $row['Interest_Amt'];
        $la      = $row['Loan_Amount'];
        $pd      = $row['Paid'];
        $tb      = $row['Total_Bal'];
        $tlo     = $row['Total_Loan'];
        $er      = $row['Expected_Amount'];
        $br      = $row['Branch'];
        $pr      = $row['Product'];
        $fr      = $row['Frequency'];
        $of      = $row['Officer_Name'];
        $tn      = $row['Team_Name'];
        $gen     = $row['Gender'];
        $st      = $row['Status'];
        $lamt    = $row['Last_Amount'];
        $dd      = $row['Date_Disbursed'];
        $td      = $row['Transaction_Date'];
        $ten     = $row['Rate'];
        $du      = $row['Duration'];
        $mtd     = $row['Maturity_Date'];
        $mts     = $row['Maturity_Status'];
    }
    mysqli_stmt_close($stmt);
} else {
    // Handle invalid ID (optional)
    die("Invalid record ID.");
}
?>
<!-- Loan Overview start-->
<div id="loan">
<b>
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M7.33049 2.00049H16.6695C20.0705 2.00049 21.9905 3.92949 22.0005 7.33049V16.6705C22.0005 20.0705 20.0705 22.0005 16.6695 22.0005H7.33049C3.92949 22.0005 2.00049 20.0705 2.00049 16.6705V7.33049C2.00049 3.92949 3.92949 2.00049 7.33049 2.00049ZM12.0495 17.8605C12.4805 17.8605 12.8395 17.5405 12.8795 17.1105V6.92049C12.9195 6.61049 12.7705 6.29949 12.5005 6.13049C12.2195 5.96049 11.8795 5.96049 11.6105 6.13049C11.3395 6.29949 11.1905 6.61049 11.2195 6.92049V17.1105C11.2705 17.5405 11.6295 17.8605 12.0495 17.8605ZM16.6505 17.8605C17.0705 17.8605 17.4295 17.5405 17.4805 17.1105V13.8305C17.5095 13.5095 17.3605 13.2105 17.0895 13.0405C16.8205 12.8705 16.4805 12.8705 16.2005 13.0405C15.9295 13.2105 15.7805 13.5095 15.8205 13.8305V17.1105C15.8605 17.5405 16.2195 17.8605 16.6505 17.8605ZM8.21949 17.1105C8.17949 17.5405 7.82049 17.8605 7.38949 17.8605C6.95949 17.8605 6.59949 17.5405 6.56049 17.1105V10.2005C6.53049 9.88949 6.67949 9.58049 6.95049 9.41049C7.21949 9.24049 7.56049 9.24049 7.83049 9.41049C8.09949 9.58049 8.25049 9.88949 8.21949 10.2005V17.1105Z" fill="currentColor" />
</svg>
LOAN OVERVIEW
</b>
<hr>
<div class="row" >
<div class="col-sm-6">

<div>
<div >
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>DISBURSED NO:</b> <?php echo $dis; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>TRANSACTION ID:</b> <?php echo $tr; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>LOAN ACCOUNT:</b> <?php echo $ln; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>PRINCIPAL AMT:</b> <?php echo number_format($la,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>INTEREST AMT:</b> <?php echo number_format($int,2); ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>LOAN AMT:</b> <?php echo number_format($la + $int,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>AMOUNT PAID:</b> <?php echo number_format($pd,2); ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>OUTSTANDING:</b> <?php echo number_format($tb,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>LAST AMT PAID:</b> <?php echo number_format($lamt,2); ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>EXPECTED AMT:</b> <?php echo number_format($er,2); ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<small style="font-size:10px; margin-left:8px"><b>TRANSACTION DATE:</b> <?php echo date("d-M-Y", strtotime($td)); ?></small>
</div>
</div>
<br>
</div>

</div>
</div>
</div>

<div class="col-sm-6">
<div>
<div>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>GROUP NAME:</b> <?php echo $un; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>BRANCH:</b> <?php echo $br; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>PRODUCT:</b> <?php echo $pr; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>FREQUENCY:</b> <?php echo $fr; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>RATE:</b> <?php echo $ten; ?>%</small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>DURATION:</b> <?php echo $du; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>LOAN OFFICER:</b> <?php echo $of; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>TEAM LEADER:</b> <?php echo $tn; ?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>MATURITY DATE:</b> <?php echo $mtd; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>LOAN STATUS:</b> <?php 
if($d < $mtd){
echo "<span style='color:green'>Runing</span>";
}else{
echo "<span style='color:red'>Expired</span>";
}
?></small>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>DATE DISBURSED:</b> <?php echo $dd; ?></small>
</div>
<div class="col-sm-6">
<small style="font-size:10px; margin-left:8px"><b>LOAN DUE DAYS:</b> 
<?php 
if($d > $mtd){
// overdue days
if($fr == 'Daily'){
$now = time(); // or your date as well
$your_date = strtotime($dd);
$datediff = $now - $your_date;
$ad = round($datediff / (60 * 60 * 24));//tenure used
$day_used = $du - $ad;// overdue
if($du > $ad){
$expt_based_on_day = $er * $ad;
$overdue_amt = $expt_based_on_day - $pd;
$miss_day = $overdue_amt/$er;
echo round($miss_day)." "."Days";
}else{
$miss_day = $tb/$er;
echo round($miss_day)." "."Days";
}

}else if($fr == 'Weekly'){

$date1 = new DateTime($dd);
$date2 = new DateTime($d);
// I have left the remainer. You may need to round up/down. 
$week_used = round($date1->diff($date2)->days / 7); 

$week = $du - $week_used;
if ($week_used == '0'){
echo number_format(0,2);
}else if($du > $week_used){
$expt_based_on_week = $er * $week_used;
$overdue_amt = $expt_based_on_week - $pd;
$miss_day = $overdue_amt/$er;
echo round($miss_day)." "."Weeks";
}else{
$miss_day = $tb/$er;
echo round($miss_day)." "."Weeks";
}

}else{

$date1 = new DateTime($dd);
$date2 = new DateTime($d);
// I have left the remainer. You may need to round up/down. 
$month_used = round($date1->diff($date2)->days / 30); 
    
$month = $du - $month_used;
if($month_used == '0'){
echo number_format(0,2);
}else if($du > $month_used){
$expt_based_on_month = $er * $month_used;
echo number_format($expt_based_on_month - $pd,2);
}else{
echo number_format($member->Total_Loan,2);
}
}
}else{
echo "0";
}
?>

</small>
</div>
</div>
<br>
</div>
</div>

</div>
</div>

</div>
 


<?php 
include_once '../config/db.php';
$id = $_GET['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT id,Reg_id,BVN
FROM repayments WHERE id = '$id'  ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$bv = $row['BVN'];
?>
<div >
<?php 
include '../config/db.php';
$sql = "SELECT count(*)  AS overs FROM repayments WHERE BVN = '$bv' AND Status = 'Closed'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$closed = $data['overs'];

$sql = "SELECT count(*)  AS overs FROM repayments WHERE BVN = '$bv' AND Status = 'Active'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$active = $data['overs'];

$sql = "SELECT count(*)  AS overs FROM repayments WHERE BVN = '$bv' AND Status = 'Cancelled'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$cancel = $data['overs'];
?>
<div class="row">
<div class="col-sm-4">
No Of Closed Loans: <?php  echo $closed; ?>
</div>
<div class="col-sm-4">
No Of Active Loans: <?php  echo $active; ?>
</div>
<div class="col-sm-4">
No Of Cancelled Loans: <?php  echo $cancel; ?>
</div>
</div>
<br>
<h5 style="font-size:11px;"><b>LOAN HISTORY</b></h5>
<div class="table-container" style="height:120px; overflow:auto">
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
$Query = "SELECT Loan_Account_No,Savings_Account_No,BVN,Loan_Amount,Total_Bal,Status,Date_Disbursed,Date_Closed FROM repayments WHERE BVN='$bv' ORDER BY id DESC LIMIT 10";
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

<!-- Loan Overview end-->
