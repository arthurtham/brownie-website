<?php
$dir = dirname(__DIR__, 2);
$title = "BrownieVAL - Twitch Sub Only Videos";
require $dir . "/templates/header.php";
require_once $dir . "/includes/twitch.php";
?>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <div class="d-flex flex-column align-items-center justify-content-center" style="height:100%">
        <span>
            <h1 class="text-center">#BrownieVAL - Sub Only VODs</h1>
            <p>Thanks for your support. Unfortunately, due to changes in Twitch's VOD policy,
            this sub perk is no longer supported.</p>
        </span>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>