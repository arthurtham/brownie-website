<?php
function echoYouTubeCardEntries($result) {
    if (isset($result["error"])) {
        echo '<div class="row">';
        echo '<div class="col">';
        echo 'Error from YouTube API: ' . $result["error"];
        echo "</div>";
        return;
    }
    $count = 0;
    foreach ($result as $item) {
        $short_title = explode("|", $item["title"])[0];
        $url = "https://youtube.com/watch?v=".$item["video_id"];
        $date = date("M d, Y", strtotime($item["published_at"]));
        if ($count % 3 == 0) {
            if ($count > 0) {
                echo '</div>';
            }
            echo '<div class="row" style="padding-bottom:10px" oncontextmenu="return false;">';
        }
        echo '<div class="col-md-4 mb-2 d-flex align-items-stretch"><div class="card" style="width:100% !important;">';
        // echo '<a data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'"><div style="position:relative;background-color:lightgray">';
        echo '<img src="'.$item["thumbnail_url"].'" 
        class="card-img-top" alt="video thumbnail image: '.$short_title.'">';
        // echo '</div></a>';
        echo '<div class="card-body">';
        // echo '<button type="button" class="btn btn-dark" style="width:100%;margin-bottom:18px" data-bs-toggle="modal" data-bs-target="#modal-'.$item["id"].'">Watch</button>';
        echo '<a type="button" class="btn btn-dark" style="width:100%;margin-bottom:18px" href="'.$url.'" target="_blank">Watch</a>';
        echo '<h5 class="card-title">'.$short_title = explode("|", $item["title"])[0].'</h5>';
        echo '<p class="card-text">'.$date.'</p>';
        echo '</div>';
        echo '</div></div>';
        $count += 1;
    }
    echo '</div>';
}

?>