<?php
include('../config/db.php');
$regid = intval($_POST['id']);
$Query = "SELECT * FROM register WHERE id='$regid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$loc = $row['Location'];
$fn = $row['Firstname'];
$full = $row['Firstname']." ". $row['Middlename']." ". $row['Lastname'];
$fullx = $row['Firstname']." ".$row['Lastname'];
$ln = $row['Lastname'];
$mn = $row['Middlename'];
$bv = $row['BVN'];
$ph = $row['Phone'];
$em = $row['Education'];
$prid = $row['Product_id'];
$gn = $row['Gender'];
$ad = $row['Address'];
$bu = $row['Biz_Type'];
$tn = $row['Tenure'];
$rt = $row['Rate'];
$la = $row['Loan_Amount'];
$bn = $row['Bank'];
$an = $row['Account_Name'];
$ac = $row['Account_No'];
$bs = $row['Business'];
$st = $row['Biz_State'];
$ch = $row['Cash_Flow'];
$bd = $row['Biz_Address'];
$ss = $row['Status'];
$int_amt = $row['Interest_Amt'];
$re_amt = $row['Repayment_Amt'];
$ttl = $row['Total_Loan'];

// getting product information
$Query = "SELECT * FROM product_list WHERE Product_id = '$prid'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$rt = $row['Rate'];
$tn = $row['Tenure'];
$fr = $row['Frequency'];
//$cnts = $row['Count'];

// Define holidays array - Add your specific holidays here
$holidays = array(
    '2025-01-01', // New Year's Day
    '2025-04-18', // Good Friday
    '2025-04-21', // Easter Monday
    '2025-05-01', // Workers' Day
    '2025-05-27', // Children's Day
    '2025-06-12', // Democracy Day
    '2025-10-01', // Independence Day
    '2025-12-25', // Christmas Day
    '2025-12-26', // Boxing Day
    // Add more holidays as needed
);

// Function to check if a date is a weekend
function isWeekend($date) {
$dayOfWeek = date('D', strtotime($date));
return in_array($dayOfWeek, array('Sat', 'Sun'));
}

// Function to check if a date is a holiday
function isHoliday($date, $holidays) {
return in_array($date, $holidays);
}

// Function to get next business day
function getNextBusinessDay($date, $holidays) {
$nextDay = $date;
do {
$nextDay = date('Y-m-d', strtotime($nextDay . ' +1 day'));
} while (isWeekend($nextDay) || isHoliday($nextDay, $holidays));
return $nextDay;
}
?>

<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<div id="table-container" style="height:350px;">
<table>
<thead>
<tr>
<th style="font-size:8px">Principal Amount</th> 
<th style="font-size:8px">Interest Amount</th> 
<th style="font-size:8px">Total Loan Amount</th> 
<th style="font-size:8px">Repayment Amount</th> 
<th style="font-size:8px">Repayment Date</th>
<th style="font-size:8px">Days</th>
</tr>
</thead>
<tbody>
<?php 
if($fr == 'Daily'){
$no = $_POST['no'];
$ft = $_POST['ft'];
$startdate = strtotime($_POST['ft']);
$businessDaysAdded = 0;
$currentDate = date('Y-m-d', $startdate);
// Loop until we have the exact number of business days equal to tenure
while($businessDaysAdded < $no) {
// Check if current date is a business day
if(!isWeekend($currentDate) && !isHoliday($currentDate, $holidays)) {
$days = date("D", strtotime($currentDate));
?>
<tr>
<input hidden="hidden" name="id[]" class="form-control" value="<?php echo $id;?>" required="required">
<input hidden="hidden" name="bv[]" class="form-control" value="<?php echo $bv;?>" required="required">
<input hidden="hidden" name="full[]" class="form-control" value="<?php echo $full;?>" required="required">
<input hidden="hidden" name="la[]" class="form-control" value="<?php echo $la;?>" required="required">
<input hidden="hidden" name="tt[]" class="form-control" value="<?php echo $ttl;?>" required="required">
<input hidden="hidden" name="pt[]" class="form-control" value="Daily" required="required">
<input hidden="hidden" name="re_amt[]" class="form-control" value="<?php echo $re_amt;?>" required="required">
<input hidden="hidden" name="fn[]" class="form-control" value="<?php echo $fn;?>" required="required">
<input hidden="hidden" name="mn[]" class="form-control" value="<?php echo $mn;?>" required="required">
<input hidden="hidden" name="ln[]" class="form-control" value="<?php echo $ln;?>" required="required">
<input hidden="hidden" name="ph[]" class="form-control" value="<?php echo $ph;?>" required="required">
<input hidden="hidden" name="int_amt[]" class="form-control" value="<?php echo $int_amt/$tn;?>" required="required">
<input hidden="hidden" name="cnts[]" class="form-control" value="<?php echo $tn;?>" required="required">
<input hidden="hidden" name="exp_date[]" class="form-control" value="<?php echo $currentDate; ?>" required="required">
<input hidden="hidden" name="day[]" class="form-control" value="<?php echo $days; ?>" required="required">
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int_amt/$tn,2); ?></td>
<td><?php echo number_format($ttl,2); ?></td>
<td><?php echo number_format($re_amt,2); ?></td>
<td><?php echo $currentDate; ?></td>
<td><?php echo $days; ?></td>
</tr>
<?php 
$businessDaysAdded++;
}
// Move to next day
$currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
}
?>

