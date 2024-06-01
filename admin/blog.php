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
                <!-- <form action="blog.php" method="get"> -->
                    <input class="search form-control" type="text" name="search-text" id="search-text" placeholder="Search..." value="<?php echo $_GET["search-text"] ?>" />
                    <!-- <button type="submit">Search</button> | 
                    <a href="blog.php"><button type="button">All Posts</button></a> -->
                    <a href="blog_editor.php"><button type="button">Create New Post</button></a>
                <!-- </form> -->
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
echo "<table class='table'><tr>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_id\">ID</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_name\">Name</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_date\">Post Date</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_type\">Type</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_visible\">Visible</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_published\">Published</button></th>
<th>Actions</th></tr><tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($blog_post = $result->fetch_assoc()) {
        $blog_id = $blog_post['blog_id'];
        $blog_type = $blog_post['blog_type'];
        echo "<tr><td class='bl_id'>".$blog_id.
        "</td><td class='bl_name'>".$blog_post['blog_name'].
        "</td><td class='bl_date_readable'>".$blog_post['blog_date'].
        "</td><td class='bl_date' style='display:none'>".strtotime($blog_post['blog_date']).
        "</td><td class='bl_type'>".$blog_type.
        "</td><td class='bl_visible'>".$blog_post['visible'].
        "</td><td class='bl_published'>".$blog_post['published'].
        "</td><td><a href='blog_editor.php?blog_id=$blog_id'><button type='button'>Edit</button></a>".
        "<a target='_blank' href='/subs/blog/$blog_type/$blog_id/'><button type='button'>View</button></a>".
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
    var options = { valueNames: ['bl_id', 'bl_name', 'bl_date', 'bl_date_readable', 'bl_type', 'bl_visible', 'bl_published']};
    var linkList = new List('blog_links', options);
</script>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>