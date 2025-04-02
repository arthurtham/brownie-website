<?php

$dir = dirname(__DIR__, 1);
$title = "Admin";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";

require $dir . "/includes/cloudinary.env.php";
require $dir . "/includes/CloudinarySigner.php";


if (isset($_GET["cldurl"])) {
    $cldSigner = new CloudinarySigner();
    $image = $cldSigner->signUrl($_GET["cldurl"]);
}

?>

<div class="container body-container">
<h1>Validate Cloudinary Media</h1>
<p>Use this to manually validate Cloudinary media.</p>

<form id="post-editor" action="" method="get">
    <label for ="cldurl">Unsigned Cloudinary URL</label>: <input required style="width:100%" type="text" id="cldurl" name="cldurl" value="<?=(isset($_GET["cldurl"]) ? $_GET["cldurl"] : "") ?>" /><br/>
    Make sure this URL has a file extension (accepted: png, jpg, mov, mp4, webp, gif) <br/>
    <button class="btn btn-success" id="submitButton" name="submitButton" type="button" style="min-width:200px" onclick="startSubmit()">Sign</button> 
    <a href="/admin" class="btn btn-danger">Return to Main Menu</a>
</form>

<?php 
if (isset($_GET["cldurl"])) {
?>
<div class="alert alert-dark">
    <p>Original URL: <br/> 
    <pre> <?=$_GET["cldurl"]?> </pre></p>
    <p>Signed URL: <br/>
    <pre><?=$image ?> </pre><hr>
    <img src="<?=$image ?>" style="width:200px !important" /></p>
</div>
<?php 
}

require $dir . "/templates/admin-check-script.php";
?>

</div>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>