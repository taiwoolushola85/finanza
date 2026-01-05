<small><b>Total Credit Officer's:
<?php 
include '../config/db.php';
include '../config/user_session.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM mapping WHERE Team_Leader = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?></b>
<br><br>
</small>

<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$result = mysqli_query($con, "SELECT Officer_Name, Loan_Officer, Branch,
(SELECT COALESCE(SUM(Amount), 0) FROM flexi_history WHERE User = Loan_Officer AND Status = 'Waiting For Approval' AND Posting_Method = 'Basic Posting') AS `rep`,
(SELECT COALESCE(SUM(Savings), 0) FROM save WHERE User = Loan_Officer AND Status = 'Waiting For Approval' AND Posting_Method = 'Basic Posting') AS `saving`,
(SELECT Location FROM users WHERE Username = Loan_Officer) AS `img`
FROM mapping WHERE Team_Leader = '$User' ORDER BY Officer_Name ASC") or die("Bad Query.");
mysqli_close($con);
$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/flexi_credit_officer.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div id="table-container" style="overflow-y:auto; height:330px">
<table>
<thead>
<tr>
<th style="font-size:9px;">Name</th>
<th style="font-size:9px;">Branch</th>
<th style="font-size:9px;">Repayments</th>
<th style="font-size:9px;">Savings</th>
<th style="font-size:9px;">Total</th>
<th style="font-size:9px;">Action</th>
</tr>
</thead>
<tbody>
<?php
$url = '../data/flexi_credit_officer.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td style="font-size:9px;"><?php echo $member->Officer_Name?></td>
<td style="font-size:9px;"><?php echo $member->Branch?></td>
<td style="font-size:9px;"><?php echo number_format($member->rep,2)?></td>
<td style="font-size:9px;"><?php echo number_format($member->saving,2)?></td>
<td style="font-size:9px;"><?php echo number_format($member->rep +  $member->saving,2)?></td>
<td>
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $member->Loan_Officer; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>





<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").hide();
$("#view").show();
var id = $(this).data('id');// username
if(id) {
$.ajax({
url: 'flexi_transaction_list.php',
type: "GET",
data: {'id': id},// username
success: function(data) { 
setTimeout(function() {
$("#updateModal").show();
$("#view").hide();
$('#result').html(data);
}, 1000);
},
error: function(xhr, status, error) {
alert('Error loading transaction: ' + error);
$("#view").hide();
}
});
} else {
alert('Invalid ID');
$("#view").hide();
}
});
});
</script>


<script type="text/javascript">
function load()  {
$.ajax({
method: "POST",
url: "team_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#list').html(data);
}, 1000);
}
});
}
</script> 