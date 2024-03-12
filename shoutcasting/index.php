<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Esports Portfolio";

$find_md_file_name = function ($v) {
    return strpos($v, ".md");
};

require $dir . "/templates/header.php";
?>

<link href="https://unpkg.com/cloudinary-video-player@1.10.6/dist/cld-video-player.min.css" rel="stylesheet">
<script src="https://unpkg.com/cloudinary-video-player@1.10.6/dist/cld-video-player.min.js"
    type="text/javascript"></script>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Esports Portfolio</h1>
    <p>Here you can take a look at my shoutcasting and production highlights.</p>

    <ul class="nav nav-tabs" id="portfolioContentTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="shoutcasting-tab" data-bs-toggle="tab" data-bs-target="#shoutcasting"
                type="button" role="tab" aria-controls="home" aria-selected="true">Shoutcasting</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="producer-tab" data-bs-toggle="tab" data-bs-target="#producer" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Broadcast Production</button>
        </li>
    </ul>
    <div class="tab-content" id="portfolioContent">
        <div class="tab-pane fade show active" id="shoutcasting" role="tabpanel" aria-labelledby="shoutcasting-tab">
            <h2 class="text-center">Shoutcasting</h2>
            <p>
            <div style="border-style:solid;border-size:1px;border-color:black">
                <iframe width=100% height=400px
                    src="https://docs.google.com/document/d/e/2PACX-1vQrfP_CiPjcTAWXJGm2Wzj5nVXXHTI2bZLF6oeCigXTVrNeizRJZTQ_g6ftcG6NV4pUtypJv20VI87u/pub?embedded=true"></iframe>
            </div>
            </p>
            <hr>
            <p>
                <center>
                    <h2>2022 Shoutcasting Highlights</h2>
                    <p>On YouTube</p>
                    <iframe width="100%" height="315" style="max-width:516px" src="https://www.youtube.com/embed/mM0aQ0V4EjI"
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
                                class="cld-video-player cld-video-player-skin-dark w-100" style="height:500px">
                            </video>
                        </center>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade" id="producer" role="tabpanel" aria-labelledby="producer-tab">
            <div class="text-center">
                <h2>Broadcast Production</h2>
                <div style="border-style:solid;border-size:1px;border-color:black">
                    <iframe width=100% height=400px
                        src="https://docs.google.com/document/d/e/2PACX-1vTWgBvPC8yndQcXrJQ4hnQBUlzXxE_tS35NPkpInI9QEp5eQ4lX3Esjto8Qlkz3cn41pyUps1EFSgMj/pub?embedded=true">
                    </iframe>
                </div>
                <div>
                    <hr />
                    <iframe width="100%" height="315" style="max-width:516px"
                        src="https://www.youtube.com/embed/ag3RgaXbLoM" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
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
</div>
<?php require $dir . "/templates/footer.php" ?>