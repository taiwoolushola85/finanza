<?php
include('../config/db.php');
$data[] = array('Name','Total');
$Query = "SELECT id, Name, (SELECT COALESCE(COUNT(*), 0) FROM users WHERE Branch = branch.Name) AS onb FROM branch ORDER BY Name";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
$records = $rows['onb'];
$pr = $rows['Name'];
$data[] = array($pr,(int)$records);
}
}
///$data = array($data);			
echo json_encode($data);
?>