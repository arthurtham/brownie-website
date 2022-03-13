<?php
if (!isset($_SESSION['timeout']) || !isset($_SESSION['user'])) {
    $_SESSION['timeout']=time();
} else {
    $inactive = 9000; 
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive)
    {  
        header("Location: /logout.php");
        die();     
    } 
    else 
    {
        $_SESSION['timeout']=time();
    }
}
?>