<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Apps and Games";
require_once($dir . "/includes/mysql.php");
require $dir . "/templates/header.php";
require_once $dir . "/includes/CloudinarySigner.php";
$cldSigner = new CloudinarySigner();
?>
<style>
    .body-container hr {
        margin-top:50px !important;
        margin-bottom:50px !important;
    }
</style>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Apps and Games</h1>
    <p class="text-center">
        Here are some of the apps and games that I have developed. 
        You can check out the links below to download and play them.
    </p>

<?php 
$mysql_applications = queryAppEntries($conn);

/* Carousel: Highlighting Artists (temporary removal)*/

echoHighlightedAppEntries($mysql_applications);
echoCardEntries($mysql_applications);
echoModalEntries($mysql_applications);

?>
</div>

<?php
$_FOOTER_HOME = false;
require $dir . "/templates/footer.php";



function queryAppEntries($conn) {
    $sql = "SELECT * FROM applications WHERE entry_active = 1 ORDER BY sort_order ASC;";
    $result = $conn->query($sql);
    return $result;
}

function echoHighlightedAppEntries($result) {
    echo '<div id="carouselApp" class="carousel carousel-light slide bg-dark rounded rounded-5">';
    echo '<div class="carousel-inner">';
    global $cldSigner;
    if (isset($result->num_rows) && $result->num_rows > 0) {
        $show_active_text = " active";
        while ($item = $result->fetch_assoc()) {
            if ($item["entry_highlight"] == 0) {
                continue;
            }
            echo '<div class="carousel-item' . ($show_active_text) . '" style="" oncontextmenu="return false;">';
            echo '<img loading="lazy" src="'.$cldSigner->signUrl($item["thumbnail"]).'" class="d-block w-80" style="width:100%;height:500px;object-fit:contain;" alt="portfolio image: '.$item["name"].'" />';
            echo '<div class="carousel-caption d-block rounded rounded-3" style="background-color:rgb(0,0,0,0.7)">';
            echo '<h5>'.$item["name"].'</h5>';
            echo '<p>'.$item["subheader"].'</p>';
            echo '<button type="button" class="btn btn-sm btn-success" style="width:100%;max-width:200px;margin-bottom:18px" data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'">More Info</button>';
            echo '</div>';
            echo '</div>';
            $show_active_text = "";
        }
        mysqli_data_seek($result,0);
    }
    echo '</div>';
    echo <<<CAROUSELBUTTONS
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselApp" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselApp" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
    </button>
CAROUSELBUTTONS;
    echo "</div><hr />";
}

function echoCardEntries($result) {
    global $cldSigner;
    if (isset($result->num_rows) && $result->num_rows > 0) {
        $count = 0;
        while ($item = $result->fetch_assoc()) {
            if ($count % 2 == 0) {
                if ($count > 0) {
                    echo '</div>';
                }
                echo '<div class="row" style="padding-bottom:10px" oncontextmenu="return false;">';
            }
            echo '<div class="col-lg-6 mb-2 d-flex align-items-stretch">';
                echo <<<CARD
                <div class="card mb-3" style="width: 100%;color:black">
                    <div class="row g-0">
                        <div class="col-md-4" style="align-items: middle;">
                            <img loading="lazy" src="{$cldSigner->signUrl($item["thumbnail"])}" style="width: 100%; height: 100%; object-fit: cover;" />
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{$item['name']}</h5>
                                <p class="card-text">{$item['short_description']}</p>
                                <p>
                                    <a class="btn btn-primary" href="{$item['game_link']}" role="button">Play</a>
                                    <button type="button" class="btn btn-success" margin-bottom:18px" data-bs-toggle="modal" data-bs-target="#modal-{$item['id']}">Info</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
CARD;
            echo '</div>';
            $count++;
        }
    }
    echo "</div>";
    mysqli_data_seek($result,0);
}

function echoModalEntries($result) {
    global $cldSigner;
    if (isset($result->num_rows) && $result->num_rows > 0) {
        while ($item = $result->fetch_assoc()) {
            // $media = (isset($item["youtube_id"]) && ($item["youtube_id"] !== "") ? 
            // '<iframe width="100%" height="200" src="https://www.youtube-nocookie.com/embed/'.$item["youtube_id"].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>'
            // : 
            $media = '<img loading="lazy" src="'.$cldSigner->signUrl($item["thumbnail"]).'" class="mb-2" style="width:200px;height:200px;object-fit:cover;border: 3px solid black;border-radius:20px;" oncontextmenu="return false;" alt="logo image: '.$item["name"].'" />';
            // );
            /* Export */
            echo <<<MODALENTRY
            <div class="modal fade" style="overflow: hidden !important" id="modal-{$item["id"]}" tabindex="-1" aria-labelledby="modal-{$item["id"]}-label" aria-hidden="true">
                <div class="modal-dialog" style="overflow: hidden !important">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modal-{$item["id"]}-label"></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="height:60vh;overflow-y:auto">
                            <center>
                            $media
                            </center><br />
                            <center><h1 style="word-break: break-word">{$item["name"]}</h1>
                            <h5>{$item['short_description']}</h5>
                            <p>{$item["description"]}</p>
                            <p><a class="btn btn-primary" href="{$item['game_link']}" role="button">Play Game</a></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
MODALENTRY;
        }
        mysqli_data_seek($result,0);
    }
}