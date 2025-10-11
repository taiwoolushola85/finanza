<?php
// restricting access
include_once '../config/db.php';
$rowCount = count($_POST["id"]);
for($i=0;$i<$rowCount;$i++) {
$sql =  "DELETE FROM control WHERE id='" . $_POST["id"][$i] . "'";
$result = mysqli_query($con, $sql);
}
?>