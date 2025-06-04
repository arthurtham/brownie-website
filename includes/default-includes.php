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
if (str_contains($_SERVER['REQUEST_URI'], "admin")) {
    // Redirect all admin pages to home
    $_SESSION['redirect'] = "/";
// Otherwise if the redirect URL has the word "iriam-rewards/" in it
} else if (str_contains($_SERVER['REQUEST_URI'], "iriam-rewards/")) {
    // Redirect all download pages to home
    $_SESSION['redirect'] = "/subs/iriam-rewards";
} else {
    // Normal behavior
    $_SESSION['redirect'] = $_SERVER["REQUEST_URI"];
}

# A general check if a login was attempted but interrupted.
# If it was interrupted, log out so we can try again.
# Successful sign in denoted with Session variable: signin-attempted = 2
if ($_SESSION['signin-attempted'] === 1) {
    $_SESSION['signin-attempted'] = 0;
    redirect("/logout.php?badauth");
    die();
}

# Run session timer
require_once $dir . "/includes/sessiontimer.php";

?>