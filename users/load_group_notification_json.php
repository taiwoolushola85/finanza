<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
include '../config/user_session.php';
$d = date('Y-m-d');
$result = mysqli_query($con, "SELECT id, Name, Date_Register FROM groups ORDER BY id DESC LIMIT 1") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/group_notification_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<?php
$url = '../data/group_notification_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<i class="fa fa-bell"></i> <b style="color:red;">Notification: </b><i> Your last group created is [ <?php echo $member->Name?> ] on <?php echo $member->Date_Register?> </i>
<?php
}
?>
