<?php 
$_game_div_dir = dirname(__DIR__, 1);
$_disallow_navbar = true;
require $_game_div_dir . "/templates/header.php";
if (!isset($_game_src)) {
    $_game_src = "./game/game.html";
}
?>
<div name="game-div" id="game-div">
</div>
<div id="small-screen-warning">
</div>
<script>
const iframe = document.createElement('iframe');
iframe.className = "game-div-iframe";
iframe.src = "<?=$_game_src; ?>?ts="+new Date().getTime();
document.getElementById("game-div").appendChild(iframe);

function smallScreenWarning() {
    let windowWidth = 800;
    if (window.innerWidth < windowWidth) {
        document.getElementById("small-screen-warning").innerHTML = `
        <div class="modal fade" id="smallScreenModal" tabindex="-1" aria-labelledby="smallScreenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallScreenModalLabel">Unoptimized</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                The screen size of your device is smaller than `+windowWidth+`px wide. 
                For the best experience, please use a desktop browser with a larger browser window.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            </div>
            </div>
        </div>
        </div>
        `;
        const smallScreenModal = new bootstrap.Modal(document.getElementById('smallScreenModal'));
        smallScreenModal.show();
    }
}
window.onload = smallScreenWarning;
</script>

<?php
$_FOOTER_APPS = true;
require $_game_div_dir . "/templates/footer.php";