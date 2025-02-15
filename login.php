<?php

/* Discord Oauth v.4.1
 * Demo Login Script
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */


# Including all the required scripts for demo
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/discord.php";
require_once "config.php";

# Initializing all the required values for the script to work
# Fetching user details | (identify scope) (optionally email scope too if you want user's email) [Add identify AND email scope for the email!]


# Start session if not active
if (session_status() != PHP_SESSION_ACTIVE) {
    start_session_custom();
}

# If a user is already logged in, ignore login request
if (isset($_SESSION["user"]) && !is_null($_SESSION["user"])) {
    redirect("/");
}

# Set sign-in attempted variable if not set yet
if (!isset($_SESSION['signin-attempted'])) {
    $_SESSION['signin-attempted'] = 0;
}

# If an error occured (usually set from Discord), deny login request
if (isset($_GET["error"])) {// && $_GET["error"]==="access_denied") {
    $_SESSION['signin-attempted'] = 0;
    redirect("/logout.php?badauth");
    die();
}

# If a sign-in is not attempted yet and initialization is not yet performed, attempt to log-in
if ($_SESSION['signin-attempted'] === 0) {
    $_SESSION['signin-attempted'] = 1;
    $auth_url = url($client_id, $redirect_url, $scopes);
    redirect($auth_url);
    die();
};

if ((rate_limit_wrapper("init", array($redirect_url, $client_id, $secret_id, $bot_token)) === false) || (rate_limit_wrapper("get_user")) === false) {
    $_SESSION['signin-attempted'] = 0;
    redirect("/logout.php?badauth");
    die();
}

# Continue Login flow if all the above conditions have passed
$_SESSION['timeout']=time();


# Fetching user guild details | (guilds scope)
// Not necessary right now (see later code below)
// $_SESSION['guilds'] = rate_limit_wrapper("get_guilds");

# Fetching user connections | (connections scope)
// Unneeded, so comment out
// $_SESSION['user_connections'] = rate_limit_wrapper("get_connections");
$_SESSION['user_connections'] = array();

# Get user guild info from Browntulstar and Brownieval
$user_guild_info = rate_limit_wrapper("get_user_guild_info", array($guild_id));
if ($user_guild_info === false) {
    $_SESSION['signin-attempted'] = 0;
    redirect("/logout.php?badauth");
    die();
}
$user_guild_info_brownieval = rate_limit_wrapper("get_user_guild_info", array($brownieval_guild_id));
if ($user_guild_info_brownieval === false) {
    $_SESSION['signin-attempted'] = 0;
    redirect("/logout.php?badauth");
    die();
}
# Merge roles together
$_SESSION['roles'] = array_merge(
    (!isset($user_guild_info['roles'])) ? array() :$user_guild_info['roles'],
    (!isset($user_guild_info_brownieval['roles'])) ? array() : $user_guild_info_brownieval['roles']);

# If a role exists for a user in a guild (mandatory in both servers), then they are in the guild.
# Since we don't use any other features of the guild array, just reconstruct it based off this instance to save
# an api call.
$_SESSION['guilds'] = array();
if (isset($user_guild_info['roles']) && sizeof($user_guild_info['roles']) > 0) {
    array_push($_SESSION['guilds'], array("id" => $guild_id));
}
if (isset($user_guild_info_brownieval['roles']) && sizeof($user_guild_info_brownieval['roles']) > 0) {
    array_push($_SESSION['guilds'], array("id" => $brownieval_guild_id));
}

# Sign-in is completed
$_SESSION['signin-attempted'] = 2;

# Redirecting to home page once all data has been fetched
# Is user in the guild?
if (check_guild_membership($guild_id) || (check_guild_membership($brownieval_guild_id) && str_contains($_SESSION['redirect'], "brownieval"))) {
    if (!isset($_SESSION['redirect']) || (strlen($_SESSION['redirect']) <= 0)) {
        redirect("/"); // if the redirect URL is not set, just send us back home
    } else {
        redirect(preg_replace("((\?|!)(logout|badauth|expired|ratelimit))", "", $_SESSION['redirect']));
    }
} else {
    // user is not in the guild, so none of the features can actually be used.
    // but we can let them know that they should join the guild to activate these rewards.
    redirect("/subs?joinserver");
}