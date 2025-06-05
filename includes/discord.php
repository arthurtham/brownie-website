<?php
/* Discord Oauth v.4.1
 * This file contains the core functions of the oauth2 script.
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */

require_once __DIR__ . "/functions.php";
require_once dirname(__DIR__, 1) . "/config.php";
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
    $httpcode = strval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
    curl_close($curl);
    $results = json_decode($response, true);
    if ($httpcode === "429") {
        return $results;
    } else if ($httpcode !== "200") {
        // echo "init" . $httpcode;
        // die();
        return false;
    }
    $_SESSION['access_token'] = $results['access_token'] ?? null;
    return $results;
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
    $httpcode = strval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
    curl_close($curl);
    $results = json_decode($response, true);
    if ($httpcode === "429") {
        return $results;
    } else if ($httpcode !== "200") {
        return false;
    } 
    $_SESSION['user'] = $results;
    $_SESSION['username'] = $results['username'];
    $_SESSION['discrim'] = $results['discriminator'];
    $_SESSION['user_id'] = $results['id'];
    $_SESSION['user_avatar'] = $results['avatar'];
    if ($email == True) {
        $_SESSION['email'] = $results['email'];
    }
    return true;
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
    $httpcode = strval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
    curl_close($curl);
    #TODO: processing codes
    $results = json_decode($response, true);
    // if ($httpcode === "429") {
    //     return $results;
    // } else if ($httpcode !== "200") {
    //     return false;
    // }
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
    $httpcode = strval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
    curl_close($curl);
    #TODO: processing codes
    $results = json_decode($response, true);
    // if ($httpcode === "429") {
    //     return $results;
    // } else if ($httpcode !== "200") {
    //     return false;
    // }
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
    $httpcode = strval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
    curl_close($curl);
    $results = json_decode($response, true);
    if ($httpcode === "429") {
        return $results;
    } else if (!in_array($httpcode, array("404","200"))) {
        // 404 possible if not in guild
        return false;
    }
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
    if (!isset($_SESSION['guilds'])) {
        return false;
    }
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
// Compatibility function
function get_avatar_url() {
    return get_discord_avatar_url();
}

function get_discord_avatar_url() {
    # Check user's avatar type
    if (isset($_SESSION['twitch_user_access_token'])) {
        return $_SESSION['user_avatar'];
    } else if (isset($_SESSION['user_avatar'])) {
        $extention = is_animated($_SESSION['user_avatar']);
        return "https://cdn.discordapp.com/avatars/".$_SESSION["user_id"]."/".$_SESSION['user_avatar'].$extention;
    } else {
        return "https://cdn.discordapp.com/embed/avatars/0.png";
    }
}

# Wrapper to force a retry
function rate_limit_wrapper($function, array $param=null) {
    // There is only one param in use for any function that uses this,
    // so we can use the param directly
    $result = is_null($param) ? call_user_func($function) : call_user_func($function, ...$param);
    if (isset($result["retry_after"])) {
        redirect("/logout.php?ratelimit=".urlencode($result["retry_after"]));
        die;
    } else {
        return $result;
    }
}

