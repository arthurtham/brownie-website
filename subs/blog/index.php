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
		$title = $title_temp[3];
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
	<div class='container body-container'>
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
				$blog_id = rtrim(explode("_", $_GET["blog-id"])[4], ".md");
				require dirname(__DIR__, 2) . "/templates/blog.php";
				echo <<<DISQUS
				<div id="disqus_thread"></div>
				<script>
					/**
					*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
					*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
					var disqus_config = function () {
					this.page.url = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"  // Replace PAGE_URL with your page's canonical URL variable
					this.page.identifier = "brownblog_$blog_id"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
					};
					(function() { // DON'T EDIT BELOW THIS LINE
					var d = document, s = d.createElement('script');
					s.src = 'https://browntulstar-com.disqus.com/embed.js';
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
					})();
				</script>
				<noscript>Please enable JavaScript to view the <a href='https://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript>
				<script id="dsq-count-scr" src='//browntulstar-com.disqus.com/count.js' async></script>
DISQUS;
			} else {
				echo '<h1 style="text-align: center;">Brown\'s Blog</h1>';
				$directories = array(array("travelblog","NYC Travel Blog"));
				foreach ($directories as $directory) {	
					echo "<h3>" . $directory[1] . "</h3>";
					$file_directory = array_filter(scandir(__DIR__ . "/" . $directory[0]), $find_md_file_name);
					function file_compare($blog_entry_a, $blog_entry_b) {
						$blog_entry_a = explode("_", $blog_entry_a);
						$id_a = intval(rtrim($blog_entry_a[4], ".md"));
						$blog_entry_b = explode("_", $blog_entry_b);
						$id_b = intval(rtrim($blog_entry_b[4], ".md"));
						return $id_a < $id_b ? 1 : -1;
					}
					usort($file_directory, "file_compare");
					foreach ($file_directory as $blog_entry) {
						echo "<br/>";
						$blog_entry_array = explode("_", $blog_entry);
						$month = $blog_entry_array[1];
						$day = $blog_entry_array[2];
						$year = $blog_entry_array[0];
						$title = $blog_entry_array[3];
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