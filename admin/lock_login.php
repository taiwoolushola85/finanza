<?php
session_start();
include '../config/db.php';
$pass = $_POST['pass'] ?? '';
$id = $_POST['id'] ?? '';
$us = $_POST['us'] ?? '';
$bck = $_POST['bck'] ?? '';
if (empty($pass)) {
echo 1; // password empty
exit;
}
// Fetch the user securely
$stmt = mysqli_prepare($con, "SELECT * FROM users WHERE Username = ? AND id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "si", $us, $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
// Verify password
if (!password_verify($pass, $row['Password'])) {
echo 6; // invalid password
exit;
}
// Check account status
if ($row['Status'] === 'Deactivated') {
echo 4; // account deactivated
exit;
}
// Login successful, set session
$_SESSION["Username"] = $row['Username'];
$_SESSION["Name"] = $row['Name'];
$_SESSION['login_time'] = time();
// Redirect or echo resume location
echo htmlspecialchars($bck);
} else {
echo 6; // user not found
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
