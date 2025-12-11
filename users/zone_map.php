<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['sf'];// user id
$br = $_POST['br'];// branch id
// selecting loan officer info
$Query = "SELECT * FROM users WHERE id ='$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$off_id = $row['id'];
$bra = $row['Branch'];
$usg = $row['User_Group'];
$na = $row['Name'];
$us = $row['Username'];
//Checkin if the branch already exist
$Query= "SELECT * FROM zone_mapping WHERE Usernames = '$us' AND Branches_id = '$br'";
$result= mysqli_query($con, $Query);
$Counter = mysqli_num_rows($result);
if ($Counter > 0){
echo 1;
}else{

// branch info
$Query = "SELECT * FROM branch WHERE id='$br'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$br_id = $row['id'];
$b = $row['Name'];
$zns = $row['Zone'];
$znids = $row['Zone_id'];
$cnts = $row['Country'];
$d = date('Y-m-d');
$s = date('h:m:sa');
// inserting user info for mapping
$Query = "INSERT INTO zone_mapping (Staff_Name, User_Role, Usernames, Staff_id, Branches, Branches_id, Zones, Zones_id, Countrys, Date_Mapped, Time_Mapped, Status) 
VALUES ('$na', '$usg', '$us', '$off_id', '$b', '$br_id', '$zns', '$znids', '$cnts', '$d', '$s', 'Mapped')";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>