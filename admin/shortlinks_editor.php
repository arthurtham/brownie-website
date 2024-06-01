<?php

$dir = dirname(__DIR__, 1);
$title = "Shortlinks Editor";

require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

?>
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
    .blog-images img {
        width: auto;
        max-width: 400px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding: 10px;
    }
    video {
        width: auto;
        max-width: 300px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<div class="container body-container">
<?php

$shortlink_id = "-1";
$shortlink_shortcode = "";
$shortlink_fulllink = "https://www.browntulstar.com";
$shortlink_available = "0";
$shortlink_creationdate = "-1";
$can_change_id = "readonly=\"readonly\"";
$result_message = "Pending SQL result";

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
    $result = $conn->query($sql);
    if ($result === TRUE) {
        $result_message = "<p>Success!</p><code>$sql</code>";
        $_GET["shortcode"] = $_POST["shortlink_shortcode"];
    } else {
        $result_message = "<p>Failure: $conn->error </p><code>$sql</code>";
    }
    $shortlink_id = $_POST['shortlink_id'];
    $shortlink_shortcode = $_POST['shortlink_shortcode'];
    $shortlink_fulllink = $_POST['shortlink_fulllink'];
    $shortlink_available = $_POST['shortlink_available'];
    $shortlink_creationdate = $_POST['shortlink_creationdate'];
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
        }
    }
}

if ($shortlink_available == "1") {
    $shortlink_available = "checked";
}

echo <<<FORM
<div class="row"><div class="col"><h1>Shortlinks Editor</h1><a href="shortlinks.php"><button type="button">Back to All Shortlinks</button></a></div></div>
<hr/>
<div class="row"><div class="col"><div class="card text-white bg-dark p-2">$result_message</div></div></div>
<hr/>
<div class="row">
    <div class="col col-md-12">
        <form action="shortlinks_editor.php" method="post">
            <label for ="shortlink_shortcode">Shortcode</label>: <div class="input-group"><span class="input-group-text"></span><input class="form-control" required pattern="^\S+$" type="text" id="shortlink_shortcode" name="shortlink_shortcode" value="$shortlink_shortcode" /></div>
            Current shortlink: https://browntulstar.com/r/$shortlink_shortcode<br/><br/>
            <label for ="shortlink_fulllink">Leads to</label>: <input class="form-control" required pattern="^\S+$" style="width:100%" type="url" id="shortlink_fulllink" name="shortlink_fulllink" value="$shortlink_fulllink" /><br/>
            <button id="preview-webpage-button" name="preview-webpage-button" type="button">Preview Full Link</button><button id="preview-webpage-external-button" name="preview-webpage-external-button" type="button">Popout Preview Full Link</button><br/>
            <label for ="shortlink_available">Active</label>: <input type="checkbox" id="shortlink_available" name="shortlink_available" value="1" $shortlink_available /><br/>
            <label for ="shortlink_id">ID</label>: <input requred hidden type="input" type="text" id="shortlink_id" name="shortlink_id" value="$shortlink_id" />$shortlink_id<br/>
            <label for ="shortlink_creationdate">Creation Date</label>: <input required hidden type="input" type="text" id="shortlink_creationdate" name="shortlink_creationdate" value="$shortlink_creationdate" />$shortlink_creationdate<br/>
            <button id="submit" name="submit">Send Request to Update Link</button><br/>
        </form>
    </div>
    <iframe id="preview-webpage" width=100% height=700px src=""> </iframe>
</div>
FORM;
?>
<script type="text/javascript">
    document.getElementById("preview-webpage-button").addEventListener("click", () => {
        document.getElementById("preview-webpage").src=document.getElementById("shortlink_fulllink").value;
    });
    document.getElementById("preview-webpage-external-button").addEventListener("click", () => {
        window.open(document.getElementById("shortlink_fulllink").value);
    });
</script>
</div>
<?php $_footer_adminmode = true; require $dir . "/templates/footer.php"; ?>