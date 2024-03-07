<?php
/* Discord Oauth v.4.1
 * This file will logout a user logged in via the oauth.
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */

# Including all the required scripts for demo
require __DIR__ . "/includes/functions.php";

# Save Redirect in case we need it
$_REDIRECT_URL = "/";
if (isset($_SESSION) && isset($_SESSION['redirect'])) {
    $_REDIRECT_URL = is_null($_SESSION['redirect'], "/");
}

//regenerate_session();
// # Closing the session and deleting all values associated with the session
start_session_custom();
$_SESSION = array();
session_destroy();
// # Starting the session
start_session_custom();



$argument_string = "";

if (isset($_GET["logout"])) {
    $argument_string = "?logout";
    $_SESSION['redirect'] = "/";
} else if (isset($_GET["badauth"])) {
    $argument_string = "?badauth";
    $_SESSION['redirect'] = "$_REDIRECT_URL";
} else if (isset($_GET["expired"])) {
    $argument_string = "?expired";
    $_SESSION['redirect'] = "$_REDIRECT_URL";
}

# Reset expired session timer
// unset($_SESSION['timeout_since_login']);

# Redirecting the user back to login page
redirect("/".$argument_string);

?>
