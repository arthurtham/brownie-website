<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Apps and Games";
require_once($dir . "/includes/mysql.php");
require $dir . "/templates/header.php";
require_once $dir . "/includes/CloudinarySigner.php";
$cldSigner = new CloudinarySigner();
?>
<style>
    .body-container hr {
        margin-top:50px !important;
        margin-bottom:50px !important;
    }
</style>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Apps and Games</h1>
    <p class="text-center">
        Here are some of the apps and games that I have developed. 
        You can check out the links below to download and play them.
    </p>
    <p class="text-center">
        A fully detailed list of apps and games will be available at a later date.    
    </p>
    <h5>App Listings</h5>
    </ul>
<?php
$directories = array_filter(array_values(array_diff(scandir(__DIR__), array('.', '..'))), function($directory) {
    return is_dir($directory);
});
foreach ($directories as $directory) {
    echo "<li><a href='$directory/'>$directory</a></li>";
}
?>
    </ul>
</div>

<?php
$_FOOTER_HOME = false;
require $dir . "/templates/footer.php";
