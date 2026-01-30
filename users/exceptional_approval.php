<?php 
include '../config/db.php';
include '../config/user_session.php';
$id = trim($_POST['id']);// reg id
$reason = str_replace( array("#", "'", ";", "/", "-", "@", "_", "$", "%", "!", "`", ":", ".", "?", ",", "'"), ' ', $_POST['reason']); // reason

//
$Query = "SELECT id, Firstname, Middlename, Lastname, BVN, Loan_Status, Status FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$reg_id = $row['id'];
$name = $row['Firstname'].' '.$row['Middlename'].' '.$row['Lastname'];
$bvn = $row['BVN'];
$loan_status = $row['Loan_Status'];

//
$d = date("Y-m-d");
$s = date("h:m:sa");
//
if($loan_status == 'Existing Client'){
//
$sql = "UPDATE register SET Status = 'Waiting For Verification', Approval_Type = 'Exceptional Approval' WHERE id = '$id' ";
$result= mysqli_query($con, $sql);
//state reason for exceptional approval
$sql = "INSERT INTO reason (BVN_ID, RegNO, Name, Reason, Stated_By, Date_Stated) 
VALUES ('$bvn', '$reg_id', '$name', '$reason', '$na', '$d')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}


}else{
//
$sql = "UPDATE register SET Status = 'Approved', Approval_Type = 'Exceptional Approval' WHERE id = '$id' ";
$result= mysqli_query($con, $sql);
//state reason for exceptional approval
$sql = "INSERT INTO reason (BVN_ID, RegNO, Name, Reason, Stated_By, Date_Stated) 
VALUES ('$bvn', '$reg_id', '$name', '$reason', '$na', '$d')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}


?>