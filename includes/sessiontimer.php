<?php
if (isset($_SESSION['user']) && isset($_SESSION['user']['message']) && $_SESSION['user']["message"] === "401: Unauthorized") {
    redirect("/logout.php?badauth");
}

if (!isset($_SESSION['timeout']) || !isset($_SESSION['user'])) {
    $_SESSION['timeout']=time();
} else {
    $inactive = 1800;
    $inactive_since_login = 21600; 
    $session_life = time() - $_SESSION['timeout'];
    if (!isset($_SESSION['timeout_since_login'])) {
        $_SESSION['timeout_since_login']=time();
    }
    $session_life_since_login = time() - $_SESSION['timeout_since_login'];
    if ($session_life > $inactive)
    {  
        header("Location: /logout.php?expired");
        die();     
    } 
    else if ($session_life_since_login > $inactive_since_login)
    {  
        header("Location: /logout.php?expired");
        die();     
    } 
    else 
    {
        $_SESSION['timeout']=time();
    }
}
?>