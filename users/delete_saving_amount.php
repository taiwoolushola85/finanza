<?php
include '../config/db.php';
$id = mysqli_real_escape_string($con, $_POST['id']);
//
$query = "DELETE FROM save WHERE id = '$id'";
$result = mysqli_query($con, $query);
if ($result) {
echo 1;
} else {
echo "Error: " . mysqli_error($con);
}
?>
