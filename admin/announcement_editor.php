<?php

$dir = dirname(__DIR__, 1);
$title = "Announcement Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");
require_once $dir . "/includes/CloudinarySigner.php";

?>
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
    .blog-images img {
        width: auto;
        max-width: 200px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding: 10px;
    }
    video {
        width: auto;
        max-width: 200px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<div class="container body-container">
<?php

$announcement_id = 0;
$announcement_name = "Announcement Name";
$announcement_embed = "insert link here";
$announcement_date = "2022-1-1";
$can_change_blog_id = "readonly=\"readonly\"";

if (isset($_GET["announcement_id"])) {
    $can_change_blog_id = "readonly=\"readonly\"";
    $sql = "SELECT * FROM announcement_embeds WHERE announcement_id = \"".$_GET["announcement_id"]."\" LIMIT 1;";
    $result = $conn->query($sql);
    $cldSigner = new CloudinarySigner();
    if ($result->num_rows > 0) {
        while ($announcement_post = $result->fetch_assoc()) {
            $announcement_id = $announcement_post["announcement_id"];
            $announcement_name = $announcement_post["announcement_name"];
            $announcement_date = explode(" ",$announcement_post["announcement_date"])[0];
            $announcement_embed = $cldSigner->convertAllUrls($announcement_post["announcement_embed"]);
            $announcement_published = $announcement_post["published"];
        }
    }
} else {
    $sql = "SELECT announcement_id FROM announcement_embeds ORDER BY announcement_id DESC LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($announcement_post = $result->fetch_assoc()) {
            $announcement_id = intval($announcement_post["announcement_id"])+1;
        }
    }
}

if ($announcement_published == "1") {
    $announcement_published = "checked";
}

echo <<<FORM
<div class="row"><div class="col"><h1>Announcement Editor</h1><a href="announcement.php"><button type="button">Back to Announcement Posts</button></a></div></div>
<div class="row">
<div class="col col-md-12">
<form action="announcement_process.php" method="post">
    <label for ="announcement_name">Announcement Name</label>: <input style="width:100%" type="text" id="announcement_name" name="announcement_name" value="$announcement_name" /><br/>
    <label for ="announcement_id">Announcement ID</label>: <input $can_change_blog_id type="number" id="announcement_id" name="announcement_id" value="$announcement_id" /><br/>
    <label for ="announcement_date">Announcement Date</label>: <input type="date" id="announcement_date" name="announcement_date" value="$announcement_date" /><br/>
    <label for ="announcement_published">Published</label>: <input type="checkbox" id="announcement_published" name="announcement_published" value="1" $announcement_published /><br/>
    <button type="button" onclick="openmarkdown()">Open Blog Editor</button>
    <button type="button" onclick="restoreblogeditorcontents()">Restore Local Autosave</button>
    <a target="_blank" href="cloudinary.php"><button type="button">Media Signer</button></a>
    <button id="submit" name="submit">Post to DB</button><br/>
    <label for ="announcement_embed">Markdown Contents</label>:
    <textarea style="display:none;width:100%;height:100px" id="announcement_embed" name="announcement_embed">$announcement_embed</textarea><br/>
</form>
<div class="card blog-images" style="padding:10px;min-height:500px;height:auto" id="announcement_content_preview" name="announcement_content_preview">
    (Loading preview...)
</div>
</div></div>
FORM;
?>
</div>
<script src="https://unpkg.com/stackedit-js@1.0.7/docs/lib/stackedit.min.js"></script>
<script>
const stackedit_editor           = document.querySelector('#announcement_embed');
const stackedit_preview          = document.querySelector('#announcement_content_preview');
const stackedit_localstoragetext = localStorage.getItem("announcementeditortext");
let   stackedit_loaded           = false;
const stackedit                  = new Stackedit();

stackedit.on('fileChange', (file) => {
    stackedit_file = file;
    stackedit_preview.innerHTML = file.content.html;
    stackedit_editor.value = file.content.text;
});
stackedit.on('close', () => {
    if (stackedit_loaded) {
        localStorage.setItem("announcementeditortext", stackedit_editor.value);
    } else {
        stackedit_loaded = true;
    }
});

function openmarkdown(silent=false) {
    stackedit.openFile({
        content: {
            text: stackedit_editor.value
        }
    }, silent);
}
openmarkdown(silent=true);

function restoreblogeditorcontents() {
    stackedit_editor.value = stackedit_localstoragetext;
    openmarkdown();
}
</script>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";
?>