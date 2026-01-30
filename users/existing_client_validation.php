<?php
include '../config/db.php';
include '../config/user_session.php';
$bv = $_POST['bv'] ?? '';
// Check if client exists
$query = "SELECT id, Firstname, Middlename, Lastname, Location FROM register WHERE BVN = '$bv' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$fn = $row['Firstname'];
$mn = $row['Middlename'];
$ln = $row['Lastname'];
$lo = $row['Location'];
$full = trim($fn . ' ' . $mn . ' ' . $ln);
echo json_encode(["fullName" => $full, "regID" => $id,"userImg"  => $lo]);
} else {
echo json_encode(["error" => "User not found"]);
}
mysqli_close($con);
?>
