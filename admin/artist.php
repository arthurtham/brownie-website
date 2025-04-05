<?php

$dir = dirname(__DIR__, 1);
$title = "Artist (Credits) Editor";
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
        <div id="artist_links">
        <div class='row'>
            <div class='col'>
                <h1>Artist (Credits) Editor</h1>
                <div class="input-group mb-3">
                    <a href="artist_editor.php" class="btn btn-success">Add New Artist Credits</a>
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
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",name)>0'
    ) : "");


$sql = "SELECT * FROM artists $search_criteria ORDER BY entry_active DESC, entry_highlight DESC, name ASC;";
//echo "<p>$sql</p>";
echo "<table class='table'><thead class='table-dark sticky-top' style='z-index:1'><tr>
<th class='col-3'><button class='sort btn btn-success btn-sm' data-sort=\"bl_id\">ID</button</th>
<th class='col-3'><button class='sort btn btn-success btn-sm' data-sort=\"bl_name\">Name</button</th>
<th class='col-4'><button class='sort btn btn-success btn-sm' data-sort=\"bl_subheader\">Description</button</th>
<th class='col-1'><button class='sort btn btn-success btn-sm' data-sort=\"bl_highlight\">Highlight</button</th>
<th class='col-1'><button class='sort btn btn-success btn-sm' data-sort=\"bl_active\">List in Dir</button</th>
<th class='col-1'>Actions</th></tr></thead>";
echo "<tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($artist_entry = $result->fetch_assoc()) {
        echo "<tr>".
        "<td class='bl_id' style='word-wrap: break-word;max-width:300px'><strong>".$artist_entry['id']."</strong>".
        "</td><td class='bl_name' style='word-wrap: break-word;max-width:300px'><strong>".$artist_entry['name']."</strong>".
        "</td><td class='bl_subheader'>".$artist_entry['subheader'].
        "</td><td class='bl_highlight'>".$artist_entry['entry_highlight'].
        "</td><td class='bl_active'>".$artist_entry['entry_active'].
        "</td><td><a href='artist_editor.php?id=".$artist_entry['id']."'><button type='button' class='btn btn-dark'>Edit</button></a>".
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
    var options = { valueNames: ['bl_name', 'bl_id', 'bl_subheader', 'bl_highlight', 'bl_active']};
    var linkList = new List('artist_links', options);
</script>

<?php $_footer_adminmode = true; require $dir . "/templates/footer.php"; ?>