<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    start_session_custom();
};

require_once dirname(__DIR__, 1) . "/config.php";
$GLOBALS['twitch_id_url'] = "https://id.twitch.tv";
$GLOBALS['twitch_api_url'] = "https://api.twitch.tv";
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

function twitch_gen_state()
{
    $_SESSION['twitch_state'] = bin2hex(openssl_random_pseudo_bytes(12));
    return $_SESSION['twitch_state'];
}

function twitch_check_state($state)
{
    return ($state == $_SESSION['twitch_state']);
}

function twitch_gen_userauth_url($clientid, $redirect, $scope) 
{
    $state = twitch_gen_state();
    return $GLOBALS['twitch_id_url']."/oauth2/authorize?"
        . "client_id=" . $clientid . "&redirect_uri=" . urlencode($redirect) 
        . "&scope=" . urlencode($scope) . "&state=" . $state . "&force_verify=true"
        . "&response_type=code";
}

function twitch_get_user_access_token($redirect_url) {
    global $twitch_client_id;
    global $twitch_client_secret;

    $state = isset($_GET['state']) ? $_GET['state'] : "-1";
    # Check if $state == $_SESSION['state'] to verify if the login is legit | CHECK THE FUNCTION get_state($state) FOR MORE INFORMATION.
    if (!twitch_check_state($state)) {
        // echo "state check failed";
        return false;
    }
    unset($_SESSION['twitch_user_access_token']);
    $code = $_GET['code'];
    $url = $GLOBALS['twitch_id_url'] . "/oauth2/token";
    $data = array(
        "client_id" => $twitch_client_id,
        "client_secret" => $twitch_client_secret,
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
    if ($response === false) { // Failed response 
        return false;
    }
    $results = json_decode($response, true);
    if (isset($results["error"])) {
        return false;
    }
    else if (isset($results['access_token'])) {
        $_SESSION['twitch_user_access_token'] = $results['access_token'];
        return $_SESSION['twitch_user_access_token'];
    } else {
        return false;
    }
}

function twitch_get_access_token() {
    global $twitch_client_id;
    global $twitch_client_secret;
    unset($_SESSION['twitch_access_token']);
    $url = $GLOBALS['twitch_id_url'] . "/oauth2/token";
    $data = array(
        "client_id" => $twitch_client_id,
        "client_secret" => $twitch_client_secret,
        "grant_type" => "client_credentials"
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    if ($response === false) { // Failed response 
        return false;
    }
    $results = json_decode($response, true);
    if (isset($results["error"])) {
        return false;
    }
    else if (isset($results['access_token'])) {
        $_SESSION['twitch_access_token'] = $results['access_token'];
        return $_SESSION['twitch_access_token'];
    } else {
        return -1;
    }
}

function twitch_get_user() {
    global $twitch_client_id;
    $url = $GLOBALS['twitch_api_url'] . "/helix/users";
    $headers = array(
        'Content-Type: application/x-www-form-urlencoded', 
        'Authorization: Bearer ' . $_SESSION['twitch_user_access_token'],
        'Client-Id: ' . $twitch_client_id);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    if ($response === false) { // Failed response 
        return false;
    }
    $results = json_decode($response, true);
    if (isset($results["error"])) {
        return false;
    }
    else if (isset($results['data'])) {
        $_SESSION['user'] = $results['data'][0];
        $_SESSION['username'] = $results['data'][0]['login'];
        $_SESSION['discrim'] = "";
        $_SESSION['user_id'] = $results['data'][0]['id'];
        $_SESSION['user_avatar'] = $results['data'][0]['profile_image_url'];
        return true;
    } else {
        return false;
    }
}

function twitch_get_user_sub_status() {
    global $twitch_client_id;
    global $twitch_client_secret;
    global $twitch_user_id;
    $url = $GLOBALS['twitch_api_url'] . "/helix/subscriptions/user?broadcaster_id=".urlencode($twitch_user_id)."&user_id=".urlencode($_SESSION["user_id"]);
    $headers = array(
        'Authorization: Bearer ' . $_SESSION['twitch_user_access_token'],
        'Client-Id: ' . $twitch_client_id);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    if ($response === false) { // Failed response 
        return false;
    }
    $results = json_decode($response, true);
    if (isset($results["error"])) {
        return false;
    } else if (isset($results["data"])) {
        return true;
    } else {
        return false;
    }
}

function _helper_twitch_get_videos($url) {
    CacheManager::setDefaultConfig(new ConfigurationOption([
        "path" => dirname(__DIR__, 1) . "/cache"
    ]));
    $instanceCache = CacheManager::getInstance("files");
    $key = "twitch_".urlencode($url);
    $cache = $instanceCache->getItem($key);
    if (!$cache->isHit()) {
        global $twitch_client_id;
        if (!isset($_SESSION['twitch_access_token']) || $_SESSION['twitch_access_token'] == -1) {
            if (twitch_get_access_token() === -1) {
                return array("error" => "unauthorized");
            }
        }
        $_retry = 1;
        while ($_retry-- > 0) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $headers = array('Authorization: Bearer ' . $_SESSION['twitch_access_token'], 'Client-Id: ' . $twitch_client_id);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($curl);
            curl_close($curl);
            if ($response === false) { // Failed response 
                return false;
            }
            $results = json_decode($response, true);
            if (isset($results['data'])) { //Success
                $resulting_data = array();
                foreach ($results['data'] as $result) {
                    $entry = array_filter($result, function($key) {
                        return in_array($key, array("id", "title", "published_at", "url", "thumbnail_url", "description", "viewable", "duration"));
                    }, ARRAY_FILTER_USE_KEY);
                    $entry["thumbnail_url"] = str_replace("%{width}x%{height}", "320x180", $entry["thumbnail_url"]);
                    array_push($resulting_data, $entry);
                }
                usort($resulting_data, function($a, $b) {
                    return intval(strtotime($a["published_at"]) < intval(strtotime($b["published_at"])));
                });
                $cache->set($resulting_data)->expiresAfter(21600);
                $instanceCache->save($cache);
                return $resulting_data;
            } else if (isset($results['error']) && (isset($results['status']) && ($results['status'] == "401"))) {
                if (twitch_get_access_token() === -1) {
                    return array("error" => "unauthorized");
                } else {
                    $_retry += 1;
                }
            }
        }
        return array("error" => "invalid response");
    } else {
        return $cache->get();
    }
}

function twitch_get_recent_videos($count = 9, $type = "archive") {
    global $twitch_user_id;
    $url = $GLOBALS['twitch_api_url'] . "/helix/videos?user_id=".$twitch_user_id."&first=".$count."&type=".$type;
    return _helper_twitch_get_videos($url);
}

function twitch_get_videos_by_id($video_ids) {
    $url = $GLOBALS['twitch_api_url'] . "/helix/videos?";
    $_first_video = true;
    foreach ($video_ids as $video_id) {
        if (!$_first_video) {
            $url .= "&";
        } else {
            $_first_video = false;
        }
        $url .= "id=" . $video_id;
    }
    #var_dump($url);
    return _helper_twitch_get_videos($url);
}
