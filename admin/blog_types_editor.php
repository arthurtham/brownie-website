<?php

$dir = dirname(__DIR__, 1);
$title = "Blog Types Editor";

require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");



$blog_type_id = -1;
$blog_type_type = "";
$blog_type_name = "";
$blog_type_description = "";
$blog_type_visible = 0;
$can_change_id = "";

$result_message = "Make changes to the category and click 'Save Category' to save changes.";

if (isset($_POST["blog_type_id"])) {
    if ($_POST["blog_type_id"] === "-1") {
        $sql = "INSERT INTO blog_types (blog_type, name, description, visible) VALUES (";
        $sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_type_type"]) . "\", ";
        $sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_type_name"]) . "\", ";
        $sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_type_description"]) . "\", ";
        $sql .= "\"" . (isset($_POST["blog_type_visible"]) ? 1 : 0) . "\"";
        $sql .= ");";
    } else {
        $sql = "UPDATE blog_types SET ";
        $sql .= "blog_type=\"" . mysqli_real_escape_string($conn, $_POST["blog_type_type"]) . "\", ";
        $sql .= "name=\"" . mysqli_real_escape_string($conn, $_POST["blog_type_name"]) . "\", ";
        $sql .= "description=\"" . mysqli_real_escape_string($conn, $_POST["blog_type_description"]) . "\", ";
        $sql .= "visible=\"" . (isset($_POST["blog_type_visible"]) ? 1 : 0) . "\"";
        $sql .= " WHERE id=\"".mysqli_real_escape_string($conn, $_POST["blog_type_id"])."\";";
    }
    try {
        $result = $conn->query($sql);
        if ($result === TRUE) {
            $result_message = "Success!";
            $_GET["type"] = $_POST["blog_type_type"];
        } else {
            $result_message = "<p>Failure: $conn->error </p><code>$sql</code>";
        }
    } catch (Exception $e) {
        $result_message = "<p>Failure: $e </p><code>$sql</code>";
    }
}

if (isset($_GET["type"])) {
    $sql = "SELECT * FROM blog_types WHERE blog_type = '".mysqli_real_escape_string($conn, $_GET["type"])."' LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($blog_type_entry = $result->fetch_assoc()) {
            $blog_type_id = $blog_type_entry['id'];
            $blog_type_type = $blog_type_entry['blog_type'];
            $blog_type_name = htmlspecialchars($blog_type_entry['name']);
            $blog_type_description = htmlspecialchars($blog_type_entry['description']);
            $blog_type_visible = $blog_type_entry['visible'];
            $can_change_id = "readonly=\"readonly\"";
        }
    }
}

if ($blog_type_visible == "1") {
    $blog_type_visible = "checked";
}

echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Blog Types Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <div class="card text-white bg-dark p-2 mb-2">$result_message</div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <form id="post-editor" action="blog_types_editor.php" method="post">
                <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                    <div class="card-body" style="min-width: 500px">
                        <input class="d-none form-control" readonly=readonly required type="text" id="blog_type_id" name="blog_type_id" value="$blog_type_id" />
                        <small class="text-white">Once set, the category ID cannot be edited.</small>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <label for ="blog_type_type">Category ID</label>
                            </span>
                            <input class="form-control" $can_change_id required maxlength="45" pattern="^\S+$" type="text" id="blog_type_type" name="blog_type_type" value="$blog_type_type" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <label for ="blog_type_name">Display Name</label>
                            </span>
                            <input class="form-control" required maxlength="45" pattern="^\S+$" type="text" id="blog_type_name" name="blog_type_name" value="$blog_type_name" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <label for ="blog_type_description">Description</label>
                            </span>
                            <input class="form-control" required maxlength="255" type="text" id="blog_type_description" name="blog_type_description" value="$blog_type_description" />
                        </div>
                        <small class="text-white">Categories can be hidden from the listings page,<br>but individual posts have their own published/visible settings.</small>
                        <div class="input-group mb-3" style="max-width:500px">
                            <span class="input-group-text"><label for ="blog_type_visible">Show Category on Blog Listings</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="blog_type_visible" name="blog_type_visible" value="1" $blog_type_visible />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mb-2">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Save Category</button> 
                            <a href="blog_types.php"><button type="button" class="btn btn-danger">Cancel (Back to Blog Types List)</button></a>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>
FORM;

require $dir . "/templates/admin-check-script.php";
?>
</div>
<?php $_footer_adminmode = true; require $dir . "/templates/footer.php"; ?>