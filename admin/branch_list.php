<div>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Name, 
(SELECT COUNT(*) FROM users WHERE Branch = Name) AS `cont`,
Status FROM branch ORDER BY Name ASC LIMIT 10") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/all_branch_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>
<br>
<div class="table-reponsive">
<div class="row">
<?php
$url = '../data/all_branch_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<div class="col-4" style="margin-top: 4px; border:1px solid; font-size:10px">
<b><?php echo $member->Name?></b>
</div>
<div class="col-4" style="margin-top: 4px; border:1px solid; font-size:10px">
<?php echo $member->cont?>
</div>
<div class="col-4" style="margin-top: 4px; border:1px solid; font-size:10px">
<i style="color:green"><?php echo $member->Status?></i>
</div>

<?php
}
?>
</div>
</div>