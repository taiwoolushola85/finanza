<?php
session_start();
include './config/db.php';
extract($_POST);
if (empty($user) && empty($pass)) {
echo 1;
}else if(empty($user)){ 
echo 2;
}else if(empty($pass)){
echo 3;
}else{
// checking the if login is correct
$sql ="SELECT id, Name, Usertype, Status, Checks, Username, Password FROM users WHERE Username = '$user' AND Password = '$pass' ORDER BY id ASC LIMIT 1";
$result=mysqli_query($con,$sql); 
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
if (mysqli_num_rows($result) === 1) {
$id = $row['id'];
$name= $row['Name'];
$nn = $row['Username'];
$pwd = $row['Password'];
$User = $row['Usertype'];
$Status = $row['Status'];
$chk = $row['Checks'];

// check if user is admin
if($User == 'Admin' && $chk == 0 && $Status == 'Activate'){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
$_SESSION["Name"] = $name;
$_SESSION['login_time'] = time();
echo "./admin/index.php";

}elseif($User == 'Admin' && $chk == 1 && $Status == 'Activate'){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
$_SESSION["Name"] = $name;
$_SESSION['login_time'] = time();
echo "authentication.php";

}elseif($User == 'User' && $chk == 0 && $Status == 'Activate'){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
$_SESSION["Name"] = $name;
$_SESSION['login_time'] = time();
echo "./users/home.php";

}elseif($User == 'User' && $chk == 1 && $Status == 'Activate'){
$_SESSION["id"] = $id;
$_SESSION["Username"] = $user;
$_SESSION["Name"] = $name;
$_SESSION['login_time'] = time();
echo "authentication.php";

}elseif($User == 'User' && $Status == 'Deactivated'){
echo 4;

} else {
echo 5;

}

}else{
echo 6;
}
}
mysqli_close($con);
?>