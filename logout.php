<?php
/* Discord Oauth v.4.1
 * This file will logout a user logged in via the oauth.
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */

# Including all the required scripts for demo
require __DIR__ . "/includes/functions.php";
start_session_custom();

# Save Redirect in case we need it
$_REDIRECT_URL = "/";
if (isset($_SESSION) && isset($_SESSION['redirect'])) {
    $_REDIRECT_URL = is_null($_SESSION['redirect']) ? "/" : $_SESSION['redirect'];
}
// $_REDIRECT_URL = $_SESSION["redirect"];
// die($_REDIRECT_URL);
//regenerate_session();
// # Closing the session and deleting all values associated with the session
$_SESSION = array();
session_destroy();
// # Starting the session
start_session_custom();

$_REDIRECT_URL = str_replace(array("?badauth", "?expired","&badauth", "&expired"), array("","","",""), $_REDIRECT_URL);

$argument_string = "";
$query_exists = parse_url($_REDIRECT_URL, PHP_URL_QUERY);
// Returns a string if the URL has parameters or NULL if not

if (isset($_GET["logout"])) {
    $argument_string .= '?';
    $argument_string .= "logout";
    $_SESSION['redirect'] = "/";
} else if (isset($_GET["badauth"])) {
    $argument_string .= $query_exists ? '&' : '?';
    $argument_string .= "badauth";
    $_SESSION['redirect'] = $_REDIRECT_URL;
} else if (isset($_GET["expired"])) {
    // $argument_string .= $query_exists ? '&' : '?';
    // $argument_string .= "expired";
    $_SESSION['redirect'] = $_REDIRECT_URL;
} else {
    $argument_string .= '?';
    $argument_string .= "logout";
    $_SESSION['redirect'] = "/";
}

# Reset expired session timer
// unset($_SESSION['timeout_since_login']);

# Redirecting the user back to login page
// print_r($_SESSION["redirect"] . $argument_string);
// redirect("/".$argument_string);
redirect($_SESSION['redirect'] . $argument_string);

?>
