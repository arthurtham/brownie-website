<?php
$dir = dirname(__DIR__, 1);
$title = "Turtle Pond - Sub Perks";
require $dir . "/templates/header.php";
?>
<?php
if (!isset($_SESSION['user'])) {
	echo '<div class="container body-container">';
	echo "<div class='alert alert-danger' role='alert'>
	<center>You need to log in to Discord before viewing this page.</center>
	</div>";
	echo '<h1 style="text-align: center;">Turtle Pond - Sub Perks</h1>';
	require $dir . "/templates/sub-perks-description.php";
	echo "</div>";
} else { // User is logged in
	if (false) { //(!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
		//require dirname(__DIR__, 1) . "/templates/login-required.php";
	} else {
		echo '<div class="container body-container"';
		echo '<p><h1 class="text-center">Turtle Pond - Sub Perks</h1></p>';
		require $dir . "/templates/profile-box.php";
		echo <<<BODY

BODY;
		require $dir . "/templates/sub-perks-description.php";
		echo "</div>";
	}
}
?>
<?php require $dir . "/templates/footer.php" ?>