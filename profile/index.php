<?php
$dir = dirname(__DIR__, 1);
$title = "Turtle Pond - Profile";
require $dir . "/templates/header.php";
?>
<?php
$quote_array = array(
	"You're a star!",
	"So inspirational!",
	"Big moves!",
	"You're so good!"
);
$quote = array_rand(
	$quote_array
);

if (!isset($_SESSION['user'])) {
	echo '<div class="container body-container">';
	echo "<div class='alert alert-danger' role='alert'>
	<center>You need to log in to Discord before viewing this page.</center>
	</div>";
	echo '<h1 style="text-align: center;">Turtle Pond - Profile</h1>';
	require $dir . "/templates/sub-perks-description.php";
	echo "</div>";
} else { // User is logged in
    echo '<div class="container body-container"';
    echo '<p><h1 class="text-center">Turtle Pond - Profile</h1></p>';
    require $dir . "/templates/profile-box.php";
	echo '<div class="row"><div class="col col-md-6 offset-md-3">';
	echo '<p class="text-center">Look at you! '.$quote_array[$quote].'</p>';
	echo '<p class="text-center">You get more perks if you subscribe
		and <strong><a href="/discord" target="_blank">
		join the Discord</a></strong>!';
    echo "</div></div>";
	echo "</div>";
}
?>
<?php require $dir . "/templates/footer.php" ?>