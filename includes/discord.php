<?php
/* Discord Oauth v.4.1
 * This file contains the core functions of the oauth2 script.
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */

require_once __DIR__ . "/functions.php";
 # Starting session so we can store all the variables
start_session_custom();

# Setting the base url for API requests
$GLOBALS['base_url'] = "https://discord.com";

# Setting bot token for related requests
$GLOBALS['bot_token'] = null;

# A function to generate a random string to be used as state | (protection against CSRF)
function gen_state()
{
    $_SESSION['state'] = bin2hex(openssl_random_pseudo_bytes(12));
    return $_SESSION['state'];
}

# A function to generate oAuth2 URL for logging in
function url($clientid, $redirect, $scope)
{
    $state = gen_state();
    return 'https://discord.com/oauth2/authorize?response_type=code&client_id=' . $clientid . '&redirect_uri=' . $redirect . '&scope=' . $scope . "&state=" . $state;
}

# A function to initialize and store access token in SESSION to be used for other requests
function init($redirect_url, $client_id, $client_secret, $bot_token = null)
{
    $state = isset($_GET['state']) ? $_GET['state'] : "-1";
    # Check if $state == $_SESSION['state'] to verify if the login is legit | CHECK THE FUNCTION get_state($state) FOR MORE INFORMATION.
    if (!check_state($state)) {
        // echo "state check failed";
        return false;
    }
    if ($bot_token != null)
        $GLOBALS['bot_token'] = $bot_token;
    $code = $_GET['code'];
    $url = $GLOBALS['base_url'] . "/api/oauth2/token";
    $data = array(
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "grant_type" => "authorization_code",
        "code" => $code,
        "redirect_uri" => $redirect_url
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    $_SESSION['access_token'] = $results['access_token'];
    return true;
}

# A function to get user information | (identify scope)
function get_user($email = null)
{
    $url = $GLOBALS['base_url'] . "/api/users/@me";
    $headers = array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $_SESSION['access_token']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    $_SESSION['user'] = $results;
    $_SESSION['username'] = $results['username'];
    $_SESSION['discrim'] = $results['discriminator'];
    $_SESSION['user_id'] = $results['id'];
    $_SESSION['user_avatar'] = $results['avatar'];
    # Fetching email 
    if ($email == True) {
        $_SESSION['email'] = $results['email'];
    }
    if (!isset($_SESSION['user']['message'])) {
        return true;
    }
    else if ($_SESSION['user']['message'] !== "401: Unauthorized") {
        return true;
    } else {
        return false;
    }
}

# A function to get user guilds | (guilds scope)
function get_guilds()
{
    $url = $GLOBALS['base_url'] . "/api/users/@me/guilds";
    $headers = array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $_SESSION['access_token']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    return $results;
}

# A function to get user connections | (connections scope)
function get_connections()
{
    $url = $GLOBALS['base_url'] . "/api/users/@me/connections";
    $headers = array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $_SESSION['access_token']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    return $results;
}

# A function to get user guild stats | (guilds scope)
function get_user_guild_info($guild_id)
{
    $url = $GLOBALS['base_url'] . "/api/users/@me/guilds/" . $guild_id . "/member";
    $headers = array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $_SESSION['access_token']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    return $results;
}

# A function to check if the user is a Red Shell, VIP, or overridden special role
function check_roles($array_of_roles) {
    if ($_SESSION["roles"] === null) {
        return false;
    }
    for ($i = 0; $i < sizeof($array_of_roles); $i++) {
        if (in_array($array_of_roles[$i], $_SESSION["roles"])) {
            return true;
        } 
    }
    return false;
}

# A function to check if the user is a member of Turtle Pond
function check_guild_membership($guild_id) {
    for ($i = 0; $i < sizeof($_SESSION['guilds']); $i++) {
        if ($guild_id === $_SESSION['guilds'][$i]['id']) {
            return true;
        }
    }
    return false;
}

# A function to verify if login is legit
function check_state($state)
{
    if ($state == $_SESSION['state']) {
        return true;
    } else {
        # The login is not valid, so you should probably redirect them back to home page
        return false;
    }
}

function is_animated($avatar) {
    $ext = substr($avatar, 0, 2);
    if ($ext == "a_")
    {
        return ".gif";
    }
    else
    {
        return ".png";
    }
}

# Get user's avatar URL
function get_discord_avatar_url() {
    # Check user's avatar type
    if (isset($_SESSION['user_avatar'])) {
        $extention = is_animated($_SESSION['user_avatar']);
        return "https://cdn.discordapp.com/avatars/".$_SESSION["user_id"]."/".$_SESSION['user_avatar'].$extention;
    } else {
        return "https://cdn.discordapp.com/embed/avatars/0.png";
    }
}