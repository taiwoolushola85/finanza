<?php
// CORS headers MUST come before ANY output
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include '../config/db.php';
include '../config/user_session.php';

$d = date('Y-m-d');

// FIXED: Properly parameterized query (was still vulnerable with $User)
$stmt = $con->prepare("SELECT id, Image, craccountname, amount FROM nip_notifications
WHERE Status = 'Waiting For Approval' ORDER BY id DESC LIMIT 100");
$stmt->execute();
$result = $stmt->get_result();

// Convert to array
$results = [];
while ($row = $result->fetch_assoc()) {
$results[] = $row;
}

$stmt->close();
$con->close();

// Output starts here
?>
<marquee direction="left" scrolldelay="300">
<?php
// If no data
if (empty($results)) {
echo "<div>No notification payment yet </div>";
} else {
// Write JSON (if required)
file_put_contents('../data/recent_notofication.json', json_encode($results));
  
// OUTPUT THE MARQUEE ITEMS
foreach ($results as $member):
?>

<i class="fa fa-user" style="font-size:20px; height:30px; width:35px; border-radius:50px; margin:10px"></i>
<?php echo $member['craccountname']; ?> just paid <?php echo number_format($member['amount'],2); ?>
<?php 
endforeach;
}
?>
</marquee>