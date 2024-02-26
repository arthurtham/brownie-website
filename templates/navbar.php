<?php
require_once __DIR__ . "/navbar-contents.php";
?>

<header>
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark" style="position:fixed; width:100%; top:0; padding-left:20px; padding-right:20px;">
<div class="container-fluid">
    <a class="navbar-brand" href="/">
        <img src="https://res.cloudinary.com/browntulstar/image/private/c_pad,h_200/com.browntulstar/img/browntulstar-logo-v1-large.webp" width=30px height=30px class="d-inline-block align-top" style="border-radius:100%" />
        BrowntulStar
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
<?php

function create_navbar_items($navbar_items) {
    foreach ($navbar_items as $navbar_item) {
        switch ($navbar_item["type"]) {
            case "nav-dropdown":
                _helper_create_nav_item_dropdown($navbar_item);
                break;
            case "dropdown-item":
                $target = $navbar_item["popout"] ? 'target="_blank"' : "";
                echo '<li><a class="dropdown-item" href="'.$navbar_item["href"].'" '.$target.'>'.$navbar_item["contents"].'</a></li>';
                break;
            case "nav-item":
                $target = $navbar_item["popout"] ? 'target="_blank"' : "";
                echo '<li class="nav-item"><a class="nav-link" href="'.$navbar_item["href"].'" '.$target.'>'.$navbar_item["contents"].'</a></li>';
                break;
            case "dropdown-divider":
                echo '<li><hr class="dropdown-divider" />';
                break;
            case "dropdown-header":
                echo '<li><h6 class="dropdown-header">'.$navbar_item["contents"].'</h6></li>';
                break;
            default:
                break;
        }
    }
}

function _helper_create_nav_item_dropdown($item) {
    echo '<li class="nav-item dropdown">';
    echo '<a class="nav-link dropdown-toggle" href="'.$item["href"].'" id="navbar'.$item["id"].'" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.$item["contents"].'</a>';
    echo '<ul class="dropdown-menu" aria-labelledby="navbar'.$item[id].'">';
    create_navbar_items($item["children"]);
    echo '</ul></li>';
}

create_navbar_items($navbar_contents);
?>
        </ul>
        <li class="d-flex">
<?php
// Auth_URL now handled in login file
// $auth_url = url($client_id, $redirect_url, $scopes);\
if (isset($_SESSION['user'])) {
    echo '<a href="/profile"><button class="btn text-white" style="background-color: #6f42c1"><i class="fa-brands fa-discord"></i> ' . $_SESSION['username'] . '</button></a></li>&nbsp;<li class="d-flex"><a href="/logout.php"><button class="btn btn-danger">Logout</button></a>';
} else {
    echo "<a href='" . "/login.php" ."'><button class='btn btn-success'><i class='fa-brands fa-discord'></i> Login</button></a>";
}
?>
            </li>
        </div>
    </div>
</header>