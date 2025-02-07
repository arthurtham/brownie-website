<?php
function echoCardEntries($result) {
    if (isset($result["error"])) {
        echo '<div class="row">';
        echo '<div class="col">';
        echo 'Error from Twitch API: ' . $result["error"];
        echo "</div>";
        return;
    }
    $count = 0;
    foreach ($result as $item) {
        $short_title = explode("|", $item["title"])[0];
        $date = date("M d, Y", strtotime($item["published_at"]));
        if ($count % 3 == 0) {
            if ($count > 0) {
                echo '</div>';
            }
            echo '<div class="row" style="padding-bottom:10px" oncontextmenu="return false;">';
        }
        echo '<div class="col-md-4 mb-2 d-flex align-items-stretch"><div class="card" style="width:100% !important;">';
        echo '<a data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'">
        <div style="position:relative;background-color:lightgray"><img src="'.$item["thumbnail_url"].'" 
        class="card-img-top" alt="video thumbnail image: '.$short_title.'"></div></a>';
        echo '<div class="card-body">';
        echo '<button type="button" class="btn btn-dark" style="width:100%;margin-bottom:18px" data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'">Watch</button>';
        echo '<h5 class="card-title">'.$short_title = explode("|", $item["title"])[0].'</h5>';
        echo '<p class="card-text">'.$date.'</p>';
        echo '</div>';
        echo '</div></div>';
        $count += 1;
    }
    echo '</div>';
}

function echoModalEntries($result) {
    if (isset($result["error"])) {
        return;
    }
    foreach ($result as $item) {
        /* Links */
        $links = array();
        foreach ([
            "twitch"    => [$item["viewable"] == "public" ? $item["url"] : "","fa-brands fa-twitch"]
        ] as $category => $contents) {
            if (strlen($contents[0]) <= 0) {
                $links[$category] = "";
            } else {
                $links[$category] = '<a href="'.$contents[0].'" target="_blank" class="btn btn-dark" style="width:100%">
                <i class="'.$contents[1].'"></i> Watch on Twitch</a><br /><center>'.$contents[0].'</center>';
            }
        }
        $short_title = explode("|", $item["title"])[0];
        $description = Parsedown::instance()->text($item["description"]);
        if (strlen($description) <= 0) {
            $description = "";
        } else {
            $description = "<hr><h5>Description</h5><p>".$description."</p>";
        }
        $date = date("M d, Y", strtotime($item["published_at"]));

        /* Export */
        echo <<<MODALENTRY
        <div class="modal modal-description fade" style="overflow: hidden !important" id="modal-{$item["id"]}" tabindex="-1" aria-labelledby="modal-{$item["id"]}-label" aria-hidden="true">
            <div class="modal-dialog" style="overflow: hidden !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-{$item["id"]}-label">{$short_title}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <center><img src="{$item["thumbnail_url"]}" style="max-width:320px;max-height:180px;object-fit:contain;border: 3px solid black;border-radius:20px;" oncontextmenu="return false;" alt="portfolio image: {$item["title"]}" /></center><br />
                        <center><h5>{$item["title"]}</h5></center>
                        <center><p>Published on {$date}</p></center>
                        <span>{$links["twitch"]}</span>
                        {$description}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
MODALENTRY;
        }
    }
?>