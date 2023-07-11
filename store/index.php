<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Services";
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
    <h1 style="text-align: center;">Services</h1>
    <p>Welcome to the services page. Here, you can request the services of Browntul that is offering.</p>
    <div class='alert alert-success' role='alert'>
        <center>Request a service using email!</center>
	</div>

<?php
$directories = array();
array_push($directories, array("shoutcasting", "Shoutcasting", "Want Browntul to shoutcast your games? Check out the services you can request below!<br/>Currently, Browntul is offering shoutcasting services for VALORANT."));
//array_push($directories, array("merch", "Merchandise", "Check out the merchandise store where you can flex your Turtle Pond gear!"));
array_push($directories, array("donate", "Donate", "Directly support Browntul through these methods!"));
// $sql = "SELECT blog_type, name, description FROM blog_types";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         array_push($directories, array($row["blog_type"],$row["name"],$row["description"]));
//     }
// }
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
            //TODO: add the listings
            $sql = "SELECT * FROM shop_item_types WHERE item_type = 'shoutcasting'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($item = $result->fetch_assoc()) {
                    $item_name = $item["item_name"];
                    $item_type = $item["item_type"];
                    $item_description = $item["item_description"];
                    $item_price = number_format($item["item_price"], 2);
                    $item_units = $item["item_units"];
                    $item_id = $item["item_id"];
                    $available = $item["available"] ? 1 : 0;
                    $book_button = $available ? '<a href="mailto:browntulstar@browntulstar.com?subject=Booking Inquiry for '.
                    $item_name.'&body=(Describe your event and include dates and times as well as information flyers)"><button class="btn btn-primary">Book now</button></a> via email!
                    <br><small>If the email conversation leads to a booking, PayPal will be used for invoicing.</small>' : '<button class="btn btn-primary" disabled>Unavailable</button>'; 
                    // Original code: '<a href="/store/book?item-id='.$item_id.'"><button class="btn btn-primary">Book now</button> via email</a>'
                    echo <<<LISTINGS
                    <div class="card" style="width: 100%;color:black">
                        <!--<img src="..." class="card-img-top" alt="...">-->
                        <div class="card-body">
                            <h5 class="card-title">$item_name</h5>
                            <p class="card-text">
                                $item_description
                            </p>
                            <p><span class="badge bg-danger"> Cost: USD$$item_price per $item_units</span></p>
                            $book_button
                        </div>
                    </div>
                    <br />
LISTINGS;
                }
            }
        break;
        /*case "merch":
            echo "<p>Use the link below to access the merchandise store. If you are subscribed to Browntul on Twitch, you can enjoy a discount on your merchandise purchased.</p>
            <p><image src='https://cdn.streamelements.com/merch/static/se-merch-logo-dark.svg' /></p>
            <p><a href='https://merch.streamelements.com/browntulstar' target='_blank'><button class='btn btn-primary'>Go to Store</button></a></p>";
            break;*/
        case "donate":
            echo "<p>Use the link below to donate to Browntul! Note that donations are not refundable.</p>
            <p><a href='https://streamelements.com/browntulstar/tip' target='_blank'><button class='btn btn-primary'>Donate (StreamElements)</button></a></p>
            <p>You can also buy Browntul gift cards and plushies, via Throne Gifts! Use the link below to donate with this method:</p>
            <a href='https://thronegifts.com/u/browntulstar' target='_blank'><img height='60' style='border:0px;height:60px;' src='https://firebasestorage.googleapis.com/v0/b/onlywish-9d17b.appspot.com/o/common%2Fbrandassets%2FWishlistButton_V1.png?alt=media&token=dafe4567-b095-48c4-9a09-6abfd14ee04f' border='0' alt='My Wishlist' /></a>";
        default:
            break;
    }
    echo "</div>";
}
echo "</div>";

?>

</div>
<?php require $dir . "/templates/footer.php" ?>