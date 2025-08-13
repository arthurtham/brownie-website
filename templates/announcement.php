<?php
require_once $dir . "/includes/CloudinarySigner.php";

$_return_to_announcements_button = '<a href="/announcements/"><button class="btn btn-success">Return to Browntul Says</button></a>';
$_error_message = <<<ERROR

<h1 class="text-center">Browntul Says</h1>
<hr/>
<p class="text-center">Note: Sorry, it looks like this post is not published or no longer exists.</p>
<p class="text-center">$_return_to_announcements_button</p>

ERROR;

//MYSQL is already imported
$sql = "SELECT announcement_posts.title, announcement_posts.published, announcement_posts.visible, announcement_posts.publish_date, announcement_posts.modified_date, announcement_posts.content FROM announcement_posts WHERE id = \"" . mysqli_real_escape_string($conn, $announcement_id) . "\""; 
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
            echo "<center><h1>" . $embed["title"] . "</h1><a href='/announcements/'>Browntul Says</a><br>Published: " . $publish_date .  " PT<br>Last modified: " . $modified_date . " PT</center><br/><hr/>";
            $embed_contents = (new CloudinarySigner())->convertAllUrls($embed["content"]);
            include_once $dir . "/templates/markdown-render.php";
            echo "</div></div>";
            echo <<<FOOTER
            <hr>            
FOOTER;
            $_post_footer_type = "announcement";
            $_post_footer_return_button = $_return_to_announcements_button;
            include $dir . "/templates/post-footer.php";
        }
    }
} else {
    echo $_error_message;
}
?>



