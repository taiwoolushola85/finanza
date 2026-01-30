<?php
header('Content-Type: application/json'); // Crucial for jQuery to read data
include '../config/db.php';
include '../config/user_session.php';

$bvn = isset($_POST['bvn']) ? mysqli_real_escape_string($con, $_POST['bvn']) : '';

if (empty($bvn)) {
echo json_encode(['status' => 'error', 'message' => 'BVN is required']);
exit();
}

// 1. Check for Active Loans
$stmt1 = mysqli_prepare($con, "SELECT id FROM repayments WHERE BVN = ? AND Status = 'Active' LIMIT 1");
mysqli_stmt_bind_param($stmt1, "s", $bvn);
mysqli_stmt_execute($stmt1);
if (mysqli_stmt_get_result($stmt1)->num_rows > 0) {
echo json_encode(['status' => '1']); // Running active loan
exit();
}

// 2. Check for Pending/Review Registrations AND Fetch Data
// We combine these to save a database trip.
$query = "SELECT id, Firstname, Middlename, Lastname, Location, Status FROM register WHERE BVN = ? LIMIT 1";
$stmt2 = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt2, "s", $bvn);
mysqli_stmt_execute($stmt2);
$res2 = mysqli_stmt_get_result($stmt2);
$customer = mysqli_fetch_assoc($res2);

if ($customer) {
// Check if the current status is a "Pending" type status
$pendingStatuses = ['Disbursed', 'Cancelled', 'Loan Closed'];
if (!in_array($customer['Status'], $pendingStatuses)) {
echo json_encode(['status' => '2']); // Application already in review
exit();
}

// 3. SUCCESS: If we reach here, customer exists and is eligible for a new loan
echo json_encode([
'status' => 'success',
'full_name' => $customer['Firstname'] . ' ' . $customer['Middlename'] . ' ' . $customer['Lastname'],
'customer_img' => $customer['Location'],
'customer_id' => $customer['id']
]);
} else {
echo json_encode(['status' => 'new', 'message' => 'No record found']);
}
?>