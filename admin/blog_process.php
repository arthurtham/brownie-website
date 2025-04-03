<?php

$dir = dirname(__DIR__, 1);
$title = "Blog Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

echo "<div class=\"container body-container\">";

if (empty($_POST)) {
    echo ("No variables passed");
} else {

$sql = "REPLACE INTO blog_posts (blog_id, blog_name, blog_date, blog_type, blog_content, visible, published, free) VALUES (";
$sql .= "\"" . $_POST["blog_id"] . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_name"]) . "\",";
$sql .= "\"" . $_POST["blog_date"] . "\",";
$sql .= "\"" . $_POST["blog_type"] . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_content"]) . "\",";
$sql .= "\"" . (isset($_POST["blog_visible"]) ? 1 : 0) . "\",";
$sql .= "\"" . (isset($_POST["blog_published"]) ? 1 : 0)."\",";
$sql .= "\"" . (isset($_POST["blog_free"]) ? 1 : 0)."\"";
$sql .= ");";
$result = $conn->query($sql);
if ($result === TRUE) {
    echo "<p>Success!</p>";
    echo "<a href='/admin/blog.php'><button>Main</button></a></p>";
    // echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    redirect("/admin/blog_editor.php?blog_id=".$_POST["blog_id"]);
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