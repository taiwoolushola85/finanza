<?php
include('../config/db.php');

// Input validation and sanitization
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$regid = isset($_POST['reg']) ? intval($_POST['reg']) : 0;
$no = isset($_POST['no']) ? intval($_POST['no']) : 0;
$ft = isset($_POST['ft']) ? mysqli_real_escape_string($con, $_POST['ft']) : '';

// Validate inputs
if ($regid <= 0 || $no <= 0 || empty($ft)) {
    die("Invalid input parameters");
}

// Use prepared statement to prevent SQL injection
$stmt = mysqli_prepare($con, "SELECT * FROM repayments WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("No record found");
}

$row = mysqli_fetch_array($result);

// Extract user data
$id = $row['id'];
$loc = $row['Location'];
$fn = $row['Firstname'];
$full = $row['Firstname']." ". $row['Middlename']." ". $row['Lastname'];
$fullx = $row['Firstname']." ".$row['Lastname'];
$ln = $row['Lastname'];
$mn = $row['Middlename'];
$bv = $row['BVN'];
$ph = $row['Phone'];
$dis = $row['Disbursement_No'];
$prid = $row['Product_id'];
$loan = $row['Loan_Account_No'];
$tr = $row['Transaction_id'];
$sa = $row['Savings_Account_No'];
$tn = $row['Duration'];
$rt = $row['Rate'];
$la = $row['Loan_Amount'];
$ss = $row['Status'];
$int_amt = $row['Interest_Amt'];
$re_amt = $row['Expected_Amount'];
$ttl = $row['Total_Loan'];

// Get product information using prepared statement
$stmt = mysqli_prepare($con, "SELECT * FROM product_list WHERE Product_id = ?");
mysqli_stmt_bind_param($stmt, "s", $prid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Product id not found. please update the product ");
}

$row = mysqli_fetch_array($result);
$rt = $row['Rate'];
$tn = $row['Tenure'];
$fr = $row['Frequency'];

// Initialize holidays array
$holidays = [];

