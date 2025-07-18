<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Twitch";
require_once $dir . "/templates/twitch-video-listings.php";
require_once $dir . "/templates/youtube-video-listings.php";
require $dir . "/templates/header.php";
require_once $dir . "/includes/twitch.php";
require_once $dir . "/includes/youtube.php";
?>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Stream</h1>
    <p class="text-center">Watch me live on Twitch, IRIAM, and YouTube!</p>

    <ul class="nav nav-tabs" id="streamContentTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link<?php echo ((isset($_GET["youtube"]) || isset($_GET["iriam"])) ? "" : " active");?>" id="twitch-stream-tab" data-bs-toggle="tab" data-bs-target="#twitch-stream"
                type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fa-brands fa-twitch"></i> Twitch</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link<?php echo (isset($_GET["iriam"]) ? " active" : "");?>" id="iriam-stream-tab" data-bs-toggle="tab" data-bs-target="#iriam-stream" type="button"
                role="tab" aria-controls="profile" aria-selected="false">
                <img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0">
                IRIAM
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link<?php echo (isset($_GET["youtube"]) ? " active" : "");?>" id="youtube-stream-tab" data-bs-toggle="tab" data-bs-target="#youtube-stream" type="button"
                role="tab" aria-controls="profile" aria-selected="false"><i class="fa-brands fa-youtube"></i> YouTube</button>
        </li>
    </ul>
    <div class="tab-content bg-dark text-white ps-3 pe-3 pt-4 pb-4" id="portfolioContent">
        <div class="tab-pane fade<?php echo ((isset($_GET["youtube"]) || isset($_GET["iriam"])) ? "" : " show active");?>" id="twitch-stream" role="tabpanel" aria-labelledby="twitch-stream-tab">
            <p>
                <img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/private/s--KfoRY1En--/c_fit,w_150,h_150/f_webp/v1/com.browntulstar/img/platform-twitch.webp?_a=BAAAV6E0"  style="width:100%;max-height:125px;object-fit:contain;" />
            </p>
            <h1 class="text-center">Twitch</h1>
            <p class="text-center">
                <a class="btn btn-light mb-2 w-100 shadow" href="https://twitch.tv/browntulstar" target="_blank" style="max-width:300px"><strong>
                    <i class="fa-brands fa-twitch"></i>
                    /browntulstar
                </strong></a>
            </p>
            <p class="text-center">
                Watch Browntul play his favorite games, like Honkai: Star Rail, VALORANT, Marvel Rivals, Nintendo Switch games, and more. Livestreams take place on most Saturday nights on Twitch.
            </p>
            
            <!-- <iframe
                src="https://player.twitch.tv/?channel=browntulstar&parent=browntulstar.com"
                height="600"
                width="100%"
                allowfullscreen>
            </iframe> -->
            <hr />
<?php
            $video_ids = twitch_get_recent_videos(6);
            echoTwitchCardEntries($video_ids);
            // echoTwitchModalEntries($video_ids);
?>
        </div>
        <div class="tab-pane fade<?php echo (isset($_GET["iriam"]) ? " show active" : "");?>" id="iriam-stream" role="tabpanel" aria-labelledby="iriam-stream-tab">
            <p>
                <img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0"  style="width:100%;max-height:125px;object-fit:contain;" />
            </p>
            <h1 class="text-center">IRIAM</h1>
            <p class="text-center">
                <a class="btn btn-info w-100 shadow" href='/iriam' style="max-width:300px">
                <img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0">
                <strong>
                    Watch on the IRIAM App
                </strong></a>
            </p>
            <p class="text-center">
                Listen to Browntul talk about the latest sports events and your favorite variety topics exclusively on the IRIAM mobile app in the US region.
            </p>
            <p class="text-center">
                Every Saturday night, catch the simulcasted Just-Chatting portion of the Twitch stream in audio-only mode on IRIAM.
            </p>
        </div>
        <div class="tab-pane fade<?php echo (isset($_GET["youtube"]) ? " show active" : "");?>" id="youtube-stream" role="tabpanel" aria-labelledby="youtube-stream-tab">
            <p>
                <img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/upload/s--XmT7gvOy--/c_pad,h_200,w_200/f_webp/f_webp/v1/com.browntulstar/img/icon-youtube.png?_a=BAAAV6E0"  style="width:100%;max-height:125px;object-fit:contain;" />
            </p>
            <h1 class="text-center">YouTube</h1>
            <p class="text-center">
                <a class="btn btn-danger w-100 shadow" href='https://youtube.com/@browntulstar' target="_blank" style="max-width:300px"><strong>
                    <i class="fa-brands fa-youtube"></i>
                    @browntulstar
                </strong></a>
            </p>
            <p class="text-center">
                Watch replays of Browntul's events and podcasts on YouTube. Catch the highlights of the Twitch streams and fun gaming shorts.
            </p>
            <hr/>
<?php
            $video_ids = youtube_get_recent_videos(9);
            echoYouTubeCardEntries($video_ids);
?>
        </div>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>