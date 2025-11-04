<?php 
$_game_div_dir = dirname(__DIR__, 1);
$_disallow_navbar = true;
require $_game_div_dir . "/templates/header.php";
if (!isset($_game_src)) {
    $_game_src = "./game/game.html";
}
if (!isset($_game_gpu_check)) {
    $_game_gpu_check = false;
}
?>
<div name="game-div" id="game-div">
</div>
<div id="small-screen-warning">
</div>
<?php
if ($_game_gpu_check) {
?>
<script src="/assets/js/gpu-check.js" data-info-url="https://manthrax.github.io/mtx-gpuinfo/" async></script>
<?php
}
?>
<script src="/assets/js/app-small-screen.js" async></script>
<script>
const iframe = document.createElement('iframe');
iframe.className = "game-div-iframe";
iframe.src = "<?=$_game_src; ?>?ts="+new Date().getTime();
document.getElementById("game-div").appendChild(iframe);
</script>

<?php
$_FOOTER_APPS = true;
require $_game_div_dir . "/templates/footer.php";