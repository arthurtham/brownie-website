<?php

$dir = dirname(__DIR__, 2);

require $dir . "/includes/default-includes.php";
require_once($dir . "/includes/mysql.php");
//require $dir . "/includes/admin-check.php";

if (empty($_POST)) {
    die("No variables passed");
}

// Generate a unique ID to represent the request, but if it's an updated request use the updated one from POST 
if (false) {
    //$request_id = uniqid("BTS_"); 
} else {
    $request_id = "BTS_" . md5(uniqid(random_int(1000,9999)."_"));
}

$request_date_created;

echo var_dump($_POST);
echo "<br>";
//die();
$sql = "REPLACE INTO shop_item_requests (request_id, request_date_updated, 
request_status, item_id, item_quantity, user_name, user_email, user_discord_name, user_discord_id,
event_name, event_start_date, event_end_date, user_notes, admin_notes
) VALUES (";
$sql .= "\"" . $request_id . "\",";
$sql .= "CURRENT_TIMESTAMP(),";
$sql .= "\"" . 0 . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["item-id"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["total-items"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["user-name"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["user-email"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["user-discord-name"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["user-discord-id"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["event-name"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["event-start-date"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["event-end-date"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["event-user-notes"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, " ") . "\"";
//$sql .= "\"" . (isset($_POST["blog_published"]) ? 1 : 0)."\"";
$sql .= ");";
$result = $conn->query($sql);
if ($result === TRUE) {
    echo "<p>Success!</p>";
    echo "<p>Request ID: $request_id</p>";
    echo "<a href='/shop'><button>Main</button></a></p>";
    echo "<code>$sql</code>";
    $_SESSION["last_request_id"] = $request_id;
    redirect("/store/book/success.php");
} else {
    echo "<p>Failure: $conn->error </p>";
    echo "<code>$sql</code>";
    redirect("/store/book/error.php");
}
//print_r($_POST);



?>