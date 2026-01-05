<?php
include '../config/db.php';
include '../config/user_session.php';

$bvn = $_POST['bvn'] ?? '';

// ================= CHECKS FIRST =================

// 1. Check if client already exists and not disbursed
$query = "SELECT id FROM register WHERE BVN = '$bvn' AND Status != 'Disbursed' AND Application_Status = 'Registered'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
echo 1; // client exists
exit();
}

// 2. Check if customer has active loan
$query = "SELECT id FROM repayments WHERE BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
echo 2; // active loan
exit();
}

// 3. Check if BVN is blacklisted
$query = "SELECT id FROM blacklist WHERE BVN = '$bvn' AND Status = 'Approved'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
echo 3; // blacklisted
exit();
}

// 4. Check if BVN has been used as guarantor
$query = "SELECT id FROM gaurantors WHERE Gaurantor_BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
echo 4; // guarantor already used
exit();
}

// ================= FETCH CLOSED RECORD =================

$query = "SELECT id, Firstname, Middlename, Lastname, Location FROM register WHERE BVN = '$bvn' AND Status = 'Closed' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_assoc($result)) {
echo json_encode(["regId"  => $row['id'], "fName"  => $row['Firstname'], "mName"  => $row['Middlename'], "lName"  => $row['Lastname'], "imgLoc"  => $row['Location']]);
} else {
echo "Record not found in our database.";
}
?>
