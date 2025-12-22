<?php 
include '../config/db.php';
include '../config/user_session.php';
$id = $_POST['id'];// repayment id
$due = $_POST['due'];// new due date
$fr = $_POST['fr'];// frequency
$ten = $_POST['ten'];// tenure
$reason = $_POST['reason'];// reason
$detail = $_POST['detail'];// additional details
$d = date('Y-m-d');
$s = date('h:m:sa');

// inserting the customer information
$sql = "UPDATE repayments SET Maturity_Date = '$due', Maturity_Status = 'Runing' WHERE id = '$id'";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
// inserting request
$sql = "INSERT INTO extension (Rep_No, Frequency, Duration, Due_Date, Reason, Detail, Status, Date_Sent, Time_Sent, Sent_By) 
VALUES ('$id', '$fr', '$ten', '$due', '$reason', '$detail', 'Approved', '$d', '$s', '$na')";
$result= mysqli_query($con, $sql);
}else{
echo("Error description: " . mysqli_error($con));
}

?>