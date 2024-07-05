<?php
$dir = dirname(__DIR__, 2);
$title = "Turtle Pond - YEAH!";
require $dir . "/templates/header.php";

?>
<div class="container body-container-home"> 
    <div id="center-block" class="d-flex flex-column align-items-center justify-content-center">
        <div class="text-center" style="max-width:400px">
            <button id="yeahbutton"></button>
            <h1 style="font-size: 96px;"><span id="yeahbuttoncounter">0</span></h1>
        </div>
    </div>
</div>


<style>
#yeahbutton {
    background-image: url("https://res.cloudinary.com/browntulstar/image/private/s--5vwUdda1--/c_scale,w_400/com.browntulstar/img/turtleyeah.png");
    background-size: contain;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    background-color: #00000000;
    /* put the height and width of your image here */
    width:fit-content;
    height:fit-content;
    min-width: 350px;
    min-height: 153px;
    border: none;
    animation: yeahButtonZoomOut 0.1s forwards;
}

#yeahbutton.yeahbuttonhover {
    animation: yeahButtonZoomIn 0.1s forwards;
}

#yeahbutton.yeahbuttonhover.yeahbuttondown {
    animation: yeahButtonZoomOutSmall 0.05s forwards !important;
}

@keyframes yeahButtonZoomIn {
    from {
        transform: scale(1.0);
    }
    to {
        transform: scale(1.05);
    }
}
@keyframes yeahButtonZoomOut{
    from {
        transform: scale(1.05);
    }
    to {
        transform: scale(1.0);
    }
}
@keyframes yeahButtonZoomOutSmall{
    from {
        transform: scale(1.05);
    }
    to {
        transform: scale(1.01);
    }
}
</style>
<script src="script.js" type="text/javascript"></script>
<script type="module" src="particles.js" type="text/javascript"></script>

<?php

require $dir . "/templates/footer.php";