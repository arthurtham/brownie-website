<?php
require_once __DIR__ . "/navbar-contents.php";
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;
require_once dirname(__DIR__, 1) . "/includes/discord.php";
require_once dirname(__DIR__, 1) . "/includes/mysql.php";

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

function _helper_get_alert_post($conn)
{
    CacheManager::setDefaultConfig(new ConfigurationOption([
        "path" => dirname(__DIR__, 1) . "/cache"
    ]));
    $instanceCache = CacheManager::getInstance("files");
    $key = "alert_post";
    $cache = $instanceCache->getItem($key);
    if (true) {
    // if (!$cache->isHit()) {
        $sql = "SELECT * FROM alert_posts WHERE alert_active=1 ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $alert_post = $result->fetch_assoc();
            // Place in an organized array
            $alert_post_array = array();
            $alert_post_array["exists"] = true;
            $alert_post_array["id"] = $alert_post["id"];
            $alert_post_array["title"] = htmlspecialchars($alert_post["alert_title"]);
            $alert_post_array["contents"] = htmlspecialchars($alert_post["alert_contents"]);
            $alert_post_array["url"] = htmlspecialchars($alert_post["alert_url"]);
            $alert_post_array["popout"] = (($alert_post["alert_popout"]) == 1 ? true : false);
            $alert_post_array["active"] = (($alert_post["alert_active"]) == 1 ? true : false);
            $cache->set($alert_post_array)->expiresAfter(3600);
            $instanceCache->save($cache);
            return $alert_post_array;
        } else {
            $alert_post_array = array();
            $alert_post_array["exists"] = false;
            return $alert_post_array;
        }
    } else {
        return $cache->get();
    }
}

$_disallow_navbar = (isset($_disallow_navbar) && ($_disallow_navbar === true));

if ($_disallow_navbar) {
    $_alert_post = null;
    $_alert_post_exists = false;
    $_alert_post_height = 0;
} else {
    $_alert_post = _helper_get_alert_post($conn);
    $_alert_post_exists = (isset($_alert_post) && $_alert_post["exists"]) && (!isset($_disallow_navbar_alert) || $_disallow_navbar_alert != true);
    $_alert_post_height = 50;
}
?>


<header>

<?php
if (!$_disallow_navbar) {
    if ($_alert_post_exists) {
?>
    <nav class="navbar brownie-navbar fixed-top navbar-expand-lg navbar-dark bg-warning shadow flex-column" style="height:<?=$_alert_post_height?>px;">
        <div class="navbar-topbar-text text-center justify-content-center align-items-center d-flex w-100 h-100 p-2">
            <span style="line-height:0.9em;"><?=$_alert_post["contents"];?></span>
<?php
            if (!empty($_alert_post["url"])) {
?>
            <a href="<?=$_alert_post['url'];?>" <?=(($_alert_post["popout"]) ? 'target="_blank"' : "") ?> 
            class="btn btn-sm btn-light ms-3 p-2"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
<?php
            }
?>
        </div>
    </nav>
<?php
    }
?>
    <nav class="navbar brownie-navbar fixed-top navbar-expand-lg navbar-dark bg-dark shadow"
<?php 
    if ($_alert_post_exists) {
?>
        style="margin-top:<?=$_alert_post_height?>px"';
<?php
    }
?>
    >
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
    </nav>
<?php 
}
?>
</header>

<?php 
if (!$_disallow_navbar && $_alert_post_exists) {
?>
<div class="container-fluid" style="height:<?=$_alert_post_height?>px;"></div>
<?php
}  
?>
