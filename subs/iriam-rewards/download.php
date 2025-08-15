<?php 

$dir = dirname(__DIR__, 2);
require_once $dir . "/includes/default-includes.php";
require_once $dir . "/includes/mysql.php";
require_once $dir . "/includes/functions.php";
require_once $dir . "/includes/cloudinary.env.php";
use Cloudinary\Api\Search\SearchApi;
use Cloudinary\Api\Upload\UploadApi;

// Check if the user is logged in and has the required roles
if (!isset($_SESSION['user']) || !check_roles(array_merge($iriam_star_roles, array($vip_role_id, $mod_role_id)))) {
    header('HTTP/1.0 403 Forbidden');
    require $dir . "/error/403-iriam.php";
    die();
}

// Get the link information from the GET request. reward_type and download_id are required.
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    header('HTTP/1.0 404 Not Found');
    require $dir . "/error/404.php";
    die();
}
$reward_id = htmlspecialchars($_GET['id']);
$reward_type = $_GET['type'];

// We need to check if the file exists and get the star badge permissions from the database
$sql_rewards = "SELECT * FROM `iriam_rewards` WHERE `published`=1 AND `iriam_reward_type`=\"" . mysqli_real_escape_string($conn, $reward_type) ."\" AND `iriam_reward_download_id`=\"" . mysqli_real_escape_string($conn, $reward_id) . "\" LIMIT 1;";
$result_rewards = $conn->query($sql_rewards);
unset($sql_rewards);
if ($result_rewards->num_rows === 0) {
    // If the reward does not exist, return a 404 error
    header('HTTP/1.0 404 Not Found');
    require $dir . "/error/404.php";
    die();
}

// Check if the user has the required star badge to download this reward
// Includes VIP and Mod roles by default
$reward = $result_rewards->fetch_assoc();
unset($result_rewards);
$star_roles_to_check = array();
$reward_list_only = true;
if (intval($reward['3star']) == 1) {
    $reward_star_banners = $star3_small_banner;
    $star_roles_to_check[] = $iriam_3star_role_id;
    $reward_list_only = false;
}
if (intval($reward['2star']) == 1 || intval($reward['1star']) == 1) {
    $star_roles_to_check[] = $mod_role_id;
    $star_roles_to_check[] = $vip_role_id;
    $reward_list_only = false;
    if (intval($reward['2star']) == 1) {
        $reward_star_banners = $star2_small_banner;
        $star_roles_to_check[] = $iriam_2star_role_id;
    }
    if (intval($reward['1star']) == 1) {
        $reward_star_banners = $star1_small_banner;
        $star_roles_to_check[] = $iriam_1star_role_id;
    }
}
if ($reward_list_only || !check_roles($star_roles_to_check)) {
    // If the user does not have the required star badge, return a 403 error
    header('HTTP/1.0 403 Forbidden');
    require $dir . "/error/403-iriam.php";
    die();
}

// Log a hit for the reward
$sql_update = "UPDATE `iriam_rewards` SET hits = IFNULL(hits, 0) + 1 WHERE `iriam_reward_type`=\"" . mysqli_real_escape_string($conn, $reward_type) ."\" AND `iriam_reward_download_id`=\"" . mysqli_real_escape_string($conn, $reward_id) . "\";";
$result_update = $conn->query($sql_update);
unset($sql_update);
if ($result_update === false) {
    header('HTTP/1.0 500 Internal Server Error');
    require $dir . "/error/500.php";
    die();
}

// If the reward type is "cloudinary / cdncloud", use Cloudinary to download the file
if ($_GET['type'] === 'cdncloud') {
    // Get the reward public ID in Cloudinary format
    $reward_public_id = "$iriam_reward_download_folder/$reward_id";

    // Make sure the reward ID exists
    $resulting_file = (new SearchApi())->expression(
        "public_id=$reward_public_id"
        )
        ->execute();
    // Check if the file exists under the resources array
    if (!isset($resulting_file["resources"]) || count($resulting_file["resources"]) === 0) {
        header('HTTP/1.0 404 Not Found');
        require $dir . "/error/404.php";
        die();
    }

    $format = $resulting_file["resources"][0]["format"];
    $resource_type = $resulting_file["resources"][0]["resource_type"];

    $url = (new UploadApi())->privateDownloadUrl(
        $reward_public_id,
        $format,
        [
        'resource_type' => $resource_type,
        'type' => 'private',
        'attachment' => true,
        'expires_at' => time() + 60 * 5// URL expires in 5 minutes
        ]
    );
    redirect($url);
    exit;
} 
// If the reward type is "url", redirect to the external URL
elseif ($_GET['type'] === 'url') {
    // Redirect to the external URL
    $external_url = $reward['iriam_reward_url'];
    if (filter_var($external_url, FILTER_VALIDATE_URL)) {
        redirect($external_url);
        exit;
    } else {
        header('HTTP/1.0 400 Bad Request');
        require $dir . "/error/500.php";
        die();
    }
    exit;
} else {
    // If the reward type is not "cloudinary", return a 403 error because there's no other types supported yet
    require $dir . "/error/403-iriam.php";
    die();
}

?>