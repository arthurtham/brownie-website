<?php

/* Discord Oauth v.4.1
 * Demo Login Script
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */

# IMPORTANT READ THIS:
# - This requires 'guilds.join' scope to be active in url() function in index.php
# - The below function requries the client to be a BOT application with CREATE_INSTANT_INVITE permissions to be a member in the server.
# - Set the `$bot_token` to your bot token if you want to use guilds.join scope in the init() function
# - The below function HAS to be called after get_user() as it adds the user who has logged in
# - The bot DOES NOT have to be online, just a member in the server.
# - Uncomment line 35 to enable the function

# FEEL FREE TO JOIN MY SERVER FOR ANY QUERIES - https://join.markis.dev

# Enabling error display
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

# Including all the required scripts for demo
require __DIR__ . "/includes/functions.php";
require __DIR__ . "/includes/discord.php";
require "config.php";

# Initializing all the required values for the script to work
# Fetching user details | (identify scope) (optionally email scope too if you want user's email) [Add identify AND email scope for the email!]


# Start session if not active
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
        !(init($redirect_url, $client_id, $secret_id, $bot_token)) || (!get_user())
    ) {
    $_SESSION['signin-attempted'] = 1;
    $auth_url = url($client_id, $redirect_url, $scopes);
    redirect($auth_url);
    die;
};

# Continue Login flow if all the above conditions have passed
$_SESSION['timeout']=time();

# Uncomment this for using it WITH email scope and comment line 32.
#get_user($email=True);

# Adding user to guild | (guilds.join scope)
# join_guild('SERVER_ID_HERE');

# Fetching user guild details | (guilds scope)
$_SESSION['guilds'] = rate_limit_wrapper("get_guilds");
usleep(50000);
# Fetching user connections | (connections scope)
$_SESSION['user_connections'] = rate_limit_wrapper("get_connections");
usleep(50000);
$_SESSION['user_guild_info'] = rate_limit_wrapper("get_user_guild_info", $guild_id);
usleep(50000);
$_SESSION['user_guild_info_brownieval'] = rate_limit_wrapper("get_user_guild_info", $brownieval_guild_id);
$_SESSION['roles'] = array_merge(
    (!isset($_SESSION['user_guild_info']['roles'])) ? array() : $_SESSION['user_guild_info']['roles'],
    (!isset($_SESSION['user_guild_info_brownieval']['roles'])) ? array() : $_SESSION['user_guild_info_brownieval']['roles']);
# Redirecting to home page once all data has been fetched
//redirect("/subs");
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