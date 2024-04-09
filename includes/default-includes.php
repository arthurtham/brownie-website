<?php
# Enabling error display
error_reporting(0);
ini_set('display_errors', 0);
# PHP strict mode for sessions
ini_set('session.use_strict_mode', 1);
# PHP Time zone
date_default_timezone_set("America/Los_Angeles");

# Helper functions and classes
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