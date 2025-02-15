<?php
# Including all the required scripts 
require __DIR__ . "/includes/functions.php";
require __DIR__ . "/includes/discord.php";
require __DIR__ . "/includes/twitch.php";
require "config.php";

# Start session if not active
// session_start();
// session_destroy();
if (session_status() != PHP_SESSION_ACTIVE) {
    start_session_custom();
}

# Set sign-in attempted variable if not set yet
if (!isset($_SESSION['signin-attempted'])) {
    $_SESSION['signin-attempted'] = 0;
}

# If a user is already logged in, ignore login request
if (isset($_SESSION["user"]) && !is_null($_SESSION["user"])) {
    redirect("/");
}

# If an error occured (usually set from Discord), deny login request
if (isset($_GET["error"])) {// && $_GET["error"]==="access_denied") {
    $_SESSION['signin-attempted'] = 0;
    redirect("/logout.php?badauth");
}

# If a sign-in is not attempted yet and initialization is not yet performed, attempt to log-in
if (
    ($_SESSION['signin-attempted'] === 0) || 
        (!(twitch_get_user_access_token($twitch_redirect_url))) || (!twitch_get_user())
    ) {
    $_SESSION['signin-attempted'] = 1;
    $auth_url = twitch_gen_userauth_url($twitch_client_id, $twitch_redirect_url, $twitch_user_scopes);
    redirect($auth_url);
    die;
};
# Continue Login flow if all the above conditions have passed
$_SESSION['timeout']=time();
// $_SESSION['user_connections'] = rate_limit_wrapper("get_connections");
if (twitch_get_user_sub_status()) {
    $_SESSION['roles'] = array($sub_role_id);
} else {
    $_SESSION['roles'] = array();
}
$_SESSION['guilds'] = array();
$_SESSION['user_connections'] = array();

# Sign in is successful
$_SESSION['signin-attempted'] = 2;
if (!isset($_SESSION['redirect']) || (strlen($_SESSION['redirect']) <= 0)) {
    redirect("/"); // if the redirect URL is not set, just send us back home
} else {
    redirect(preg_replace("((\?|!)(logout|badauth|expired|ratelimit))", "", $_SESSION['redirect']));
}