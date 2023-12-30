<?php 

require_once "cloudinary.env.php";
use Cloudinary\Api\ApiUtils;

if (!isset($_GET)) {
    die("This request is not eligible.");
} else if ($_GET["data"]["source"] !== "uw") {
    die("This request is not eligible.");
};

 ApiUtils::signRequest($_GET["data"], (object) array(
    "apiSecret" => $CLOUDINARY_API_SECRET,
    "apiKey" => $CLOUDINARY_API_KEY,
    "signatureAlgorithm" => "sha256",
));

echo $_GET["data"]["signature"];
?>