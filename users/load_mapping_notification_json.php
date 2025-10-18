<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Officer_Name, Team_Name, Branch, Date_Mapped FROM mapping ORDER BY id DESC LIMIT 1") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/mapping_notification_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<?php
$url = '../data/mapping_notification_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<i class="fa fa-bell"></i> <b style="color:red;">Notification: </b><i> You just mapped <?php echo $member->Officer_Name?> to <?php echo $member->Team_Name?> in <?php echo $member->Branch?> 
on <?php echo $member->Date_Mapped?> </i>
<?php
}
?>
