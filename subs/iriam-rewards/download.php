<?php 

$dir = dirname(__DIR__, 2);
require_once $dir . "/includes/default-includes.php";
require_once $dir . "/includes/mysql.php";
require_once $dir . "/includes/functions.php";
require_once $dir . "/includes/cloudinary.env.php";
use Cloudinary\Api\Search\SearchApi;
use Cloudinary\Api\Upload\UploadApi;

// Check if the user is logged in and has the required roles
if (!isset($_SESSION['user']) || !check_roles($iriam_star_roles)) {
    require $dir . "/error/403-iriam.php";
    die();
}

// Get the link information from the GET request. reward_type and download_id are required.
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    require $dir . "/error/404.php";
    die();
}

// If the reward type is "cloudinary / cdncloud", use Cloudinary to download the file
if (true) { // Type doesn't matter for now, //($_GET['type'] === 'cdncloud') {
    $reward_id = htmlspecialchars($_GET['id']);
    $reward_public_id = "com.browntulstar/iriam/rewards/$reward_id";
    // var_dump($reward_id); // Debugging line to see the reward ID

    // The file exists, but now we need to check the star badge permissions from the database
    $sql_rewards = "SELECT * FROM `iriam_rewards` WHERE `published`=1 AND `iriam_reward_download_id`=\"" . mysqli_real_escape_string($conn, $reward_id) . "\" LIMIT 1;";
    $result_rewards = $conn->query($sql_rewards);
    unset($sql_rewards);
    if ($result_rewards->num_rows === 0) {
        // If the reward does not exist, return a 404 error
        require $dir . "/error/404.php";
        die();
    }

    // Make sure the reward ID exists
    $resulting_file = (new SearchApi())->expression(
        "public_id=$reward_public_id"
        )
        ->execute();
    // Check if the file exists under the resources array
    if (!isset($resulting_file["resources"]) || count($resulting_file["resources"]) === 0) {
        require $dir . "/error/404.php";
        die();
    }
    $reward = $result_rewards->fetch_assoc();
    unset($result_rewards);
    // Check if the user has the required star badge to download this reward
    // Includes VIP and Mod roles by default
    $reward_list_only = true;
    $star_roles_to_check = array($vip_role_id, $mod_role_id);
    if (intval($reward['1star']) === 1) {
        $star_roles_to_check[] = $iriam_1star_role_id;
        $reward_list_only = false;
    }
    if (intval($reward['2star']) === 1) {
        $star_roles_to_check[] = $iriam_2star_role_id;
        $reward_list_only = false;
    }
    if (intval($reward['3star']) === 1) {
        $star_roles_to_check[] = $iriam_3star_role_id;
        $reward_list_only = false;
    }

    if ($reward_list_only || !check_roles($star_roles_to_check)) {
        // If the user does not have the required star badge, return a 403 error
        require $dir . "/error/403-iriam.php";
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
} else {
    // If the reward type is not "cloudinary", return a 403 error because there's no other types supported yet
    require $dir . "/error/403-iriam.php";
    die();
}

?>