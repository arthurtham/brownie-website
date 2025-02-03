<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Coding";
require $dir . "/templates/header.php";
?>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Coding</h1>
    <p class="text-center">I am a software developer that went to school in programming. This whole website was coded by me!
    </p>
    <hr>
    <p>
        <div class="row">
            <center><h2>Featured Coding Partners</h2></center>
        </div>
        <div class="row">
            <div class="col col-md-6">
                <div class="card" style="width: 100%; height:100%">
                    <center><img src="https://res.cloudinary.com/browntulstar/image/private/s--BbUcdJY2--/c_pad,w_200/f_webp/v1/com.browntulstar/img/coding-mfgj?_a=BAAAUWGX" class="img-fluid rounded-start" width=100% style="max-width:200px;padding-top:20px" alt="...">
                    </center>
                    <div class="card-body">
                        <h4 class="card-title text-center">My First Game Jam</h4>
                        <p class="card-text text-center">An online game jam for people of all skill levels to learn something new! Every summer on this channel, I stream myself playtesting game jam games for the community to review together.</p>
                        <p class="card-text text-center"><small class="text-muted">For more information about My First Game Jam, go to <br><a href="https://myfirstgamejam.tumblr.com/" target="_blank">https://myfirstgamejam.tumblr.com/</a></small></p>
                    </div>
                </div>
            </div>
            <div class="col col-md-6">
                <div class="card" style="width: 100%; height:100%">
                    <center><img src="https://res.cloudinary.com/browntulstar/image/private/s--bC9s9x1B--/c_pad,w_200/f_webp/v1/com.browntulstar/img/coding-cloudinary?_a=BAAAUWGX" class="img-fluid rounded-start" width=100% style="max-width:200px;padding-top:20px" alt="...">
                    </center>
                    <div class="card-body">
                        <h4 class="card-title text-center">Cloudinary</h4>
                        <p class="card-text text-center">A platform featuring optimized media transformations and delivery! This website's media projects are powered by Cloudinary, and many media assets are delivered from Cloudinary's CDN.</p>
                        <p class="card-text text-center"><small class="text-muted">For more information about Cloudinary, go to <br><a href="https://cloudinary.com/" target="_blank">https://cloudinary.com/</a></small></p>
                    </div>
                </div>
            </div>
        </div>
        </p>
        <hr>
        <p>
        <div class="row">
            <center><h2>Featured Games</h2></center>
            <p class="text-center">Please visit the <a href="/app">Apps and Games</a> page for more information about the games I have developed.</p>
        </div>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>