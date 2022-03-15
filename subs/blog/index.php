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
	if (isset($_GET["blog-id"])) {
		$title_temp = explode("_", $_GET["blog-id"]);
		$title = $title_temp[3];
		echo "<title>Turtle Pond - Brown's Blog - ".$title."</title>";
	} else {
		echo "<title>Turtle Pond - Brown's Blog</title>";
	} ?>
	<?php require dirname(__DIR__, 2) . "/templates/header-includes.php" ?>
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
				echo '<script src="/assets/js/bootstrap-tab.js"></script>';
				$directories = array(
					array("travelblog","NYC Travel Blog", "Follow Browntul on his adventures in New York City. January 2022."),
					array("techblog","Tech Blog", "Take a look at Browntul's technological advances in this monthly blog."),
					array("gamedevlogs","Game Dev Logs", "Deep dive into Browntul's thoughts as he makes web games for fun.")
				);

				echo '<h1 style="text-align: center;">Brown\'s Blog</h1>';
				echo <<<ABOUT
					<center>Take a look at Browntul's blogs by clicking on the tabs below!</center><br/>
ABOUT;
				echo '<ul class="nav nav-tabs" id="blogdirectory" role="tablist">';
				$show_active_toggle = "true";
				$show_active_text = "active";
				foreach ($directories as $directory) {
					echo <<<ITEM
					<li class="nav-item" role="presentation">
						<button 
						class="nav-link $show_active_text" 
						id="$directory[0]-tab" 
						data-bs-toggle="tab" 
						data-bs-target="#$directory[0]-tab-content" 
						type="button" 
						role="tab" 
						aria-controls="$directory[0]-tab" 
						aria-selected="$show_active_toggle">$directory[1]</button>
					</li>
ITEM;
				$show_active_toggle = "false";
				$show_active_text = "";
				}
				echo '</ul>';
				echo '<div class="tab-content" id="blogdirectorycontent" style="padding:20px">';
				$show_active_toggle = true;
				foreach ($directories as $directory) {	
					echo '<div class="tab-pane fade';
					if ($show_active_toggle) {
						echo ' show active';
						$show_active_toggle = false;
					}
					echo '" id="'.$directory[0].'-tab-content" role="tabpanel" aria-labelledby="'.$directory[0].'-tab-content">';
					echo "<h3>" . $directory[1] . "</h3>";
					echo "<small>" . $directory[2] . "</small><br>";
					$file_directory = array_filter(scandir(__DIR__ . "/" . $directory[0]), $find_md_file_name);
					usort($file_directory, "file_compare");
					foreach ($file_directory as $blog_entry) {
						$blog_entry_array = explode("_", $blog_entry);
						$month = $blog_entry_array[1];
						$day = $blog_entry_array[2];
						$year = $blog_entry_array[0];
						$title = $blog_entry_array[3];
						if ($title[0] === "-") {
							continue;
						}
						echo "<br/>";
						echo $month . "/" . $day . "/" . $year . " - <a href=\"?blog-type=" .  $directory[0] . "&blog-id=" . rtrim($blog_entry, ".md") . "\">" . $title . "</a>";
					}
					echo "</div>";
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