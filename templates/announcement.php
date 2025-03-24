<?php
require_once $dir . "/includes/CloudinarySigner.php";

$_contact_button = '<a href="/contact"><button class="btn btn-primary">Contact</button></a>';
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
            echo "<center><h1>" . $embed["title"] . "</h1><a href='/announcements/'>Browntul Says</a><br>Published: " . $publish_date .  "<br>Last modified: " . $modified_date . "</center><br/><hr/>";
            $embed_contents = (new CloudinarySigner())->convertAllUrls($embed["content"]);
            include_once $dir . "/templates/markdown-render.php";
            echo "</div></div>";
            echo <<<FOOTER
            <hr>
            <div class="alert alert-secondary">
                <h3>Like this announcement?</h3>
                <p>Please consider subscribing or donating to support more content.</p>
                <div class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-dark mb-2" href="https://www.twitch.tv/browntulstar/subscribe" target="_blank">
                            <i class="fa-brands fa-twitch"></i>
                            Sub on Twitch
                        </a>
                    </div>
                    <div class="col-lg-12">
                        <script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script><script type='text/javascript'>kofiwidget2.init('Support me on Ko-fi', '#66001d', 'R6R02XQSW');kofiwidget2.draw();</script> 
                    </div>
                </div>
                <hr>
                <h3>Have questions?</h3>
                $_contact_button
                <hr>
                <h3>More of Browntul Says</h3>
                $_return_to_announcements_button
            </div>
            
FOOTER;
        }
    }
} else {
    echo $_error_message;
}
?>



