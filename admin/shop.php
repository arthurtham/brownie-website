<?php

$dir = dirname(__DIR__, 1);
$title = "Shop Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
</style>
</head>
<body>
    <div class='container body-container'>
        <div id="shop_links">
        <div class='row'>
            <div class='col'>
                <h1>Shop Editor</h1>
                <div class="input-group mb-3">
                    <a href="shop_editor.php" class="btn btn-success">Create New Post</a>
                    <a href="shop_types.php" class="btn btn-dark">Shop Types</a>
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

$search_criteria = (isset($_GET["search-text"]) ? (
    'WHERE LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",item_name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$_GET["search-text"]).'",item_description)>0'
    ) : "");


$sql = "SELECT * FROM shop_posts $search_criteria ORDER BY id DESC, item_category ASC;";
//echo "<p>$sql</p>";
echo "<table class='table'><thead class='table-dark sticky-top' style='z-index:1'><tr>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_id\">ID</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_name\">Name</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_type\">Category</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_price\">Price</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_available\">Available</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"bl_visible\">List in Dir</button></th>
<th>Actions</th></tr></thead><tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($shop_post = $result->fetch_assoc()) {
        $shop_id = $shop_post['id'];
        $shop_type = $shop_post['item_category'];
        echo "<tr><td class='bl_id'>".$shop_id.
        "</td><td class='bl_name'><strong>".$shop_post['item_name']. "</strong>" .
        ((is_null($shop_post["item_platform"]) || $shop_post["item_platform"] === "") ? "" : ("<br>on ". $shop_post["item_platform"])) .
        "</td><td class='bl_type'>".$shop_type.
        "</td><td class='bl_price'><strong>USD$".number_format((float)$shop_post["item_price"]/100, 2, '.', '')."</strong><br>per ".$shop_post["item_unit"].
        "</td><td class='bl_available'>".$shop_post['available'].
        "</td><td class='bl_visible'>".$shop_post['visible'].
        "</td><td><a href='shop_editor.php?id=$shop_id'><button type='button' class='btn btn-dark'>Edit</button></a>".
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
    var options = { valueNames: ['bl_id', 'bl_name', 'bl_type', 'bl_price', 'bl_available', 'bl_visible']};
    var linkList = new List('shop_links', options);
</script>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>