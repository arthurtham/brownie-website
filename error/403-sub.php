<?php
$dir = dirname(__DIR__, 1);
require_once $dir . "/includes/default-includes.php";
if (!isset($title)) {
    $title = "BrowntulStar - Error"; 
}
require $dir . "/templates/header.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <div class="d-flex flex-column align-items-center justify-content-center" style="height:100%">
        <span>
            <h1 class="text-center">403 Not subscribed</h1>
            <p>Looks like you're not subscribed to Browntul. Uninspirational!</p>
        </span>
        <div class="alert alert-dark" role="alert">
            <p class="text-center">Trying to access sub perks? Click on
            "<?php if (isset($_SESSION["user"])) echo "Verify Sub"; else echo "Login"; ?>"
            below to get set up.<br/>
            For further help, please contact support.</p>
        <?php print_navbar_login_items($expand=true, $center=true, $subperks=true); ?>
        </div>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>