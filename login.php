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
error_reporting(E_ALL);
ini_set('display_errors', 1);

# Including all the required scripts for demo
require __DIR__ . "/includes/discord.php";
require __DIR__ . "/includes/functions.php";
require "config.php";

# Initializing all the required values for the script to work
init($redirect_url, $client_id, $secret_id, $bot_token);

# Fetching user details | (identify scope) (optionally email scope too if you want user's email) [Add identify AND email scope for the email!]
if (!get_user()) {
    if ($_SESSION['signin-attempted'] === 0 || !isset($_SESSION['signin-attempted'])) {
        $_SESSION['signin-attempted'] = 1;
        $auth_url = url($client_id, $redirect_url, $scopes);
        // echo json_encode($_SESSION['user']);
        redirect($auth_url);
        die;
    } else {
        $_SESSION['signin-attempted'] = 0;
        redirect("/logout.php?badauth");
    }
};
$_SESSION['timeout']=time();

# Uncomment this for using it WITH email scope and comment line 32.
#get_user($email=True);

# Adding user to guild | (guilds.join scope)
# join_guild('SERVER_ID_HERE');

# Fetching user guild details | (guilds scope)
$_SESSION['guilds'] = get_guilds();

# Fetching user connections | (connections scope)
$_SESSION['user_guild_info'] = get_user_guild_info($guild_id);
$_SESSION['roles'] = $_SESSION['user_guild_info']['roles'];

# Redirecting to home page once all data has been fetched
//redirect("/subs");
redirect(str_replace(array("?logout", "?badauth"), array("",""), $_SESSION['redirect']));
