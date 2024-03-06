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
	echo '<h1 style="text-align: center;">Turtle Pond - Profile</h1>';
	echo "<div class='alert alert-danger' role='alert'>
	<center>Please log in to view your profile.</center>
	</div>";
	echo "</div>";
} else { // User is logged in
	echo '<div class="container body-container-home">';
	echo '<div id="center-block" class="d-flex flex-column align-items-center justify-content-center">';
    echo '<br/><p><h1 class="text-center" style="color:white">Turtle Pond - Profile</h1></p>';
    require $dir . "/templates/profile-box.php";
	echo '<div class="row"><div class="col col-md-12">';
	echo '<p class="text-center" style="color:white;font-weight:bold">Look at you! '.$quote_array[$quote].'</p>';
    echo "</div></div>";
	echo "</div></div>";
}
?>
<?php require $dir . "/templates/footer.php" ?>