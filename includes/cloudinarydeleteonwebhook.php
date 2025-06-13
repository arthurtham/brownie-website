<?php

$dir = dirname(__DIR__, 1);

require_once($dir . "/includes/mysql.php");
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
    isset($json["notification_type"]) && $json["notification_type"] === "delete" &&
    isset($json["resources"])
)) {
    die("Error: missing parameters");
}

$list_of_public_ids = array();
foreach ($json["resources"] as $resource) {
    array_push($list_of_public_ids, mysqli_real_escape_string($conn, $resource["public_id"]));
};

if (count($list_of_public_ids) > 0) {
    $sql = "DELETE FROM `cloudinary_uploads` WHERE public_id IN (\"" . 
    implode('", "', $list_of_public_ids)
    . "\");";

    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "<p>Success!</p>";
        echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    } else {
        echo "<p>Error: SQL Error: $conn->error </p>";
        echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    }
    unset($sql);

    $iriam_ids = array();
    $prefix = "com.browntulstar/iriam/rewards/";
    foreach($list_of_public_ids as $public_id) { 
        if (str_starts_with($public_id, $prefix)) {
            $iriam_ids[] = substr($public_id, strlen($prefix));
        }
    };
    if (count($iriam_ids) > 0) {
        $sql = "DELETE FROM `iriam_rewards` WHERE iriam_reward_download_id IN (\"" . 
        implode('", "', $iriam_ids)
        . "\");";

        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "<p>Success!</p>";
            echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
        } else {
            echo "<p>Error: SQL Error: $conn->error </p>";
            echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
        }
        unset($sql);
    }
}