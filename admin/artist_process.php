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
    $new_post = (intval($_POST["artist_id"]) == 0);

    if (!$new_post) {
        $sql = "UPDATE artists SET
        name = \"" . mysqli_real_escape_string($conn, $_POST["artist_name"]) . "\",
        logo_image = \"" . mysqli_real_escape_string($conn, $_POST["artist_logo_image"]) . "\",
        portfolio_image = \"" . mysqli_real_escape_string($conn, $_POST["artist_portfolio_image"]) . "\",
        subheader = \"" . mysqli_real_escape_string($conn, $_POST["artist_subheader"]) . "\",
        description = \"" . mysqli_real_escape_string($conn, $_POST["artist_description"]) . "\",
        entry_highlight = " . (isset($_POST["artist_highlight"]) ? 1 : 0) . ",
        entry_active = " . (isset($_POST["artist_active"]) ? 1 : 0) . ",
        links_website = \"" . mysqli_real_escape_string($conn, $_POST["artist_links_website"]) . "\",
        links_twitch = \"" . mysqli_real_escape_string($conn, $_POST["artist_links_twitch"]) . "\",
        links_twitter = \"" . mysqli_real_escape_string($conn, $_POST["artist_links_twitter"]) . "\",
        links_instagram = \"" . mysqli_real_escape_string($conn, $_POST["artist_links_instagram"]) . "\",
        links_kofi = \"" . mysqli_real_escape_string($conn, $_POST["artist_links_kofi"]) . "\",
        links_vgen = \"" . mysqli_real_escape_string($conn, $_POST["artist_links_vgen"]) . "\",
        links_etsy = \"" . mysqli_real_escape_string($conn, $_POST["artist_links_etsy"]) . "\"       
        WHERE id = " . mysqli_real_escape_string($conn, $_POST["artist_id"]) . ";";
    } else {
        $sql = "INSERT INTO artists (
        name, logo_image, portfolio_image, subheader, description, entry_highlight, entry_active, links_website, links_twitch,
        links_twitter, links_instagram, links_kofi, links_vgen, links_etsy) VALUES (
        \"" . mysqli_real_escape_string($conn, $_POST["artist_name"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_logo_image"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_portfolio_image"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_subheader"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_description"]) . "\",
        " . (isset($_POST["artist_highlight"]) ? 1 : 0) . ",
        " . (isset($_POST["artist_active"]) ? 1 : 0) . ",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_links_website"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_links_twitch"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_links_twitter"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_links_instagram"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_links_kofi"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_links_vgen"]) . "\",
        \"" . mysqli_real_escape_string($conn, $_POST["artist_links_etsy"]) . "\");";
    }
    #echo $sql;
    try {
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "<p>Success!</p>";
            echo "<a href='/admin/artist_editor.php'><button>Main</button></a></p>";
            // echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
            redirect("/admin/artist_editor.php?id=" . (($new_post) ? $conn->insert_id : $_POST["artist_id"]) );
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