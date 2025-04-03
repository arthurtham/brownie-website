<?php

$dir = dirname(__DIR__, 1);
$title = "Guide Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");
require_once $dir . "/includes/CloudinarySigner.php";

$guide_id = 0;
$guide_name = "";
$guide_type = "guidetype";
$guide_visible = false;
$guide_published = false;
$guide_content = "";
$guide_summary = "";
$guide_url = "";
$guide_published_date = "2022-1-1 00:00:00";
$guide_modified_date = "2022-1-1 00:00:00";


if (isset($_GET["guide-id"])) {
    $sql = "SELECT * FROM guide_posts WHERE id = \"".mysqli_real_escape_string($conn, $_GET["guide-id"])."\" LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($guide_post = $result->fetch_assoc()) {
            $guide_id = $guide_post["id"];
            $guide_name = htmlspecialchars($guide_post["title"]);
            $guide_type = $guide_post["category"];
            $guide_published_date = $guide_post["publish_date"]; // explode(" ",$guide_post["publish_date"])[0];
            $guide_modified_date = $guide_post["modified_date"]; //explode(" ",$guide_post["modified_date"])[0];
            $guide_visible = $guide_post["visible"];
            $guide_published = $guide_post["published"];
            $guide_content = $guide_post["content"];
            $guide_summary = htmlspecialchars($guide_post["summary"]);
            $guide_url = $guide_post["url"];
        }
    }
    $cldSigner = new CloudinarySigner();
    $guide_content = $cldSigner->convertAllUrls($guide_content);
}

if ($guide_visible == "1") {
    $guide_visible = "checked";
}
if ($guide_published == "1") {
    $guide_published = "checked";
}

$guide_types = array();
$sql = "SELECT category, displayname, description FROM guide_types";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($guide_types, $row["category"]);
    }
}
$html_guide_types = "<span class=\"input-group-text\"><label for ='guide_type'>Category</label></span><select required class=\"form-control\" name='guide_type' id='guide_type'>";
foreach ($guide_types as $entry) {
    $html_guide_types .= "<option value=\"$entry\" ". ($guide_type === $entry ? "selected" : "") .">$entry</option>";
}
$html_guide_types .= "</select>";
// <button type="button" onclick="renderMarkdown()">Preview Markdown</button><button id="submit" name="submit">Post to DB</button><br/>
$guide_url_button_if_exists = (strlen($guide_url) > 0) ? <<<GUIDE
<span class="input-group-text"><a href="/guides/post/$guide_url" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
GUIDE : "";

echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Guide Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <form id="post-editor" action="guide_process.php" method="post">
                <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                    <div class="card-body" style="min-width: 500px">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="guide_name">Title</label></span>
                            <input required minlength="1" maxlength="255" class="form-control" type="text" id="guide_name" name="guide_name" value="$guide_name" /> 
                        </div>
                        <div class="input-group mb-3" style="display:none">
                            <span class="input-group-text"><label for ="guide_id">ID</label></span>
                            <input readonly class="form-control" type="number" id="guide_id" name="guide_id" value="$guide_id" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="guide_summary">Summary</label></span>
                            <input required minlength="1" maxlength="255" class="form-control" type="text" id="guide_summary" name="guide_summary" value="$guide_summary" /> 
                        </div>
                        <div class="input-group mb-3">
                        $html_guide_types
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="guide_published_date">Published</label></span>
                            <input readonly class="form-control" type="datetime-local" id="guide_published_date" name="guide_published_date" value="$guide_published_date" />
                            <span class="input-group-text"><label for ="guide_modified_date">Modified</label></span>
                            <input readonly class="form-control" type="datetime-local" id="guide_modified_date" name="guide_modified_date" value="$guide_modified_date" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="guide_url">URL</label></span>
                            $guide_url_button_if_exists
                            <input required minlength="1" maxlength="255" pattern="[a-zA-Z0-9\-_]*" class="form-control" type="text" id="guide_url" name="guide_url" value="$guide_url" placeholder="Letters, numbers, dash or underscore only" /> 
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="guide_visible">Show on Guides Listings</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="guide_visible" name="guide_visible" value="1" $guide_visible />
                            </span>
                            <span class="input-group-text"><label for ="guide_published">Published/Viewable</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="guide_published" name="guide_published" value="1" $guide_published />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mb-2">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Save Guide</button> 
                            <a href="guide.php"><button class="btn btn-danger" type="button">Cancel (Back to Guides List)</button></a>
                        </div>
                        <div class="mb-2">
                            <a target="_blank" href="cloudinary.php"><button class="btn btn-light" type="button">Cloudinary Media Signer</button></a>
                        </div>
                    </div>
                </div>
                <div class="card bg-light mb-2 post-contents" style="z-index:1020; height:200px">
                    <textarea style="display:none;width:100%;height:500px" id="guide_content" name="guide_content">$guide_content</textarea><br/>
                </div>
            </form>
        </div>
    </div>
</div>
FORM;

$simplemde_element_name = "guide_content";
require $dir . "/templates/simplemde.php";

require $dir . "/templates/admin-check-script.php";

$_footer_adminmode = true;
require $dir . "/templates/footer.php";
?>