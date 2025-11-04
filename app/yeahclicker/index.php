<?php
$dir = dirname(__DIR__, 2);
$title = "Turtle Pond - YEAH!";
require $dir . "/templates/header.php";

?>
<link rel="stylesheet" href="style.css?v=2025-01-27">
<div class="container body-container-home"> 
    <div id="center-block" class="d-flex flex-column align-items-center justify-content-center">
        <div class="text-center" style="max-width:400px">
            <button id="yeahbutton"></button>
            <h1 style="font-size: 96px;"><span id="yeahbuttoncounter">0</span></h1>
        </div>
    </div>
</div>
<script src="script.js?v=2025-10-13" type="text/javascript"></script>
<script type="module" src="particles.js?v=2025-10-13" type="text/javascript"></script>

<?php

require $dir . "/templates/footer.php";