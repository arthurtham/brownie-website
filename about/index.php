<?php

/* Home Page
* The home page of the working demo of oauth2 script.
* @author : MarkisDev
* @copyright : https://markis.dev
*/

# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 1) . "/includes/functions.php";
require dirname(__DIR__, 1) . "/includes/discord.php";
require dirname(__DIR__, 1) . "/config.php";
require dirname(__DIR__, 1) . "/includes/sessiontimer.php";

# ALL VALUES ARE STORED IN SESSION!
# RUN `echo var_export([$_SESSION]);` TO DISPLAY ALL THE VARIABLE NAMES AND VALUES.
# FEEL FREE TO JOIN MY SERVER FOR ANY QUERIES - https://join.markis.dev

?>

<html>

<head>
	<title>BrowntulStar - About</title>
	<?php require dirname(__DIR__, 1) . "/templates/header-includes.php" ?>
    <style>
		.body-container hr {
			margin-top:50px !important;
			margin-bottom:50px !important;
		}
	</style>
</head>

<body>
    <?php require dirname(__DIR__, 1) . "/templates/navbar.php" ?>
	<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
        <center><img src="/assets/img/browntulstar-logo.png" style="border-radius: 100%;width:auto;max-width:200px" /></center>
        <h1 style="text-align: center;">Hi, I'm Browntul.</h1>
        <p style="text-align: center;">You can call me Brown, Browntul, Brown Toaster, BT, Star... actually, "Brown" is fine :)</p>
        <p style="text-align: center;">My pronouns are he/him/his. <br />
            I'm an aspiring game developer / designer. <br />
            I stream Switch games and KartRider Rush+ on the NA/West server. <br />
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
                                <li>Rank: 21,038 VR as of Oct 13th, 2021</li>
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
                            <h5 class="card-title  text-center">KartRider Rush+</h5>
                            <ul>
                                <li>Build: BROWN, Jin Ramen Kart, Busta Bear, Mech Core.</li>
                                <li>Rank: Legend (Season 9)</li>
                                <li>Club: TurtleNation</li>
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
                                    <li>Secondaries: Viper, Astra</li>
                                </ul>
                                <li>Rank: Silver 1 (Ep 4 Act 1)</li>
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
                    <center><img src="/assets/img/turtlecirclehack.png" class="card-img-top" alt="" style="object-fit:contain;height:150px;padding:20px"></center>
                        <div class="card-body">
                            <h5 class="card-title  text-center">Coding</h5>
                            <p style="text-align:center">I make games for fun, and I create coding content on stream.</p>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-3">
                    <div class="card" style="width: 100%; height:100%">
                    <center><img src="/assets/img/turtlecirclecaster.png" class="card-img-top" alt="" style="object-fit:contain;height:150px;padding:20px"></center>
                        <div class="card-body">
                            <h5 class="card-title  text-center">Shoutcasting</h5>
                            <p style="text-align:center">I shoutcast VALORANT and Tetris tournaments year-round!</p>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-3">
                    <div class="card" style="width: 100%; height:100%">
                    <center><img src="/assets/img/turtlecirclekj.png" class="card-img-top" alt="" style="object-fit:contain;height:150px;padding:20px"></center>
                        <div class="card-body">
                            <h5 class="card-title  text-center">Event Planning</h5>
                            <p style="text-align:center">I help plan streamer tournaments and events hosted on Twitch.</p>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-3">
                    <div class="card" style="width: 100%; height:100%">
                    <center><img src="/assets/img/turtlecirclegood.png" class="card-img-top" alt="" style="object-fit:contain;height:150px;padding:20px"></center>
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
                        <img src="/assets/img/comfycafelogo.png" class="card-img-top" alt="comfy cafe logo" style="padding: 20px;object-fit: contain;height:200px">
                        <div class="card-body">
                            <h5 class="card-title  text-center">Comfy Cafe</h5>
                            <p style="text-align:center"><a href="https://comfycafe.carrd.co" target="_blank">Content Creation Team</a></p>
                            <p style="text-align:center">Chaotic Online Mutual Friendships For You</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col col-md-12">
                    <center>
                    <h2>Let's Chat!</h2>
                        <button class="btn btn-primary">
                            <a style="color:white; text-decoration: none;font-size:24px" href="https://twitter.com/browntulstar" target="_blank">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                        </button>
                        <button class="btn btn-primary">
                        <a style="color:white; text-decoration: none;font-size:24px" href="https://twitch.tv/browntulstar" target="_blank">
                            <i class="fab fa-twitch"></i> Twitch
                        </a>
                        </button>
                        <button class="btn btn-primary">
                            <a style="color:white; text-decoration: none;font-size:24px" href="mailto:browntulstar@gmail.com" target="_blank">
                                <i class="fa fa-envelope" aria-hidden="true"></i> Email
                            </a>
                        </button>
                        <br/>
                    </center>
                </div>
            </div>
        </div>
    </div>
	<?php require dirname(__DIR__, 1) . "/templates/footer.php" ?>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>