<?php
}elseif($fr == 'Weekly'){
$no = $_POST['no'];
$ft = $_POST['ft'];
$increment = 1;
$startdate = strtotime($_POST['ft']);
for ($week = 0; $week <= $no; $week += $increment) {
$scheduledDate = date('Y-m-d', strtotime("+$week weeks", $startdate));
// If scheduled date falls on weekend or holiday, move to next business day
if(isWeekend($scheduledDate) || isHoliday($scheduledDate, $holidays)) {
$scheduledDate = getNextBusinessDay($scheduledDate, $holidays);
}
$days = date("D", strtotime($scheduledDate));
?>
<tr>
<input hidden="hidden" name="id[]" class="form-control" value="<?php echo $id;?>" required="required">
<input hidden="hidden" name="bv[]" class="form-control" value="<?php echo $bv;?>" required="required">
<input hidden="hidden" name="full[]" class="form-control" value="<?php echo $full;?>" required="required">
<input hidden="hidden" name="la[]" class="form-control" value="<?php echo $la;?>" required="required">
<input hidden="hidden" name="tt[]" class="form-control" value="<?php echo $ttl;?>" required="required">
<input hidden="hidden" name="pt[]" class="form-control" value="Weekly" required="required">
<input hidden="hidden" name="re_amt[]" class="form-control" value="<?php echo $re_amt;?>" required="required">
<input hidden="hidden" name="fn[]" class="form-control" value="<?php echo $fn;?>" required="required">
<input hidden="hidden" name="mn[]" class="form-control" value="<?php echo $mn;?>" required="required">
<input hidden="hidden" name="ln[]" class="form-control" value="<?php echo $ln;?>" required="required">
<input hidden="hidden" name="ph[]" class="form-control" value="<?php echo $ph;?>" required="required">
<input hidden="hidden" name="int_amt[]" class="form-control" value="<?php echo $int_amt;?>" required="required">
<input hidden="hidden" name="exp_date[]" class="form-control" value="<?php echo $scheduledDate;?>" required="required">
<input hidden="hidden" name="day[]" class="form-control" value="<?php echo $days; ?>" required="required">
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int_amt,2); ?></td>
<td><?php echo number_format($ttl,2); ?></td>
<td><?php echo number_format($re_amt,2); ?></td>
<td><?php echo $scheduledDate; ?></td>
<td><?php echo $days; ?></td>
</tr>
<?php
}
?>

<?php
}else{
// Monthly
$no = $_POST['no'];
$ft = $_POST['ft'];
$increment = 1;
$startdate = strtotime($_POST['ft']);
for ($month = 0; $month <= $no; $month += $increment) {
$scheduledDate = date('Y-m-d', strtotime("+$month months", $startdate));
// If scheduled date falls on weekend or holiday, move to next business day
if(isWeekend($scheduledDate) || isHoliday($scheduledDate, $holidays)) {
$scheduledDate = getNextBusinessDay($scheduledDate, $holidays);
}
$days = date("D", strtotime($scheduledDate));
?>
<tr>
<input hidden="hidden" name="id[]" class="form-control" value="<?php echo $id;?>" required="required">
<input hidden="hidden" name="bv[]" class="form-control" value="<?php echo $bv;?>" required="required">
<input hidden="hidden" name="full[]" class="form-control" value="<?php echo $full;?>" required="required">
<input hidden="hidden" name="la[]" class="form-control" value="<?php echo $la;?>" required="required">
<input hidden="hidden" name="tt[]" class="form-control" value="<?php echo $ttl;?>" required="required">
<input hidden="hidden" name="pt[]" class="form-control" value="Monthly" required="required">
<input hidden="hidden" name="re_amt[]" class="form-control" value="<?php echo $re_amt;?>" required="required">
<input hidden="hidden" name="fn[]" class="form-control" value="<?php echo $fn;?>" required="required">
<input hidden="hidden" name="mn[]" class="form-control" value="<?php echo $mn;?>" required="required">
<input hidden="hidden" name="ln[]" class="form-control" value="<?php echo $ln;?>" required="required">
<input hidden="hidden" name="ph[]" class="form-control" value="<?php echo $ph;?>" required="required">
<input hidden="hidden" name="int_amt[]" class="form-control" value="<?php echo $int_amt;?>" required="required">
<input hidden="hidden" name="exp_date[]" class="form-control" value="<?php echo $scheduledDate;?>" required="required">
<input hidden="hidden" name="day[]" class="form-control" value="<?php echo $days; ?>" required="required">
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int_amt,2); ?></td>
<td><?php echo number_format($ttl,2); ?></td>
<td><?php echo number_format($re_amt,2); ?></td>
<td><?php echo $scheduledDate; ?></td>
<td><?php echo $days; ?></td>
</tr>

<?php 
}
}
?>
</tbody>
</table>
</div>
<br>

<button type="submit" class="btn btn-outline-success btn-sm" onclick="data()" id="save">Proceed For Disbursement</button>

</form>

<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to approve this application for disbursement";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "save_repayment_schedule.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
setTimeout(function(){
$("#please").hide();
$("#tot").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#tot").hide();
}, 6000);
},
error: function(){
}
});
}
}));
});
</script>

<?php
mysqli_close($con);
?>