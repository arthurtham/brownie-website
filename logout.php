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

# Save rate limit in case we need it
$_RATE_LIMIT = $_SESSION['rate-limit-timestamp'] ?? 0;

//regenerate_session();
// # Closing the session and deleting all values associated with the session
$_SESSION = array();
session_destroy();
// # Starting the session
start_session_custom();

$_REDIRECT_URL = preg_replace("((\?|!)(logout|badauth|expired|ratelimit))", "", $_REDIRECT_URL);

$argument_string = "";
$query_exists = parse_url($_REDIRECT_URL, PHP_URL_QUERY);
// Returns a string if the URL has parameters or NULL if not
if (isset($_GET["ratelimit"])) {
    $argument_string .= $query_exists ? '&' : '?';
    $argument_string .= "ratelimit";
    if (intval($_GET["ratelimit"]) !== -1) {
        $_SESSION['rate-limit-timestamp'] = strval(time() + intval($_GET["ratelimit"] + 120));
    } else {
        $_SESSION['rate-limit-timestamp'] = $_RATE_LIMIT;
    }
    $_SESSION['redirect'] = $_REDIRECT_URL;
} else if (isset($_GET["badauth"])) {
    $argument_string .= $query_exists ? '&' : '?';
    $argument_string .= "badauth";
    $_SESSION['redirect'] = $_REDIRECT_URL;
} else if (isset($_GET["expired"])) {
    $argument_string .= $query_exists ? '&' : '?';
    $argument_string .= "expired";
    $_SESSION['redirect'] = $_REDIRECT_URL;
} else {
    $argument_string .= '?';
    $argument_string .= "logout";
    $_SESSION['redirect'] = "/";
}

# Redirecting the user back to login page
$_SESSION['logout-flow-ran'] = true;
redirect($_SESSION['redirect'] . $argument_string);

?>
