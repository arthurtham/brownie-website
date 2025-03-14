<?php
require_once $dir . "/includes/CloudinarySigner.php";

$_contact_button = '<a href="/contact"><button class="btn btn-primary">Contact</button></a>';
$_return_to_guides_button = '<a href="/guides/"><button class="btn btn-success">Return to Guides</button></a>';
$_error_message = <<<ERROR

<h1 class="text-center">Guide</h1>
<hr/>
<p class="text-center">Note: Sorry, it looks like this guide is not published or no longer exists.</p>
<p class="text-center">$_return_to_guides_button</p>

ERROR;

//MYSQL is already imported
$sql = "SELECT guide_posts.title, guide_posts.summary, guide_posts.category, guide_types.displayname as category_displayname, guide_posts.published, guide_posts.visible, guide_posts.publish_date, guide_posts.modified_date, guide_posts.url, guide_posts.content FROM guide_posts LEFT JOIN guide_types on guide_posts.category=guide_types.category WHERE guide_posts.category = \"". mysqli_real_escape_string($conn, $category) ."\" AND url = \"" . mysqli_real_escape_string($conn, $guide_url) . "\""; 
// echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($embed = $result->fetch_assoc()) {
        if (!$embed["published"]) {
            echo $_error_message;
        } else {
            $url = $embed["url"];
            echo <<<STYLE
            <style>
            .guide-images img {
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
            echo "<div class='row guide-images' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
            $publish_date = date_format(date_create_from_format("Y-m-d",explode(" ",$embed["publish_date"])[0]),"F d, Y");
            $modified_date = date_format(date_create_from_format("Y-m-d",explode(" ",$embed["modified_date"])[0]),"F d, Y");
            echo "<center><h1>" . $embed["title"] . "</h1><i>".$embed["summary"]."</i><br>Category: <strong>" . $embed["category_displayname"]. "</strong><br><a href='/guides/'>" . "guides" . "</a> / <a href='/guides/$category'>" . $category . "</a> / <a href='/guides/$category/$url'>" . $url . "</a> <br>Published: " . $publish_date .  "<br>Last modified: " . $modified_date . "</center><br/><hr/>";
            $embed_contents = (new CloudinarySigner())->convertAllUrls($embed["content"]);
            echo Parsedown::instance()->text($embed_contents);
            echo "</div></div>";
            echo <<<FOOTER
            <hr>
            <div class="alert alert-secondary">
                <h3>Like this guide?</h3>
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
                <h3>More Guides</h3>
                $_return_to_guides_button
            </div>
            
FOOTER;
        }
    }
} else {
    echo $_error_message;
}
?>



