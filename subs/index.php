<?php

/* Home Page
* The home page of the working demo of oauth2 script.
* @author : MarkisDev
* @copyright : https://markis.dev
*/

# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 1) . "/includes/functions.php";
require dirname(__DIR__, 1) . "/includes/discord.php";
require dirname(__DIR__, 1) . "/config.php";
require dirname(__DIR__, 1) . "/includes/sessiontimer.php";

# ALL VALUES ARE STORED IN SESSION!
# RUN `echo var_export([$_SESSION]);` TO DISPLAY ALL THE VARIABLE NAMES AND VALUES.
# FEEL FREE TO JOIN MY SERVER FOR ANY QUERIES - https://join.markis.dev

?>

<html>

<head>
	<?php $title = "Turtle Pond - Sub Perks" ?>
	<?php require dirname(__DIR__, 1) . "/templates/header-includes.php" ?>
</head>

<body>
	<?php require dirname(__DIR__, 1) . "/templates/navbar.php" ?>
	<?php
	if (!isset($_SESSION['user'])) {
		echo '<div class="container body-container">';
		echo '<h1 style="text-align: center;">Turtle Pond - Sub Perks</h1>';
		echo "You need to log in to Discord before viewing this page.<br/>";
		require dirname(__DIR__, 1) . "/templates/sub-perks-description.php";
		echo "</div>";
	} else { // User is logged in
		if (false) { //(!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
			//require dirname(__DIR__, 1) . "/templates/login-required.php";
		} else {
			echo '<div class="d-flex align-items-center justify-content-center" style="height:100%;padding-top:100px;padding-bottom:50px">';
			echo '<div class="box bg-light bg-gradient shadow" style="padding: 40px; border-radius: 10%">';
			echo '<center><div class="card" style="width:auto;max-width:400px;padding-top:20px"><center>';
			if (isset($_SESSION['user_avatar'])) {
				echo '<img src="https://cdn.discordapp.com/avatars/';
				$extention = is_animated($_SESSION['user_avatar']);
				echo $_SESSION['user_id'] . "/" . $_SESSION['user_avatar'] . $extention;
			} else {
				echo '<img src="https://cdn.discordapp.com/embed/avatars/0.png"';
			}
			echo '" class="card-img-top" alt="..."/ style="width:auto;max-width:100px;"></center>';
			echo '<div class="card-body"><h5 class="card-title">' . $_SESSION["username"] . '</h5>';
			if (!check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
				echo '<h5><span class="badge bg-dark" style="width:100%">Not Subbed</span></h5>';
			}
			else {
				if (check_roles([$sub_role_id])) {
					echo '<h5><span class="badge bg-danger" style="width:100%">RED SHELLS (Subs)</span></h5>';
				}
				if (check_roles([$vip_role_id])) {
					echo '<h5><span class="badge bg-warning" style="width:100%">STARS (VIPs)</span></h5>';
				}
				if (check_roles([$mod_role_id])) {
					echo '<h5><span class="badge bg-info" style="width:100%">BLUE SHELLS (Mods)</span></h5>';
				}
				
				
			}
			echo '<h5><span class="badge bg-secondary" style="width:100%">';
			echo check_guild_membership($guild_id) ? 'In Turtle Pond Server' : 'Not in Turtle Pond Server';
			echo '</span></h5>';
			echo "</div></center>";
			echo "</div>";
			echo "</div>";
			echo '<div class="container body-container" style="padding-top:20px !important;">';
			echo <<<BODY
				<h1 class="text-center">Turtle Pond - Sub Perks</h1>
				<p>Welcome to my sub perks section! If you're subscribed to me on my Twitch channel, linked your 
				subbed Twitch account to Discord, and joined my Turtle Pond Discord server, you can access sub perks
				in the "Sub Perks" dropdown menu on the navigation bar at the top of this page.</p>

BODY;
			require dirname(__DIR__, 1) . "/templates/sub-perks-description.php";
			echo "</div>";
		}
	}
	?>
	</div>
	<?php require dirname(__DIR__, 1) . "/templates/footer.php" ?>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>