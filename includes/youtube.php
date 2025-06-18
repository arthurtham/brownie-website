<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    start_session_custom();
};

require_once dirname(__DIR__, 1) . "/config.php";
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
$GLOBALS['youtube_api_url'] = "https://youtube.googleapis.com";
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

function _helper_youtube_get_videos($url) {
    CacheManager::setDefaultConfig(new ConfigurationOption([
        "path" => dirname(__DIR__, 1) . "/cache"
    ]));
    $instanceCache = CacheManager::getInstance("files");
    $key = "youtube_".urlencode($url);
    $cache = $instanceCache->getItem($key);
    if (!$cache->isHit()) {
        $_retry = 1;
        while ($_retry-- > 0) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            if ($response === false) { // Failed response 
                return false;
            }
            $results = json_decode($response, true);
            if (isset($results['items'])) { //Success
                $resulting_data = array();
                foreach ($results['items'] as $result) {
                    $entry = array();
                    $entry["title"] = $result["snippet"]["title"];
                    $entry["video_id"] = $result["id"]["videoId"];
                    $entry["published_at"] = $result["snippet"]["publishedAt"];
                    $entry["thumbnail_url"] = $result["snippet"]["thumbnails"]["high"]["url"];
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

function youtube_get_recent_videos($count = 12) {
    // https://youtube.googleapis.com/youtube/v3/search?part=snippet&channelId=UCKaqbVfcK6XmANqwC1xRzig&type=video&maxResults=12&order=date&key=AIzaSyAUUqPug7OOftblILUtiIqeA1OOQD3cGZM
    global $youtube_user_id, $youtube_api_key;
    $url = $GLOBALS["youtube_api_url"]."/youtube/v3/search?part=snippet&channelId=".$youtube_user_id."&type=video&maxResults=".$count."&order=date&key=".$youtube_api_key;
    return _helper_youtube_get_videos($url);
}
