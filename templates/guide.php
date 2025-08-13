<?php
require_once $dir . "/includes/CloudinarySigner.php";

$_return_to_guides_button = '<a href="/guides/"><button class="btn btn-success">Return to Guides</button></a>';
$_error_message = <<<ERROR

<h1 class="text-center">Guide</h1>
<hr/>
<p class="text-center">Note: Sorry, it looks like this guide is not published or no longer exists.</p>
<p class="text-center">$_return_to_guides_button</p>

ERROR;

//MYSQL is already imported
$sql = "SELECT guide_posts.title, guide_posts.summary, guide_posts.category, guide_types.displayname as category_displayname, guide_posts.published, guide_posts.visible, guide_posts.publish_date, guide_posts.modified_date, guide_posts.url, guide_posts.content FROM guide_posts LEFT JOIN guide_types on guide_posts.category=guide_types.category WHERE url = \"" . mysqli_real_escape_string($conn, $guide_url) . "\""; 
// echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($embed = $result->fetch_assoc()) {
        if (!$embed["published"]) {
            echo $_error_message;
        } else {
            $url = $embed["url"];
            echo "<div class='row post-contents' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
            $publish_date = DateTime::createFromFormat('Y-m-d H:i:s', $embed["publish_date"])->format("F d, Y h:i A");
            $modified_date = DateTime::createFromFormat('Y-m-d H:i:s', $embed["modified_date"])->format("F d, Y h:i A");
            echo "<center><h1>" . $embed["title"] . "</h1><i>".$embed["summary"]."</i><br><a href='/guides/'>Guides</a> / <a href='/guides/category/".$embed["category"]."'>" . $embed["category_displayname"]. "</a><br>Published: " . $publish_date .  " PT<br>Last modified: " . $modified_date . " PT</center><br/><hr/>";
            $embed_contents = (new CloudinarySigner())->convertAllUrls($embed["content"]);
            include_once $dir . "/templates/markdown-render.php";
            echo "</div></div>";
            echo <<<FOOTER
            <hr>
FOOTER;
            $_post_footer_type = "guide";
            $_post_footer_return_button = $_return_to_guides_button;
            include $dir . "/templates/post-footer.php";
        }
    }
} else {
    echo $_error_message;
}
?>



