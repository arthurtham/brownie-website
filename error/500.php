<?php
http_response_code(500);
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Error"; 
require $dir . "/templates/header.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <div class="d-flex align-items-center justify-content-center" style="height:100%">
        <span>
            <h1 class="text-center">500 Internal Error</h1>
            <p>Something inside the Turtle Pond didn't work. Uninspirational!<br/>
            It's not your fault, though. It's best to let Browntul know about this error.<br/>
            Otherwise, please try again later.</p>
        </span>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>