<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Discord";
require $dir . "/templates/header.php";
?>
<div class="container body-container">
    <h1 class="text-center">Discord Server Selection</h1>
    <p class="text-center">Please select a Discord server to join.</p>
    <div class="row">
        <div class="col-lg-6 mb-2 d-flex align-items-stretch">
            <div class="card h-100 w-100">
                <center>
                    <img 
                        loading="lazy" 
                        src="https://res.cloudinary.com/browntulstar/image/private/s--gRiI4zsg--/c_pad,h_400/e_shadow/com.browntulstar/img/browntulstar-logo-v2-large.png" 
                        class="card-img-top" 
                        style="height:150px;width:auto;padding:10px"
                        alt="BrowntulStar Logo"
                    >
                </center>
                <div class="card-body text-center">
                    <h3 class="card-title">Browntul's Turtle Pond</h3>
                    <a href="/r/discord" class="btn btn-dark mb-2"><i class="fa-brands fa-discord"></i> Join Community Server</a>
                    <p><span class="badge bg-danger mb-2">Join to Set Up Twitch Perks</span><br><span class="badge bg-info text-black">Join to Set Up IRIAM Perks</span></p>
                    <p class="card-text">Join this server to chat with fellow community members from Browntul's Twitch and IRIAM streams.
                    After joining this server and claiming your Twitch sub and IRIAM ★ Star Badge roles,
                    sign in to this website using Discord and activate your supporter perks.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-2 d-flex align-items-stretch">
            <div class="card h-100 w-100">
                <center>
                    <img 
                        loading="lazy" 
                        src="https://res.cloudinary.com/browntulstar/image/private/s--5R7V9ugr--/c_pad,w_300,h_300,ar_1:1/f_webp/v1/com.browntulstar/img/brownieval-logo-v1.webp?_a=BAAAV6E0" 
                        class="card-img-top" 
                        style="height:150px;width:auto;padding:10px"
                        alt="BrownieVAL Logo"
                    >
                </center>
                <div class="card-body text-center">
                    <h3 class="card-title">#BrownieVAL / Browntul's Events</h3>
                    <a href="/r/brownievaldiscord" target="_blank" class="btn btn-dark mb-2"><i class="fa-brands fa-discord"></i> Join Events Server</a>
                    <p><span class="badge bg-secondary">Join to Set Up Access Event-Specific Pages</span></p>
                    <p class="card-text">Join this server to take part in #BrownieVAL and Browntul's events.
                    After joining this server and claiming your game roles,
                    sign in to this website using Discord to access event-specific webpages.</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="text-center">Check Your Roles</h1>
            <p class="text-center">If you're logged in to this website using a Discord account that has joined a server above,
             then you can see what roles you have. 
             If these roles aren't correct and you just got them recently, please log out and log back in again.</p>
            <?php 
            if (isset($_SESSION['user'])) {
                require $dir . "/templates/profile-box.php";
            } else {
                print_navbar_login_items($expand = true, $center = true, $subperks = false, $label = true);
            }
            ?>
        </div>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>