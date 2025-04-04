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
        <div id="sl_links">
        <div class='row'>
            <div class='col'>
                <h1>Shortlinks Editor</h1>
                <div class="input-group mb-3">
                    <a href="shortlinks_editor.php" class="btn btn-success">Create New Shortlink</a>
                    <a href="/admin" class="btn btn-danger">Return to Main Menu</a>
                </div>
                <div class="input-group mb-3">
                    <label for="search-text" class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input class="search form-control" type="text" name="search-text" id="search-text" placeholder="Search..." />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-12 border' style='overflow:scroll;max-height:70vh'>
<?php

$search_criteria = (isset($_GET["search-text"]) ? (
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",shortcode)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",fulllink)>0'
    ) : "");


$sql = "SELECT * FROM shortlinks $search_criteria ORDER BY creationdate DESC, shortcode ASC;";
//echo "<p>$sql</p>";
echo "<table class='table'><thead class='table-dark sticky-top' style='z-index:1'><tr>
<th class='col-2'><button class='sort btn btn-success btn-sm' data-sort=\"sl_shortcode\">Short Code</button</th>
<th class='col-4'><button class='sort btn btn-success btn-sm' data-sort=\"sl_fulllink\">Full Link</button</th>
<th class='col-1'><button class='sort btn btn-success btn-sm' data-sort=\"sl_hits\">Hits</button</th>
<th class='col-1'><button class='sort btn btn-success btn-sm' data-sort=\"sl_available\">Accessible</button</th>
<th class='col-4'><button class='sort btn btn-success btn-sm' data-sort=\"sl_creationdate\">Date Created</button</th>
<th class='col-1'>Actions</th></tr></thead>";
echo "<tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($shortlink_entry = $result->fetch_assoc()) {
        echo "<tr>
        <td class='sl_shortcode' style='word-wrap: break-word;max-width:300px'><strong>".$shortlink_entry['shortcode']."</strong><br><a href='/r/".$shortlink_entry['shortcode']."' target='_blank'>Link</a>".
        "</td><td class='sl_fulllink' style='word-wrap: break-word;max-width:300px'><a href='".$shortlink_entry['fulllink']."' target='_blank'>".$shortlink_entry['fulllink']."</strong></a>".
        "</td><td class='sl_hits'>".$shortlink_entry['hits'].
        "</td><td class='sl_available'>".$shortlink_entry['available'].
        "</td><td class='sl_creationdate_readable'>".DateTime::createFromFormat('Y-m-d H:i:s', $shortlink_entry['creationdate'])->format("F d, Y<\b\\r>h:i A").
        "</td><td style=\"display:none\" class='sl_creationdate'>". strtotime($shortlink_entry['creationdate']) .
        "</td><td><a href='shortlinks_editor.php?shortcode=".$shortlink_entry['shortcode']."'><button type='button' class='btn btn-dark'>Edit</button></a>".
        "</td></tr>";
    }
}
?>
                    </tbody>
                </div>
            </table>
        </div>
    </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script>
    var options = { valueNames: ['sl_shortcode', 'sl_fulllink', 'sl_hits', 'sl_available', 'sl_creationdate', 'sl_creationdate_readable']};
    var linkList = new List('sl_links', options);
</script>

<?php $_footer_adminmode = true; require $dir . "/templates/footer.php"; ?>