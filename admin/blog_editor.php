<?php

$dir = dirname(__DIR__, 1);
$title = "Blog Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");
require_once $dir . "/includes/CloudinarySigner.php";


$blog_id = 0;
$blog_name = "Blog Name";
$blog_type = "blogtype";
$blog_visible = false;
$blog_published = false;
$blog_content = "";
$blog_date = "2022-1-1";
$can_change_blog_id = "";

if (isset($_GET["blog_id"])) {
    $can_change_blog_id = "readonly=\"readonly\"";
    $sql = "SELECT * FROM blog_posts WHERE blog_id = \"".$_GET["blog_id"]."\" LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($blog_post = $result->fetch_assoc()) {
            $blog_id = $blog_post["blog_id"];
            $blog_name = $blog_post["blog_name"];
            $blog_type = $blog_post["blog_type"];
            $blog_date = explode(" ",$blog_post["blog_date"])[0];
            $blog_visible = $blog_post["visible"];
            $blog_published = $blog_post["published"];
            $blog_content = $blog_post["blog_content"];
        }
    }
    $cldSigner = new CloudinarySigner();
    $blog_content = $cldSigner->convertAllUrls($blog_content);
} else {
    $can_change_blog_id = "readonly=\"readonly\"";
    $sql = "SELECT blog_id FROM blog_posts ORDER BY blog_id DESC LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($blog_post = $result->fetch_assoc()) {
            $blog_id = intval($blog_post["blog_id"])+1;
        }
    }
}

if ($blog_visible == "1") {
    $blog_visible = "checked";
}
if ($blog_published == "1") {
    $blog_published = "checked";
}

$blog_types = array();
$sql = "SELECT blog_type, name, description FROM blog_types";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($blog_types, $row["blog_type"]);
    }
}
$html_blog_types = "<span class=\"input-group-text\"><label for ='blog_type'>Category</label></span><select class=\"form-control\" name='blog_type' id='blog_type'>";
foreach ($blog_types as $entry) {
    $html_blog_types .= "<option value=\"$entry\" ". ($blog_type === $entry ? "selected" : "") .">$entry</option>";
}
$html_blog_types .= "</select>";
// <button type="button" onclick="renderMarkdown()">Preview Markdown</button><button id="submit" name="submit">Post to DB</button><br/>
echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Blog Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <div class="card-body">
                <form action="blog_process.php" method="post">
                    <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                        <div class="card-body" style="min-width: 500px">
                            <div class="input-group mb-3" style="max-width:500px">
                                <span class="input-group-text"><label for ="blog_name">Title</label></span>
                                <input class="form-control" type="text" id="blog_name" name="blog_name" value="$blog_name" />
                            </div>
                            <div class="input-group mb-3" style="max-width:500px">
                                <span class="input-group-text"><label for ="blog_id">ID</label></span>
                                <input $can_change_blog_id class="form-control" type="number" id="blog_id" name="blog_id" value="$blog_id" />
                            </div>
                            <div class="input-group mb-3" style="max-width:500px">
                            $html_blog_types
                            </div>
                            <div class="input-group mb-3" style="max-width:500px">
                                <span class="input-group-text"><label for ="blog_date">Date</label></span>
                                <input class="form-control" type="date" id="blog_date" name="blog_date" value="$blog_date" />
                            </div>
                            <div class="input-group mb-3" style="max-width:500px">
                                <span class="input-group-text"><label for ="blog_visible">Visible</label></span>
                                <span class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" id="blog_visible" name="blog_visible" value="1" $blog_visible />
                                </span>
                                <span class="input-group-text"><label for ="blog_published">Published</label></span>
                                <span class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" id="blog_published" name="blog_published" value="1" $blog_published />
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-dark mb-2">
                        <div class="card-body"> 
                            <div class="mb-2">
                                <button class="btn btn-success" id="submit" name="submit">Save Blog Post</button> 
                                <button class="btn btn-primary" type="button" onclick="openmarkdown()">Open Blog Editor</button>
                                <a href="blog.php"><button class="btn btn-danger" type="button">Cancel (Back to Blog Post Listings)</button></a>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-light" type="button" onclick="restoreblogeditorcontents()">Restore Local Autosave</button>
                                <a target="_blank" href="cloudinary.php"><button class="btn btn-light" type="button">Cloudinary Media Signer</button></a>
                            </div>
                        </div>
                    </div>
                    <textarea style="display:none;width:100%;height:500px" id="blog_content" name="blog_content">$blog_content</textarea><br/>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <h1>Blog Preview</h1>
            <hr>
            <div class="card post-contents" style="padding:10px" id="blog_content_preview" name="blog_content_preview">
                (Loading preview...)
            </div>
        </div>
    </div>
</div>
FORM;
?>
<script src="https://unpkg.com/stackedit-js@1.0.7/docs/lib/stackedit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.2.3/purify.min.js" integrity="sha512-Ll+TuDvrWDNNRnFFIM8dOiw7Go7dsHyxRp4RutiIFW/wm3DgDmCnRZow6AqbXnCbpWu93yM1O34q+4ggzGeXVA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/marked/15.0.6/marked.min.js" integrity="sha512-rvRITpPeEKe4hV9M8XntuXX6nuohzqdR5O3W6nhjTLwkrx0ZgBQuaK4fv5DdOWzs2IaXsGt5h0+nyp9pEuoTXg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
const stackedit_editor           = document.querySelector('#blog_content');
const stackedit_preview          = document.querySelector('#blog_content_preview');
const stackedit_localstoragetext = localStorage.getItem("blogeditortext");
let   stackedit_loaded           = false;
const stackedit                  = new Stackedit();

stackedit.on('fileChange', (file) => {
    stackedit_file = file;
    stackedit_preview.innerHTML = DOMPurify.sanitize(marked.parse(file.content.text), {ADD_TAGS: ["iframe"], ADD_ATTR: ['allow', 'allowfullscreen', 'frameborder', 'scrolling'] });
    stackedit_editor.value = file.content.text;
});
stackedit.on('close', () => {
    if (stackedit_loaded) {
        localStorage.setItem("blogeditortext", stackedit_editor.value);
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