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
    <p style="text-align: center;">You can call me Brown, Browntul, Brown Toaster, BT, Star... actually, "Brown" is fine :)</p>
    <p style="text-align: center;">My pronouns are he/him/his. <br />
        I am a shoutcaster and broadcast producer. <br />
        I used to be an aspiring game developer / designer. <br />
        I stream multiplayer games on the NA/West server. <br />
        I also host coding and game-jam streams.</p>
    <p style="text-align: center;">I hope you all can jump along for the ride!</p>
    <hr>
    <h2 style="text-align: center;">Games I Play on Stream</h2>
    <div class="container">
        <div class="row">
            <div class="col col-md-4">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/mk8dx.jpg" class="card-img-top" alt="mario kart 8 deluxe" style="object-fit: cover;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Mario Kart 8 Deluxe</h5>
                        <ul>
                            <li>Build: DK, Wiggler, Azure Roller, Parafoil</li>
                            <li>Tournament Highlights: </li>
                            <ul>
                                <li>Change Thru Games Mario Kart 8 Deluxe reigning champion (2018)</li>
                                <li>SoCal Flower Fest 2021 150cc champion</li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col col-md-4">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/krr.jpg" class="card-img-top" alt="KRR" style="object-fit: cover;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">KartRider</h5>
                        <ul>
                            <li>KartRider Rush+</li>
                            <ul>
                                <li>Rank: Legend (Season 9, 13)</li>
                                <li>Club: TurtleNation</li>
                            </ul>
                            <li>KartRider: Drift</li>
                            <ul>
                                <li>Rank: Silver</li>
                                <li>Platform: Steam, iOS</li>
                                <li>Controls: XBOX Controller</li>
                                <li>Setup: 5/0/3/2, Kris + Mine Cart</li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col col-md-4">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/valorant-kj.jpg" class="card-img-top" alt="valorant killjoy" style="object-fit: cover;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">VALORANT</h5>
                        <ul>
                            <li>Agents: </li>
                            <ul>
                                <li>Primary: Killjoy</li>
                                <li>Secondaries: Astra, Gekko, Viper</li>
                            </ul>
                            <li>Platinum 1 (Ep 5 Act 3)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h2 style="text-align: center;">Things I Do</h2>
    <div class="container">
        <div class="row">
            <div class="col col-lg-3">
                <div class="card" style="width: 100%; height:100%">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Coding</h5>
                        <p style="text-align:center">I make games for fun, and I create coding content on stream.</p>
                    </div>
                </div>
            </div>
            <div class="col col-lg-3">
                <div class="card" style="width: 100%; height:100%">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Shoutcasting</h5>
                        <p style="text-align:center">I shoutcast and produce VALORANT tournaments year-round!</p>
                    </div>
                </div>
            </div>
            <div class="col col-lg-3">
                <div class="card" style="width: 100%; height:100%">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Event Planning</h5>
                        <p style="text-align:center">I help plan streamer tournaments and events hosted on Twitch.</p>
                    </div>
                </div>
            </div>
            <div class="col col-lg-3">
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
            <div class="col col-md-6 offset-md-3">
                <div class="card" style="width: 100%; height:100%">
                    <img src="/assets/img/kazokulogo.png" class="card-img-top" alt="kazoku logo" style="padding: 20px;object-fit: contain;height:200px">
                    <div class="card-body">
                        <h5 class="card-title  text-center">Kazoku</h5>
                        <p style="text-align:center"><a href="https://bio.site/kazoku" target="_blank">Content Creation Team</a></p>
                        <p style="text-align:center"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>