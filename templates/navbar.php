<?php
require_once __DIR__ . "/navbar-contents.php";
?>

<header>
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark shadow" style="position:fixed; width:100%; top:0; padding-left:20px; padding-right:20px;">
<div class="container-fluid">
    <a class="navbar-brand" href="/" style="margin-top:-10px;margin-bottom:-10px;">
        <img src="https://res.cloudinary.com/browntulstar/image/private/c_pad,h_200/com.browntulstar/img/browntulstar-logo-v2-large.webp" height=50px class="d-inline-block align-top" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-lg-0">
<?php

function create_navbar_items($navbar_items, $depth=0) {
    $depth_style = $depth==0 ? 'style="font-weight:500"' : '';
    foreach ($navbar_items as $navbar_item) {
        switch ($navbar_item["type"]) {
            case "nav-dropdown":
                _helper_create_nav_item_dropdown($navbar_item, $depth);
                break;
            case "dropdown-item":
                $target = $navbar_item["popout"] ? 'target="_blank"' : "";
                echo '<li><a class="dropdown-item" '.$depth_style.'href="'.$navbar_item["href"].'" '.$target.'>'.$navbar_item["contents"].'</a></li>';
                break;
            case "nav-item":
                $target = $navbar_item["popout"] ? 'target="_blank"' : "";
                echo '<li class="nav-item"><a class="nav-link" '.$depth_style.'href="'.$navbar_item["href"].'" '.$target.'>'.$navbar_item["contents"].'</a></li>';
                break;
            case "dropdown-divider":
                echo '<li><hr class="dropdown-divider" '.$depth_style.' />';
                break;
            case "dropdown-header":
                echo '<li><h2 class="dropdown-header-navbar" '.$depth_style.'>'.$navbar_item["contents"].'</h2></li>';
                break;
            default:
                break;
        }
    }
}

function _helper_create_nav_item_dropdown($item, $depth=0) {
    $depth_style = $depth==0 ? 'style="font-weight:500"' : '';
    echo '<li class="nav-item dropdown">';
    echo '<a class="nav-link dropdown-toggle" '.$depth_style.'href="'.$item["href"].'" id="navbar'.$item["id"].'" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.$item["contents"].'</a>';
    echo '<ul class="dropdown-menu" aria-labelledby="navbar'.$item["id"].'">';
    create_navbar_items($item["children"], $depth+1);
    echo '</ul></li>';
}

if (isset($_layout_brownievalmode) && $_layout_brownievalmode == true) {
    create_navbar_items($navbar_contents_brownieval);
} else {
    create_navbar_items($navbar_contents);
}
?>
        </ul>
        <ul class="navbar-nav mt-auto">
            <li style="padding-right:4px">
<?php
if (check_roles([$turtle_role_id])) {
    echo "<a href='" . "/admin" ."'><button class='btn btn-danger'><i class='fa-solid fa-hammer'></i> Admin</button></a></li><li style='padding-right:4px'>";
}

// Auth_URL now handled in login file
// $auth_url = url($client_id, $redirect_url, $scopes);\
if (isset($_SESSION['user'])) {
    echo '<a href="/profile"><button class="btn btn-primary"><img style="height:24px;border-color:gray;border:1px solid" class="rounded" src="'.get_discord_avatar_url().'" /></button></a></li><li><a href="/logout.php"><button class="btn btn-danger">Logout</button></a>';
} else {
    echo "<a href='" . "/login.php" ."'><button class='btn btn-success'><i class='fa-brands fa-discord'></i> Login</button></a>";
}
?>
            </li>
            </ul>
        </div>
    </div>
</header>