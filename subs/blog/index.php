<?php


# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 2) . "/includes/functions.php";
require dirname(__DIR__, 2) . "/includes/discord.php";
require dirname(__DIR__, 2) . "/config.php";
require dirname(__DIR__, 2) . "/includes/sessiontimer.php";


$find_md_file_name = function($v) { 
	return strpos($v, ".md");
};
?>

<html>

<head>
	<?php 
	if (isset($_GET["blog-id"])) {
		$title_temp = explode("_", $_GET["blog-id"]);
		$title = rtrim($title_temp[3], ".md");
		echo "<title>Turtle Pond - Brown's Blog - ".$title."</title>";
	} else {
		echo "<title>Turtle Pond - Brown's Blog</title>";
	} ?>
	<link rel="stylesheet" href="/assets/css/style.css">
	<script src="https://kit.fontawesome.com/7f5f717705.js" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>

<body>
	<?php require dirname(__DIR__, 2) . "/templates/navbar.php" ?>
	<div class='container body-container shadow'>
	<?php
	if (!isset($_SESSION['user'])) { 
		echo '<h1 style="text-align: center;">Brown\'s Blog</h1>';
		echo "You need to log in to Discord before viewing this page.";
		require dirname(__DIR__, 2) . "/templates/sub-perks-description.php";
		echo "</div>";
	} else { // User is logged in
		if (!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
			echo '<h1 style="text-align: center;">Brown\'s Blog</h1>';
			require dirname(__DIR__, 2) . "/templates/login-required.php";
			echo "</div>";
		} else {
			if (isset($_GET["blog-type"]) && (isset($_GET["blog-id"]))) {
				$blog_file_location = dirname(__DIR__, 2) . "/subs/blog/" . $_GET["blog-type"] . "/" . $_GET["blog-id"];
				require dirname(__DIR__, 2) . "/templates/blog.php";
			} else {
				echo '<h1 style="text-align: center;">Brown\'s Blog</h1>';
				$directories = array(array("travelblog","NYC Travel Blog"));
				foreach ($directories as $directory) {	
					echo "<h3>" . $directory[1] . "</h3>";
					$file_directory = array_filter(scandir(__DIR__ . "/" . $directory[0]), $find_md_file_name);
					$file_directory = array_reverse($file_directory);
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
				echo "</div>";
			}
			
		}
	}
	?>
	</div>
	<?php require dirname(__DIR__, 2) . "/templates/footer.php" ?>	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>