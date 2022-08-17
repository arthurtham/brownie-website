<?php
$dir = dirname(__DIR__, 2);
$title = "BrowntulStar - Book a Service";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");
echo '<script src="/assets/js/bootstrap-tab.js"></script>';
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 style="text-align: center;">Book Service</h1>

<?php
if (!isset($_SESSION['user'])) { 
	echo "<div class='alert alert-danger' role='alert'>
	<center>You need to log in to Discord before viewing this page. You can fill out the rest of the information once you log in!</center>";
	echo "</div>";
} else if (!isset($_GET["item-id"])) {
    echo "<div class='alert alert-danger' role='alert'>
	<center>Please go to the Store page to specify the service you'd like to book.</center>";
	echo "</div>";
} else { // User is logged in
	

$sql = "SELECT * FROM shop_item_types WHERE item_id = ".mysqli_real_escape_string($conn, $_GET["item-id"])." AND available = 1 LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($item = $result->fetch_assoc()) {
        $item_name = $item["item_name"];
        $item_type = $item["item_type"];
        $item_description = $item["item_description"];
        $item_price = $item["item_price"];
        $item_units = $item["item_units"];
        $item_id = $item["item_id"];
   
        $discord_username = $_SESSION['username'] . "#" . $_SESSION['discrim'];
        $discord_id = $_SESSION['user_id'];

        echo <<<FORM
        <hr />
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="/store"><button class="btn btn-primary" type="button">Back to Store Page</button></a>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col col-md-12">
                    <form action="/store/book/process.php" method="post">
                        <input hidden type="number" id="item-id" name="item-id" value="$item_id"/>
                        <div class="card">
                            <div class="card-body">
                                <h3>Your Selected Service</h3>
                                <strong>Service Item: </strong> $item_name <br/>
                                <p>$item_description</p>
                                </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2>Cost</h2>
                                <strong>Cost per $item_units: $$item_price</strong><br/>
                                <strong><label for ="total-items">Quantity</label></strong>: 
                                    <input type="number" style="width:4rem" type="text" id="total-items" name="total-items" value="1" required/>
                                    <br/>
                                    <strong><label for ="total-cost">Total Cost</label></strong>: 
                                    <input disabled type="text" step="0.01" style="width:12rem" type="text" id="total-cost" name="total-cost" value="" />
                                    <br/>
                                    <span>If your request is accepted, you will be invoiced for the total cost listed above.</span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h3>Personal Information</h3>
                                <strong><label for ="">Contact's Name</label></strong>:<br/> 
                                    <input style="width:12rem" type="text" id="user-name" name="user-name" value="" required />
                                    <br/>
                                <strong><label for ="">Contact's Email Address</label></strong>:<br/> 
                                    <input type="email" style="width:12rem" type="text" id="user-email" name="user-email" value="" placeholder="turtle@browntulstar.com" required />
                                    <br/>
                                <strong><label for ="">Contact's Discord Handle</label></strong>:<br/> <span><em>$discord_username</em></span>
                                    <input hidden style="width:12rem" type="text" id="user-discord-name" name="user-discord-name" value="$discord_username" required />
                                    <input hidden style="width:12rem" type="text" id="user-discord-id" name="user-discord-id" value="$discord_id" required />
                                    <br/>
                                    To change the Discord username handle, log in to the Discord account you'd like to use.
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h3>Event Details </h3>
                                <strong><label for ="event-name">Event Name</label></strong>:<br/>
                                    <input style="width:12rem" type="text" id="event-name" name="event-name" value="" required />
                                    <br/>
                                <strong><label for ="event-start-date">Event Start Date</label></strong>:<br/> 
                                    <input type="datetime-local" id="event-start-date" name="event-start-date" value="" required />
                                    <br/>
                                <strong><label for ="event-end-date">Event End Date</label></strong>:<br/> 
                                    <input type="datetime-local" id="event-end-date" name="event-end-date" value="" required />
                                    <br/>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h3>Additional Information</h3>
                                <ul>
                                    <li>What is your event about?</li>
                                    <li>How is it formatted?</li>
                                    <li>Where will it take place?</li>
                                    <li>How will you use Browntul as a caster? </li>
                                    <li> How can I benefit you as much as you benefit me? </li>
                                    <li> Are there promotional materials where I can learn more?</li>
                                </ul>
                                    <textarea id="event-user-notes" name="event-user-notes" value="" style="width:100%;height:12rem"></textarea>
                                    <br/>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                    <h2>Submit</h2>
                                    <p>Double check the information above! You won't be able to change your request after submitting.</p>
                                    <button class="btn btn-primary" id="submit" name="submit">Submit Request</button>
                            </div>
                        </div>
                                    
                        
                    </form>
                </div>
            </div>
        </div>
FORM;
        }
    }  else {
        echo "<p><strong>This item you are requesting does not exist or is out of commission.</strong></p>";
    }
}
?>

    </div>

<?php require $dir . "/templates/footer.php" ?>

<?php // Script ?>
<script>
    function validateCount(event) {
        const totalItems = document.querySelector("#total-items");
        if (totalItems.value < 0) {
            totalItems.value = 0;
        }
    }
    function updateCost(event) {
        document.querySelector("#total-cost").value = "$" + (event.target.value * <?php echo $item_price ?>);
    }
    updateCost({target: {value: 1}});
    function updateCountAndCost(event) {
        validateCount(event);
        updateCost(event);
    }
    document.querySelector("#total-items").addEventListener("change", updateCountAndCost);
</script>