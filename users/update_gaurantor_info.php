<?php
include('../config/db.php') ;
$id = $_POST['id']; // id
$fn = $_POST['fn'];
$md = $_POST['md'];
$ln = $_POST['ln'];
$ph = $_POST['ph'];
$rel = $_POST['rel'];
$gn = $_POST['gn'];
$idd = $_POST['idd'];
$dt = $_POST['dt'];
$gst = $_POST['gst'];
$dress = $_POST['dress'];
$gbvn = $_POST['gbvn'];

// updating  info
$Query = "UPDATE gaurantors SET Firstname='$fn', Middlename='$md', Lastname='$ln',  Phone='$ph', Relationship='$rel', Gender='$gn', ID_No='$idd', ID_Type='$dt', 
Address = '$dress', Status = '$gst', Gaurantor_BVN = '$gbvn'  WHERE Regis_id='$id'";
$result= mysqli_query($con, $Query);
if($result){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}
mysqli_close($con);
?>