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
session_destroy();
header('location:../index.php');
?>