<?php

$dir = dirname(__DIR__, 1);
$title = "Blog Editor";
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
        <div id="blog_links">
        <div class='row'>
            <div class='col'>
                <h1>Blog Editor</h1>
                <div class="input-group mb-3">
                    <a href="blog_editor.php"><button class="btn btn-success" type="button">Create New Post</button></a>
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

$search_criteria = (isset($_GET["search-text"]) ? (
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",blog_name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",blog_content)>0'
    ) : "");


$sql = "SELECT * FROM blog_posts $search_criteria ORDER BY id DESC, blog_id DESC, blog_name ASC;";
//echo "<p>$sql</p>";
echo "<table class='table'><tr class='sticky-top' style='background-color:lightgray;z-index:1'>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_id\">ID</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_name\">Name</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_type\">Category</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_date\">Post Date</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_published\">Published</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_visible\">List in Dir</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_free\">Free</button></th>
<th>Actions</th></tr><tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($blog_post = $result->fetch_assoc()) {
        $blog_id = $blog_post['blog_id'];
        $blog_type = $blog_post['blog_type'];
        echo "<tr><td class='bl_id'>".$blog_id.
        "</td><td class='bl_name'><strong>".$blog_post['blog_name'].
            '</strong><br><a href="/subs/blog/'.$blog_type.'/'.$blog_id.'/" target="_blank">/subs/blog/'.$blog_type.'/'.$blog_id.'/</a>'.
        "</td><td class='bl_type'>".$blog_type.
        "</td><td class='bl_date_readable'>".DateTime::createFromFormat('Y-m-d H:i:s', $blog_post['blog_date'])->format("F d, Y").
        "</td><td class='bl_date' style='display:none'>".strtotime($blog_post['blog_date']).
        "</td><td class='bl_published'>".$blog_post['published'].
        "</td><td class='bl_visible'>".$blog_post['visible'].
        "</td><td class='bl_free'>".$blog_post['free'].
        "</td><td><a href='blog_editor.php?blog_id=$blog_id'><button type='button' class='btn btn-dark'>Edit</button></a>".
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
    var options = { valueNames: ['bl_id', 'bl_name', 'bl_date', 'bl_date_readable', 'bl_type', 'bl_visible', 'bl_published', 'bl_free']};
    var linkList = new List('blog_links', options);
</script>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>