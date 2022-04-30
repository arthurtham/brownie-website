<?php

$dir = dirname(__DIR__, 1);

require $dir . "/includes/default-includes.php";
require_once($dir . "/includes/mysql.php");
require $dir . "/includes/admin-check.php";

?>
<html>
<head>
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
</style>
</head>
<body>
<?php

$sql = "SELECT * FROM blog_posts ORDER BY blog_id DESC, blog_name ASC;";
echo "<table><tr><th>Blog ID</th><th>Blog Name</th><th>Blog Date</th><th>Blog Type</th><th>Visible<th>Published</th><th>Actions</th>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($blog_post = $result->fetch_assoc()) {
        $blog_id = $blog_post['blog_id'];
        echo "<tr><td>".$blog_id.
        "</td><td>".$blog_post['blog_name'].
        "</td><td>".$blog_post['blog_date'].
        "</td><td>".$blog_post['blog_type'].
        "</td><td>".$blog_post['visible'].
        "</td><td>".$blog_post['published'].
        "</td><td><a href='blog_editor.php?blog_id=$blog_id'><button type='button'>Edit</button></a>".
        "<a target='_blank' href='/subs/blog/?blog-type=$blog_type&blog-id=$blog_id'><button type='button'>View</button></a>".
        "</td></tr>";
    }
}
?>
</body>
</html>