function print_navbar_login_items($expand=false, $center=false, $subperks=false) {
    global $sub_perk_roles, $mod_role_id, $vip_role_id, $turtle_role_id, $iriam_1star_role_id, $iriam_2star_role_id, $iriam_3star_role_id, $sub_role_id;
    // Auth_URL now handled in login file
    // $auth_url = url($client_id, $redirect_url, $scopes);\

    if ($expand) {
        echo "<div><ul class='navbar-nav d-flex flex-row";
        if ($center) {
            echo " justify-content-center";
        }
        echo "'>";
    }
    if (isset($_SESSION['user'])) {
        if ($expand) echo "<li>";
        echo '<a href="/profile" style="text-decoration: none !important"><img style="text-decoration: none; border: 1; border-color:black; border-top-left-radius:4px;border-bottom-left-radius:4px;height:38px;border-color:gray;border:1px solid;" src="'.get_avatar_url().'" /></button></a>';
        if ($subperks) {
            if ($expand) echo "</li>";
            echo "<li class='nav-item dropdown' style='width: 175px'>";
            $dropdown_style = "dropdown-toggle w-100' style='border-radius:0' href='#' id='accountMenu' role='button' data-bs-toggle='dropdown' aria-expanded='false'";
            if (check_roles([$turtle_role_id])) {
                echo "<a class='btn btn-success $dropdown_style><i class=\"fa-solid fa-person-shelter\"></i> Head Turtle</a>";
            } else if (check_roles([$mod_role_id])) {
                echo "<a class='btn btn-success $dropdown_style><i class=\"fa-solid fa-circle-check\"></i> Discord Mod</a>";
            } else if (check_roles([$vip_role_id])) {
                echo "<a class='btn btn-success $dropdown_style><i class=\"fa-solid fa-circle-check\"></i> Discord VIP</a>";
            } else if (check_roles([$iriam_3star_role_id])) {
                echo "<a class='btn btn-success $dropdown_style><i class=\"fa-solid fa-circle-check\"></i> IRIAM 3★</a>";
            } else if (check_roles([$iriam_2star_role_id])) {
                echo "<a class='btn btn-success $dropdown_style><i class=\"fa-solid fa-circle-check\"></i> IRIAM 2★</a>";
            } else if (check_roles([$sub_role_id])) {
                echo "<a class='btn btn-success $dropdown_style><i class=\"fa-solid fa-circle-check\"></i> Twitch Sub</a>";
            } else if (check_roles([$iriam_1star_role_id])) {
                echo "<a class='btn btn-success $dropdown_style><i class=\"fa-solid fa-circle-check\"></i> IRIAM 1★</a>";
            } else {
                echo "<a class='btn btn-primary $dropdown_style><i class=\"fa-solid fa-link\"></i> Get Perks</a>";
            }
            ?>
            <ul class="dropdown-menu dropdown-menu-end" id="accountMenu-menu" aria-labelledby="accountMenu" style="width: inherit">
                <li><h6 class="dropdown-header">
                    <?=(isset($_SESSION["twitch_user_access_token"]) 
                    ? '<i class="fa-brands fa-twitch" style="font-size: 12px"></i>' 
                    : '<i class="fa-brands fa-discord" style="font-size: 12px"></i>') 
                    ?>
                Logged In As</h6></li>                
                <li><a class="dropdown-item text-wrap text-break" href="/profile">
                    <strong><?=$_SESSION["username"] ?></strong>
                </a></li>
                <li class="dropdown-divider"></li>
                <?php
                if (check_roles([$turtle_role_id])) {
                ?>
                <li><h6 class="dropdown-header">Internal Admin Tools</h6></li>
                <li><a class="dropdown-item" href="/admin"><i style="width:26px" class='fa-solid fa-cog'></i> Admin</a></li>
                <li class="dropdown-divider"></li>
                <?php 
                }
                ?>
                <li><h6 class="dropdown-header">Account</h6></li>
                <li><a class="dropdown-item" href="/profile"><i style="width:26px" class="fa-solid fa-user"></i> Profile</a></li>
                <li><a class="dropdown-item" href="/subs"><i style="width:26px" class='
                    <?=(check_roles($sub_perk_roles) ? "fa-solid fa-circle-check'></i> Perks" : "fa-solid fa-link'></i> Perks")?>
                </a></li>
                <li><a class="dropdown-item" href="/logout.php"><i style="width:26px" class='fa-solid fa-right-from-bracket'></i> Logout</a></li>
            </ul>
            <?php
            echo "</li>";
        }
        if ($expand) echo "<li>";
        echo '<a href="/logout.php" class="btn btn-danger" style="border-top-left-radius:0;border-bottom-left-radius:0;height:38px;font-size:22px"><i class="fa-solid fa-right-from-bracket"></i></a>';
        if ($expand) echo "</li>";
    } else {
        echo <<<LOGINITEMS
        <li class="nav-item dropdown">
            <a class="btn btn-success dropdown-toggle" style="font-weight:500;width:190px;" href="#" id="accountLogin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-right-to-bracket"></i> Login
            </a>
            <ul class="dropdown-menu dropdown-menu-end" id="accountLogin-menu" aria-labelledby="accountLogin">
                <li><h6 class="dropdown-header">Twitch/IRIAM★ perks and <br>#BrownieVAL locked pages</h6></li>
                <li><a class="dropdown-item" href="/login.php"><i style="width:26px" class='fa-brands fa-discord'></i> Discord Login</a></li>
                <li><hr class="dropdown-divider"></hr></li>
                <li><h6 class="dropdown-header">Twitch perks only</h6></li>
                <li><a class="dropdown-item" href="/login-twitch.php"><i style="width:26px" class='fa-brands fa-twitch'></i> Twitch Login</a></li>
            </ul>
        </li>
LOGINITEMS;
    }
    if ($expand) {
        echo "</ul></div>";
    }
}