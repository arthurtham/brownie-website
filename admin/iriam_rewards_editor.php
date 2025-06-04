<?php

$dir = dirname(__DIR__, 1);
$title = "IRIAM Rewards Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");
require_once $dir . "/includes/cloudinary.env.php";
require_once $dir . "/includes/CloudinarySigner.php";
use Cloudinary\Api\Search\SearchApi;

$iriam_reward_download_id = "";
$iriam_reward_name = "";
$iriam_reward_type = "announcement";
$iriam_reward_published = false;
$iriam_reward_thumbnail = "";
$iriam_reward_1star = false;
$iriam_reward_2star = false;
$iriam_reward_3star = false;
$iriam_reward_description = "";
$iriam_reward_date = "2022-1-1 00:00:00";

$_temp = null;
if (isset($_GET["public-id"])) {
    $sql = "SELECT * FROM iriam_rewards WHERE iriam_reward_download_id = \"".mysqli_real_escape_string($conn, $_GET["public-id"])."\" LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($iriam_reward_post = $result->fetch_assoc()) {
            $iriam_reward_download_id = htmlspecialchars($iriam_reward_post['iriam_reward_download_id']);
            $iriam_reward_name = htmlspecialchars($iriam_reward_post['iriam_reward_name']);
            $iriam_reward_type = htmlspecialchars($iriam_reward_post['iriam_reward_type']);
            $iriam_reward_published = $iriam_reward_post['published'];
            $iriam_reward_thumbnail = htmlspecialchars($iriam_reward_post['iriam_reward_thumbnail']);
            $iriam_reward_1star = $iriam_reward_post['1star'];
            $iriam_reward_2star = $iriam_reward_post['2star'];
            $iriam_reward_3star = $iriam_reward_post['3star'];
            $iriam_reward_description = htmlspecialchars($iriam_reward_post['iriam_reward_description']);
            $iriam_reward_date = $iriam_reward_post['iriam_reward_date'];
            $_temp = var_export($iriam_reward_post,true);
        }
    }
}

if ($iriam_reward_published == "1") {
    $iriam_reward_published = "checked";
}
if ($iriam_reward_1star == "1") {
    $iriam_reward_1star = "checked";
} 
if ($iriam_reward_2star == "1") {
    $iriam_reward_2star = "checked";
}
if ($iriam_reward_3star == "1") {
    $iriam_reward_3star = "checked";
}

// Make sure the reward ID exists
if ($iriam_reward_download_id !== "") {
    $_cloudinary_results = (new SearchApi())->expression(
        "public_id=iriam/rewards/$iriam_reward_download_id"
        )
        ->execute();
    // Check if the file exists under the resources array
    if (isset($_cloudinary_results["resources"]) && count($_cloudinary_results["resources"]) > 0) {
        $iriam_reward_download_id_secure_url = $_cloudinary_results["resources"][0]["secure_url"];
    } else {
        $iriam_reward_download_id_secure_url = "";
    }
} else {
    $iriam_reward_download_id_secure_url = "";
}

$cldSigner = new CloudinarySigner();
$iriam_reward_thumbnail_signed_url = $cldSigner->signUrl($iriam_reward_thumbnail);


echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Iriam Rewards Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <form id="post-editor" action="iriam_rewards_process.php" method="post">
                <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                    <div class="card-body" style="min-width: 500px">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="iriam_reward_name">Title</label></span>
                            <input required minlength="1" maxlength="255" class="form-control" type="text" id="iriam_reward_name" name="iriam_reward_name" value="$iriam_reward_name" /> 
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="iriam_reward_name">Description</label></span>
                            <input required minlength="1" maxlength="512" class="form-control" type="text" id="iriam_reward_description" name="iriam_reward_description" value="$iriam_reward_description" /> 
                        </div>
                        <small class="text-white">To change this asset, you must delete it from Cloudinary and make a new asset.</small>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="iriam_reward_name">Cloudinary Public ID: /iriam/rewards/</label></span>
                            <input disabled class="form-control" type="text" value="$iriam_reward_download_id"></input>
                            <input required minlength="1" maxlength="512" class="d-none form-control" type="text" id="iriam_reward_download_id" name="iriam_reward_download_id" value="$iriam_reward_download_id" /> 
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="iriam_reward_name">Thumbnail URL</label></span>
                            <input required minlength="1" maxlength="512" class="form-control" type="text" id="iriam_reward_thumbnail" name="iriam_reward_thumbnail" value="$iriam_reward_thumbnail" /> 
                        </div>
                        <small class="text-white">Set a date for this reward. Only the month and year matters in terms of displaying it on the IRIAM rewards list.</small>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="iriam_reward_date">Reward Date</label></span>
                            <input class="form-control" type="datetime-local" id="iriam_reward_date" name="iriam_reward_date" value="$iriam_reward_date" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="iriam_reward_name">Category (manual entry)</label></span>
                            <input required minlength="1" maxlength="512" class="form-control" type="text" id="iriam_reward_type" name="iriam_reward_type" value="$iriam_reward_type" /> 
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="iriam_reward_published">Published/Viewable</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="iriam_reward_published" name="iriam_reward_published" value="1" $iriam_reward_published />
                            </span>
                            <span class="input-group-text"><label for ="iriam_reward_published">1★</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="iriam_reward_1star" name="iriam_reward_1star" value="1" $iriam_reward_1star />
                            </span>
                            <span class="input-group-text"><label for ="iriam_reward_published">2★</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="iriam_reward_2star" name="iriam_reward_2star" value="1" $iriam_reward_2star />
                            </span>
                            <span class="input-group-text"><label for ="iriam_reward_published">3★</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="iriam_reward_3star" name="iriam_reward_3star" value="1" $iriam_reward_3star />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mb-2">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Save Reward</button> 
                            <a href="iriam_rewards.php"><button class="btn btn-danger" type="button">Cancel (Back to Rewards List)</button></a>
                        </div>
                        <div class="mb-2">
                            <a target="_blank" href="cloudinary.php"><button class="btn btn-light" type="button">Cloudinary Media Signer</button></a>
                        </div>
                    </div>
                </div>
                <h1>Thumbnail Preview</h1>
                <img id="iriam_reward_thumbnail_preview" src="$iriam_reward_thumbnail_signed_url" class="img-fluid rounded shadow" style="max-height: 200px; max-width: min(100%,225px);" />
                <h1>Cloudinary Public ID</h1>
                <img id="iriam_reward_thumbnail_preview_full" src="$iriam_reward_download_id_secure_url" class="img-fluid rounded shadow" style="max-height: 500px; max-width: min(100%,600px);" />
            </form>
        </div>
    </div>
</div>
FORM;

require $dir . "/templates/admin-check-script.php";

$_footer_adminmode = true;
require $dir . "/templates/footer.php";
?>