<?php
include '../config/db.php';
// Check if the request is POST and usdid exists
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usdid'])) {
$usdid = mysqli_real_escape_string($con, $_POST['usdid']);
// Use prepared statement to prevent SQL injection
$stmt = mysqli_prepare($con, "SELECT id, Firstname, Middlename, Lastname, Paid, Total_Bal, Product, Expected_Amount, Location FROM repayments WHERE id = ?");
mysqli_stmt_bind_param($stmt, "s", $usdid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);
if ($row) {
$id = $row['id'];
$fullname = $row['Firstname'] . " " . $row['Middlename'] . " " . $row['Lastname'];
$paid = number_format($row['Paid'],2);
$bal = number_format($row['Total_Bal'],2);
$bals = $row['Total_Bal'];
$pr = $row['Product'];
$exp = number_format($row['Expected_Amount'],2);
$loc = $row['Location'];
header('Content-Type: application/json');
echo json_encode(["repId" => $id, "repPaid" => $paid, "repName" => $fullname, "repBal" => $bal, "repBals" => $bals, "repProduct" => $pr, "repExpected" => $exp,
"repImg" => $loc]);
} else {
header('Content-Type: application/json');
echo json_encode(["error" => "No record found"]);
}
mysqli_stmt_close($stmt);
} else {
header('Content-Type: application/json');
echo json_encode(["error" => "Invalid request"]);
}
mysqli_close($con);
?>