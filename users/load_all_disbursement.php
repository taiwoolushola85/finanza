<?php
// CORS headers MUST come before ANY output
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include '../config/db.php';
include '../config/user_session.php';

$d = date('Y-m-d');

// FIXED: Properly parameterized query (was still vulnerable with $User)
$stmt = $con->prepare("SELECT id, Firstname, Middlename, Loan_Amount, Status, Date_Disbursed, Time_Disbursed FROM repayments ORDER BY id DESC LIMIT 10");
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
<marquee direction="up" scrolldelay="300" style="margin-top:0px; height:190px">
<?php
// If no data
if (empty($results)) {
echo "<div>No latest disbursement</div>";
} else {
// Write JSON (if required)
file_put_contents('../data/recent_disbursement.json', json_encode($results));
  
// OUTPUT THE MARQUEE ITEMS
foreach ($results as $member):
?>
<p>
<strong class="text-body">Disbursement:</strong>
<a href="#!" class="text-body fw-medium">
<?= htmlspecialchars($member['Firstname'] . " " . $member['Middlename']) ?><br>
</a>has been successfully recieved [ <?= number_format($member['Loan_Amount'], 2) ?> ]<br>
<span class="badge badge-label-info"><?= htmlspecialchars($member['Status']) ?></span><br>
<span class="rich-list-subtitle mb-2">
<?= htmlspecialchars($member['Date_Disbursed']) ?> · 
<a href="#!"><?= htmlspecialchars($member['Time_Disbursed']) ?></a>
</span>
</p>
<?php 
endforeach;
}
?>
</marquee>