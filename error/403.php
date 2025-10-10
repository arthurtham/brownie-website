<?php
http_response_code(403);
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Error"; 
require $dir . "/templates/header.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <div class="d-flex flex-column align-items-center justify-content-center" style="height:100%">
        <span>
            <h1 class="text-center">403 Forbidden</h1>
            <p>Looks like you're not supposed to be here. Uninspirational!</p>
        </span>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>