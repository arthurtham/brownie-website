<?php

require $dir . "/includes/functions.php";
require $dir . "/includes/discord.php";
require $dir . "/config.php";
require $dir . "/includes/sessiontimer.php";

# Set redirect URL
$_SESSION['redirect'] = $_SERVER["REQUEST_URI"];

?>