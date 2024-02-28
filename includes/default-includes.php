<?php

require_once $dir . "/vendor/autoload.php";
require_once $dir . "/config.php";
require_once $dir . "/includes/functions.php";
require_once $dir . "/includes/discord.php";
require_once $dir . "/includes/sessiontimer.php";

# Set redirect URL
$_SESSION['redirect'] = $_SERVER["REQUEST_URI"];

?>