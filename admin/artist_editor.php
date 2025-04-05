<?php

$dir = dirname(__DIR__, 1);
$title = "Artist (Credits) Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");
require_once $dir . "/includes/CloudinarySigner.php";

$artist_id = 0;
$artist_name = "";
$artist_logo_image = "";
$artist_portfolio_image = "";
$artist_subheader = "";
$artist_description = "";
$artist_highlight = 0;
$artist_active = 0;
$artist_links_website = "";
$artist_links_twitch = "";
$artist_links_twitter = "";
$artist_links_instagram = "";
$artist_links_kofi = "";
$artist_links_vgen = "";
$artist_links_etsy = "";


if (isset($_GET["id"])) {
    $sql = "SELECT * FROM artists WHERE id = \"".mysqli_real_escape_string($conn, $_GET["id"])."\" LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($artist_post = $result->fetch_assoc()) {
            $artist_id = $artist_post["id"];
            $artist_name = htmlspecialchars($artist_post["name"]);
            $artist_logo_image = htmlspecialchars($artist_post["logo_image"]);
            $artist_portfolio_image = htmlspecialchars($artist_post["portfolio_image"]);
            $artist_subheader = htmlspecialchars($artist_post["subheader"]);
            $artist_description = htmlspecialchars($artist_post["description"]);
            $artist_highlight = $artist_post["entry_highlight"];
            $artist_active = $artist_post["entry_active"];
            $artist_links_website = htmlspecialchars($artist_post["links_website"]);
            $artist_links_twitch = htmlspecialchars($artist_post["links_twitch"]);
            $artist_links_twitter = htmlspecialchars($artist_post["links_twitter"]);
            $artist_links_instagram = htmlspecialchars($artist_post["links_instagram"]);
            $artist_links_kofi = htmlspecialchars($artist_post["links_kofi"]);
            $artist_links_vgen = htmlspecialchars($artist_post["links_vgen"]);
            $artist_links_etsy = htmlspecialchars($artist_post["links_etsy"]);
        }
    }
    $cldSigner = new CloudinarySigner();
    $artist_description = $cldSigner->convertAllUrls($artist_description);
}

if ($artist_highlight == "1") {
    $artist_highlight = "checked";
}
if ($artist_active == "1") {
    $artist_active = "checked";
}

echo <<<FORM
<div class="container body-container">
    <div class="row">
        <div class="col">
            <h1>Artist (Credits) Editor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <form id="post-editor" action="artist_process.php" method="post">
                <div class="card bg-secondary mb-2" style="width: 100%; overflow-x: auto;">
                    <div class="card-body" style="min-width: 500px">
                        <h2 class="text-white">Main</h2>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_name">Name</label></span>
                            <input required minlength="1" maxlength="255" class="form-control" type="text" id="artist_name" name="artist_name" value="$artist_name" /> 
                        </div>
                        <div class="input-group mb-3" style="display:none">
                            <span class="input-group-text"><label for ="artist_id">ID</label></span>
                            <input readonly class="form-control" type="number" id="artist_id" name="artist_id" value="$artist_id" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_subheader">Subheader</label></span>
                            <input maxlength="255" class="form-control" type="text" id="artist_subheader" name="artist_subheader" value="$artist_subheader" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_logo_image">Logo Image</label></span>
                            <input maxlength="512" class="form-control" type="text" id="artist_logo_image" name="artist_logo_image" value="$artist_logo_image" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_portfolio_image">Portfolio Image</label></span>
                            <input maxlength="512" class="form-control" type="text" id="artist_portfolio_image" name="artist_portfolio_image" value="$artist_portfolio_image" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_links_website">Website URL</label></span>
                            <input maxlength="255" class="form-control" type="text" id="artist_links_website" name="artist_links_website" value="$artist_links_website" />
                        </div>
                        <h2 class="text-white">Social Links</h2>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_links_twitch">Twitch</label></span>
                            <input maxlength="255" class="form-control" type="text" id="artist_links_twitch" name="artist_links_twitch" value="$artist_links_twitch" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_links_twitter">Twitter</label></span>
                            <input maxlength="255" class="form-control" type="text" id="artist_links_twitter" name="artist_links_twitter" value="$artist_links_twitter" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_links_instagram">Instagram</label></span>
                            <input maxlength="255" class="form-control" type="text" id="artist_links_instagram" name="artist_links_instagram" value="$artist_links_instagram" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_links_kofi">Kofi</label></span>
                            <input maxlength="255" class="form-control" type="text" id="artist_links_kofi" name="artist_links_kofi" value="$artist_links_kofi" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_links_vgen">VGen</label></span>
                            <input maxlength="255" class="form-control" type="text" id="artist_links_vgen" name="artist_links_vgen" value="$artist_links_vgen" />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_links_etsy">Etsy</label></span>
                            <input maxlength="255" class="form-control" type="text" id="artist_links_etsy" name="artist_links_etsy" value="$artist_links_etsy" />
                        </div>
                        <h2 class="text-white">Visibility</h2>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><label for ="artist_highlight">Highlight</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="artist_highlight" name="artist_highlight" value="1" $artist_highlight />
                            </span>
                            <span class="input-group-text"><label for ="artist_active">Visible</label></span>
                            <span class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="artist_active" name="artist_active" value="1" $artist_active />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mb-2">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Save Artist Credits</button> 
                            <a href="artist.php"><button class="btn btn-danger" type="button">Cancel (Back to Credits Listings)</button></a>
                        </div>
                        <div class="mb-2">
                            <a target="_blank" href="cloudinary.php"><button class="btn btn-light" type="button">Cloudinary Media Signer</button></a>
                        </div>
                    </div>
                </div>
                <div class="card bg-light mb-2 post-contents" style="z-index:1020; height:200px">
                    <textarea style="display:none;width:100%;height:500px" id="artist_description" name="artist_description">$artist_description</textarea><br/>
                </div>
            </form>
        </div>
    </div>
</div>
FORM;

$simplemde_element_name = "artist_description";
require $dir . "/templates/simplemde.php";

require $dir . "/templates/admin-check-script.php";

$_footer_adminmode = true;
require $dir . "/templates/footer.php";
?>