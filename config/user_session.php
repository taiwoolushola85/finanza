<?php
include 'db.php';
session_start();
if (isset($_SESSION['Username'])) {
$user = $_SESSION['Username'];
$Query = "SELECT * FROM users WHERE Username='$user'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$usd_id = $row['id'];
$User = $row['Username'];
$loc = $row['Location'];
$na = $row['Name'];
$psw = $row['Password'];
$em = $row['Email'];
$brss = $row['Branch'];
$brss_id = $row['Branch_id'];
$user_id = $row['id'];
$gr = $row['User_Group'];
$us_ty = $row['Usertype'];
$pho = $row['Phone'];
$ct = $row['Role_Categorys'];
$map = $row['Mapped'];
$zone = $row['Zone'];
$zone_id = $row['Zone_id'];
$country = $row['Country'];
}
// getting team leader infor

?>