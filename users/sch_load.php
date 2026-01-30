<b style="font-size:11px">
<?php 
$reg_id = $_GET['id'];// register id
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT COUNT(*) AS overs FROM schedule WHERE Regs_id = '$reg_id'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
//
?>
Total: <?php echo $over; ?>
</b>
<br><br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';

$result = mysqli_query($con, "SELECT id,Regs_id, Loan_Account_No, Loan_Amount, Interest, Amount_Paid, Expecting_Amount, Expected_Date, Status
FROM schedule WHERE Regs_id = '$reg_id' ORDER BY Expected_Date ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/schedul_load.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container" style="overflow: auto; height:300px;">
<table>
<thead>
<tr style="font-size:8px">
<th >MARK</th>
<th >REG ID</th>
<th >LOAN ACCOUNT</th>
<th >PRINCIPAL</th>
<th >INTEREST</th>
<th >REPAYMENT</th>
<th >STATUS</th>
<th >AMOUNT</th>
<th >EXPECTED DATE</th>
</tr>
<tbody>
<?php
$url = '../data/schedul_load.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td class="sort border-top"><input type="checkbox" class="emp_checkbox" name="id[]" value="<?php echo $member->id; ?>" ></td>
<td class="sort border-top"><?php echo $member->Regs_id?></td>
<td class="sort border-top"><?php echo $member->Loan_Account_No?></td>
<td class="sort border-top" ><?php echo number_format($member->Loan_Amount,2)?></td>
<td class="sort border-top"><?php echo number_format($member->Interest,2)?></td>
<td class="sort border-top"><?php echo number_format($member->Expecting_Amount,2)?></td>
<td class="sort border-top"><?php echo $member->Status?></td>
<td class="sort border-top"><?php echo number_format($member->Amount_Paid,2)?></td>
<td class="sort border-top"><?php echo $member->Expected_Date?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
<br>
<div>
<button type="button" class="btn btn-light btn-sm" id="delete"><i class="fa fa-trash"></i> Bulk Delete</button>
</div>



<script type="text/javascript">
function loadData() {
// ajax function start here to load table data
$.ajax({
method: "POST",
url: "sch_load.php?id=<?php echo $reg_id; ?>",
dataType: "html",
success:function(data){
$("#heylist").html(data);
}
});
}
</script>  





<script type="text/javascript">
$("#delete").on('click', function () {
WRN_PROFILE_DELETE = "Are you sure you want to delete record.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
var ids = [];
$(".emp_checkbox").each(function () {
if ($(this).is(":checked")) {
ids.push($(this).val());
}
});
if (ids.length) {
$("#approve").attr("disabled", true);
$("#decline").attr("disabled", true);
$.ajax({
type: 'POST',
url: 'delete_schedule.php',
data: {id: ids},
success:function (data) {
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
loadData();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);

}
});
} else {
$("#dece").hide();
alert("Please mark record to be deleted.");
}
}
});
</script>

