<?php

$dir = dirname(__DIR__, 3);
require_once $dir . "/includes/mysql.php";
require_once $dir . "/includes/cloudinary.env.php";
require_once $dir . "/vendor/autoload.php";
use Cloudinary\Utils\SignatureVerifier;


$json_string = file_get_contents("php://input");
$json = json_decode($json_string, $associative = true);
if (is_null($json)) {
    die("Error: no json");
}

$HEADERS = getallheaders();

if (!(
    isset($HEADERS["X-Cld-Timestamp"]) && isset($HEADERS["X-Cld-Signature"])
    && strlen($json_string) > 0
)) {
    die("Error: missing headers or body");
}

if (!(SignatureVerifier::verifyNotificationSignature($json_string, $HEADERS["X-Cld-Timestamp"], $HEADERS["X-Cld-Signature"]))) {
    die("Error: webhook is unverified");
}

if (!(
    isset($json["notification_type"]) && $json["notification_type"] === "upload" &&
    isset($json["context"]["custom"]["discord_id"]) &&
    isset($json["context"]["custom"]["discord_username"]) &&
    isset($json["secure_url"])
)) {
    die("Error: missing parameters");
}

if (isset($json["existing"]) && $json["existing"] === true) {
    die("Error: asset already exists");
}

$sql = "INSERT INTO `cloudinary_uploads`
(
`discord_id`,
`discord_username`,
`public_id`,
`secure_url`,
`uploaded_from`)
VALUES
(
\"" . mysqli_real_escape_string($conn, $json["context"]["custom"]["discord_id"]) . "\",
\"" . mysqli_real_escape_string($conn, $json["context"]["custom"]["discord_username"]) . "\",
\"" . mysqli_real_escape_string($conn, $json["public_id"]) . "\",
\"" . mysqli_real_escape_string($conn, $json["secure_url"]) . "\",
\"clipuploader-dd\");
";

// ob_start();
$result = $conn->query($sql);
if ($result === TRUE) {
    echo "<p>Success!</p>";
    echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
} else {
    echo "<p>Error: SQL Error: $conn->error </p>";
    echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
};
// $output = ob_get_contents();
// ob_end_clean();
// file_put_contents("debug.log", $output);