<?php

$dir = dirname(__DIR__, 1);
$title = "Guide Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

echo "<div class=\"container body-container\">";

if (empty($_POST)) {
    echo ("No variables passed");
} else {
    $new_post = (intval($_POST["guide_id"]) == 0);
    $was_published_before = false;
    $was_published_before_date = null;

    if (!$new_post) {
        $sql = "SELECT published, publish_date FROM guide_posts WHERE id = " . mysqli_real_escape_string($conn, $_POST["guide_id"]) . " LIMIT 1;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($guide_post = $result->fetch_assoc()) {
                $was_published_before = (intval($guide_post["published"]) === 1);
                $was_published_before_date = $guide_post["publish_date"];
            }
        }
    }
    
    if (isset($_POST["guide_published"]) && $_POST["guide_published"] == 1) {
        if ($was_published_before) {
            $guide_published_date = $was_published_before_date;
        } else {
            $guide_published_date = date("Y-m-d H:i:s");
        }
    } else {
        $guide_published_date = null;
    }

    if (!$new_post) {
        $sql = "UPDATE guide_posts SET
        title = \"" . mysqli_real_escape_string($conn, $_POST["guide_name"]) . "\",
        category = \"" . mysqli_real_escape_string($conn, $_POST["guide_type"]) . "\",
        publish_date = " . ($guide_published_date != null ? ("\"" . mysqli_real_escape_string($conn, $guide_published_date)) . "\"" : "NULL") . ",
        modified_date = \"" . date("Y-m-d H:i:s") . "\",
        visible = " . (isset($_POST["guide_visible"]) ? 1 : 0) . ",
        published = " . (isset($_POST["guide_published"]) ? 1 : 0) . ",
        content = \"" . mysqli_real_escape_string($conn, $_POST["guide_content"]) . "\",
        summary = \"" . mysqli_real_escape_string($conn, $_POST["guide_summary"]) . "\",
        url = \"" . mysqli_real_escape_string($conn, $_POST["guide_url"]) . "\"
        WHERE id = " . mysqli_real_escape_string($conn, $_POST["guide_id"]) . ";";
    } else {
        $sql = "INSERT INTO guide_posts (title, category, publish_date, modified_date, visible, published, content, summary, url) VALUES (" . 
        "\"" . mysqli_real_escape_string($conn, $_POST["guide_name"]) . "\", " . 
        "\"" . mysqli_real_escape_string($conn, $_POST["guide_type"]) . "\", " . 
        ($guide_published_date != null ? ("\"" . mysqli_real_escape_string($conn, $guide_published_date)) . "\"" : "NULL") . ", " .
        "\"" . date("Y-m-d H:i:s") . "\", " . 
        (isset($_POST["guide_visible"]) ? 1 : 0) . ", " . 
        (isset($_POST["guide_published"]) ? 1 : 0) . ", " . 
        "\"" . mysqli_real_escape_string($conn, $_POST["guide_content"]) . "\", " . 
        "\"" . mysqli_real_escape_string($conn, $_POST["guide_summary"]) . "\", " . 
        "\"" . mysqli_real_escape_string($conn, $_POST["guide_url"]) . "\");";
    }
    #echo $sql;
    try {
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "<p>Success!</p>";
            echo "<a href='/admin/guide.php'><button>Main</button></a></p>";
            echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
            redirect("/admin/guide_editor.php?guide-id=" . (($new_post) ? $conn->insert_id : $_POST["guide_id"]) );
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