<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Schedule";
require_once $dir . "/templates/twitch-video-listings.php";
require $dir . "/templates/header.php";
require_once $dir . "/includes/twitch.php";
?>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Stream</h1>
    <p class="text-center">
        <a class="btn btn-dark" href="https://twitch.tv/browntulstar" target="_blank">
            <i class="fa-brands fa-twitch"></i>
            Watch browntulstar on Twitch
        </a>
    </p>
    
    <iframe
        src="https://player.twitch.tv/?channel=browntulstar&parent=browntulstar.com"
        height="600"
        width="100%"
        allowfullscreen>
    </iframe>
    <hr />
<?php
    $video_ids = twitch_get_recent_videos(12);
    echoCardEntries($video_ids);
    echoModalEntries($video_ids);
?>
</div>
<?php require $dir . "/templates/footer.php" ?>