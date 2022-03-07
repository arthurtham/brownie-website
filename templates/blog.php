<?php

require dirname(__DIR__, 1) . "/includes/Parsedown.php"; 

$blogtype = "null";
if ($_GET["blog-type"] === "travelblog") {
    $blogtype = "NYC Travel Blog";
}

$blog_entry_array = explode("_", $_GET["blog-id"]);
$month = $blog_entry_array[1];
$day = $blog_entry_array[2];
$year = $blog_entry_array[0];
$title = rtrim($blog_entry_array[3], ".md");

?>

<style>
    img {
        width: auto;
        max-width: 300px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    video {
        width: auto;
        max-width: 300px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<?php 
echo "<div class='row'><div class='col col-md-12'>";
echo "<a href='/subs/blog'>Back</a>";
echo "<center><h1>" . $title . "</h1>" . $blogtype . " | " .  $month . "/" . $day . "/" . $year .  "</center><hr><br/>";
if ($myfile = fopen($blog_file_location . ".md", "r")) {
    echo Parsedown::instance()->text(fread($myfile, filesize($blog_file_location . ".md")));
    fclose($myfile);
} else {
    header("Location: /subs/blog");
    die();
}


?>



