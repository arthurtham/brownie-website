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

# ALL VALUES ARE STORED IN SESSION!
# RUN `echo var_export([$_SESSION]);` TO DISPLAY ALL THE VARIABLE NAMES AND VALUES.
# FEEL FREE TO JOIN MY SERVER FOR ANY QUERIES - https://join.markis.dev

?>

<html>

<head>
	<title>Turtle Pond - Sub Perks</title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
	<?php require dirname(__DIR__, 1) . "/templates/navbar.php" ?>
	<h1 style="text-align: center;">Turtle Pond - Sub Perks</h1>
	<?php
	if (!isset($_SESSION['user'])) {
		echo "You need to log in to Discord before viewing this page.";
	} else { // User is logged in
		if (!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
			require dirname(__DIR__, 1) . "/templates/login-required.php";
		} else {
			require dirname(__DIR__, 1) . "/templates/debug.php";
		}
	}
	?>
		
</body>

</html>