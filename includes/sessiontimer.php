<?php
if (isset($_SESSION['user']) && isset($_SESSION['user']['message']) && $_SESSION['user']["message"] === "401: Unauthorized") {
    redirect("/logout.php?badauth");
}

if (!isset($_SESSION['timeout']) || !isset($_SESSION['user'])) {
    $_SESSION['timeout']=time();
} else {
    $inactive = 1800; 
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive)
    {  
        header("Location: /logout.php?logout");
        die();     
    } 
    else 
    {
        $_SESSION['timeout']=time();
    }
}
?>