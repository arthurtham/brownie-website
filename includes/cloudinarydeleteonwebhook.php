<?php

$dir = dirname(__DIR__, 1);

require_once($dir . "/includes/mysql.php");

$json_string = file_get_contents("php://input");
$json = json_decode($json_string, $associative = true);

if (is_null($json)) {
    die("Error: no json");
}

var_dump($json);

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
}