<?php
$dir = dirname(__DIR__, 2);
$title = "BrowntulStar - Book a Service - Success";
require $dir . "/templates/header.php";
echo '<script src="/assets/js/bootstrap-tab.js"></script>';
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 style="text-align: center;">Error</h1>
    <p>There seems to be a problem with the store right now. You can click the back button and try submitting again!</p>
    <button class="btn btn-primary" onclick="history.back()">Back</button>
    </div>

<?php require $dir . "/templates/footer.php" ?>