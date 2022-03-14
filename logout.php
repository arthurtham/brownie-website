<?php
/* Discord Oauth v.4.1
 * This file will logout a user logged in via the oauth.
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */

# Including all the required scripts for demo
require __DIR__ . "/includes/functions.php";

# Starting the session
session_start();

# Closing the session and deleting all values associated with the session
session_destroy();


$argument_string = "";

if (isset($_GET["logout"])) {
    $argument_string = "?logout";
} else if (isset($_GET["badauth"])) {
    $argument_string = "?badauth";
}

# Redirecting the user back to login page
redirect("/".$argument_string);

?>
