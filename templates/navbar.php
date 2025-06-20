<?php
require_once __DIR__ . "/navbar-contents.php";
require_once dirname(__DIR__, 1) . "/includes/discord.php";

function create_navbar_items($navbar_items, $depth = 0)
{
    $depth_style = $depth == 0 ? 'style="font-weight:500"' : '';
    foreach ($navbar_items as $navbar_item) {
        switch ($navbar_item["type"]) {
            case "nav-dropdown":
                _helper_create_nav_item_dropdown($navbar_item, $depth);
                break;
            case "dropdown-item":
                $target = $navbar_item["popout"] ? 'target="_blank"' : "";
                echo '<li><a class="dropdown-item" ' . $depth_style . 'href="' . $navbar_item["href"] . '" ' . $target . '>' . $navbar_item["contents"] . '</a></li>';
                break;
            case "nav-item":
                $target = $navbar_item["popout"] ? 'target="_blank"' : "";
                echo '<li class="nav-item"><a class="nav-link" ' . $depth_style . 'href="' . $navbar_item["href"] . '" ' . $target . '>' . $navbar_item["contents"] . '</a></li>';
                break;
            case "dropdown-divider":
                echo '<li><hr class="dropdown-divider" ' . $depth_style . ' />';
                break;
            case "dropdown-header":
                echo '<li><h2 class="dropdown-header-navbar" ' . $depth_style . '>' . $navbar_item["contents"] . '</h2></li>';
                break;
            default:
                break;
        }
    }
}

function _helper_create_nav_item_dropdown($item, $depth = 0)
{
    $depth_style = $depth == 0 ? 'style="font-weight:500"' : '';
    echo '<li class="nav-item dropdown">';
    echo '<a class="nav-link dropdown-toggle" ' . $depth_style . ' href="' . $item["href"] . '" id="navbar' . $item["id"] . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $item["contents"] . '</a>';
    echo '<ul class="dropdown-menu" id="navbar' . $item["id"] . '-menu" aria-labelledby="navbar' . $item["id"] . '">';
    create_navbar_items($item["children"], $depth + 1);
    echo '</ul></li>';
}

?>


<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="/" style="margin-top:-10px;margin-bottom:-10px;">
                <img src="https://res.cloudinary.com/browntulstar/image/private/s--4EOtuy1N--/c_pad,h_200/f_webp/v1/com.browntulstar/img/browntulstar-logo-v2-large?_a=BAAAUWGX" height=50px class="d-inline-block align-top" />
            </a>
            <div class="navbar-mobile-login-items-small">
                <ul class="navbar-nav mt-auto ms-0 d-flex flex-row">
                    <?php
                    print_navbar_login_items($expand = true, $center = false, $subperks = true, $label=false);
                    ?>
                </ul>
            </div>
            <div class="navbar-mobile-login-items-medium">
                <ul class="navbar-nav mt-auto ms-0 d-flex flex-row">
                    <?php
                    print_navbar_login_items($expand = true, $center = false, $subperks = true, $label=true);
                    ?>
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-0">
                    <?php
                    if (isset($_layout_brownievalmode) && $_layout_brownievalmode == true) {
                        create_navbar_items($navbar_contents_brownieval);
                    } else {
                        create_navbar_items($navbar_contents);
                    }
                    ?>
                </ul>
                <div class="navbar-desktop-login-items">
                    <ul class="navbar-nav mt-auto ms-0 d-flex flex-row">
                        <?php
                        print_navbar_login_items($expand = true, $center = false, $subperks = true, $label=true);
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>