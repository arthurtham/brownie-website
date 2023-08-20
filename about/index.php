<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - About";
require $dir . "/templates/header.php"
?>

<style>
    .body-container hr {
        margin-top:50px !important;
        margin-bottom:50px !important;
    }
</style>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <center><img src="/assets/img/turtleavatar.png" style="border-radius: 100%;width:auto;max-width:200px" /></center>
    <h1 style="text-align: center;">Hi, I'm Browntul.</h1>
    <p style="text-align: center;">My pronouns are he/him/his. <br />
        I am a shoutcaster and broadcast producer. <br />
        I aspire to be a game developer / designer. <br />
        I stream multiplayer games based in the NA/West server. <br />
        I also host coding and game-jam streams from time to time.</p>
    <p style="text-align: center;">I hope you all can jump along for the ride!</p>
    <hr>
    <h2 style="text-align: center;">Games I Play on Stream</h2>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/mk8dx.jpg" class="card-img-top" alt="mario kart 8 deluxe" style="object-fit: cover;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Mario Kart 8 Deluxe</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/krr.jpg" class="card-img-top" alt="KRR" style="object-fit: cover;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">KartRider Rush+ and KartRider: Drift</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/valorant-kj.jpg" class="card-img-top" alt="valorant killjoy" style="object-fit: cover;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">VALORANT</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/honkaistarrail.jpg" class="card-img-top" alt="qingque honkai star rail" style="object-fit: cover;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Honkai: Star Rail</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h2 style="text-align: center;">Things I Do</h2>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card" style="width: 100%; height:100%">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Coding</h5>
                        <p style="text-align:center">I make games for fun, and I create coding content on stream.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card" style="width: 100%; height:100%">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Shoutcasting</h5>
                        <p style="text-align:center">I shoutcast and produce VALORANT tournaments year-round!</p>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card" style="width: 100%; height:100%">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Event Planning</h5>
                        <p style="text-align:center">I help plan streamer tournaments and events hosted on Twitch.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card" style="width: 100%; height:100%">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Community Modding</h5>
                        <p style="text-align:center">I mod for streamer and game-jam communities on Discord and Twitch.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h2 style="text-align: center;">My Stream Teams</h2>
    <div class="container">
        <div class="row">
            <div class="col col-md-4 offset-md-2">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/kazokulogo.png" class="card-img-top" alt="kazoku logo" style="padding: 20px;object-fit: contain;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Kazoku</h5>
                        <p style="text-align:center"><a href="https://kazoteam.carrd.co/" target="_blank">Events Coordinator</a></p>
                        <p style="text-align:center"></p>
                    </div>
                </div>
            </div>
            <div class="col col-md-4">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/comfycafelogo.png" class="card-img-top" alt="okimi logo" style="padding: 20px;object-fit: contain;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Okimi Cafe</h5>
                        <p style="text-align:center"><a href="https://okimicafe.crd.co/" target="_blank">Legacy Co-founder</a></p>
                        <p style="text-align:center"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>