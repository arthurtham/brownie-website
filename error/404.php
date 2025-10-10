<?php
http_response_code(404);
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Error"; 
require $dir . "/templates/header.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <div class="d-flex align-items-center justify-content-center" style="height:100%">
        <span>
            <h1 class="text-center">404 Not Found</h1>
            <p>Uh oh! Looks like this page doesn't exist. Uninspirational!</p>
        </span>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>