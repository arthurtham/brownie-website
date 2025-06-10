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
            <h1 class="text-center">403 Insufficient Perks</h1>
            <center>
            <p>Insufficient perks found. Uninspirational!</p>
            <p>Subscribe on Twitch, or meet the ★ Star Badge tier on IRIAM for this content and join the Discord server to access perks.</p> 
            </center>
        </span>
        <div class="alert alert-dark" role="alert">
            <p class="text-center">Trying to access perks? Click on
            "<?php if (isset($_SESSION["user"])) echo "Verify Perks"; else echo "Login"; ?>"
            below to get set up.<br/>
            For further help, please contact support.</p>
        <?php print_navbar_login_items($expand=true, $center=true, $subperks=true); ?>
        </div>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>