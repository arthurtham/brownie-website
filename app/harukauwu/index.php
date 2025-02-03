<?php
$dir = dirname(__DIR__, 2);
$title = "BrowntulStar - HarukaUWU";
require $dir . "/templates/header.php";

?>
<div style="padding-top:56px" name="game-div" id="game-div">
</div>
<script>
const iframe = document.createElement('iframe');
iframe.src = "./game/game.html?timestamp="+new Date().getTime();
iframe.style.width = "100%";
iframe.style.height = "calc(100vh - 56px)"; 
iframe.style.border = "none";
document.getElementById("game-div").appendChild(iframe);

</script>
<?php
$_FOOTER_HOME = true;
require $dir . "/templates/footer.php";