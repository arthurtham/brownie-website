<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Support";
require_once($dir . "/includes/mysql.php");
require $dir . "/templates/header.php";
echo '<script src="/assets/js/bootstrap-tab.js"></script>';
?>

<style>
    .body-container hr {
        margin-top:50px !important;
        margin-bottom:50px !important;
    }
</style>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 style="text-align: center;">Support Browntul</h1>
    <center>
        <p>Thank you for supporting me! Please take a look at ways you can support me.</p>
    </center>

<?php
$directories = array();
array_push($directories, array("donate", "Donate", "Directly support Browntul via these options!<br/>For subscriptions, all prices listed below are rates for the lowest subscription tier."));
array_push($directories, array("shoutcasting", "Shoutcasting", "Want Browntul to shoutcast your games? Check out the services you can request below!<br/>All prices listed below are starting rates."));
array_push($directories, array("merch", "Store", "Check out these featured store items that you can purchase for a one-time fee!"));

echo '<ul class="nav nav-tabs" id="storedirectory" role="tablist">';
$show_active_toggle = "true";
$show_active_text = "active";
foreach ($directories as $directory) {
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
$show_active_toggle = "false";
$show_active_text = "";
}
echo "</ul>";
echo '<div class="tab-content bg-dark" id="storedirectorycontent" style="padding:20px;color:white">';
$show_active_toggle = true;
foreach ($directories as $directory) {	
    echo '<div class="tab-pane fade';
    if ($show_active_toggle) {
        echo ' show active';
        $show_active_toggle = false;
    }
    echo '" id="'.$directory[0].'-tab-content" role="tabpanel" aria-labelledby="'.$directory[0].'-tab-content">';
    echo "<h3>" . $directory[1] . "</h3>";
    echo "<small>" . $directory[2] . "</small><br><br>";

    // Select listings
    switch ($directory[0]) {
        case "shoutcasting":
            queryShopItems($conn, "shoutcasting"); 
            break;
        case "donate":
            queryShopItems($conn, "donate");
        default:
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
        while ($item = $result->fetch_assoc()) {
            $item_thumbnail = $item["item_thumbnail"];
            $item_name = $item["item_name"];
            $item_type = $item["item_type"];
            $item_description = $item["item_description"];
            $item_price = number_format($item["item_price"], 2);
            $item_units = $item["item_units"];
            $item_id = $item["item_id"];
            $item_url = $item["item_url"];
            $item_service = $item["item_service"];
            $available = $item["available"] ? 1 : 0;
            $book_button = $available ? 
            $item_service === "email" ? 
                '<a href="'.$item_url.'?subject=Inquiry for '.$item_name.'&body=(Describe your event and include dates 
    and times as well as information flyers)"><button class="btn btn-primary">Request</button></a> via email!
                <br><small>If the email conversation leads to a booking, PayPal will be used for invoicing.</small>' 
                : '<a href="'.$item_url.'" target="_blank"><button class="btn btn-primary">Support</button></a> via '.$item_service.'' 
            : '<button class="btn btn-primary" disabled>Unavailable</button>'; 
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
    }
}

require $dir . "/templates/footer.php";

?>