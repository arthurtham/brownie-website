<?php

$dir = dirname(__DIR__, 1);
$title = "Shop Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

echo "<div class=\"container body-container\">";

if (empty($_POST)) {
    echo ("No variables passed");
} else {
    $new_post = (intval($_POST["shop_id"]) == 0);

    if (!$new_post) {
        $sql = "UPDATE shop_posts SET
        item_name = \"" . mysqli_real_escape_string($conn, $_POST["shop_name"]) . "\",
        item_category = \"" . mysqli_real_escape_string($conn, $_POST["shop_type"]) . "\",
        item_price = \"" . mysqli_real_escape_string($conn, $_POST["shop_price"]) . "\",
        item_unit = \"" . mysqli_real_escape_string($conn, $_POST["shop_unit"]) . "\",
        visible = " . (isset($_POST["shop_visible"]) ? 1 : 0) . ",
        available = " . (isset($_POST["shop_available"]) ? 1 : 0) . ",
        item_description = \"" . mysqli_real_escape_string($conn, $_POST["shop_description"]) . "\",
        item_summary = \"" . mysqli_real_escape_string($conn, $_POST["shop_summary"]) . "\",
        item_thumbnail = \"" . (isset($_POST["shop_thumbnail"]) ?  mysqli_real_escape_string($conn, $_POST["shop_thumbnail"]) : "null") . "\",
        item_platform = \"" . (isset($_POST["shop_platform"]) ?  mysqli_real_escape_string($conn, $_POST["shop_platform"]) : "null") . "\",
        item_url = \"" . mysqli_real_escape_string($conn, $_POST["shop_url"]) . "\"
        WHERE id = " . mysqli_real_escape_string($conn, $_POST["shop_id"]) . ";";
    } else {
        $sql = "INSERT INTO shop_posts (
        item_name, item_category, item_price, item_unit, visible, available, item_description, item_summary, item_thumbnail, item_platform, item_url) VALUES (
        \"" . mysqli_real_escape_string($conn, $_POST["shop_name"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["shop_type"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["shop_price"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["shop_unit"]) . "\",
        " . (isset($_POST["shop_visible"]) ? 1 : 0) . ",
        " . (isset($_POST["shop_available"]) ? 1 : 0) . ",
        \"" . mysqli_real_escape_string($conn, $_POST["shop_description"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["shop_summary"]) . "\",
        \"" . (isset($_POST["shop_thumbnail"]) ?  mysqli_real_escape_string($conn, $_POST["shop_thumbnail"]) : "null") . "\",
        \"" . (isset($_POST["shop_platform"]) ?  mysqli_real_escape_string($conn, $_POST["shop_platform"]) : "null") . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["shop_url"]) . "\");";
    }
    #echo $sql;
    try {
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "<p>Success!</p>";
            echo "<a href='/admin/shop.php'><button>Main</button></a></p>";
            // echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
            redirect("/admin/shop_editor.php?id=" . (($new_post) ? $conn->insert_id : $_POST["shop_id"]) );
        } else {
            echo "<p>Failure: $conn->error </p>";
            echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
        }
    } catch (Exception $e) {
        echo "<p>Failure: ".$e->getMessage()." </p>";
        echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    }
}

echo "</div>";
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>