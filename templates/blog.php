<?php

require dirname(__DIR__, 1) . "/includes/Parsedown.php"; 

$blogtype = "null";
switch ($_GET["blog-type"]) {
    case "travelblog":
        $blogtype = "NYC Travel Blog";
        break;
    case "techblog":
        $blogtype = "Tech Blog";
        break;
    case "gamedevlogs":
        $blogtype = "Game Dev Logs";
        break;
    default:
        $blogtype = "Unknown Category";
}

$blog_entry_array = explode("_", $_GET["blog-id"]);
$month = $blog_entry_array[1];
$day = $blog_entry_array[2];
$year = $blog_entry_array[0];
$title = $blog_entry_array[3];
$id = rtrim($blog_entry_array[4], ".md");

?>

<style>
    .blog-images img {
        width: auto;
        max-width: 400px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding: 10px;
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
echo "<div class='row blog-images' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
echo "<a href='/subs/blog'>Back to Blog Directory</a>";
echo "<center><h1>" . ltrim($title,"-") . "</h1>" . $blogtype . " | " .  $month . "/" . $day . "/" . $year .  "</center><hr><br/>";
if ($myfile = fopen($blog_file_location . ".md", "r")) {
    echo Parsedown::instance()->text(fread($myfile, filesize($blog_file_location . ".md")));
    fclose($myfile);
} else {
    header("Location: /subs/blog");
    die();
}

echo "</div></div>";


?>



