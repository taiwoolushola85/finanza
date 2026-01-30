<?php
session_start();
include './config/db.php';

/* ===============================
INPUT VALIDATION
================================ */
$user = trim($_POST['user'] ?? '');
$pass = $_POST['pass'] ?? '';

if ($user === '' && $pass === '') { echo 1; exit; }
elseif ($user === '') { echo 2; exit; }
elseif ($pass === '') { echo 3; exit; }

/* ===============================
FETCH USER
================================ */
$stmt = mysqli_prepare(
    $con,
    "SELECT id, Name, Usertype, Status, Checks, Username, Password 
     FROM users 
     WHERE Username = ? 
     LIMIT 1"
);
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$row = mysqli_fetch_assoc($result)) {
    echo 6; // user not found
    exit;
}

/* ===============================
CHECK IF DEACTIVATED
================================ */
if ($row['Status'] === 'Deactivated') {
    echo 4;
    exit;
}

/* ===============================
PASSWORD VERIFY
================================ */
if (!password_verify($pass, $row['Password'])) {
    echo 6; // invalid credentials
    exit;
}

/* ===============================
SESSION SECURITY
================================ */
session_regenerate_id(true);
$_SESSION["id"] = $row['id'];
$_SESSION["Username"] = $row['Username'];
$_SESSION["Name"] = $row['Name'];
$_SESSION["Usertype"] = $row['Usertype'];
$_SESSION['login_time'] = time();

/* ===============================
ACCESS LOGIC
================================ */
if ($row['Checks'] == 1) {
    echo "authentication.php";
} elseif ($row['Usertype'] === 'Admin') {
    echo "./admin/index.php";
} elseif ($row['Usertype'] === 'User') {
    echo "./users/home.php";
} else {
    echo 5;
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
