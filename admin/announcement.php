<?php

$dir = dirname(__DIR__, 1);
$title = "Announcement Editor";
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
        <div id="announcement_links">
        <div class='row mb-2'>
            <div class='col'>
                <h1>Announcement Editor</h1>
                <div class="input-group mb-3">
                    <a href="announcement_editor.php"><button class="btn btn-success" type="button">Create New Post</button></a>
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


$sql = "SELECT * FROM announcement_posts ORDER BY publish_date DESC, id ASC, title ASC;";
//echo "<p>$sql</p>";

echo "<table class='table'><tr class='sticky-top' style='background-color:lightgray;z-index:1'>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_id\">ID</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_name\">Name</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_date_published_readable\">Published Date</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_date_modified_readable\">Modified Date</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_visible\">List in Dir</button></th>
<th>Actions</th></tr><tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($announcement_post = $result->fetch_assoc()) {
        $announcement_id = $announcement_post['id'];
        $announcement_type = $announcement_post['category'];
        $announcement_publish_date = (!is_null($announcement_post['publish_date'])) ? DateTime::createFromFormat('Y-m-d H:i:s', $announcement_post['publish_date'])->format("F d, Y<\b\\r>h:i A") : "Not Published";
        $announcement_modified_date = DateTime::createFromFormat('Y-m-d H:i:s', $announcement_post['modified_date'])->format("F d, Y<\b\\r>h:i A");
        echo "<tr>" . 
        "<td class='gl_id'>".$announcement_post['id'].
        "</td><td class='gl_name' style='min-width:200px'><strong>".$announcement_post['title'].
            "</strong><br><a target='_blank' href='/announcements/$announcement_id/'>/announcements/$announcement_id</a>".
        "</td><td class='gl_date_published_readable'>".$announcement_publish_date.
        "</td><td class='gl_date_published' style='display:none'>".strtotime($announcement_post['publish_date']).
        "</td><td class='gl_date_modified_readable'>".$announcement_modified_date.
        "</td><td class='gl_date_modified' style='display:none'>".strtotime($announcement_post['modified_date']).
        "</td><td class='gl_visible'>".$announcement_post['visible'].
        "</td><td><a href='announcement_editor.php?announcement-id=$announcement_id'><button class='btn btn-dark' type='button'>Edit</button></a>".
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
    var linkList = new List('announcement_links', options);
</script>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>