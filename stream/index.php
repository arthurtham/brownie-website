<?php
# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 1) . "/includes/functions.php";
require dirname(__DIR__, 1) . "/includes/discord.php";
require dirname(__DIR__, 1) . "/config.php";
require dirname(__DIR__, 1) . "/includes/sessiontimer.php";

?>

<html>

<head>
	<?php $title = "BrowntulStar - Schedule" ?>
	<?php require dirname(__DIR__, 1) . "/templates/header-includes.php" ?>
</head>

<body>
    <?php require dirname(__DIR__, 1) . "/templates/navbar.php" ?>
	<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
        <h1 class="text-center">Stream</h1>
        <p class="text-center"><a href="https://twitch.tv/browntulstar" target="_blank">twitch.tv/browntulstar</a></p>
        
        <iframe
            src="https://player.twitch.tv/?channel=browntulstar&parent=localhost"
            height="600"
            width="100%"
            allowfullscreen>
        </iframe>
        
        <p>
        <iframe id="open-web-calendar" 
    style="background:url('https://raw.githubusercontent.com/niccokunzmann/open-web-calendar/master/static/img/loaders/circular-loader.gif') center center no-repeat;"
    src="https://open-web-calendar.herokuapp.com/calendar.html?url=https%3A%2F%2Fapi.twitch.tv%2Fhelix%2Fschedule%2Ficalendar%3Fbroadcaster_id%3D174220979&amp;title=Browntul&#039;s%20Stream%20Schedule&amp;tabs=month&amp;tabs=agenda"
    sandbox="allow-scripts allow-same-origin allow-top-navigation"
    allowTransparency="true" scrolling="no" 
    frameborder="0" height="600px" width="100%"></iframe>
        </p>
    </div>
	<?php require dirname(__DIR__, 1) . "/templates/footer.php" ?>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>