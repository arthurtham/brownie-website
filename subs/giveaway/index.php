<?php


# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 2) . "/includes/functions.php";
require dirname(__DIR__, 2) . "/includes/discord.php";
require dirname(__DIR__, 2) . "/config.php";
require dirname(__DIR__, 2) . "/includes/sessiontimer.php";
require dirname(__DIR__, 2) . "/includes/Parsedown.php"; 


$find_md_file_name = function($v) { 
	return strpos($v, ".md");
};

function file_compare($blog_entry_a, $blog_entry_b) {
	$blog_entry_a = explode("_", $blog_entry_a);
	$id_a = intval(rtrim($blog_entry_a[4], ".md"));
	$blog_entry_b = explode("_", $blog_entry_b);
	$id_b = intval(rtrim($blog_entry_b[4], ".md"));
	return $id_a < $id_b ? 1 : -1;
}

?>

<html>

<head>
	<?php 
	$title = "Turtle Pond - Brown's Giveaways";
	require dirname(__DIR__, 2) . "/templates/header-includes.php" 
	?>
</head>

<body>
	<?php require dirname(__DIR__, 2) . "/templates/navbar.php" ?>
	<div class='container body-container'>
	<?php
	if (!isset($_SESSION['user'])) { 
		echo '<h1 style="text-align: center;">Brown\'s Giveaways</h1>';
		echo "You need to log in to Discord before viewing this page.";
		require dirname(__DIR__, 2) . "/templates/sub-perks-description.php";
		echo "</div>";
	} else { // User is logged in
		if (!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
			echo '<h1 style="text-align: center;">Brown\'s Giveaways</h1>';
			echo "You need to fulfill the sub requirements <a href='/subs'>here</a> before viewing this page.";
			require dirname(__DIR__, 2) . "/templates/sub-perks-description.php";
			echo "</div>";
		} else {
			echo "<h1 class='text-center'>Brown's Giveaways</h1>";
			echo "<p class='text-center'>Claim sub-exclusive giveaways on this page, as a special thanks to you!</p>";
			echo "<hr/>";
			try {
				if ($myfile = fopen("giveaway-links.md", "r")) {
				echo Parsedown::instance()->text(fread($myfile, filesize("giveaway-links.md")));
				fclose($myfile);
				} else {
					echo "There's no sub giveaways going on right now.";
				}
			} catch (Exception $e) {
				echo "There's either no sub giveaways going on right now, or there was a problem loading them.";
			}
		}
	}
	?>
	</div>
	<?php require dirname(__DIR__, 2) . "/templates/footer.php" ?>	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>