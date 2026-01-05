<?php
$bvn = $_GET['bvn'];// bvn number
?>
</div>
<small><b>Total Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE BVN = '$bvn'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?></b>
</small>
</div>
<br><br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';

$result = mysqli_query($con, "SELECT id, BVN, Firstname, Middlename, Lastname, Phone, Branch, Gender, Officer_Name, Date_Reg, Status FROM register
WHERE BVN = '$bvn' ORDER BY id ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/all_client.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div style="overflow-y:auto; height:350px">
<table>
<thead>
<tr style="font-size:8px">
<th >BVN NO</th>
<th >NAME</th> 
<th >PHONE NO</th>
<th >BRANCH</th>
<th >GENDER</th>
<th >LOAN OFFICER</th>
<th >STATUS</th>
<th >DATE REG</th>
<th >ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/all_client.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:8px">
<td><?php echo $member->BVN?></td>
<td style="text-transform:uppercase"><?php echo $member->Firstname." ". $member->Middlename." ".$member->Lastname?></td>
<td><?php echo $member->Phone?></td>
<td><?php echo $member->Branch?></td>
<td><?php echo $member->Gender?></td>
<td><?php echo $member->Officer_Name?></td>
<td><?php echo $member->Status?></td>
<td ><?php echo date("d-M-Y", strtotime($member->Date_Reg))?></td>
<td style="font-size:8px;"><a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $member->id?>" style="font-size:9px;">
+  Manage Account</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>



<script>
// Modal data loading
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").modal('hide');
$("#please").show();
var id = $(this).data('id');
if (id) {
$.ajax({
url: 'manager_profile.php',
type: "GET",
data: {'id': id},
success: function(data) { 
setTimeout(function() {
$("#updateModal").modal('show');
$("#please").hide();
$('#profile').html(data);
}, 1000);
},
error: function(xhr, status, error) {
alert('Error loading profile: ' + error);
$("#please").hide();
}
});
} else {
alert('Invalid ID');
$("#please").hide();
}
});
});
</script>



<script type="text/javascript">
function loads() {
$.ajax({
method: "GET",
url: "search_client.php?bvn=" + <?php echo $bvn; ?>,
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 