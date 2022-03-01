<?php

require dirname(__DIR__, 1) . "/includes/Parsedown.php"; 

$blogtype = "null";
if ($_GET["blog-type"] === "travelblog") {
    $blogtype = "Travel Blog";
}

$blog_entry_array = explode("_", $_GET["blog-id"]);
$month = $blog_entry_array[1];
$day = $blog_entry_array[2];
$year = $blog_entry_array[0];
$title = rtrim($blog_entry_array[3], ".md");

echo "<div class='container'>";
echo "<a href='/subs/blog'>Back</a>";
echo "<h1>" . $title . "</h1>" . $blogtype . " | " .  $month . "/" . $day . "/" . $year .  "<br/><br/>";
$myfile = fopen($blog_file_location . ".md", "r") or die("Unable to open file!");
echo Parsedown::instance()->text(fread($myfile, filesize($blog_file_location . ".md")));
fclose($myfile);
echo "</div>";

?>



