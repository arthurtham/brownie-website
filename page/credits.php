<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Credits";
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
    <h1 class="text-center">Credits</h1>
    <p class="text-center">Thank you to these wonderful contributors for their hard work. 
            You can check out their contributions below, which also includes their social links.</p>

<?php
$mysql_artists = queryArtEntries($conn);

/* Carousel: Highlighting Artists (temporary removal)*/
echoHighlightedArtEntries($mysql_artists);
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
    echo '<div id="carouselArt" class="carousel carousel-light slide bg-dark" data-bs-ride="carousel">';
    echo '<div class="carousel-inner">';
    global $cldSigner;
    if (isset($result->num_rows) && $result->num_rows > 0) {
        $show_active_text = " active";
        while ($item = $result->fetch_assoc()) {
            if ($item["entry_highlight"] == 0) {
                continue;
            }
            echo '<div class="carousel-item' . ($show_active_text) . '" style="padding: 20px;" oncontextmenu="return false;">';
            echo '<img loading="lazy" src="'.$cldSigner->signUrl($item["portfolio_image"]).'" class="d-block w-100" style="height: 300px;object-fit:contain;" alt="portfolio image: '.$item["name"].'" />';
            echo '<div class="carousel-caption d-block rounded rounded-3" style="position: relative; left: 0; right: 0; bottom: 0;">';
            echo '<h5>'.$item["name"].'</h5>';
            echo '<p>'.$item["subheader"].'</p>';
            echo '<button type="button" class="btn btn-sm btn-success" style="width:100%;max-width:200px;" data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'">More Info</button>';
            echo '</div>';
            echo '</div>';
            $show_active_text = "";
        }
        mysqli_data_seek($result,0);
    }
    echo '</div>';
    echo <<<CAROUSELBUTTONS
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselArt" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselArt" data-bs-slide="next">
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
        ?>
        <div class="d-flex flex-column align-items-center justify-contents-center"><div id="prt_items" style="width: 100%; max-width: 600px; min-height:60vh;">
        <div class="input-group mb-2">
            <span class="input-group-text"><label for ="search-text"><i class="fa-solid fa-magnifying-glass"></i> Search</label></span>
            <input class="search form-control" type="text" name="search-text" id="search-text" placeholder="Name / Type" value="" />
            <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="searchFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Filters
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" id="searchFilterDropdownMenu" aria-labelledby="searchFilterDropdown">
                <li><a class="dropdown-item" onclick='fillSearchText("")'>Show All</a></li>
                <li><h6 class="dropdown-divider"></h6></li>
                <li><a class="dropdown-item" onclick='fillSearchText("logo")'>Logos</a></li>
                <li><a class="dropdown-item" onclick='fillSearchText("emote")'>Emotes</a></li>
                <li><a class="dropdown-item" onclick='fillSearchText("badge")'>Badges</a></li>
                <li><a class="dropdown-item" onclick='fillSearchText("overlay")'>Overlays</a></li>
                <li><a class="dropdown-item" onclick='fillSearchText("hardware")'>Hardware</a></li>
                <li><a class="dropdown-item" onclick='fillSearchText("widget")'>Widgets</a></li>
            </ul>
        </div>
        <div>
            <div class="input-group input-group-sm mb-2">
                <button class="sort btn btn-success btn-sm" data-sort="prt-name">Sort by Name</button>
            </div>
        </div>
        <ul class="list-unstyled list">
        <?php
        while ($item = $result->fetch_assoc()) {
            echo "<li>";
            // if ($count % 2 == 0) {
            //     if ($count > 0) {
            //         echo '</div>';
            //     }
            //     echo '<div class="row" style="padding-bottom:10px" oncontextmenu="return false;">';
            // }
            // echo '<li><div class="col-lg-6 mb-2 d-flex align-items-stretch">';
            $signed_portfolio_image = $cldSigner->signUrl($item["portfolio_image"]);
            $portfolio_name = $item["name"];
            $portfolio_id = $item["id"];
            $portfolio_subheader = $item["subheader"];
            $logo_image = $cldSigner->signUrl($item["logo_image"]);
            // $links_string = generateLinksString($item, false, -1);

            echo <<<CREDITSPOST
                <div class="card mt-2" style="width: 100%;color:black">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4" oncontextmenu='return false;' ondragstart='return false;'>
                                    <center><div><img loading="lazy" class="rounded shadow" src="$signed_portfolio_image" style="max-height: 200px; max-width: min(100%,225px);" /><img loading="lazy" src="$logo_image" 
            class="shadow" style="position:absolute;top:0px;left:0px;width:75px;height:75px;background-color:gray;border: 1px solid black;border-width:normal;border-top-left-radius:5px;border-bottom-right-radius:10px;" 
            alt="logo image: $portfolio_name"></div></center>
                                    <br />
                                </div>
                                <div class="col-lg-8 card-content-center">
                                    <h2 class="card-title prt-name">$portfolio_name</h2>
                                    <p class="prt-subheader">$portfolio_subheader</p>
                                    <p><button type="button" class="btn btn-success" margin-bottom:18px" data-bs-toggle="modal" data-bs-target="#modal-$portfolio_id">More Info</button></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
CREDITSPOST;
            // echo "</div></li>";
            echo "</li>";
            $count += 1;
            }
        echo "</ul></div></div>";
        ?>
        <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
        <script>
            var options = { valueNames: ['prt-name', 'prt-subheader']};
            var linkList = new List('prt_items', options);

            function fillSearchText(phrase) {
                var searchBox = document.getElementById("search-text");
                searchBox.value=phrase;
                searchBox.dispatchEvent(new KeyboardEvent('keyup', { keyCode: 13}));
            }
        </script>
        <?php
        mysqli_data_seek($result,0);
    }
}

function echoModalEntries($result) {
    global $cldSigner;
    if (isset($result->num_rows) && $result->num_rows > 0) {
        while ($item = $result->fetch_assoc()) {
            $links_string = generateLinksString($item, false, -1);

            /* Export */
            echo <<<MODALENTRY
            <div class="modal modal-description fade" style="overflow: hidden !important" id="modal-{$item["id"]}" tabindex="-1" aria-labelledby="modal-{$item["id"]}-label" aria-hidden="true">
                <div class="modal-dialog" style="overflow: hidden !important">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modal-{$item["id"]}-label"></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <center>
                            <img loading="lazy" src="{$cldSigner->signUrl($item["logo_image"])}" class="mb-2" style="width:200px;height:200px;object-fit:contain;border: 3px solid black;border-radius:20px;" oncontextmenu="return false;" alt="logo image: {$item["name"]}" />
                            </center><br />
                            <center><h1 style="word-break: break-word">{$item["name"]}</h1>
                            <p>{$item["subheader"]}</p>
                            <span>{$links_string}</span></center>
                            <p>{$item["description"]}</p>
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

function generateLinksString($item, $textLabels=true, $countLimit=-1) {
    /* Links */
    $counter = 0;
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
            $links[$category] = '<a href="'.$contents[2].$contents[0].'" target="_blank" class="btn btn-dark mb-2" style="width:40px;">
            <i class="'.$contents[1].'"></i></a>';
            if ($textLabels) {
                $links[$category] .= ' <span style="display: inline-block !important;margin-top:-10px !important"><strong>'.$contents[3].'</strong>: '.$contents[0].'</span><br />';
            } else {
                $links[$category] .= ' ';
            }
            $counter += 1;
            if ($countLimit != -1 && $counter >= $countLimit) {
                break;
            }
        }
    }
    $links_string = join($links);
    return $links_string;
}

?>