<?php 

require_once "cloudinary.env.php";
require_once "functions.php";
use Cloudinary\Api\ApiUtils;

if (!isset($_GET)) {
    http_response_code(400);
    die("This request is not eligible.");
} 

if ($_GET["data"]["source"] !== "uw" || !isset($_GET["data"]["timestamp"])) {
    http_response_code(400);
    die("This request is missing required parameters.");
};

start_session_custom();
$cloudinary_timer_duration = 300;
if (!isset($_SESSION['cloudinary_timer_start']) 
    || (time() - $_SESSION['cloudinary_timer_start'] > $cloudinary_timer_duration)
    || ($_GET["data"]["timestamp"] - $_SESSION['cloudinary_timer_start'] > $cloudinary_timer_duration)
) {
    http_response_code(401);
    die("This session has expired. Please refresh the page and try again.");
}

//Hijack GET request if prefix is not in the list of approved prefixes
if (isset($_GET["uploadPreset"]) && !in_array($_GET["uploadPreset"], $CLOUDINARY_BROWNIEVAL_PREFIX_ARRAY)) {
    $_GET["uploadPreset"] = -1;
}

 ApiUtils::signRequest($_GET["data"], (object) array(
    "apiSecret" => $CLOUDINARY_API_SECRET,
    "apiKey" => $CLOUDINARY_API_KEY,
    "signatureAlgorithm" => "sha256",
));

//$_SESSION['cloudinary_timer_start'] -= $cloudinary_timer_duration;

echo $_GET["data"]["signature"];
?>