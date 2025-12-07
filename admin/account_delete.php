<?php
//if the add button has been clicked
include('../config/db.php') ;
$user_id = $_POST['id']; // user id
// deleting account info
$Query = "DELETE FROM users WHERE id = '$user_id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
} else {
echo("Error description: " . mysqli_error($con));
}
?>