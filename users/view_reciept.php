<?php
include '../config/db.php';
$id = $_POST['id'] ?? '';
$query = "SELECT * FROM fee WHERE id = '$id'";
$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$ids = $row['id'];
$receipt = $row['Reciept'] ?? '';
// Determine correct path for receipt
if (!empty($receipt)) {
if (strpos($receipt, '../') === 0) {
$receiptPath = $receipt;
} else {
$receiptPath = '../' . $receipt;
}
} else {
$receiptPath = '';
}
echo json_encode(["historyId" => $ids, "recieptLocation" => $receiptPath]);
} else {
echo json_encode([
"error" => "Record not found"
]);
}
mysqli_close($con);
?>
