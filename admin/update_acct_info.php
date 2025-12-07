<?php
//if the add button has been clicked
include('../config/db.php') ;
$id = $_POST['id'];// user id
$nm = $_POST['nm'];// name
$em = $_POST['em'];// email
$ph = $_POST['ph'];// phone
$ad = $_POST['ad'];// address
$tw = $_POST['tw'];// town
$uu = $_POST['us'];// user name
$go = $_POST['go'];// user role
$br_id = $_POST['br'];// branch id
// getting branch info
$Query = "SELECT * FROM branch WHERE id='$br_id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$brid = $row['id'];
$bb = $row['Name'];
$zn = $row['Zone'];
$zn_id = $row['Zone_id'];
$cn = $row['Country'];
//$pr = $_POST['pr'];
if($go == 'Loan Officers'){
// updating users info
$Query = "UPDATE users SET Name = '$nm', Email = '$em', Phone = '$ph', Address = '$ad', Branch = '$bb', Branch_id = '$brid', Town = '$tw', Zone = '$zn',
Zone_id = '$zn_id', Country = '$cn' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
// updating register info
$Query = "UPDATE register SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating cancel info
$Query = "UPDATE cancel SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating aprove info
$Query = "UPDATE aprove SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating disburse info
$Query = "UPDATE disburse SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating guarantor info
$Query = "UPDATE gaurantors SET Officer_Name = '$nm' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating group info
$Query = "UPDATE groups SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Officer_id = '$id'";
$result= mysqli_query($con, $Query);
// updating history info
$Query = "UPDATE history SET Officer_Name = '$nm', Branch = '$bb', Branch_Code = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating loan cancel info
$Query = "UPDATE loan_cancel SET Officer_Name = '$nm', Branch = '$bb' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating mapping info
$Query = "UPDATE mapping SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Officer_id = '$id'";
$result= mysqli_query($con, $Query);
// updating recover info
$Query = "UPDATE recover SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating repayments info
$Query = "UPDATE repayments SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating save info
$Query = "UPDATE save SET Officer_Name = '$nm', Branch = '$bb', Branch_Code = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating saving rep info
$Query = "UPDATE saving_rep SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating savings info
$Query = "UPDATE savings SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating schedule info
$Query = "UPDATE schedule SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating transfers info
$Query = "UPDATE transfers SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
// updating withdraw info
$Query = "UPDATE withdraw SET Officer_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}elseif ($go == 'Team Leaders') {


// updating users info
$Query = "UPDATE users SET Name = '$nm', Email = '$em', Phone = '$ph', Address = '$ad', Branch = '$bb', Branch_id = '$brid', Town = '$tw' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
// updating register info
$Query = "UPDATE register SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid'  WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating cancel info
$Query = "UPDATE cancel SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating aprove info
$Query = "UPDATE aprove SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating disburse info
$Query = "UPDATE disburse SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating guarantor info
$Query = "UPDATE gaurantors SET Team_Name = '$nm', Branch = '$bb' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating group info
$Query = "UPDATE groups SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating history info
$Query = "UPDATE history SET Team_Name = '$nm', Branch = '$bb', Branch_Code = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating loan cancel info
$Query = "UPDATE loan_cancel SET Team_Name = '$nm', Branch = '$bb' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating mapping info
$Query = "UPDATE mapping SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// refund info
$Query = "UPDATE refund SET Team_Name = '$nm', Branch = '$bb' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating repayments info
$Query = "UPDATE repayments SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating save info
$Query = "UPDATE save SET Team_Name = '$nm', Branch = '$bb', Branch_Code = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating saving rep info
$Query = "UPDATE saving_rep SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating savings info
$Query = "UPDATE savings SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating schedule info
$Query = "UPDATE schedule SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating transfers info
$Query = "UPDATE transfers SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'";
$result= mysqli_query($con, $Query);
// updating withdraw info
$Query = "UPDATE withdraw SET Team_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE Team_id = '$id'"; 
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}elseif($go == 'Branch Operations'){
// updating users info
$Query = "UPDATE users SET Name = '$nm', Email = '$em', Phone = '$ph', Address = '$ad', Branch = '$bb', Branch_id = '$brid', Town = '$tw' WHERE id = '$id'";
$result= mysqli_query($con, $Query);

$Query = "UPDATE register SET Reciever_Name = '$nm' WHERE Reciver_Username = '$uu'"; 
$result= mysqli_query($con, $Query); 

$Query = "UPDATE fee SET Reciever_Name = '$nm', Branch = '$bb', Branch_id = '$brid' WHERE User_id = '$id'"; 
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

}else{
// updating union info
$Query = "UPDATE users SET Name = '$nm', Email = '$em', Phone = '$ph', Address = '$ad', Branch = '$bb', Branch_id = '$brid', Town = '$tw' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
}
?>