<?php
$dir = dirname(__DIR__, 1);

require $dir . "/includes/default-includes.php";
require_once($dir . "/includes/mysql.php");
require $dir . "/includes/admin-check.php";
?>

<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
</style>
</head>
<body>
    <div class='container'>
        <div class='row'>
            <div class='col'>
<?php
if (!isset($_GET["request-id"])) {
    echo '<h1>Request Manager</h1>';
    echo '<p>Enter the request ID of the service you are looking for.</p>';
    echo '<form action="." method="get">
			<input type="text" name="search-text" id="search-text" placeholder="Search..." value=""></input>
			<button type="submit">Search</button>
			</form>';
    $sql = "SELECT * FROM shop_item_requests INNER JOIN shop_item_types ON 
    shop_item_requests.item_id = shop_item_types.item_id
    ORDER BY request_date_created DESC";
    echo $sql;
    $result = $conn->query($sql);
    if (is_object($result) && $result->num_rows > 0) {
        echo "<table class='table'><tr><th>Request ID</th><th>Service</th><th>Request Date</th><th>Event Start Date</th><th>Event Name</th>";
        while ($item = $result->fetch_assoc()) {
            echo '<tr><td><a href="/admin/store.php?request-id='.$item['request_id'].'">'.$item['request_id']."</a>".
            "</td><td>".$item['item_name'].
            "</td><td>".$item['request_date_created'].
            "</td><td>".$item['event_start_date'].
            "</td><td>".$item['event_name'].
            "</tr>";
        }
        echo "</table>";

    } else {
        echo '<p>(No requests...)</p>';
    }

} else {
    $sql = "SELECT * FROM shop_item_requests INNER JOIN shop_item_types ON 
    shop_item_requests.item_id = shop_item_types.item_id
    WHERE request_id = \"". mysqli_real_escape_string($conn, $_GET["request-id"])."\" LIMIT 1";
    #echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($item = $result->fetch_assoc()) {
            $item_name = $item["item_name"];
            $item_type = $item["item_type"];
            $item_description = $item["item_description"];
            $item_price = $item["item_price"];
            $item_units = $item["item_units"];
            $item_id = $item["item_id"];

            $item_quantity = $item["item_quantity"];
            $discord_username = $item["user_discord_name"];
            $user_name = $item["user_name"];
            $user_email = $item["user_email"];
            $event_name = $item["event_name"];
            $event_start_date = $item["event_start_date"];
            $event_end_date = $item["event_end_date"];
            $user_notes = $item["user_notes"];
            $admin_notes = $item["admin_notes"];
            $request_status = $item["request_status"];
            $admin_notes = $item["admin_notes"];
            $request_status = $item["request_status"];
            $request_id = $item["request_id"];

            echo <<<FORM
            <hr />
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                            <h2>Manage</h2>
                            <form action="/admin/store_process.php" method="post">
                                <input hidden name="request-id" id="request-id" value="$request_id" />
                                <label>Request ID: </label>
                                <input disabled style="width:100%" value="$request_id" /><br />
                                <label for="request-status">Request Status: </label>
                                <select name="request-status">
                                    <option rid="0" value="0">Not started/viewed</option>
                                    <option rid="1" value="1">Waitlisted</option>
                                    <option rid="2" value="2">Rejected</option>
                                    <option rid="3" value="3">Communicating terms via email</option>
                                    <option rid="4" value="4">Pending PayPal Invoice</option>
                                    <option rid="5" value="5">Request confirmed</option>
                                    <option rid="6" value="6">Request completed</option>
                                    <option rid="7" value="7">Request closed</option>
                                </select><br/>
                                <label for="admin-comments">Admin Notes: </label><br/>
                                <textarea id="admin-comments" name="admin-comments" style="width:100%">$admin_notes</textarea><br/>
                                <button class="btn btn-primary" id="submit" name="submit">Update Status</button>
                                <a href="/admin/store.php"><button class="btn btn-primary" type="button">Back to Requests Page</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-12">
                        <form action="" method="post">
                            <input hidden type="number" id="item-id" name="item-id" value="$item_id"/>
                            <div class="card">
                                <div class="card-body">
                                    <h3>Service Information</h3>
                                    <strong>Service Item: </strong> $item_name <br/>
                                    <p>$item_description</p>
                                    <hr>
                                    <strong>Cost: $$item_price per $item_units </strong><br/>
                                    <label for ="total-items">Number of $item_units's</label>: 
                                        <input disabled type="number" style="width:12rem" type="text" id="total-items" name="total-items" value="$item_quantity" required/>
                                        <br/>
                                    <label for ="total-cost">Total Cost</label>: 
                                        <input disabled type="text" step="0.01" style="width:12rem" type="text" id="total-cost" name="total-cost" value="" />
                                        <br/>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h3>Personal Information</h3>
                                    <label for ="">Contact's Name</label>: 
                                        <input disabled style="width:12rem" type="text" id="user-name" name="user-name" value="$user_name" required />
                                        <br/>
                                    <label for ="">Contact's Email Address</label>: 
                                        <input disabled type="email" style="width:12rem" type="text" id="user-email" name="user-email" value="$user_email" placeholder="turtle@browntulstar.com" required />
                                        <br/>
                                    <label for ="">Contact's Discord Handle</label>: <span>$discord_username</span>
                                        <br/>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h3>Event Details </h3>
                                    <label for ="event-name">Event Name</label>: 
                                        <input disabled style="width:12rem" type="text" id="event-name" name="event-name" value="$event_name" required />
                                        <br/>
                                    <label for ="event-start-date">Event Start Date</label>: 
                                        <input disabled type="datetime-local" id="event-start-date" name="event-start-date" value="$event_start_date" required />
                                        <br/>
                                    <label for ="event-end-date">Event End Date</label>: 
                                        <input disabled type="datetime-local" id="event-end-date" name="event-end-date" value="$event_end_date" required />
                                        <br/>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <h3>Additional Information</h3>
                                    <span>What is your event about? How is it formatted? Where will it take place?
                                    How will you use Browntul as a caster? How can I benefit you as much
                                    as you benefit me? Are there promotional materials where I can learn more?</span>
                                        <textarea disabled id="event-user-notes" name="event-user-notes" value="" style="width:100%;height:12rem">$user_notes</textarea>
                                        <br/>
                                </div>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
FORM;
        }
    }
}

?>

            </div>
        </div>
    </div>
</body>

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
    updateCost({target: {value: <?php echo $item_quantity ?>}});
    function updateCountAndCost(event) {
        validateCount(event);
        updateCost(event);
    }
    function updateStatus() {
        document.querySelector("[rid='<?php  echo $request_status ?>']").setAttribute("selected", "1");
    }
    updateStatus();
    document.querySelector("#total-items").addEventListener("change", updateCountAndCost);
</script>

</html>