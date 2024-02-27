<?php
$dir = dirname(__DIR__, 2);
$title = "BrowntulStar - Credits";
require_once($dir . "/includes/mysql.php");
require $dir . "/templates/header.php";
?>

<style>
    .body-container hr {
        margin-top:50px !important;
        margin-bottom:50px !important;
    }
</style>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 style="text-align: center;">Credits</h1>
    <center>
        <p>Thank you to these wonderful contributors for their hard work. 
            You can check out their contributions below, which also includes their social links.</p>
    </center>

<?php
$mysql_artists = queryArtEntries($conn);

/* Carousel: Highlighting Artists (temporary removal)*/
// echo '<div id="carouselArt" class="carousel carousel-dark slide">';
// echo '<div class="carousel-inner">';
// echoHighlightedArtEntries($mysql_artists);
// echo '</div>';
// echo <<<CAROUSELBUTTONS
// <button class="carousel-control-prev" type="button" data-bs-target="#carouselArt" data-bs-slide="prev">
// <span class="carousel-control-prev-icon" aria-hidden="true"></span>
// <span class="visually-hidden">Previous</span>
// </button>
// <button class="carousel-control-next" type="button" data-bs-target="#carouselArt" data-bs-slide="next">
// <span class="carousel-control-next-icon" aria-hidden="true"></span>
// <span class="visually-hidden">Next</span>
// </button>
// CAROUSELBUTTONS;
// echo "</div><hr />";


/* Specific Artists */
echoCardEntries($mysql_artists);

echoModalEntries($mysql_artists);

?>

</div>

<?php

require $dir . "/templates/footer.php";




function queryArtEntries($conn) {
    $sql = "SELECT * FROM artists WHERE entry_active = 1 ORDER BY sort_order ASC;";
    $result = $conn->query($sql);
    return $result;
}

function echoHighlightedArtEntries($result) {
    if (isset($result->num_rows) && $result->num_rows > 0) {
        $show_active_text = " active";
        while ($item = $result->fetch_assoc()) {
            if ($item["entry_highlight"] == 0) {
                continue;
            }
            echo '<div class="carousel-item' . ($show_active_text) . '" style="" oncontextmenu="return false;">';
            echo '<img src="'.$item["portfolio_image"].'" class="d-block w-80" style="width:100%;height:500px;object-fit:contain;" alt="portfolio image: '.$item["name"].'" />';
            echo '<div class="carousel-caption d-block" style="background-color:rgb(255,255,255,0.7)">';
            echo '<h5>'.$item["name"].'</h5>';
            echo '<p>'.$item["subheader"].'</p>';
            echo '<button type="button" class="btn btn-secondary" style="width:100%;margin-bottom:18px" data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'">Info</button>';
            echo '</div>';
            echo '</div>';
            $show_active_text = "";
        }
        mysqli_data_seek($result,0);
    }
}

function echoCardEntries($result) {
    if (isset($result->num_rows) && $result->num_rows > 0) {
        $count = 0;
        while ($item = $result->fetch_assoc()) {
            if ($count % 3 == 0) {
                if ($count > 0) {
                    echo '</div>';
                }
                echo '<div class="row" style="padding-bottom:10px" oncontextmenu="return false;">';
            }
            echo '<div class="col-md-4 d-flex align-items-stretch"><div class="card" style="width:100% !important;">';
            echo '<a data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'">
            <div style="position:relative;background-color:lightgray"><img src="'.$item["portfolio_image"].'" 
            class="card-img-top" alt="portfolio image: '.$item["name"].'"><img src="'.$item["logo_image"].'" 
            style="position:absolute;top:0px;left:0px;width:75px;height:75px;background-color:gray;border: 2px solid black;border-width:thick" 
            alt="logo image: '.$item["name"].'"></div></a>';
            echo '<div class="card-body">';
            echo '<button type="button" class="btn btn-dark" style="width:100%;margin-bottom:18px" data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'">Info</button>';
            echo '<h5 class="card-title">'.$item["name"].'</h5>';
            echo '<p class="card-text">'.$item["subheader"].'</p>';
            echo '</div>';
            echo '</div></div>';
            $count += 1;
        }
        echo '</div>';
        mysqli_data_seek($result,0);
    }
}

function echoModalEntries($result) {
    if (isset($result->num_rows) && $result->num_rows > 0) {
        while ($item = $result->fetch_assoc()) {
            /* Links */
            $links = array();
            foreach ([
                "website"   => [$item["links_website"],"fa-solid fa-globe","","Website"],
                "vgen"      => [$item["links_vgen"],"fa-solid fa-v","https://vgen.co/","VGen"],
                "ko-fi"     => [$item["links_kofi"],"fa-solid fa-mug-hot","https://ko-fi.com/","Ko-fi"],
                "etsy"      => [$item["links_etsy"],"fa-brands fa-etsy","https://etsy.com/shop/","Etsy"],
                "twitch"    => [$item["links_twitch"],"fa-brands fa-twitch","https://twitch.tv/","Twitch"],
                "twitter"   => [$item["links_twitter"],"fa-brands fa-x-twitter","https://twitter.com/","X (Twitter)"],
                "instagram" => [$item["links_instagram"],"fa-brands fa-instagram","https://instagram.com/","Instagram"],
            ] as $category => $contents) {
                if (strlen($contents[0]) <= 0) {
                    $links[$category] = "";
                } else {
                    $links[$category] = '<a href="'.$contents[2].$contents[0].'" target="_blank" class="btn btn-dark" style="width:50px">
                    <i class="'.$contents[1].'"></i></a> <strong>'.$contents[3].'</strong>: '.$contents[0].'<br />';
                }
            }
            $links_string = join($links);

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
                            <center><img src="{$item["logo_image"]}" style="max-width:200px;max-height:200px;object-fit:contain;border: 3px solid black;border-radius:20px;" oncontextmenu="return false;" alt="portfolio image: {$item["name"]}" /></center><br />
                            <center><h5>{$item["name"]}</h5></center>
                            <center><p>{$item["subheader"]}</p></center>
                            <p>{$item["description"]}</p>
                            <h5>Links</h5>
                            <span>{$links_string}</span>
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


?>