<?php

$dir = dirname(__DIR__, 1);
$title = "Announcement Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

echo "<div class=\"container body-container\">";

if (empty($_POST)) {
    echo ("No variables passed");
} else {
    $new_post = (intval($_POST["announcement_id"]) == 0);
    $was_published_before = false;
    $was_published_before_date = null;

    if (!$new_post) {
        $sql = "SELECT published, publish_date FROM announcement_posts WHERE id = " . mysqli_real_escape_string($conn, $_POST["announcement_id"]) . " LIMIT 1;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($announcement_post = $result->fetch_assoc()) {
                $was_published_before = (intval($announcement_post["published"]) === 1);
                $was_published_before_date = $announcement_post["publish_date"];
            }
        }
    }
    
    if (isset($_POST["announcement_published"]) && $_POST["announcement_published"] == 1) {
        if ($was_published_before) {
            $announcement_published_date = $was_published_before_date;
        } else {
            $announcement_published_date = date("Y-m-d H:i:s");
        }
    } else {
        $announcement_published_date = null;
    }

    if (!$new_post) {
        $sql = "UPDATE announcement_posts SET
        title = \"" . mysqli_real_escape_string($conn, $_POST["announcement_name"]) . "\",
        publish_date = " . ($announcement_published_date != null ? ("\"" . mysqli_real_escape_string($conn, $announcement_published_date)) . "\"" : "NULL") . ",
        modified_date = \"" . date("Y-m-d H:i:s") . "\",
        visible = " . (isset($_POST["announcement_visible"]) ? 1 : 0) . ",
        published = " . (isset($_POST["announcement_published"]) ? 1 : 0) . ",
        content = \"" . mysqli_real_escape_string($conn, $_POST["announcement_content"]) . "\"
        WHERE id = " . mysqli_real_escape_string($conn, $_POST["announcement_id"]) . ";";
    } else {
        $sql = "INSERT INTO announcement_posts (title, publish_date, modified_date, visible, published, content) VALUES (" . 
        "\"" . mysqli_real_escape_string($conn, $_POST["announcement_name"]) . "\", " . 
        ($announcement_published_date != null ? ("\"" . mysqli_real_escape_string($conn, $announcement_published_date)) . "\"" : "NULL") . ", " .
        "\"" . date("Y-m-d H:i:s") . "\", " . 
        (isset($_POST["announcement_visible"]) ? 1 : 0) . ", " . 
        (isset($_POST["announcement_published"]) ? 1 : 0) . ", " . 
        "\"" . mysqli_real_escape_string($conn, $_POST["announcement_content"]) . "\");";
    }
    #echo $sql;
    try {
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "<p>Success!</p>";
            echo "<a href='/admin/announcement.php'><button>Main</button></a></p>";
            echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
            redirect("/admin/announcement_editor.php?announcement-id=" . (($new_post) ? $conn->insert_id : $_POST["announcement_id"]) );
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