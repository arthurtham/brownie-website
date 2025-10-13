<?php

$dir = dirname(__DIR__, 1);
$title = "Alert Editor";
require $dir . "/includes/admin-check.php";
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

echo "<div class=\"container body-container\">";

if (empty($_POST)) {
    echo ("No variables passed");
} else {

$_POST["alert_id"] = 1; // Force ID to 1 since we only have one alert box

$sql = "REPLACE INTO alert_posts (id, alert_title, alert_contents, alert_url, alert_popout, alert_active, alert_modified_date) VALUES (";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["alert_id"]) . "\", ";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["alert_title"]) . "\", ";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["alert_contents"]) . "\", ";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["alert_url"]) . "\", ";
$sql .= "\"" . (isset($_POST["alert_popout"]) ? 1 : 0) . "\", ";
$sql .= "\"" . (isset($_POST["alert_active"]) ? 1 : 0) . "\", ";
$sql .= "CURRENT_TIMESTAMP";
$sql .= ");";
$result = $conn->query($sql);
if ($result === TRUE) {
    CacheManager::setDefaultConfig(new ConfigurationOption([
        "path" => dirname(__DIR__, 1) . "/cache"
    ]));
    $instanceCache = CacheManager::getInstance("files");
    $key = "alert_post";
    $instanceCache->deleteItem($key);
    echo "<p>Success!</p>";
    echo "<a href='/admin/alert.php'><button>Main</button></a></p>";
    // echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    redirect("/admin/alert_editor.php");
} else {
    echo "<p>Failure: $conn->error </p>";
    echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
}
//print_r($_POST);
}

echo "</div>";
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>