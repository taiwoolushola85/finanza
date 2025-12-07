<?php
// CORS headers MUST come before ANY output
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include '../config/db.php';
include '../config/user_session.php';

$d = date('Y-m-d');

// FIXED: Properly parameterized query (was still vulnerable with $User)
$stmt = $con->prepare("SELECT id, Firstname, Middlename, Amount, Status, Date_Paid, Time_Paid FROM history WHERE User = ? AND Date_Paid = ? ORDER BY id DESC LIMIT 20");
$stmt->bind_param("ss", $User, $d);
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
<marquee direction="up" scrolldelay="300" style="margin-top:0px; height:51px">
<?php
// If no data
if (empty($results)) {
echo "<div>No Repayment History</div>";
} else {
// Write JSON (if required)
file_put_contents('../data/recent_transaction.json', json_encode($results));
  
// OUTPUT THE MARQUEE ITEMS
foreach ($results as $member):
?>
<p>
<strong class="text-body">Payment:</strong>
<a href="#!" class="text-body fw-medium">
<?= htmlspecialchars($member['Firstname'] . " " . $member['Middlename']) ?><br>
</a>has been successfully paid [ <?= number_format($member['Amount'], 2) ?> ]<br>
<span class="badge badge-label-info"><?= htmlspecialchars($member['Status']) ?></span><br>
<span class="rich-list-subtitle mb-2">
<?= htmlspecialchars($member['Date_Paid']) ?> · 
<a href="#!"><?= htmlspecialchars($member['Time_Paid']) ?></a>
</span>
</p>
<?php 
endforeach;
}
?>
</marquee>