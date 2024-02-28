<?php

$dir = dirname(__DIR__, 1);

require $dir . "/includes/admin-check.php";
require $dir . "/includes/default-includes.php";
require_once($dir . "/includes/mysql.php");

if (empty($_POST)) {
    die("No variables passed");
}

$sql = "REPLACE INTO announcement_embeds (announcement_id, announcement_name, announcement_embed, announcement_date, published) VALUES (";
$sql .= "\"" . $_POST["announcement_id"] . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["announcement_name"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["announcement_embed"]) . "\",";
$sql .= "\"" . $_POST["announcement_date"] . "\",";
$sql .= "\"" . (isset($_POST["announcement_published"]) ? 1 : 0)."\"";
$sql .= ");";
$result = $conn->query($sql);
if ($result === TRUE) {
    echo "<p>Success!</p>";
    echo "<a href='/admin/announcement.php'><button>Main</button></a></p>";
    echo "<code>$sql</code>";
} else {
    echo "<p>Failure: $conn->error </p>";
    echo "<code>$sql</code>";
}
echo "<br/>";
print_r($_POST);



?>