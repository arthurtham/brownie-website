<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Coding";
require_once($dir . "/includes/mysql.php");
require $dir . "/templates/header.php";
?>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Coding</h1>
    <p class="text-center">I am a software developer that went to school in programming. This whole website was coded by me!
    </p>
    <hr>
    <h2 class="text-center">My Skills</h2>
    <p>
    <div class="row">
        <div class="col-lg-4">
            <div class="card" style="width: 100%; height:100%">
                <div class="card-body">
                    <h4 class="card-title text-center">Programming Languages</h4>
                    <p class="card-text text-center">Here's the languages I use:</p>
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item">HTML / CSS / Javascript</li>
                        <li class="list-group-item">PHP / MySQL / MariaDB / MongoDB</li>
                        <li class="list-group-item">Python 3 / Flask</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="width: 100%; height:100%">
                <div class="card-body">
                    <h4 class="card-title text-center">Frameworks / Engines</h4>
                    <p class="card-text text-center">Here's the frameworks I use:</p>
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item">Bootstrap 5 CSS / Javascript</li>
                        <li class="list-group-item">GameMaker: Studio 1</li>
                        <li class="list-group-item">Unity 3D</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="width: 100%; height:100%">
                <div class="card-body">
                    <h4 class="card-title text-center">Applications / Systems</h4>
                    <p class="card-text text-center">Here's some tech things I know:</p>
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item">Windows, macOS, iOS</li>
                        <li class="list-group-item">Microsoft Office, Google Apps</li>
                        <li class="list-group-item">VMWare Workstation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </p>
    <hr>
    <p>
    <div class="row">
        <h2 class="text-center">Coding Partners</h2>
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
        <h2 class="text-center">Apps and Games</h2>
        <p class="text-center">Please visit the <a href="/app">Apps and Games</a> page to see the games I have developed.</p>
        <center><div id="apps-container" class="rounded">
            <div class="photobanner">
                <?php
                $sql = "SELECT * FROM applications WHERE entry_active = 1 ORDER BY sort_order ASC;";
                $result = $conn->query($sql);
                if (isset($result->num_rows) && $result->num_rows > 0) {
                    $images_to_echo = "";
                    while ($item = $result->fetch_assoc()) {
                        if ($first_item == null) {
                            $first_item = $item;
                        }
                        $images_to_echo .= "<img class='rounded shadow border' style='height:200px' src='" . $item["thumbnail"] . "' />";
                    }
                    echo $images_to_echo . $images_to_echo;
                }
                ?>
            </div>
        </div></center>
    </div>
</div>

<style>
    /* Lety */
    #apps-container {
        height: 200px;
        width: 90%;
        position: relative;
        overflow: hidden;
    }

    .photobanner {
        position: absolute;
        top: 0px;
        left: 0px;
        overflow: hidden;
        white-space: nowrap;
        animation: bannermove 20s linear infinite;
    }

    .photobanner img {
        margin: 0 0.5em
    }

    @keyframes bannermove {
        0% {
            transform: translate(0, 0);
        }

        100% {
            transform: translate(-50%, 0);
        }
    }
</style>
<?php require $dir . "/templates/footer.php" ?>