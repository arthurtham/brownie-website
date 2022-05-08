<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Schedule";
require $dir . "/templates/header.php";
?>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Stream</h1>
    <p class="text-center"><a href="https://twitch.tv/browntulstar" target="_blank">twitch.tv/browntulstar</a></p>
    
    <iframe
        src="https://player.twitch.tv/?channel=browntulstar&parent=browntulstar.com"
        height="600"
        width="100%"
        allowfullscreen>
    </iframe>
</div>
<?php require $dir . "/templates/footer.php" ?>