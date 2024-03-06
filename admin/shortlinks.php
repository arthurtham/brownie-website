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
                <h1>Shortlink Editor</h1>
                <form action="shortlinks.php" method="get">
                    <input type="text" name="search-text" id="search-text" placeholder="Search..." value="<?php echo $_GET["search-text"] ?>" />
                    <button type="submit">Search Links</button> | 
                    <a href="shortlinks.php"><button type="button">All Links</button></a>
                    <a href="shortlinks_editor.php"><button type="button">Create New Shortlink</button></a>
                </form>
            </div>
        </div>
        <div class='row'>
            <div class='col'>
                <div id='editor'>
                    
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col'>
<?php

$search_criteria = (isset($_GET["search-text"]) ? (
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",shortcode)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",fulllink)>0'
    ) : "");


$sql = "SELECT * FROM shortlinks $search_criteria ORDER BY available DESC, shortcode ASC, hits DESC, id ASC;";
//echo "<p>$sql</p>";
echo "<table class='table w-100' style='overflow-x:auto;min-width:400px;'><tr><th class='col-1'>ID</th><th class='col-2'>Short Code</th><th class='col-4'>Full Link</th><th class='col-1'>Hits</th><th class='col-1'>Visible</th><th class='col-1'>Date Created</th><th class='col-2'>Actions</th>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($shortlink_entry = $result->fetch_assoc()) {
        echo "<tr><td>".$shortlink_entry['id'].
        "</td><td><strong>".$shortlink_entry['shortcode']."</strong><br/>browntulstar.com/r/".$shortlink_entry['shortcode'].
        "</td><td>".$shortlink_entry['fulllink'].
        "</td><td>".$shortlink_entry['hits'].
        "</td><td>".$shortlink_entry['available'].
        "</td><td>".$shortlink_entry['creationdate'].
        "</td><td><a href='shortlinks_editor.php?shortcode=".$shortlink_entry['shortcode']."'><button type='button'>Edit</button></a>".
        "<a target='_blank' href='/r/index.php?shortcode=".$shortlink_entry['shortcode']."'><button type='button'>View</button></a>".
        "<a target='_blank' href='".$shortlink_entry['fulllink']."'><button type='button'>Raw</button></a>".
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