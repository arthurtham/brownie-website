<?php

$dir = dirname(__DIR__, 1);
$title = "Guide Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

?>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
</style>
</head>
<body>
    <div class='container body-container'>
        <div id="guide_links">
        <div class='row mb-2'>
            <div class='col'>
                <h1>Guide Editor</h1>
                <div class="input-group mb-3">
                    <a href="guide_editor.php"><button class="btn btn-success" type="button">Create New Post</button></a>
                    <a href="/admin" class="btn btn-danger">Return to Main Menu</a>
                </div>
                <div class="input-group mb-3">
                    <label for="search-text" class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input class="search form-control" type="text" name="search-text" id="search-text" placeholder="Search..." value="<?php echo $_GET["search-text"] ?>" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-12 border' style='overflow:scroll;max-height:70vh'>
<?php


$sql = "SELECT * FROM guide_posts ORDER BY publish_date DESC, id ASC, title ASC;";
//echo "<p>$sql</p>";


// <th><button class='sort btn btn-success btn-sm' data-sort=\"gl_id\">ID</button></th>
// <th><button class='sort btn btn-success btn-sm' data-sort=\"gl_published\">Published</button></th>


echo "<table class='table'><tr>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_name\">Name</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_type\">Category</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_url\">URL</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_date_published_readable\">Published Date</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_date_modified_readable\">Modified Date</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_visible\">List in Dir</button></th>
<th>Actions</th></tr><tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($guide_post = $result->fetch_assoc()) {
        $guide_id = $guide_post['id'];
        $guide_type = $guide_post['category'];
        $guide_url = $guide_post['url'];
        echo "<tr>" . 
        // "<td class='gl_id'>".$guide_id.
        "</td><td class='gl_name' style='min-width:200px'>".$guide_post['title'].
        "</td><td class='gl_type'>".$guide_type.
        "</td><td class='gl_url'><a target='_blank' href='/guides/post/$guide_url/'>".$guide_url."</a>".
        "</td><td class='gl_date_published_readable'>".$guide_post['publish_date'].
        "</td><td class='gl_date_published' style='display:none'>".strtotime($guide_post['publish_date']).
        "</td><td class='gl_date_modified_readable'>".$guide_post['modified_date'].
        "</td><td class='gl_date_modified' style='display:none'>".strtotime($guide_post['modified_date']).
        "</td><td class='gl_visible'>".$guide_post['visible'].
        // "</td><td class='gl_published'>".$guide_post['published'].
        "</td><td><a href='guide_editor.php?guide-id=$guide_id'><button class='btn btn-dark' type='button'>Edit</button></a>".
        "</td></tr>";
    }
}
?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script>
    var options = { valueNames: ['gl_id', 'gl_name', 'gl_date_published_readable', 'gl_date_modified_readable', 'gl_type', 'gl_visible', 'gl_published', 'gl_url']};
    var linkList = new List('guide_links', options);
</script>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>