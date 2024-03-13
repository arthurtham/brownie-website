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
                <h1>Announcement Editor</h1>
                <form action="announcement.php" method="get">
                    <input type="text" name="search-text" id="search-text" placeholder="Search..." value="<?php echo $_GET["search-text"] ?>" />
                    <button type="submit">Search</button> | 
                    <a href="announcement.php"><button type="button">All Posts</button></a>
                    <a href="announcement_editor.php"><button type="button">Create New Post</button></a>
                </form>
            </div>
        </div>
        <div class='row'>
            <div class='col'>
<?php

$search_criteria = (isset($_GET["search-text"]) ? (
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",announcement_name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",announcement_embed)>0'
    ) : "");


$sql = "SELECT * FROM announcement_embeds $search_criteria ORDER BY id DESC, announcement_id DESC, announcement_name ASC;";
//echo "<p>$sql</p>";
echo "<table class='table'><tr><th>Announcement ID</th><th>Announcement Name</th><th>Announcement Date</th><th>Published</th><th>Actions</th>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($announcement_post = $result->fetch_assoc()) {
        $announcement_id = $announcement_post['announcement_id'];
        $announcement_embed = $announcement_post['announcement_embed'];
        echo "<tr><td>".$announcement_id.
        "</td><td>".$announcement_post['announcement_name'].
        "</td><td>".$announcement_post['announcement_date'].
        "</td><td>".$announcement_post['published'].
        "</td><td><a href='announcement_editor.php?announcement_id=$announcement_id'><button type='button'>Edit</button></a>".
        "<a target='_blank' href='/announcements/$announcement_id/'><button type='button'>View</button></a>".
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