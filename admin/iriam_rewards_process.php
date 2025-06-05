<?php

$dir = dirname(__DIR__, 1);
$title = "IRIAM Rewards Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

echo "<div class=\"container body-container\">";

if (empty($_POST)) {
    echo ("No variables passed");
} else {
    $new_post = (isset($_POST["new_entry"]) && (intval($_POST["new_entry"]) == 1));

    if (!$new_post) {
        $sql = "UPDATE iriam_rewards SET
        iriam_reward_name = \"" . mysqli_real_escape_string($conn, $_POST["iriam_reward_name"]) . "\",
        iriam_reward_description = \"" . mysqli_real_escape_string($conn, $_POST["iriam_reward_description"]) . "\",
        iriam_reward_thumbnail = \"" . mysqli_real_escape_string($conn, $_POST["iriam_reward_thumbnail"]) . "\",
        iriam_reward_type = \"" . mysqli_real_escape_string($conn, $_POST["iriam_reward_type"]) . "\",
        iriam_reward_download_id = \"" . mysqli_real_escape_string($conn, $_POST["iriam_reward_download_id"]) . "\",
        published = " . (isset($_POST["iriam_reward_published"]) ? 1 : 0) . ",
        1star = " . (isset($_POST["iriam_reward_1star"]) ? 1 : 0) . ",
        2star = " . (isset($_POST["iriam_reward_2star"]) ? 1 : 0) . ",
        3star = " . (isset($_POST["iriam_reward_3star"]) ? 1 : 0) . ",
        iriam_reward_date = \"" . mysqli_real_escape_string($conn, $_POST["iriam_reward_date"]) . "\"     
        WHERE iriam_reward_download_id = \"" . mysqli_real_escape_string($conn, $_POST["iriam_reward_download_id"]) . "\";";
    } else {
        // Special case: we are only creating new entries whenever a file is uploaded from the upload widget.
        // This shouldn't be possible here since we're using Cloudinary webhooks, so throw an error instead.
        // See cloudinarypostupload.php for more details.
        echo "<p>Failure: Invalid request, cannot make a new reward entry without using the upload widget.</p>";
        echo "</div>";
        $_footer_adminmode = true;
        require $dir . "/templates/footer.php";
        die();
    }
    #echo $sql;
    try {
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "<p>Success!</p>";
            echo "<a href='/admin/iriam_rewards_editor.php'><button>Main</button></a></p>";
            // echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
            redirect("/admin/iriam_rewards_editor.php?public-id=" . $_POST["iriam_reward_download_id"]);
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