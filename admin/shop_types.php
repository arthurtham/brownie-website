<?php

$dir = dirname(__DIR__, 1);
$title = "Shop Types Editor";
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
        <div id="bl_links">
        <div class='row'>
            <div class='col'>
                <h1>Shop Types Editor</h1>
                <div class="input-group mb-3">
                    <a href="shop_types_editor.php" class="btn btn-success">Create New Shop Type</a>
                    <a href="shop.php" class="btn btn-dark">Shop Listings</a>
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
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",shop_type)>0'
    ) : "");


$sql = "SELECT * FROM shop_types $search_criteria;";
//echo "<p>$sql</p>";
echo "<table class='table'><thead class='table-dark sticky-top' style='z-index:1'><tr>
<th class='col-3'><button class='sort btn btn-success btn-sm' data-sort=\"bl_name\">Name</button</th>
<th class='col-4'><button class='sort btn btn-success btn-sm' data-sort=\"bl_description\">Description</button</th>
<th class='col-1'><button class='sort btn btn-success btn-sm' data-sort=\"bl_visible\">List in Dir</button</th>
<th class='col-1'>Actions</th></tr></thead>";
echo "<tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($shop_type_entry = $result->fetch_assoc()) {
        echo "<tr>
        <td class='bl_name' style='word-wrap: break-word;max-width:300px'><strong>".$shop_type_entry['name']."</strong><br><a href='/shop/category/".$shop_type_entry['shop_type']."' target='_blank'>".$shop_type_entry['shop_type']."</a>".
        "</td><td class='bl_description'>".$shop_type_entry['description'].
        "</td><td class='bl_visible'>".$shop_type_entry['visible'].
        "</td><td><a href='shop_types_editor.php?type=".$shop_type_entry['shop_type']."'><button type='button' class='btn btn-dark'>Edit</button></a>".
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
    var options = { valueNames: ['bl_name', 'bl_description', 'bl_visible']};
    var linkList = new List('bl_links', options);
</script>

<?php $_footer_adminmode = true; require $dir . "/templates/footer.php"; ?>