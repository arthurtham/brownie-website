<?php 
$_disallow_navbar = true;
require $dir . "/templates/header.php";
if (!isset($_game_src)) {
    $_game_src = "./game/game.html";
}
?>
<div name="game-div" id="game-div">
</div>
<script>
const iframe = document.createElement('iframe');
iframe.className = "game-div-iframe";
iframe.src = "<?=$_game_src; ?>?ts="+new Date().getTime()+"&ref="+document.referrer;
document.getElementById("game-div").appendChild(iframe);
</script>

<?php
$_FOOTER_APPS = true;
require $dir . "/templates/footer.php";