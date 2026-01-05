<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT Username, Name, Branch,
(SELECT COALESCE(SUM(Total_Bal), 0) FROM repayments WHERE Recovery_Username = Username) AS `por`,
(SELECT COALESCE(SUM(Amount), 0) FROM recover WHERE User = Username AND Status = 'Paid') AS `rep`
FROM users WHERE User_Group = 'Recovery' ORDER BY Name ASC") or die("Bad Query.");
mysqli_close($con);
$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/credit_officer.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div id="table-container" style="overflow-y:auto; height:130px">
<table>
<thead>
<tr>
<th style="font-size:9px;">Name</th>
<th style="font-size:9px;">Branch</th>
<th style="font-size:9px;">Portfolio</th>
<th style="font-size:9px;">Recovered</th>
</tr>
</thead>
<tbody>
<?php
$url = '../data/credit_officer.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td style="font-size:9px;"><?php echo $member->Name?></td>
<td style="font-size:9px;"><?php echo $member->Branch?></td>
<td style="font-size:9px;"><?php echo number_format($member->por,2)?></td>
<td style="font-size:9px;"><?php echo number_format($member->rep,2)?></td>
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
url: 'recovery_transaction_list.php',
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
url: "recovery_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#list').html(data);
}, 1000);
}
});
}
</script> 