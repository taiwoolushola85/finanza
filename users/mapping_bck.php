<?php
//if the add button has been clicked
include('../config/db.php') ;
$tm = $_POST['tm'];// team id
$la = $_POST['la'];// officer id
// selecting loan officer info
$Query = "SELECT * FROM users WHERE id = '$la' AND User_Group = 'Loan Officers'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$off_id = $row['id'];
$bra = $row['Branch'];
$usg = $row['User_Group'];
$na = $row['Name'];
$us = $row['Username'];
$br_ids = $row['Branch_id'];
// selecting team leader info
$Query = "SELECT * FROM users WHERE id = '$tm' AND User_Group = 'Team Leaders'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$tm_id = $row['id'];
$tna = $row['Name'];
$uss = $row['Username'];
//Checkin if the branch already exist
$Query= "SELECT * FROM mapping WHERE Officer_id = '$la' AND Team_id = '$tm'";
$result= mysqli_query($con, $Query);
$Counter = mysqli_num_rows($result);
if ($Counter > 0){
echo 1;
}else{
$d = date('Y-m-d');
// inserting user info for mapping
$Query = "INSERT INTO mapping (Loan_Officer, Team_Leader, Officer_Name, Team_Name, Branch, Branch_id, Date_Mapped, Status, Officer_id, Team_id, Target) 
VALUES ('$us', '$uss', '$na', '$tna', '$bra', '$br_ids', '$d', 'Mapped', '$off_id', '$tm_id', '0')";
$result= mysqli_query($con, $Query);
// updating user mapping status
$Query = "UPDATE users SET Mapped = 'Mapped' WHERE id ='$off_id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
}
mysqli_close($con);
?>