<?php
$dir = dirname(__DIR__, 2);
$title = "Turtle Pond - Cash Mountain";
require $dir . "/templates/header.php";

?>
<div style="padding-top:56px">
<iframe src="game.html" style="width: 100%; height: calc(100vh - 56px); border: none;"></iframe>
</div>
<?php
$_FOOTER_HOME = true;
require $dir . "/templates/footer.php";