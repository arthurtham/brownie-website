<?php

$dir = dirname(__DIR__, 1);
$title = "Shop Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");
require_once $dir . "/includes/CloudinarySigner.php";

$shop_id = 0;
$shop_name = "";
$shop_type = "shoptype";
$shop_visible = false;
$shop_available = false;
$shop_description = "";
$shop_summary = "";
$shop_url = "";
$shop_thumbnail = "";
$shop_price = 0;
$shop_price_formatted = "";
$shop_unit = "";
$shop_platform = "";


if (isset($_GET["id"])) {
    $sql = "SELECT * FROM shop_posts WHERE id = \"".mysqli_real_escape_string($conn, $_GET["id"])."\" LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($shop_post = $result->fetch_assoc()) {
            $shop_id = $shop_post["id"];
            $shop_name = htmlspecialchars($shop_post["item_name"]);
            $shop_type = $shop_post["item_category"];
            $shop_visible = $shop_post["visible"];
            $shop_available = $shop_post["available"];
            $shop_description = $shop_post["item_description"];
            $shop_summary = htmlspecialchars($shop_post["item_summary"]);
            $shop_price = $shop_post["item_price"];
            $shop_price_formatted = number_format((float)$shop_price / 100, 2, '.', '');
            $shop_unit = htmlspecialchars($shop_post["item_unit"]);
            $shop_platform = htmlspecialchars($shop_post["item_platform"]);
            $shop_url = htmlspecialchars($shop_post["item_url"]);
            $shop_thumbnail = htmlspecialchars($shop_post["item_thumbnail"]);
        }
    }
    $cldSigner = new CloudinarySigner();
    $shop_description = $cldSigner->convertAllUrls($shop_description);
}

if ($shop_visible == "1") {
    $shop_visible = "checked";
}
if ($shop_available == "1") {
    $shop_available = "checked";
}

$shop_types = array();
$sql = "SELECT shop_type, name, description FROM shop_types";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($shop_types, $row["shop_type"]);
    }
}
$html_shop_types = "<span class=\"input-group-text\"><label for ='shop_type'>Category</label></span><select required class=\"form-control\" name='shop_type' id='shop_type'>";
foreach ($shop_types as $entry) {
    $html_shop_types .= "<option value=\"$entry\" ". ($shop_type === $entry ? "selected" : "") .">$entry</option>";
}
$html_shop_types .= "</select>";

echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Shop Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <form id="post-editor" action="shop_process.php" method="post">
                <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                    <div class="card-body" style="min-width: 500px">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="shop_name">Name</label></span>
                            <input required minlength="1" maxlength="255" class="form-control" type="text" id="shop_name" name="shop_name" value="$shop_name" /> 
                        </div>
                        <div class="input-group mb-3" style="display:none">
                            <span class="input-group-text"><label for ="shop_id">ID</label></span>
                            <input readonly class="form-control" type="number" id="shop_id" name="shop_id" value="$shop_id" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="shop_summary">Summary</label></span>
                            <input required minlength="1" maxlength="255" class="form-control" type="text" id="shop_summary" name="shop_summary" value="$shop_summary" /> 
                        </div>
                        <div class="input-group mb-3">
                        $html_shop_types
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="shop_price">Price (USD$)</label></span>
                            <input required class="form-control" type="number" 
                            placeholder="0.00"
                            step="0.01"
                            max="999999.99"
                            min="0.00"
                            id="shop_price_display" name="shop_price_display" value="$shop_price_formatted" oninput="updateShopPrice()" />
                            <input required type="hidden" id="shop_price" name="shop_price" value="$shop_price" />
                            <script>
                                function updateShopPrice() {
                                    const displayPrice = document.getElementById('shop_price_display').value;
                                    const hiddenPrice = document.getElementById('shop_price');
                                    hiddenPrice.value = Math.round(parseFloat(displayPrice) * 100) || 0;
                                }
                            </script>
                            <span class="input-group-text"><label for ="shop_unit">per</label></span>
                            <input required maxlength="255" class="form-control" type="text" placeholder="unit" id="shop_unit" name="shop_unit" value="$shop_unit" />
                            <span class="input-group-text"><label for ="shop_platform">on</label></span>
                            <input maxlength="64" class="form-control" type="text" placeholder="platform" id="shop_platform" name="shop_platform" value="$shop_platform" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="shop_url">URL</label></span>
                            <input required minlength="1" maxlength="255" class="form-control" type="text" id="shop_url" name="shop_url" value="$shop_url" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="shop_thumbnail">Thumbnail</label></span>
                            <input maxlength="255" class="form-control" type="text" id="shop_thumbnail" name="shop_thumbnail" value="$shop_thumbnail" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="shop_visible">Show on Shop Listings</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="shop_visible" name="shop_visible" value="1" $shop_visible />
                            </span>
                            <span class="input-group-text"><label for ="shop_available">Activate Link</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="shop_available" name="shop_available" value="1" $shop_available />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mb-2">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Save Shop Item</button> 
                            <a href="shop.php"><button class="btn btn-danger" type="button">Cancel (Back to Shop Listings)</button></a>
                        </div>
                        <div class="mb-2">
                            <a target="_blank" href="cloudinary.php"><button class="btn btn-light" type="button">Cloudinary Media Signer</button></a>
                        </div>
                    </div>
                </div>
                <div class="card bg-light mb-2 post-contents" style="z-index:1020; height:200px">
                    <textarea style="display:none;width:100%;height:500px" id="shop_description" name="shop_description">$shop_description</textarea><br/>
                </div>
            </form>
        </div>
    </div>
</div>
FORM;

$simplemde_element_name = "shop_description";
require $dir . "/templates/simplemde.php";

require $dir . "/templates/admin-check-script.php";

$_footer_adminmode = true;
require $dir . "/templates/footer.php";
?>