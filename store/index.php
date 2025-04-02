<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Store and Services";
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
    <h1 style="text-align: center;">Store and Services</h1>
    <center>
        <p>Please check out the services that I offer, downloadable digital assets from my store, and other ways to support me.</p>
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
    switch ($directory[0]) {
        //Special case for donate, otherwise just query
        case "donate":
            echo "<hr style='margin-top: 0 !important; margin-bottom: 10px !important'>";
            require $dir . "/templates/sub-perks-description.php";
            echo "<hr style='margin-top: 0 !important; margin-bottom: 10px !important'><h4>All Options</h4>";
            queryShopItems($conn, "donate");
            break;
        default:
            queryShopItems($conn, $directory[0]);
            break;
    }
    echo "</div>";
}
echo "</div>";

echo "</div>";


function queryShopItems($conn, $queryString) {
    $sql = "SELECT * FROM shop_item_types WHERE item_type = '".$queryString."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $cldSigner = new CloudinarySigner();
        while ($item = $result->fetch_assoc()) {
            $item_thumbnail = $cldSigner->signUrl($cldSigner->convertLocalUrlsToCloudinaryUrls($item["item_thumbnail"]));
            $item_name = $item["item_name"];
            $item_type = $item["item_type"];
            $item_description = $item["item_description"];
            $item_price = number_format($item["item_price"], 2);
            $item_units = $item["item_units"];
            $item_id = $item["item_id"];
            $item_url = $item["item_url"];
            $item_service = $item["item_service"];
            $available = $item["available"] ? 1 : 0;
            if ($available) {
                if ($item_service === "email") {
                    $book_button = '<a href="'.$item_url.'?subject=Inquiry for '.$item_name.'&body=(Describe your event and include dates 
    and times as well as information flyers)"><button class="btn btn-primary">Request</button></a> via email!
                <br><small>If the email conversation leads to a booking, PayPal will be used for invoicing.</small>';
                } elseif ($item_service === "Ko-fi" || $item_service === "Etsy" || $item_service === "Fiverr") {
                    $book_button = '<a href="'.$item_url.'" target="_blank"><button class="btn btn-primary">Get</button></a> on '.$item_service.'';
                } else {
                    $book_button = '<a href="'.$item_url.'" target="_blank"><button class="btn btn-primary">Support</button></a> via '.$item_service.'';
                }
            } else {
                $book_button = '<button class="btn btn-primary" disabled>Unavailable</button>';
            }
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
                                <h4><span class="badge rounded-pill bg-danger">USD$$item_price</span></h4><p><small>per $item_units</small></p>
                                <p class="card-text">
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