<?php
$dir = dirname(__DIR__, 1);
$title = "Turtle Pond - Sub Perks";
require $dir . "/templates/header.php";
?>
<?php
if (!isset($_SESSION['user'])) {
	echo '<div class="container body-container">';
	echo "<div class='alert alert-danger' role='alert'>
	<center>To view which Discord roles that you have that unlock sub perks, you need to log in to Discord first.</center>
	</div>";
	echo '<h1 style="text-align: center;">Turtle Pond - Sub Perks</h1>';
	require $dir . "/templates/sub-perks-description.php";
	echo "</div>";
} else { // User is logged in
	if (false) { //(!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
		//require dirname(__DIR__, 1) . "/templates/login-required.php";
	} else {
		echo '<div class="container body-container-no-bg">';
		echo '<div class="d-flex flex-column align-items-center justify-content-center"';
		echo '<p><h1 class="text-center" style="color:white">Turtle Pond - Sub Perks</h1></p>';
		require $dir . "/templates/profile-box.php";
		require $dir . "/templates/sub-perks-description.php";
		echo "</div></div>";
	}
}
?>
<?php require $dir . "/templates/footer.php" ?>