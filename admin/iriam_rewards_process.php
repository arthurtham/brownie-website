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
        if ((!isset($_POST["iriam_reward_download_id"])) || empty($_POST["iriam_reward_download_id"])) {
            throw new Exception("NEW ENTRY: No download ID provided for new entry.");
        }
        $iriam_reward_download_id = explode("/",mysqli_real_escape_string($conn, $_POST["iriam_reward_download_id"]));
        $iriam_reward_download_id = end($iriam_reward_download_id);
        $_POST["iriam_reward_download_id"] = $iriam_reward_download_id;
        if ((!isset($_POST["iriam_reward_thumbnail"])) || empty($_POST["iriam_reward_thumbnail"])) {
            $sql = "INSERT INTO iriam_rewards (
                iriam_reward_download_id
            ) VALUES (
                \"$iriam_reward_download_id\"
        );";
        } else {
            $iriam_reward_thumbnail = mysqli_real_escape_string($conn, $_POST["iriam_reward_thumbnail"]);
            $sql = "INSERT INTO iriam_rewards (
                iriam_reward_download_id,
                iriam_reward_thumbnail
            ) VALUES (
                \"$iriam_reward_download_id\",
                \"$iriam_reward_thumbnail\"
            );";
        }
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