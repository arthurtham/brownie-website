<?php 

require_once "cloudinary.env.php";
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

//Hijack GET request to always use this prefix
$_GET["uploadPreset"] = $CLOUDINARY_BROWNIEVAL_PREFIX;

 ApiUtils::signRequest($_GET["data"], (object) array(
    "apiSecret" => $CLOUDINARY_API_SECRET,
    "apiKey" => $CLOUDINARY_API_KEY,
    "signatureAlgorithm" => "sha256",
));

//$_SESSION['cloudinary_timer_start'] -= $cloudinary_timer_duration;

echo $_GET["data"]["signature"];
?>