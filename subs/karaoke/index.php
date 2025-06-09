<?php
$dir = dirname(__DIR__, 2);
require_once $dir . "/includes/default-includes.php";
$title = "Turtle Pond - Tank Engine Karaoke";

if (!isset($_SESSION['user']) || !check_roles($sub_perk_roles)) {
	require $dir . "/error/403-sub.php";
	die();
}
require $dir . "/templates/header.php";
echo '<div class="container body-container-no-bg" style="padding-bottom:3rem !important">';		
echo "<h1 class='text-center text-white'>Tank Engine Karaoke</h1>";
echo "<p class='text-center text-white'>Sing along with Browntul the Tank Engine!<br>You can even download the songs!</p>";
echo "<hr/>";
require_once $dir . "/templates/karaoke.php";
echo "</div>";
require $dir . "/templates/footer.php";
