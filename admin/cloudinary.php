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

<form action="" method="get">
    <label for ="cldurl">Unsigned Cloudinary URL</label>: <input style="width:100%" type="text" id="cldurl" name="cldurl" value="<?=(isset($_GET["cldurl"]) ? $_GET["cldurl"] : "") ?>" /><br/>
    Make sure this URL has a file extension (accepted: png, jpg, mov, mp4, webp) <br/>
    <button type="submit">Submit</button>
</form>

<?php 
if (isset($_GET["cldurl"])) {
?>
<p>Original URL: <br/> 
<pre> <?=$_GET["cldurl"]?> </pre></p>
<p>Signed: <br/>
<pre><?=$image ?> </pre><br/>
<img src="<?=$image ?>" style="width:200px !important" /></p>
<?php 
}
?>

</div>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>