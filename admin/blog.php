<?php

$dir = dirname(__DIR__, 1);

require $dir . "/includes/admin-check.php";
require $dir . "/includes/default-includes.php";
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
    <div class='container'>
        <div class='row'>
            <div class='col'>
                <h1>Blog Editor</h1>
                <form action="blog.php" method="get">
                    <input type="text" name="search-text" id="search-text" placeholder="Search..." value="<?php echo $_GET["search-text"] ?>" />
                    <button type="submit">Search</button> | 
                    <a href="blog.php"><button type="button">All Posts</button></a>
                    <a href="blog_editor.php"><button type="button">Create New Post</button></a>
                </form>
            </div>
        </div>
        <div class='row'>
            <div class='col'>
<?php

$search_criteria = (isset($_GET["search-text"]) ? (
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",blog_name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",blog_content)>0'
    ) : "");


$sql = "SELECT * FROM blog_posts $search_criteria ORDER BY id DESC, blog_id DESC, blog_name ASC;";
//echo "<p>$sql</p>";
echo "<table class='table'><tr><th>Blog ID</th><th>Blog Name</th><th>Blog Date</th><th>Blog Type</th><th>Visible<th>Published</th><th>Actions</th>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($blog_post = $result->fetch_assoc()) {
        $blog_id = $blog_post['blog_id'];
        $blog_type = $blog_post['blog_type'];
        echo "<tr><td>".$blog_id.
        "</td><td>".$blog_post['blog_name'].
        "</td><td>".$blog_post['blog_date'].
        "</td><td>".$blog_type.
        "</td><td>".$blog_post['visible'].
        "</td><td>".$blog_post['published'].
        "</td><td><a href='blog_editor.php?blog_id=$blog_id'><button type='button'>Edit</button></a>".
        "<a target='_blank' href='/subs/blog/$blog_type/$blog_id/'><button type='button'>View</button></a>".
        "</td></tr>";
    }
}
?>
            </table>
        </div>
    </div>
</div>
</body>
</html>