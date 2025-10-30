<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Esports Portfolio";

$find_md_file_name = function ($v) {
    return strpos($v, ".md");
};

require $dir . "/templates/header.php";
?>

<link href="https://unpkg.com/cloudinary-video-player@2.3.5/dist/cld-video-player.min.css" rel="stylesheet">
<script src="https://unpkg.com/cloudinary-video-player@2.3.5/dist/cld-video-player.min.js"
    type="text/javascript"></script>

<div class="container body-container">
    <h1 class="text-center">Esports Portfolio</h1>
    <p class="text-center">Take a look at my shoutcasting and production highlights throughout the years.</p>

    <ul class="nav nav-tabs" id="portfolioContentTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="shoutcasting-tab" data-bs-toggle="tab" data-bs-target="#shoutcasting"
                type="button" role="tab" aria-controls="home" aria-selected="true">Shoutcasting</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="producer-tab" data-bs-toggle="tab" data-bs-target="#producer" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Broadcast Production</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="organizer-tab" data-bs-toggle="tab" data-bs-target="#organizer" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Event Organization</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Contact</button>
        </li>
    </ul>
    <div class="tab-content bg-dark text-white pb-3" id="portfolioContent">
        <div class="tab-pane fade show active" id="shoutcasting" role="tabpanel" aria-labelledby="shoutcasting-tab">
            <h2 class="text-center" style="padding-top:24px">Shoutcasting</h2>
            <div class="text-center">
                <p>Click the button below to view my shoutcasting portfolio.</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#shoutcastingModal">View Shoutcasting Portfolio</button>
            </div>
            <hr>
            <p>
                <center>
                    <h2>2022 Shoutcasting Highlights</h2>
                    <p>On YouTube</p>
                    <iframe loading="lazy" width="100%" height="315" style="max-width:516px" src="https://www.youtube.com/embed/mM0aQ0V4EjI"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </center>
            </p>
            <hr>
            <h2 class="text-center">Event Highlights</h2>
            <p class="text-center">Powered by Cloudinary</p>
            <div class="row">
                <div class="col-lg-12 text-center" style="padding-bottom:12px">
                    <button id="shoutcasting-player-play-prev" class="btn btn-success w-100"
                        style="max-width:200px">Previous Video</button>
                    <button id="shoutcasting-player-play-next" class="btn btn-success w-100"
                        style="max-width:200px">Next Video</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-container" style="max-width:80wv">
                        <center>
                            <video id="shoutcasting-player" controls
                                class="cld-video-player cld-video-player-skin-dark" style="width: 100%; height: auto; aspect-ratio: 16/9">
                            </video>
                        </center>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade" id="producer" role="tabpanel" aria-labelledby="producer-tab">
            <div class="text-center">
                <h2 style="padding-top:24px">Broadcast Production</h2>
                <p>Click the button below to view my broadcast production portfolio.</p>
                <div class="text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#producerModal">View Broadcast Production Portfolio</button>
                </div>
                <div>
                    <hr />
                    <h2>2023 Production Highlights</h2>
                    <p>On YouTube</p>
                    <iframe loading="lazy" width="100%" height="315" style="max-width:516px"
                        src="https://www.youtube.com/embed/ag3RgaXbLoM" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="organizer" role="tabpanel" aria-labelledby="producer-tab">
            <div class="text-center">
                <h2 style="padding-top:24px">Event Organizing and Administration</h2>
                <p>Click the button below to view my event organizing portfolio.</p>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#organizerModal">View Event Organizing Portfolio</button>
                </div>
                <hr/>
                <h2>Additional Links</h2>
                <div class="text-center">
                    <a class="btn btn-danger" href="https://brownieval.browntulstar.com" target="_blank"><img class='rounded' style='width:18px' src='https://res.cloudinary.com/browntulstar/image/private/s--fcXDbYLp--/f_webp/v1/com.browntulstar/img/brownieval-logo-v1?_a=BAAAUWGX'> #BrownieVAL</a>
                    <a class="btn btn-info" href="https://kazoteam.carrd.co/#events" target="_blank"><img class='rounded' style='width:18px' src='https://res.cloudinary.com/browntulstar/image/private/s--54dgg93---/ar_1:1,c_crop/c_fit,w_20/com.browntulstar/img/team-kazoku.png'> Kazoku Events</a>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="text-center">
                <h2 style="padding-top:24px">Contact</h2>
                <p>Please go to the <a href="/contact">Contact page</a> to contact me.</p>
                <hr />
                <h2>Shoutcasting Services</h2>
                <p>If you'd like, you can visit <a href="/shop/category/shoutcasting">this page</a> to take a closer look at how you can commission me to shoutcast your event.</p>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="shoutcastingModal" tabindex="-1" role="dialog" aria-labelledby="shoutcastingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shoutcastingModalLabel">Shoutcasting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe loading="lazy" style="display:block;width:100%;height:100%" width=100% height=calc(100vh-67px) overflow="scroll"
                    src="https://docs.google.com/document/d/e/2PACX-1vQrfP_CiPjcTAWXJGm2Wzj5nVXXHTI2bZLF6oeCigXTVrNeizRJZTQ_g6ftcG6NV4pUtypJv20VI87u/pub?embedded=true"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="producerModal" tabindex="-1" role="dialog" aria-labelledby="producerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="producerModalLabel">Broadcast Production</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe loading="lazy" style="display:block;width:100%;height:100%" width=100% height=calc(100vh-67px) overflow="scroll"
                    src="https://docs.google.com/document/d/e/2PACX-1vTWgBvPC8yndQcXrJQ4hnQBUlzXxE_tS35NPkpInI9QEp5eQ4lX3Esjto8Qlkz3cn41pyUps1EFSgMj/pub?embedded=true"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="organizerModal" tabindex="-1" role="dialog" aria-labelledby="organizerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="organizerModalLabel">Event Organizing and Administration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe loading="lazy" style="display:block;width:100%;height:100%" width=100% height=calc(100vh-67px) overflow="scroll"
                    src="https://docs.google.com/document/d/1Ndu5xplrrjMmWjaMOOk8SZffjlxGkwpTMTl2TSJazjc/pub?embedded=true"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    var cld = cloudinary.Cloudinary.new({ cloud_name: 'browntulstar', controls: true, fluid: true, hideContextMenu: true });
    var shoutcastingPlayer = cld.videoPlayer("shoutcasting-player", {
        transformation: { crop: 'fit', width: 720 }
    });
    shoutcastingPlayer.playlist([
        { publicId: 'com.browntulstar/video/shoutcasting_valrootine_3', sourceTypes: ['webm/vp9'], info: { title: "Happy Valrootines VALORANT Tournament", subtitle: "Play-by-play" } },
        { publicId: 'com.browntulstar/video/shoutcasting_psychocupgg_22', sourceTypes: ['webm/vp9'], info: { title: "PsychoCup x Gardenia Gauntlet", subtitle: "Play-by-play" } },
        { publicId: 'com.browntulstar/video/shoutcasting_cgt_2', sourceTypes: ['webm/vp9'], info: { title: "Chang Gang Tournament", subtitle: "Play-by-play" } },
        { publicId: 'com.browntulstar/video/shoutcasting_ultesport_19', sourceTypes: ['webm/vp9'], info: { title: "Ultimate Esport Collegiate VALORANT Tournament", subtitle: "Play-by-play" } },
        { publicId: 'com.browntulstar/video/shoutcasting_ultesport_21', sourceTypes: ['webm/vp9'], info: { title: "Ultimate Esport Collegiate VALORANT Tournament", subtitle: "Play-by-play" } },
        { publicId: 'com.browntulstar/video/shoutcasting_roolidays_1', sourceTypes: ['webm/vp9'], info: { title: "Happy Roolidays VALORANT Tournament", subtitle: "Play-by-play" } },
        { publicId: 'com.browntulstar/video/shoutcasting_summersplash_14', sourceTypes: ['webm/vp9'], info: { title: "Summer Splash 3 VALORANT Sponsored by HyperX on Highlander Gaming UC Riverside (Collegiate VALORANT)", subtitle: "Play-by-play, Color Analyst" } },
    ], {
        autoAdvance: true,
        repeat: true
    });

    document.querySelector("button#shoutcasting-player-play-prev").addEventListener("click", function () {
        shoutcastingPlayer.playPrevious();
    });

    document.querySelector("button#shoutcasting-player-play-next").addEventListener("click", function () {
        shoutcastingPlayer.playNext();
    });

</script>
<?php require $dir . "/templates/footer.php" ?>