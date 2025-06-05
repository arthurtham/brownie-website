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
    require $dir . "/error/403-iriam.php";
    die();
}

// If the reward type is "cloudinary / cdncloud", use Cloudinary to download the file
if (true) { // Type doesn't matter for now, //($_GET['type'] === 'cdncloud') {
    $reward_id = htmlspecialchars($_GET['id']);
    $reward_public_id = "iriam/rewards/$reward_id";
    // var_dump($reward_id); // Debugging line to see the reward ID

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

    $secure_url = $resulting_file["resources"][0]["secure_url"];
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
    // var_dump($url); // Debugging line to see the generated URL
    redirect($url);
    // header('Content-Description: File Transfer');
    // header('Content-Type: application/octet-stream');
    // header('Content-Disposition: attachment; filename="'.basename($reward_id).'.'.$format.'"');
    // header('Expires: 0');
    // header('Cache-Control: must-revalidate');
    // header('Pragma: public');
    // header('Content-Length: ' . filesize($secure_url));
    // readfile($secure_url);
    exit;
} else {
    // If the reward type is not "cloudinary", return a 403 error because there's no other types supported yet
    require $dir . "/error/403-iriam.php";
    die();
}

?>