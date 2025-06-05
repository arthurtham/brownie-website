<?php

$dir = dirname(__DIR__, 1);
require_once $dir . "/includes/mysql.php";
require_once $dir . "/includes/cloudinary.env.php";
require_once $dir . "/vendor/autoload.php";
require_once $dir . "/includes/CloudinarySigner.php";
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
    isset($json["notification_type"]) && $json["notification_type"] === "upload"
)) {
    die("Error: missing parameters");
}

// Check GET parameter for special case: "iriam-rewards"
// Otherwise, continue with the default behavior
// error_log(var_export($json, true));
if (isset($_GET["uploadedfrom"]) && $_GET["uploadedfrom"] === "iriam-rewards"){//} && isset($json["tags"]) && is_array($json["tags"]) && in_array("iriam-reward", $json["tags"])) {
    // error_log("Processing IRIAM reward upload...");
    $public_id = $json["public_id"];
    $resource_type = $json["resource_type"];
    $type = $json["type"];
    $format = $json["format"];

    $public_id_name_only = end(explode("/",$public_id));
    $iriam_reward_download_id = mysqli_real_escape_string($conn, $public_id_name_only);

    // If it's an image, generate the thumbnail URL
    if ($resource_type === "image") {
        $cldSigner = new CloudinarySigner();
        $iriam_reward_thumbnail = $cldSigner->signUrl("https://res.cloudinary.com/$CLOUDINARY_CLOUD_NAME/image/$type/c_thumb,g_auto,h_200,w_300/$public_id.$format");
    } 
    // Else, if it's a video, generate the thumbnail URL based on the public ID of the video
    else if ($resource_type === "video") {
        $cldSigner = new CloudinarySigner();
        $iriam_reward_thumbnail = $cldSigner->signUrl("https://res.cloudinary.com/$CLOUDINARY_CLOUD_NAME/video/$type/c_thumb,g_auto,h_200,w_300/$public_id.jpg");
    }
    else {
        $iriam_reward_thumbnail = null;
    }
    
    if ($iriam_reward_thumbnail === null || empty($iriam_reward_thumbnail)) {
        $sql = "INSERT INTO iriam_rewards (
            iriam_reward_download_id
        ) VALUES (
            \"$iriam_reward_download_id\"
    );";
    } else {
        $sql = "INSERT INTO iriam_rewards (
            iriam_reward_download_id,
            iriam_reward_thumbnail
        ) VALUES (
            \"$iriam_reward_download_id\",
            \"$iriam_reward_thumbnail\"
        );";
    }
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "<p>Success!</p>";
        echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    } else {
        echo "<p>Error: SQL Error: $conn->error </p>";
        echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    };
} else {
    if (!(
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
    \"" . mysqli_real_escape_string($conn, isset($_GET["uploadedfrom"]) ? $_GET["uploadedfrom"] : "default") . "\");
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

}