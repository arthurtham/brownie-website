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
    } else {
        // If no results, redirect to the rewards list
        redirect("/admin/iriam_rewards.php");
        die();
    }
} else {
    redirect("/admin/iriam_rewards.php");
    die();
}

$iriam_minimum_reward = 4;
if ($iriam_reward_published == "1") {
    $iriam_reward_published = "checked";
}
if ($iriam_reward_3star == "1") {
    $iriam_reward_3star = "checked";
    $iriam_minimum_reward = 3;
}
if ($iriam_reward_2star == "1") {
    $iriam_reward_2star = "checked";
    $iriam_minimum_reward = 2;
}
if ($iriam_reward_1star == "1") {
    $iriam_reward_1star = "checked";
    $iriam_minimum_reward = 1;
} 

// Make sure the reward ID exists
if ($iriam_reward_download_id !== "") {
    $_cloudinary_results = (new SearchApi())->expression(
        "public_id=com.browntulstar/iriam/rewards/$iriam_reward_download_id"
        )
        ->execute();
    // Check if the file exists under the resources array
    if (isset($_cloudinary_results["resources"]) && count($_cloudinary_results["resources"]) > 0) {
        $iriam_reward_download_id_secure_url = $_cloudinary_results["resources"][0]["secure_url"];
        $iriam_reward_resource_type = $_cloudinary_results["resources"][0]["resource_type"];
    } else {
        $iriam_reward_download_id_secure_url = "";
        $iriam_reward_resource_type = "";
    }
} else {
    $iriam_reward_download_id_secure_url = "";
    $iriam_reward_resource_type = "";
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
                            <span class="input-group-text"><label for ="iriam_reward_name">Cloudinary Public ID: com.browntulstar/iriam/rewards/</label></span>
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
                            <span class="input-group-text"><label for ="iriam_reward_name">Reward Type (backend)</label></span>
                            <input required minlength="1" maxlength="512" class="form-control" type="text" id="iriam_reward_type" name="iriam_reward_type" value="$iriam_reward_type" /> 
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="iriam_reward_published">Listed</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="iriam_reward_published" name="iriam_reward_published" value="1" $iriam_reward_published />
                            </span>
                            <div class="d-none">
                                <span class="input-group-text"><label for ="iriam_reward_1star">1★</label></span>
                                <span class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" id="iriam_reward_1star" name="iriam_reward_1star" value="1" $iriam_reward_1star />
                                </span>
                                <span class="input-group-text"><label for ="iriam_reward_2star">2★</label></span>
                                <span class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" id="iriam_reward_2star" name="iriam_reward_2star" value="1" $iriam_reward_2star />
                                </span>
                                <span class="input-group-text"><label for ="iriam_reward_3star">3★</label></span>
                                <span class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" id="iriam_reward_3star" name="iriam_reward_3star" value="1" $iriam_reward_3star />
                                </span>
                            </div>
                            <span class="input-group-text"><label for ="iriam_reward_star_rating">★ Reward Level</label>
                            </span>
                            <select class="input-group-text form-select" id="iriam_reward_star_rating" style="width: auto;max-width: 150px">
                                <option  selected disabled value=""> Loading...</option>
                                <option  value="4">List Only</option>
                                <option  value="1">1★ Reward</option>
                                <option  value="2">2★ Reward</option>
                                <option  value="3">3★ Reward</option>
                            </select>
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
                <div class="card bg-secondary mb-2"><div class="card-body">
                <h1 class="text-white">Thumbnail Preview</h1>
                <p><img id="iriam_reward_thumbnail_preview" src="$iriam_reward_thumbnail_signed_url" class="img-fluid rounded shadow" style="max-height: 200px; max-width: min(100%,225px);" /></p>
                <br>
                <h1 class="text-white">Cloudinary Asset Preview</h1>
                <p><a class="btn btn-danger" href="$iriam_reward_download_id_secure_url" target="_blank">Open in New Tab</a></p>
FORM;
                // If it an image, show an image. If it's a video, show a video. Variable: 
                if ($iriam_reward_resource_type === "image") {
                    echo "<img id=\"iriam_reward_thumbnail_preview_full\" src=\"$iriam_reward_download_id_secure_url\" class=\"img-fluid rounded shadow\" style=\"max-height: 500px; max-width: min(100%,600px);\" />";
                } else if ($iriam_reward_resource_type === "video") {
                    echo <<<VIDEOPLAYER
                    <div id="video-player-div">
                        <video id="video-player-media"></video>
                    </div> 
                    <link href="https://unpkg.com/cloudinary-video-player@1.10.4/dist/cld-video-player.min.css" 
                        rel="stylesheet">   
                    <script src="https://unpkg.com/cloudinary-video-player@1.10.4/dist/cld-video-player.min.js" 
                        type="text/javascript"></script>
                    <script type="text/javascript"> 
                    const player = cloudinary.videoPlayer('video-player-media', {
                        cloudName: 'browntulstar',
                        source: '$iriam_reward_download_id_secure_url',
                        fluid: true,
                        controls: true,
                        muted: false,
                        colors: {
                        accent: '#af0303'
                        },
                        hideContextMenu: true,
                        autoplay: false
                    });
                    </script>
VIDEOPLAYER;
                } else {
                    echo "<p class='text-white'><strong>Raw media type: $iriam_reward_resource_type</strong></p>";
                }
            echo <<<FORM
            </div></div>
            </form>
        </div>
    </div>
</div>
<script>
$("#iriam_reward_star_rating").on("change", function(e) {
  var star_value = parseInt(e.target.value);
  if (star_value > 1) {
    $("#iriam_reward_1star").prop("checked", false);
  } else {
    $("#iriam_reward_1star").prop("checked", true);
  };
  if (star_value > 2) {
    $("#iriam_reward_2star").prop("checked", false);
  } else {
    $("#iriam_reward_2star").prop("checked", true);
  };
  if (star_value > 3) {
    $("#iriam_reward_3star").prop("checked", false);
  } else {
    $("#iriam_reward_3star").prop("checked", true);
  };
});
jQuery(document).ready(function($){
    $('#iriam_reward_star_rating').find('option[value=$iriam_minimum_reward]').attr('selected','selected');
});
</script>
FORM;

require $dir . "/templates/admin-check-script.php";

$_footer_adminmode = true;
require $dir . "/templates/footer.php";
?>