<?php
# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 2) . "/includes/functions.php";
require dirname(__DIR__, 2) . "/includes/discord.php";
require dirname(__DIR__, 2) . "/config.php";
require dirname(__DIR__, 2) . "/includes/sessiontimer.php";

?>

<html>

<head>
	<title>BrowntulStar - Coding</title>
	<?php require dirname(__DIR__, 2) . "/templates/header-includes.php" ?>
</head>

<body>
    <?php require dirname(__DIR__, 2) . "/templates/navbar.php" ?>
	<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
        <h1 class="text-center">Coding</h1>
        <p>I'm a coder at heart. I started making games when I was in high school, and continue to make mini web games as
            a hobby! I currently make content in collaboration with <strong>Cloudinary</strong> and <strong>My First Game Jam</strong> which is featured on my streams from time to time.
        </p>
        <hr>
        <p>
            <div class="row">
                <center><h2>Featured Coding Content</h2></center>
            </div>
            <br>
            <div class="row">
                <div class="col col-md-5 offset-md-1">
                    <div class="card" style="width: 100%; height:100%">
                        <center><img src="/assets/img/cloudinary.png" class="img-fluid rounded-start" width=100% style="max-width:200px;padding-top:20px" alt="..."></center>
                        <div class="card-body">
                            <h4 class="card-title text-center">Coding with Cloudinary</h4>
                            <p class="card-text text-center">In coding streams sponsored by Cloudinary, viewers learn how to create fast and personalized media experiences with Cloudinary APIs, Widgets, and SDKs. Viewers also learn about the power of game development and design though the power of media and web technologies such as Javascript and Python.</p>
                            <p class="card-text text-center"><small class="text-muted">For more information about Cloudinary, go to <br><a href="https://www.cloudinary.com" target="_blank">https://www.cloudinary.com</a></small></p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-5">
                    <div class="card" style="width: 100%; height:100%">
                        <center><img src="/assets/img/mfgj-logo.png" class="img-fluid rounded-start" width=100% style="max-width:200px;padding-top:20px" alt="...">
                        </center>
                        <div class="card-body">
                            <h4 class="card-title text-center">My First Game Jam: Dev Showcase</h4>
                            <p class="card-text text-center">In the developer An online game jam for people of all skill levels to learn something new!</p>
                            <p class="card-text text-center"><small class="text-muted">For more information about My First Game Jam, go to <br><a href="https://myfirstgamejam.tumblr.com/" target="_blank">https://myfirstgamejam.tumblr.com/</a></small></p>
                        </div>
                    </div>
                </div>
            </div>
            </p>
            <hr>
            <p>
            <div class="row">
                <center><h2>Featured Games</h2></center>
            </div>
            <br>
            <div class="row">
                <div class="col col-md-5 offset-md-1">
                    <div class="card" style="width: 100%; height:100%">
                        <center><img src="/assets/img/hackuwu.png" class="img-fluid rounded-start" style="object-fit:contain;width:auto;height:200px;padding-top:20px" alt="..."></center>
                        <div class="card-body">
                            <h4 class="card-title text-center">HackUWU</h4>
                            <p class="card-text text-center"></p>
                            <p class="card-text text-center"><small class="text-muted">Play this game at  <br><a href="https://www.hackuwu.tech" target="_blank">https://www.hackuwu.tech</a></small></p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-5">
                    <div class="card" style="width: 100%; height:100%">
                        <center><img src="/assets/img/concentration.png" class="img-fluid rounded-start" style="object-fit:contain;width:auto;height:200px;padding-top:20px" alt="..."></center>
                        <div class="card-body">
                            <h4 class="card-title text-center">Concentration Training</h4>
                            <p class="card-text text-center"></p>
                            <p class="card-text text-center"><small class="text-muted">Play this game at <br><a href="https://browntulstar.itch.io/concentration" target="_blank">https://browntulstar.itch.io/concentration</a></small></p>
                        </div>
                    </div>
                </div>
            </p>
    </div>
	<?php require dirname(__DIR__, 2) . "/templates/footer.php" ?>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>