<?php

$dir = dirname(__DIR__, 1);
$title = "Shortlinks Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

?>
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
</style>
    <div class='container body-container'>
        <div class='row'>
            <div class='col'>
                <h1>Shortlinks Editor</h1>
                <form action="shortlinks.php" method="get">
                    <input type="text" name="search-text" id="search-text" placeholder="Search..." value="<?php echo $_GET["search-text"] ?>" />
                    <button type="submit">Search Links</button> | 
                    <a href="shortlinks.php"><button type="button">All Links</button></a>
                    <a href="shortlinks_editor.php"><button type="button">Create New Shortlink</button></a>
                </form>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-12 border' style='overflow:scroll;max-height:70vh'>
<?php

$search_criteria = (isset($_GET["search-text"]) ? (
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",shortcode)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",fulllink)>0'
    ) : "");


$sql = "SELECT * FROM shortlinks $search_criteria ORDER BY available DESC, shortcode ASC;";
//echo "<p>$sql</p>";
echo "<table class='table w-100'><tr><th class='col-1'>ID</th><th class='col-2'>Short Code</th><th class='col-4'>Full Link</th><th class='col-1'>Hits</th><th class='col-1'>Visible</th><th class='col-1'>Date Created</th><th class='col-2'>Actions</th>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($shortlink_entry = $result->fetch_assoc()) {
        echo "<tr><td>".$shortlink_entry['id'].
        "</td><td style='word-wrap: break-word;max-width:300px'><strong>".$shortlink_entry['shortcode']."</strong><br/>browntulstar.com/r/".$shortlink_entry['shortcode'].
        "</td><td style='word-wrap: break-word;max-width:300px'>".$shortlink_entry['fulllink'].
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

<?php $_footer_adminmode = true; require $dir . "/templates/footer.php"; ?>