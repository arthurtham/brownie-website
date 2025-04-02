<?php

$dir = dirname(__DIR__, 1);
$title = "Announcement Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");
require_once $dir . "/includes/CloudinarySigner.php";

$announcement_id = 0;
$announcement_name = "";
$announcement_type = "announcement";
$announcement_visible = false;
$announcement_published = false;
$announcement_content = "";
$announcement_summary = "";
$announcement_published_date = "2022-1-1 00:00:00";
$announcement_modified_date = "2022-1-1 00:00:00";


if (isset($_GET["announcement-id"])) {
    $sql = "SELECT * FROM announcement_posts WHERE id = \"".mysqli_real_escape_string($conn, $_GET["announcement-id"])."\" LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($announcement_post = $result->fetch_assoc()) {
            $announcement_id = $announcement_post["id"];
            $announcement_name = $announcement_post["title"];
            $announcement_type = $announcement_post["category"];
            $announcement_published_date = $announcement_post["publish_date"]; 
            $announcement_modified_date = $announcement_post["modified_date"]; 
            $announcement_visible = $announcement_post["visible"];
            $announcement_published = $announcement_post["published"];
            $announcement_content = $announcement_post["content"];
            $announcement_summary = $announcement_post["summary"];
        }
    }
    $cldSigner = new CloudinarySigner();
    $announcement_content = $cldSigner->convertAllUrls($announcement_content);
}

if ($announcement_visible == "1") {
    $announcement_visible = "checked";
}
if ($announcement_published == "1") {
    $announcement_published = "checked";
}

$announcement_url_button_if_exists = ($announcement_id > 0) ? <<<ANNOUNCE
<span class="input-group-text"><a href="/announcements/$announcement_id" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
ANNOUNCE : "";

echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Announcement Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <form id="post-editor" action="announcement_process.php" method="post">
                <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                    <div class="card-body" style="min-width: 500px">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="announcement_name">Title</label></span>
                            <input required minlength="1" maxlength="255" class="form-control" type="text" id="announcement_name" name="announcement_name" value="$announcement_name" /> 
                        </div>
                        <div class="input-group mb-3" style="display:none">
                            <span class="input-group-text"><label for ="announcement_id">ID</label></span>
                            <input readonly class="form-control" type="number" id="announcement_id" name="announcement_id" value="$announcement_id" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="announcement_published_date">Published</label></span>
                            <input readonly class="form-control" type="datetime-local" id="announcement_published_date" name="announcement_published_date" value="$announcement_published_date" />
                            <span class="input-group-text"><label for ="announcement_modified_date">Modified</label></span>
                            <input readonly class="form-control" type="datetime-local" id="announcement_modified_date" name="announcement_modified_date" value="$announcement_modified_date" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="announcement_url">URL (Announcement ID)</label></span>
                            $announcement_url_button_if_exists
                            <input readonly class="form-control" type="text" id="announcement_url" name="announcement_url" value="$announcement_id" placeholder="Announcement ID will go here when saved" /> 
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="announcement_visible">Show on Announcement Listings</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="announcement_visible" name="announcement_visible" value="1" $announcement_visible />
                            </span>
                            <span class="input-group-text"><label for ="announcement_published">Published/Viewable</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="announcement_published" name="announcement_published" value="1" $announcement_published />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mb-2">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Save Announcement</button> 
                            <a href="announcement.php"><button class="btn btn-danger" type="button">Cancel (Back to Announcements List)</button></a>
                        </div>
                        <div class="mb-2">
                            <a target="_blank" href="cloudinary.php"><button class="btn btn-light" type="button">Cloudinary Media Signer</button></a>
                        </div>
                    </div>
                </div>
                <div class="card bg-light mb-2 post-contents" style="z-index:1020; height:200px">
                    <textarea class="d-none" id="announcement_content" name="announcement_content">$announcement_content</textarea> 
                </div> 
            </form>
        </div>
    </div>
</div>
FORM;

$simplemde_element_name = "announcement_content";
require $dir . "/templates/simplemde.php";

require $dir . "/templates/admin-check-script.php";

$_footer_adminmode = true;
require $dir . "/templates/footer.php";
?>