// Fetch holiday dates from database
$query = "SELECT Holiday_Date FROM holidays";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $holidays[] = $row['Holiday_Date'];
    }
}

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
<div id="table-container" style="height:330px;">
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
    $startdate = strtotime($ft);
    $businessDaysAdded = 0;
    $currentDate = date('Y-m-d', $startdate);
    
    // Loop until we have the exact number of business days
    while($businessDaysAdded < $no) {
        // Check if current date is a business day
        if(!isWeekend($currentDate) && !isHoliday($currentDate, $holidays)) {
            $days = date("D", strtotime($currentDate));
            $daily_interest = $int_amt / $tn;
?>
<tr>
<input type="hidden" name="id[]" class="form-control" value="<?php echo htmlspecialchars($id);?>" required="required">
<input type="hidden" name="reg[]" class="form-control" value="<?php echo htmlspecialchars($regid);?>" required="required">
<input type="hidden" name="bv[]" class="form-control" value="<?php echo htmlspecialchars($bv);?>" required="required">
<input type="hidden" name="dis[]" class="form-control" value="<?php echo htmlspecialchars($dis);?>" required="required">
<input type="hidden" name="loan[]" class="form-control" value="<?php echo htmlspecialchars($loan);?>" required="required">
<input type="hidden" name="tr[]" class="form-control" value="<?php echo htmlspecialchars($tr);?>" required="required">
<input type="hidden" name="sa[]" class="form-control" value="<?php echo htmlspecialchars($sa);?>" required="required">
<input type="hidden" name="full[]" class="form-control" value="<?php echo htmlspecialchars($full);?>" required="required">
<input type="hidden" name="la[]" class="form-control" value="<?php echo htmlspecialchars($la);?>" required="required">
<input type="hidden" name="tt[]" class="form-control" value="<?php echo htmlspecialchars($ttl);?>" required="required">
<input type="hidden" name="pt[]" class="form-control" value="Daily" required="required">
<input type="hidden" name="re_amt[]" class="form-control" value="<?php echo htmlspecialchars($re_amt);?>" required="required">
<input type="hidden" name="fn[]" class="form-control" value="<?php echo htmlspecialchars($fn);?>" required="required">
<input type="hidden" name="mn[]" class="form-control" value="<?php echo htmlspecialchars($mn);?>" required="required">
<input type="hidden" name="ln[]" class="form-control" value="<?php echo htmlspecialchars($ln);?>" required="required">
<input type="hidden" name="ph[]" class="form-control" value="<?php echo htmlspecialchars($ph);?>" required="required">
<input type="hidden" name="int_amt[]" class="form-control" value="<?php echo htmlspecialchars($daily_interest);?>" required="required">
<input type="hidden" name="cnts[]" class="form-control" value="<?php echo htmlspecialchars($tn);?>" required="required">
<input type="hidden" name="exp_date[]" class="form-control" value="<?php echo $currentDate; ?>" required="required">
<input type="hidden" name="day[]" class="form-control" value="Daily" required="required">
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($daily_interest,2); ?></td>
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
    $increment = 1;
    $startdate = strtotime($ft);
    
    // Fixed: Changed <= to < to generate correct number of rows
    for ($week = 0; $week < $no; $week += $increment) {
        $scheduledDate = date('Y-m-d', strtotime("+$week weeks", $startdate));
        
        // If scheduled date falls on weekend or holiday, move to next business day
        if(isWeekend($scheduledDate) || isHoliday($scheduledDate, $holidays)) {
            $scheduledDate = getNextBusinessDay($scheduledDate, $holidays);
        }
        
        $days = date("D", strtotime($scheduledDate));
?>
<tr>
<input type="hidden" name="id[]" class="form-control" value="<?php echo htmlspecialchars($id);?>" required="required">
<input type="hidden" name="reg[]" class="form-control" value="<?php echo htmlspecialchars($regid);?>" required="required">
<input type="hidden" name="bv[]" class="form-control" value="<?php echo htmlspecialchars($bv);?>" required="required">
<input type="hidden" name="dis[]" class="form-control" value="<?php echo htmlspecialchars($dis);?>" required="required">
<input type="hidden" name="loan[]" class="form-control" value="<?php echo htmlspecialchars($loan);?>" required="required">
<input type="hidden" name="tr[]" class="form-control" value="<?php echo htmlspecialchars($tr);?>" required="required">
<input type="hidden" name="sa[]" class="form-control" value="<?php echo htmlspecialchars($sa);?>" required="required">
<input type="hidden" name="full[]" class="form-control" value="<?php echo htmlspecialchars($full);?>" required="required">
<input type="hidden" name="la[]" class="form-control" value="<?php echo htmlspecialchars($la);?>" required="required">
<input type="hidden" name="tt[]" class="form-control" value="<?php echo htmlspecialchars($ttl);?>" required="required">
<input type="hidden" name="pt[]" class="form-control" value="Weekly" required="required">
<input type="hidden" name="re_amt[]" class="form-control" value="<?php echo htmlspecialchars($re_amt);?>" required="required">
<input type="hidden" name="fn[]" class="form-control" value="<?php echo htmlspecialchars($fn);?>" required="required">
<input type="hidden" name="mn[]" class="form-control" value="<?php echo htmlspecialchars($mn);?>" required="required">
<input type="hidden" name="ln[]" class="form-control" value="<?php echo htmlspecialchars($ln);?>" required="required">
<input type="hidden" name="ph[]" class="form-control" value="<?php echo htmlspecialchars($ph);?>" required="required">
<input type="hidden" name="int_amt[]" class="form-control" value="<?php echo htmlspecialchars($int_amt);?>" required="required">
<input type="hidden" name="exp_date[]" class="form-control" value="<?php echo $scheduledDate;?>" required="required">
<input type="hidden" name="day[]" class="form-control" value="<?php echo $days; ?>" required="required">
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
    $increment = 1;
    $startdate = strtotime($ft);
    
    // Fixed: Changed <= to < to generate correct number of rows
    for ($month = 0; $month < $no; $month += $increment) {
        $scheduledDate = date('Y-m-d', strtotime("+$month months", $startdate));
        
        // If scheduled date falls on weekend or holiday, move to next business day
        if(isWeekend($scheduledDate) || isHoliday($scheduledDate, $holidays)) {
            $scheduledDate = getNextBusinessDay($scheduledDate, $holidays);
        }
        
        $days = date("D", strtotime($scheduledDate));
?>
<tr>
<input type="hidden" name="id[]" class="form-control" value="<?php echo htmlspecialchars($id);?>" required="required">
<input type="hidden" name="reg[]" class="form-control" value="<?php echo htmlspecialchars($regid);?>" required="required">
<input type="hidden" name="bv[]" class="form-control" value="<?php echo htmlspecialchars($bv);?>" required="required">
<input type="hidden" name="dis[]" class="form-control" value="<?php echo htmlspecialchars($dis);?>" required="required">
<input type="hidden" name="loan[]" class="form-control" value="<?php echo htmlspecialchars($loan);?>" required="required">
<input type="hidden" name="tr[]" class="form-control" value="<?php echo htmlspecialchars($tr);?>" required="required">
<input type="hidden" name="sa[]" class="form-control" value="<?php echo htmlspecialchars($sa);?>" required="required">
<input type="hidden" name="full[]" class="form-control" value="<?php echo htmlspecialchars($full);?>" required="required">
<input type="hidden" name="la[]" class="form-control" value="<?php echo htmlspecialchars($la);?>" required="required">
<input type="hidden" name="tt[]" class="form-control" value="<?php echo htmlspecialchars($ttl);?>" required="required">
<input type="hidden" name="pt[]" class="form-control" value="Monthly" required="required">
<input type="hidden" name="re_amt[]" class="form-control" value="<?php echo htmlspecialchars($re_amt);?>" required="required">
<input type="hidden" name="fn[]" class="form-control" value="<?php echo htmlspecialchars($fn);?>" required="required">
<input type="hidden" name="mn[]" class="form-control" value="<?php echo htmlspecialchars($mn);?>" required="required">
<input type="hidden" name="ln[]" class="form-control" value="<?php echo htmlspecialchars($ln);?>" required="required">
<input type="hidden" name="ph[]" class="form-control" value="<?php echo htmlspecialchars($ph);?>" required="required">
<input type="hidden" name="int_amt[]" class="form-control" value="<?php echo htmlspecialchars($int_amt);?>" required="required">
<input type="hidden" name="exp_date[]" class="form-control" value="<?php echo $scheduledDate;?>" required="required">
<input type="hidden" name="day[]" class="form-control" value="<?php echo $days; ?>" required="required">
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

<button type="submit" class="btn btn-outline-success btn-sm" onclick="data()" id="save">Proceed</button>

</form>

<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to reschedule this customer repayment plan";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "update_schedule.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
alert(data);
}else{
setTimeout(function(){
$("#please").hide();
$("#toast").show();
loads();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
loadAgain();
}, 6000);
}
},
error: function(){
alert("An error occurred. Please try again.");
}
});
}
}));
});
</script>


<script type="text/javascript">
function loadAgain()  {
$.ajax({
method: "POST",
url: "sch_load.php?id=<?php echo $regid; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#heylist').html(data);
}, 100);
}
});
}
</script> 


<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "check_loan.php?loan=<?php echo $loan; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 100);
}
});
}
</script> 

<?php
mysqli_close($con);
?>