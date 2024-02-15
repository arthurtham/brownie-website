<?php
$dir = dirname(__DIR__, 2);
$title = "BrownieVAL - Twitch Sub Only Videos";
require_once $dir . "/templates/twitch-video-listings.php";
require $dir . "/templates/header.php";
require_once $dir . "/includes/twitch.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 style="text-align: center;">#BrownieVAL - Twitch Sub Only Videos</h1>
    <center>
        <p>As a Twitch subscriber, you can view these subscriber-exclusive #BrownieVAL VODs.
            Please note that the original streams with caster audio and pre/postgame segments
            are always free.
        </p>
<?php
        // Check Twitch subscriber status 
        if (!isset($_SESSION['user']) || !check_guild_membership($guild_id) || !check_roles(array($sub_role_id))) {
            echo "<div class='alert alert-danger' role='alert'>
            <center>To view these videos, you must be a Twitch subscriber.<br>
            Please click <a href='https://twitch.tv/browntulstar/subscribe' target='_blank'>here</a> to subscribe on Twitch.</center>
            </div>";
        } else {
            echo "<div class='alert alert-success' role='alert'>
            <center>Twitch subscription detected. Enjoy the videos!</center>
            </div>";
        }
?>
    </center>

<?php
$video_ids = twitch_get_videos_by_id($brownieval_sub_only_videos);
echoCardEntries($video_ids);
echoModalEntries($video_ids);

?>

</div>

<?php

require $dir . "/templates/footer.php";

?>