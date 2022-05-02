<?php

$dir = dirname(__DIR__, 1);

require $dir . "/includes/default-includes.php";
require_once($dir . "/includes/mysql.php");
require $dir . "/includes/admin-check.php";

if (empty($_POST)) {
    die("No variables passed");
}

$sql = "REPLACE INTO blog_posts (blog_id, blog_name, blog_date, blog_type, blog_content, visible, published) VALUES (";
$sql .= "\"" . $_POST["blog_id"] . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_name"]) . "\",";
$sql .= "\"" . $_POST["blog_date"] . "\",";
$sql .= "\"" . $_POST["blog_type"] . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_content"]) . "\",";
$sql .= "\"" . (isset($_POST["blog_visible"]) ? 1 : 0) . "\",";
$sql .= "\"" . (isset($_POST["blog_published"]) ? 1 : 0)."\"";
$sql .= ");";
$result = $conn->query($sql);
if ($result === TRUE) {
    echo "<p>Success!</p>";
    echo "<a href='/admin/blog.php'><button>Main</button></a></p>";
    echo "<code>$sql</code>";
} else {
    echo "<p>Failure: $conn->error </p>";
    echo "<code>$sql</code>";
}
//print_r($_POST);



?>