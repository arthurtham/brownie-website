<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Schedule";
require $dir . "/templates/header.php";
?>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Stream</h1>
    <p class="text-center"><a href="https://twitch.tv/browntulstar" target="_blank">twitch.tv/browntulstar</a></p>
    
    <iframe
        src="https://player.twitch.tv/?channel=browntulstar&parent=browntulstar.com"
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
<?php require $dir . "/templates/footer.php" ?>