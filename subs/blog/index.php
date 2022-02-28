<?php


# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 2) . "/includes/functions.php";
require dirname(__DIR__, 2) . "/includes/discord.php";
require dirname(__DIR__, 2) . "/config.php";


$find_md_file_name = function($v) { 
	return strpos($v, ".md");
}

?>

<html>

<head>
	<title>Turtle Pond - Sub Perks</title>
	<style><?php include dirname(__DIR__, 2) . "/assets/css/style.css" ?> </style>
</head>

<body>
	<?php require dirname(__DIR__, 2) . "/templates/navbar.php" ?>
	<h1 style="text-align: center;">Blog Posts</h1>
	<h2 style="text-align: center;">Turtle Pond - Sub Perks</h2>
	<?php
	if (!isset($_SESSION['user'])) {
		echo "You need to log in to Discord before viewing this page.";
	} else { // User is logged in
		if (!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
			require dirname(__DIR__, 2) . "/templates/login-required.php";
		} else {
			if (isset($_GET["blog-type"]) && (isset($_GET["blog-id"]))) {
				$blog_file_location = dirname(__DIR__, 2) . "/subs/blog/" . $_GET["blog-type"] . "/" . $_GET["blog-id"];
				require dirname(__DIR__, 2) . "/templates/blog.php";
			} else {
				echo "<h1>Blog Directory</h1>";
				
				$directories = array(array("travelblog","Travel Blog"));
				foreach ($directories as $directory) {	
					echo "<h2>" . $directory[1] . "</h2>";
					$file_directory = array_filter(scandir(__DIR__ . "/" . $directory[0]), $find_md_file_name);
					foreach ($file_directory as $blog_entry) {
						echo "<br/>";
						$blog_entry_array = explode("_", $blog_entry);
						$month = $blog_entry_array[1];
						$day = $blog_entry_array[2];
						$year = $blog_entry_array[0];
						$title = rtrim($blog_entry_array[3], ".md");
						echo $month . "/" . $day . "/" . $year . " - <a href=\"?blog-type=" .  $directory[0] . "&blog-id=" . rtrim($blog_entry, ".md") . "\">" . $title . "</a>";
					}
				}
			}
			
		}
	}
	?>
		
</body>

</html>