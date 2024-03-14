<?php

$dir = dirname(__DIR__, 1);
$title = "Blog Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/markdown-it/13.0.0/markdown-it.min.js" integrity="sha512-A1dmQlsxp9NpT1ON0E7waXFEX7PXtlOlotHtSvdchehjLxBaVO5itVj8Z5e2aCxI0n02hqM1WoDTRRh36c5PuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function renderMarkdown() {
        var md = window.markdownit({html: true});
        var result = md.render(document.getElementById("blog_content").value);
        document.getElementById("blog_content_preview").innerHTML = result;
    }
</script>
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
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

$blog_id = 0;
$blog_name = "Blog Name";
$blog_type = "blogtype";
$blog_visible = false;
$blog_published = false;
$blog_content = "content";
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
$html_blog_types = "<label for ='blog_type'>Blog Type</label>: <select name='blog_type' id='blog_type'>";
foreach ($blog_types as $entry) {
    $html_blog_types .= "<option value=\"$entry\">$entry</option>";
}
$html_blog_types .= "</select>";

echo <<<FORM
<div class="container body-container">
<div class="row"><div class="col"><h1>Blog Editor</h1><a href="blog.php"><button type="button">Back to Blog Posts</button></a></div></div>
<div class="row">
<div class="col col-md-6">
<form action="blog_process.php" method="post">
    <label for ="blog_name">Blog Name</label>: <input style="width:100%" type="text" id="blog_name" name="blog_name" value="$blog_name" /><br/>
    <label for ="blog_id">Blog ID</label>: <input $can_change_blog_id type="number" id="blog_id" name="blog_id" value="$blog_id" /><br/>
    $html_blog_types <br/>
    <label for ="blog_date">Blog Date</label>: <input type="date" id="blog_date" name="blog_date" value="$blog_date" /><br/>
    <label for ="blog_visible">Visible</label>: <input type="checkbox" id="blog_visible" name="blog_visible" value="1" $blog_visible /><br/>
    <label for ="blog_published">Published</label>: <input type="checkbox" id="blog_published" name="blog_published" value="1" $blog_published /><br/>
    <button type="button" onclick="renderMarkdown()">Preview Markdown</button><button id="submit" name="submit">Post to DB</button><br/>
    <label for ="blog_content">Blog Content</label>:<br><textarea style="width:100%;height:500px" id="blog_content" name="blog_content">$blog_content</textarea><br/>
</form>
</div>
<div class="col col-md-6">
    <div class="card blog-images" style="padding:10px" id="blog_content_preview" name="blog_content_preview">
        (Preview)
    </div>
</div>
</div>
</div>
FORM;


$_footer_adminmode = true;
require $dir . "/templates/footer.php";
?>