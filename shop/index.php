<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Turtle Shop";
require_once($dir . "/includes/mysql.php");
require $dir . "/templates/header.php";
require_once $dir . "/includes/CloudinarySigner.php";
echo '<script src="/assets/js/bootstrap-tab.js"></script>';
?>

<style>
    .body-container hr {
        margin-top:50px !important;
        margin-bottom:50px !important;
    }
</style>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 style="text-align: center;">Turtle Shop</h1>
    <center>
        <p>Check out ways to support Browntul via a subscription or through merch/digital storefronts!</p>
    </center>

<?php
$directories = array();
$sql = "SELECT shop_type, name, description FROM shop_types WHERE visible = 1";
$result = $conn->query($sql);
$_is_get_tab_valid = false;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($directories, array($row["shop_type"],$row["name"],$row["description"]));
        if (isset($_GET["tab"]) && $_GET["tab"] === $row["shop_type"]) {
            $_is_get_tab_valid = true;
        }
    }
}

echo '<div class="nav-tabs-div"><ul class="nav nav-tabs" id="storedirectory" role="tablist">';
$_first = true;
foreach ($directories as $directory) {
    if (($_first && !$_is_get_tab_valid) || ($_is_get_tab_valid && $_GET["tab"] === $directory[0])) {
        $show_active_toggle = "true";
        $show_active_text = "active";
    } else {
        $show_active_toggle = "false";
        $show_active_text = "";
    }
    $_first = false;
    echo <<<ITEM
    <li class="nav-item" role="presentation">
        <button 
        class="nav-link $show_active_text" 
        id="$directory[0]-tab" 
        data-bs-toggle="tab" 
        data-bs-target="#$directory[0]-tab-content" 
        type="button" 
        role="tab" 
        aria-controls="$directory[0]-tab" 
        aria-selected="$show_active_toggle">$directory[1]</button>
    </li>
ITEM;
}
echo "</ul></div>";
echo '<div class="tab-content bg-dark" id="storedirectorycontent" style="padding:20px;color:white">';
$_first = true;
foreach ($directories as $directory) {	
    echo '<div class="tab-pane fade';
    if (($_first && !$_is_get_tab_valid) || ($_is_get_tab_valid && $_GET["tab"] === $directory[0])) {
        echo ' show active';
    }
    $_first = false;
    echo '" id="'.$directory[0].'-tab-content" role="tabpanel" aria-labelledby="'.$directory[0].'-tab-content">';
    echo "<h3>" . $directory[1] . "</h3>";
    echo "<small>" . $directory[2] . "</small><br><br>";

    // Select listings
    queryShopItems($conn, $directory[0]);
    
    echo "</div>";
}
echo "</div>";

echo "</div>";


function queryShopItems($conn, $queryString) {
    $sql = "SELECT * FROM shop_posts WHERE visible=1 AND item_category = '". mysqli_real_escape_string($conn, $queryString) ."' ORDER BY item_name ASC;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $cldSigner = new CloudinarySigner();
        while ($item = $result->fetch_assoc()) {
            $item_thumbnail = ($item["item_thumbnail"] != "") ? $cldSigner->signUrl($cldSigner->convertLocalUrlsToCloudinaryUrls($item["item_thumbnail"])) : "https://res.cloudinary.com/browntulstar/image/private/s--OQR6SXc3--/c_pad,w_200,h_200,ar_1:1/f_webp/v1/com.browntulstar/img/turtle-adult.webp?_a=BAAAV6E0";
            $item_name = $item["item_name"];
            $item_summary = $item["item_summary"];
            $item_description = (new HTMLPurifier())->purify(Parsedown::instance()->setBreaksEnabled(true)->text($item["item_description"]));
            $item_price = $item["item_price"];
            $item_units = $item["item_unit"];
            $item_url = $item["item_url"];
            $item_service = $item["item_platform"];
            $available = $item["available"] ? 1 : 0;
            if ($available) {
                if ($item_service === "email") {
                    $book_button = '<a href="'.$item_url.'?subject=Inquiry for '.$item_name.'&body=(Describe your event and include dates 
    and times as well as information flyers)"><button class="btn btn-primary">Request info</button></a> via email!';
                } else {
                    $book_button = '<a href="'.$item_url.'" target="_blank"><button class="btn btn-primary">Get</button></a>' . ($item_service != null ? (' on '.$item_service.'') : '');
                }
            } else {
                $book_button = '<button class="btn btn-primary" disabled>Unavailable</button>';
            }
            $item_price_formatted = number_format((float)$item_price / 100, 2, '.', '');
            $cost_badge = ($item_price > 0) ? "<h4><span class=\"badge rounded-pill bg-danger\">USD$$item_price_formatted</span></h4><p><small>per $item_units</small></p>" : "<h4><span class=\"badge rounded-pill bg-success\">Free</span></h4>"; 

            echo <<<LISTINGS
            <div class="card" style="width: 100%;color:black">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <center><img src="$item_thumbnail" style="max-height: 200px; max-width: 100%;" /></center>
                                <br />
                            </div>
                            <div class="col-lg-8">
                                <h4 class="card-title">$item_name</h4>
                                $cost_badge
                                <p class="card-text">
                                    <em>$item_summary</em><br />
                                    $item_description
                                </p>
                                $book_button
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br />
LISTINGS;
        }
    } else {
        echo "<hr style='margin-top: 0 !important; margin-bottom: 10px !important'><h6>Nothing to see here. Check back soon!</h6>";
    }
}

require $dir . "/templates/footer.php";

?>