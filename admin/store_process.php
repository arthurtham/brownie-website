<?php

$dir = dirname(__DIR__, 1);

require $dir . "/includes/admin-check.php";
require $dir . "/includes/default-includes.php";
require_once($dir . "/includes/mysql.php");

if (empty($_POST)) {
    die("No variables passed");
}

// Generate a unique ID to represent the request, but if it's an updated request use the updated one from POST 
// if (false) {
//     //$request_id = uniqid("BTS_"); 
// } else {
//     $request_id = "BTS_" . md5(uniqid(random_int(1000,9999)."_"));
// }

$request_id = $_POST["request-id"];

echo var_dump($_POST);
echo "<br>";
#die();
$sql = "UPDATE shop_item_requests SET ";
$sql .= "request_date_updated = CURRENT_TIMESTAMP(),";
$sql .= "request_status = \"" . mysqli_real_escape_string($conn, $_POST["request-status"]) . "\",";
$sql .= "admin_notes = \"" . mysqli_real_escape_string($conn, $_POST["admin-comments"]) . "\"";
$sql .= " WHERE request_id = \"".$request_id."\";";
$result = $conn->query($sql);
if ($result === TRUE) {
    echo "<p>Success!</p>";
    echo "<p>Request ID: $request_id</p>";
    echo "<a href='/admin/store.php'><button>Main</button></a></p>";
    echo "<code>$sql</code>";
    $_SESSION["last_request_id"] = $request_id;
    //redirect("/store/book/success.php");
} else {
    echo "<p>Failure: $conn->error </p>";
    echo "<code>$sql</code>";
    //redirect("/store/book/error.php");
}
//print_r($_POST);



?>