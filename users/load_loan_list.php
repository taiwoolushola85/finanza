<?php 
$bvn = $_GET['bvn'];
include '../config/db.php';
$Query = "SELECT * FROM repayments WHERE BVN = '$bvn'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row == 0){
echo "<i>🚫 Record Not Found..!!</i>";
exit();
}else{
?>

<div class="row">
<div class="col-sm-3">
<small><b>Total Closed Acct:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$bvn' AND Status ='Closed'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-3">
<small><b>Total Active Acct:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$bvn' AND Status ='Active'");
$row = mysqli_fetch_array($result);
$totalbal = $row[0];
echo $totalbal;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-3">
<small><b>Total Loan Cycle:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$bvn'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
</div>
<br>

<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$result = mysqli_query($con, "SELECT id, Reg_id, Loan_Account_No, BVN, Paid, Savings_Account_No, Firstname, Middlename, Lastname, Product, 
Status, Total_Loan, Total_Bal, Date_Disbursed, Date_Closed FROM repayments WHERE BVN = '$bvn' ORDER BY id ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/data_record.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-responsive" style="overflow-y:auto; height:200px">
<table>
<thead>
<tr>
<th style="font-size:8px;">LOAN ACCT</th>
<th style="font-size:8px;">SAVING ACCT</th>
<th style="font-size:8px;">BVN</th>
<th style="font-size:8px;">NAME</th>
<th style="font-size:8px;">PRODUCT</th>
<th style="font-size:8px;">LOAN AMT </th>
<th style="font-size:8px;">PAID AMT </th>
<th style="font-size:8px;">OUTSTANDING </th>
<th style="font-size:8px;">STATUS</th>
<th style="font-size:8px;">DATE DISBURSED</th>
<th style="font-size:8px;">DATE CLOSED</th>
<th style="font-size:8px;">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/data_record.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td style="font-size:8px;"><?php echo $member->Loan_Account_No?></td>
<td style="font-size:8px;"><?php echo $member->Savings_Account_No?></td>
<td style="font-size:8px;"><?php echo $member->BVN?></td>
<td style="font-size:8px;"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
<td style="font-size:8px;"><?php echo $member->Product?></td>
<td style="font-size:8px;"><?php echo number_format($member->Total_Loan,2)?></td>
<td style="font-size:8px;"><?php echo number_format($member->Paid,2)?></td>
<td style="font-size:8px;"><?php echo number_format($member->Total_Bal,2)?></td>
<td style="font-size:8px;"><?php echo $member->Status?></td>
<td style="font-size:8px;"><?php echo date("d-M-Y", strtotime($member->Date_Disbursed))?></td>
<td style="font-size:8px;"><?php 
if($member->Status == 'Active'){
echo "Still Runing";
}else{
echo date("d-M-Y", strtotime($member->Date_Closed));
}
?></td>
<td style="font-size:8px;"><a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" id="<?php echo $member->id?>" style="font-size:9px;">
+  Manage Account</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
<?php
}
?>

</div>
</div>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.invks').on('click', function() {
$("#updateModal").modal('hide');
$("#please").show();
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'manage_data_profiles.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
setTimeout(function(){
$("#please").hide();
$("#updateModal").modal('show');
$('#profile').html(data);
}, 3000);
}
});
}else{
alert ("🚫" + data)
}
});
});
</script>


<script type="text/javascript">
function load()  {
// ajax function start here to load table data
$.ajax({
method: "GET",
url: "load_loan_list.php?bvn=" + <?php echo $bvn; ?>,
dataType: "html",
success:function(data){
$("#result").html(data);
}
});
}
</script> 