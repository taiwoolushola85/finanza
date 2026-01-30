<?php
// CORS headers MUST come before ANY output
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include '../config/db.php';
include '../config/user_session.php';

$d = date('Y-m-d');

// FIXED: Properly parameterized query (was still vulnerable with $User)
$stmt = $con->prepare("SELECT id, Location, Firstname, Middlename, Loan_Amount FROM repayments 
WHERE Status = 'Active' ORDER BY id DESC LIMIT 100");
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
echo "<div>No latest disbursement</div>";
} else {
// Write JSON (if required)
file_put_contents('../data/recent_disbursement.json', json_encode($results));
  
// OUTPUT THE MARQUEE ITEMS
foreach ($results as $member):
?>

<img src="<?php echo $member['Location']; ?>" style="height:30px; width:35px; border-radius:50px; margin:10px">
<?php echo $member['Firstname']; ?> recieved <?php echo number_format($member['Loan_Amount'],2); ?>
<?php 
endforeach;
}
?>
</marquee>