<?php

$dir = dirname(__DIR__, 2);
require_once $dir . "/includes/default-includes.php";
require_once $dir . "/includes/functions.php";
require_once $dir . "/includes/cloudinary.env.php";
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Search\SearchApi;


$response = [
    "success" => false,
    "reason" => "unknown",
    "url" => null
];

// Check if the user is logged in and has the required roles
if (false){//(!isset($_SESSION['user']) || !check_roles($sub_perk_roles)) {
    $response['reason'] = "Permission denied.";
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode($response);
    die();
}

// Get the link information from the GET request. reward_type and download_id are required.
if (!isset($_GET) || !isset($_GET['track-id'])) {
    $response['reason'] = "This request is missing required parameters.";
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode($response);
    die();
}

// Use the track ID to get the mp3 file from Cloudinary
$track_id = htmlspecialchars($_GET['track-id']);
$track_public_id = "com.browntulstar/tank_engine_karaoke/$track_id";

$cloudinary_file = (new SearchApi())->expression(
    "public_id=$track_public_id"
    )
    ->execute();

// Check if the file exists under the resources array
if (!isset($cloudinary_file["resources"]) || count($cloudinary_file["resources"]) === 0) {
    $response['reason'] = "Error: The requested track does not exist.";
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode($response);
    die();
}

// The file exists, now we can retrieve its URL
$format = $cloudinary_file["resources"][0]["format"];
$resource_type = $cloudinary_file["resources"][0]["resource_type"];

$url = (new UploadApi())->privateDownloadUrl(
    $track_public_id,
    $format,
    [
        'resource_type' => $resource_type,
        'type' => 'private',
        'attachment' => true,
        'expires_at' => time() + 1 // URL expires in 1 second
    ]
);

$response = [
    "success" => true,
    "reason" => "success",
    "url" => $url
];
header('Content-Type: application/json');
http_response_code(200);
echo json_encode($response);
