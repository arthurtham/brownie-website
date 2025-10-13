<?php

$dir = dirname(__DIR__, 1);
$title = "Alert Editor";

require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");


$alert_id = "1";
$alert_title = "Title";
$alert_contents = "This is an alert text.";
$alert_url = "";
$alert_popout = "0";
$alert_active = "0";
$alert_creationdate = "-1";
$alert_creationdate_formatted = "Never";
$can_change_id = "readonly=\"readonly\"";

$var_dump_variable = null;
// if (isset($_GET["shortcode"])) {
    $sql = "SELECT * FROM alert_posts WHERE id = 1 LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($alert_entry = $result->fetch_assoc()) {
            $var_dump_variable = var_export($alert_entry, true);
            // $alert_id = $alert_entry['id'];
            $alert_id = 1;
            $alert_title = $alert_entry['alert_title'];
            $alert_contents = $alert_entry['alert_contents'];
            $alert_url = $alert_entry['alert_url'];
            $alert_popout = $alert_entry['alert_popout'];
            $alert_active = $alert_entry['alert_active'];
            $alert_creationdate = $alert_entry['alert_modified_date'];
            $alert_creationdate_formatted = DateTime::createFromFormat('Y-m-d H:i:s', $alert_creationdate)->format("F d, Y h:i A");
        }
    }
// }

if ($alert_active == "1") {
    $alert_active = "checked";
}

if ($alert_popout == "1") {
    $alert_popout = "checked";
}


echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Alert Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <form id="post-editor" action="alert_process.php" method="post">
                <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                    <div class="card-body" style="min-width: 500px">
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <label for ="alert_contents">Alert Title (For Internal Use)</label>
                            </span>
                            <input class="form-control" required maxlength="100" type="text" id="alert_title" name="alert_title" value="$alert_title" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <label for ="alert_contents">Alert Contents</label>
                            </span>
                            <input class="form-control" required maxlength="256" type="text" id="alert_contents" name="alert_contents" value="$alert_contents" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <label for ="alert_url">Button URL (optional)</label>
                            </span>
                            <input class="form-control" pattern="^\S+$" maxlength="256" type="url" id="alert_url" name="alert_url" placeholder="(Leave blank for no button)" value="$alert_url" />
                        </div>
                        <div class="alert alert-light">
                            <label for ="alert_active">Activate Alert</label>: <input type="checkbox" id="alert_active" name="alert_active" value="1" $alert_active /><br/>
                            <label for ="alert_popout">Open URL in New Tab</label>: <input type="checkbox" id="alert_popout" name="alert_popout" value="1" $alert_popout /><br/>
                            <input required hidden type="input" type="text" id="alert_id" name="alert_id" value="$alert_id" />
                            <label for ="shortlink_creationdate">Last Modified</label>: <input required hidden type="input" type="text" id="alert_creationdate" name="alert_creationdate" value="$alert_creationdate" />$alert_creationdate_formatted
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mb-2">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Save Alert</button> 
                            <button class="btn btn-warning" id="preview-webpage-external-button" name="preview-webpage-external-button" type="button">Preview URL</button>
                            <a href="index.php"><button type="button" class="btn btn-danger">Cancel (Back to Admin Home)</button></a>
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
        window.open(document.getElementById("alert_url").value);
    });
</script>
<?php
require $dir . "/templates/admin-check-script.php";
?>
</div>
<?php $_footer_adminmode = true; require $dir . "/templates/footer.php"; ?>