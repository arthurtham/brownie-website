<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
};

require_once dirname(__DIR__, 1) . "/config.php";
$GLOBALS['twitch_id_url'] = "https://id.twitch.tv";
$GLOBALS['twitch_api_url'] = "https://api.twitch.tv";

function twitch_get_access_token() {
    global $twitch_client_id;
    global $twitch_client_secret;
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
    $results = json_decode($response, true);
    if (isset($results['access_token'])) {
        $_SESSION['twitch_access_token'] = $results['access_token'];
        return $_SESSION['twitch_access_token'];
    } else {
        $_SESSION['twitch_access_token'] = -1;
        return -1;
    }
}

function _helper_twitch_get_videos($url) {
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
