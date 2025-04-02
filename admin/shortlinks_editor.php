<?php

$dir = dirname(__DIR__, 1);
$title = "Shortlinks Editor";

require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");


$shortlink_id = "-1";
$shortlink_shortcode = "";
$shortlink_fulllink = "https://www.browntulstar.com";
$shortlink_available = "0";
$shortlink_creationdate = "-1";
$can_change_id = "readonly=\"readonly\"";
$result_message = "Make changes to the shortlink and click 'Save Shortlink' to save changes.";

if (isset($_POST["shortlink_id"])) {
    if ($_POST["shortlink_id"] === "-1") {
        $sql = "INSERT INTO shortlinks (shortcode, fulllink, available) VALUES (";
        $sql .= "\"" . mysqli_real_escape_string($conn, $_POST["shortlink_shortcode"]) . "\", ";
        $sql .= "\"" . mysqli_real_escape_string($conn, $_POST["shortlink_fulllink"]) . "\", ";
        $sql .= "\"" . (isset($_POST["shortlink_available"]) ? 1 : 0) . "\"";
        $sql .= ");";
    } else {
        $sql = "UPDATE shortlinks SET ";
        $sql .= "shortcode=\"" . mysqli_real_escape_string($conn, $_POST["shortlink_shortcode"]) . "\", ";
        $sql .= "fulllink=\"" . mysqli_real_escape_string($conn, $_POST["shortlink_fulllink"]) . "\", ";
        $sql .= "available=\"" . (isset($_POST["shortlink_available"]) ? 1 : 0) . "\"";
        $sql .= " WHERE id=\"".mysqli_real_escape_string($conn, $_POST["shortlink_id"])."\";";
    }
    try {
        $result = $conn->query($sql);
        if ($result === TRUE) {
            $result_message = "Success!";
            $_GET["shortcode"] = $_POST["shortlink_shortcode"];
        } else {
            $result_message = "<p>Failure: $conn->error </p><code>$sql</code>";
        }
        $shortlink_id = $_POST['shortlink_id'];
        $shortlink_shortcode = $_POST['shortlink_shortcode'];
        $shortlink_fulllink = $_POST['shortlink_fulllink'];
        $shortlink_available = $_POST['shortlink_available'];
        $shortlink_creationdate = $_POST['shortlink_creationdate'];
    } catch (Exception $e) {
        $result_message = "<p>Failure: $e </p><code>$sql</code>";
    }
}

if (isset($_GET["shortcode"])) {
    $sql = "SELECT * FROM shortlinks WHERE shortcode = '".mysqli_real_escape_string($conn, $_GET["shortcode"])."' LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($shortlink_entry = $result->fetch_assoc()) {
            $shortlink_id = $shortlink_entry['id'];
            $shortlink_shortcode = $shortlink_entry['shortcode'];
            $shortlink_fulllink = $shortlink_entry['fulllink'];
            $shortlink_hits = $shortlink_entry['hits'];
            $shortlink_available = $shortlink_entry['available'];
            $shortlink_creationdate = $shortlink_entry['creationdate'];
            $shortlink_creationdate_formatted = DateTime::createFromFormat('Y-m-d H:i:s', $shortlink_creationdate)->format("F d, Y h:i A");
        }
    }
}

if ($shortlink_available == "1") {
    $shortlink_available = "checked";
}

echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Shortlinks Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <div class="card text-white bg-dark p-2 mb-2">$result_message</div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <form id="post-editor" action="shortlinks_editor.php" method="post">
                <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                    <div class="card-body" style="min-width: 500px">
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <label for ="shortlink_shortcode">Shortcode</label>
                            </span>
                            <input class="form-control" required pattern="^\S+$" type="text" id="shortlink_shortcode" name="shortlink_shortcode" value="$shortlink_shortcode" />
                        </div>
                        <div class="alert alert-info" role="alert">
                            Current shortlink: <a href="/r/$shortlink_shortcode" target="_blank">https://browntulstar.com/r/$shortlink_shortcode</a>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <label for ="shortlink_fulllink">Destination Link</label>
                            </span>
                            <input class="form-control" required pattern="^\S+$" type="url" id="shortlink_fulllink" name="shortlink_fulllink" value="$shortlink_fulllink" />
                        </div>
                        <div class="alert alert-light">
                            <label for ="shortlink_available">Active</label>: <input type="checkbox" id="shortlink_available" name="shortlink_available" value="1" $shortlink_available /><br/>
                            <label for ="shortlink_id">ID</label>: <input requred hidden type="input" type="text" id="shortlink_id" name="shortlink_id" value="$shortlink_id" />$shortlink_id<br/>
                            <label for ="shortlink_creationdate">Creation Date</label>: <input required hidden type="input" type="text" id="shortlink_creationdate" name="shortlink_creationdate" value="$shortlink_creationdate" />$shortlink_creationdate_formatted
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mb-2">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Save Shortlink</button> 
                            <button class="btn btn-warning" id="preview-webpage-external-button" name="preview-webpage-external-button" type="button">Popout Preview Full Link</button>
                            <a href="shortlinks.php"><button type="button" class="btn btn-danger">Cancel (Back to Shortlinks List)</button></a>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>
FORM;
?>
<script type="text/javascript">
    document.getElementById("preview-webpage-external-button").addEventListener("click", () => {
        window.open(document.getElementById("shortlink_fulllink").value);
    });
</script>
<?php
require $dir . "/templates/admin-check-script.php";
?>
</div>
<?php $_footer_adminmode = true; require $dir . "/templates/footer.php"; ?>