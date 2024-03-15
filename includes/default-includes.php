<?php

require_once $dir . "/vendor/autoload.php";
require_once $dir . "/config.php";
require_once $dir . "/includes/functions.php";
require_once $dir . "/includes/discord.php";

# Set redirect URL
if (mb_strpos($_SERVER['REQUEST_URI'], "admin") !== false) {
    // Redirect all admin pages to home
    $_SESSION['redirect'] = "/";
} else {
    // Normal behavior
    $_SESSION['redirect'] = $_SERVER["REQUEST_URI"];
}

require_once $dir . "/includes/sessiontimer.php";

?>