
<div style="display:none;">
<?php
$mnth = $_POST['mnth'];// months
?>
</div>
<small><b>Total Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM register WHERE Birthday_Month like '%$mnth%' ");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?></b>
<br><br>
</small>
<div style="overflow-y:auto;">
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';

$result = mysqli_query($con, "SELECT DISTINCT id, Firstname, Middlename, Lastname, Gender, Phone, Branch, Years, Location, Birthday_Month FROM register 
WHERE Birthday_Month = '$mnth' ORDER BY Years ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/birthdaylist.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div id="table-container" style="height:350px;">
<table>
<thead>
<tr style="font-size:10px;">
<th class="sort border-top border-translucent ps-3">Image</th>
<th class="sort border-top">Name</th>
<th class="sort border-top">Gender</th>
<th class="sort border-top">Phone</th>
<th class="sort border-top">Branch</th>
<th class="sort border-top">Day</th>
<th class="sort border-top">Months</th>
</tr>
</thead>
<tbody>
<?php
$url = '../data/birthdaylist.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr style="font-size:10px;">
<td class="sort border-top border-translucent ps-3">
<img src=" <?php echo $member->Location?>" style="height:30px; width: 30px; border-radius:30px">
</td>
<td class="sort border-top"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
<td class="sort border-top"><?php echo $member->Gender?></td>
<td class="sort border-top"><?php echo $member->Phone?></td>
<td class="sort border-top"><?php echo $member->Branch?></td>
<td class="sort border-top"><?php echo date("d", strtotime($member->Years))?></td>
<td class="sort border-top"><?php echo $member->Birthday_Month?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
</div> 

</div>
