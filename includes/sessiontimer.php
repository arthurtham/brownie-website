<?php
if (!isset($_SESSION['timeout'])) {
    $_SESSION['timeout']=time();
} else {
    $inactive = 900; 
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive)
    {  
        header("Location: /includes/logout.php");
        die();     
    } 
    else 
    {
        $_SESSION['timeout']=time();
    }
}
?>