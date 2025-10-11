<?php 
//find session
session_start();
if (isset($_SESSION['Username'])) {
    $user = $_SESSION['Username'];
}
//unset all session variale
$_SESSION = array();
//destroy session cookie
if (isset($_cookie[session_name()])){
setcookie (session_name(),'',time() - 3000,'/');
}
//destroy  the seeion
$user = $_GET['id'];// username
$bck = $_GET['resume'];// resume
session_destroy();
header("location:lockscreen.php?id=$user&&resume=$bck");
?>