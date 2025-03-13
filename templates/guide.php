<?php
require_once $dir . "/includes/CloudinarySigner.php";

//MYSQL is already imported
$sql = "SELECT guide_posts.title, guide_posts.summary, guide_posts.category, guide_types.displayname as category_displayname, guide_posts.published, guide_posts.visible, guide_posts.publish_date, guide_posts.modified_date, guide_posts.url, guide_posts.content FROM guide_posts LEFT JOIN guide_types on guide_posts.category=guide_types.category WHERE guide_posts.category = \"". mysqli_real_escape_string($conn, $category) ."\" AND url = \"" . mysqli_real_escape_string($conn, $guide_url) . "\""; 
// echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($embed = $result->fetch_assoc()) {
        $url = $embed["url"];
        echo <<<STYLE
        <style>
        .blog-images img {
            width: 100%;
            max-width: 600px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding: 10px;
        }
        video {
            width: 100%;
            max-width: 400px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-bottom: 20px;
        }
    </style>
STYLE;
        echo "<div class='row blog-images' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
        if (!$embed["published"]) {
            echo "<center><h1>Guide</h1></center><hr/>";
            echo "<p>Note: This guide is not published or no longer exists!</p>";
        } else {
            $publish_date = date_format(date_create_from_format("Y-m-d",explode(" ",$embed["publish_date"])[0]),"F d, Y");
            $modified_date = date_format(date_create_from_format("Y-m-d",explode(" ",$embed["modified_date"])[0]),"F d, Y");
            echo "<center><h1>" . $embed["title"] . "</h1><i>".$embed["summary"]."</i><br><strong>" . $embed["category_displayname"]. "</strong> | <a href='/guides/'>" . "guide" . "</a> / <a href='/guides/$category'>" . $category . "</a> / <a href='/guides/$category/$url'>" . $url . "</a> <br>Published: " . $publish_date .  " | Last modified: " . $modified_date . "</center><br/><hr/>";
            $embed_contents = (new CloudinarySigner())->convertAllUrls($embed["content"]);
            echo Parsedown::instance()->text($embed_contents);
        }
        echo "</div></div>";
    }
} else {
    echo "<center><h1>Guide</h1></center><hr/>";
    echo "<p>Note: This guide is not published or no longer exists!</p>";
}
?>



