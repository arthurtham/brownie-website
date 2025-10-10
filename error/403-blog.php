<?php
http_response_code(403);
$dir = dirname(__DIR__, 1);
require_once $dir . "/includes/default-includes.php";
if (!isset($title)) {
    $title = "BrowntulStar - Error"; 
}
if (!isset($blog_title)) {
    $blog_title = "unnamed blog post";
}
require $dir . "/templates/header.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <div class="d-flex flex-column align-items-center justify-content-center" style="height:100%">
        <span>
            <h1 class="text-center">403 Insufficient Perks</h1>
            <center>
            <p>To read this blog post: "<?=$blog_title?>", please subscribe on Twitch or meet the ★ Star Badge tier on IRIAM for this content. Then, join the Discord server to claim the perks role.
            Finally, log into this website to read this blog post.</p> 
            </center>
        </span>
        <div class="alert alert-dark" role="alert">
            <p class="text-center">
                Trying to access perks? For help setting up your perks, please go to <a href="/subs/details">this page</a>.
            </p>
        </div>
        <?php
        if (!isset($_SESSION['user'])) {
            print_navbar_login_items($expand = true, $center = true, $subperks = true, $label=true);
        }
        ?>
    </div>
</div>
<?php require $dir . "/templates/footer.php" ?>