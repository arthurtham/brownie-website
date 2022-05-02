<?php


$dir = dirname(__DIR__, 2);

require_once($dir . "/includes/mysql.php");
// $find_md_file_name = function($v) { 
// 	return strpos($v, ".md");
// };

function file_compare($blog_entry_a, $blog_entry_b) {
	$blog_entry_a = explode("_", $blog_entry_a);
	$id_a = intval(rtrim($blog_entry_a[4], ".md"));
	$blog_entry_b = explode("_", $blog_entry_b);
	$id_b = intval(rtrim($blog_entry_b[4], ".md"));
	return $id_a < $id_b ? 1 : -1;
}

if (isset($_GET["search-text"])) {
	$search_text = $_GET["search-text"];
} else {
	$search_text = "";
}

if (isset($_GET["blog-id"])) {
	//$title_temp = explode("_", $_GET["blog-id"]);
	//$title = "Turtle Pond - Brown's Blog - " . $title_temp[3];
	$sql = "SELECT blog_name FROM blog_posts WHERE blog_id = \"".$_GET['blog-id']."\""; 
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($blog_post = $result->fetch_assoc()) {
			$blog_title = $blog_post["blog_name"];
		}
	}
	$title = "Turtle Pond - Brown's Blog - $blog_title";
} else {
	$title = "Turtle Pond - Brown's Blog";
}

require $dir . "/templates/header.php" ?>
<div class='container body-container'>
<?php
if (!isset($_SESSION['user'])) { 
	echo '<h1 style="text-align: center;">Brown\'s Blog</h1>';
	echo "You need to log in to Discord before viewing this page.";
	require $dir . "/templates/sub-perks-description.php";
	echo "</div>";
} else { // User is logged in
	if (!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
		echo '<h1 style="text-align: center;">Brown\'s Blog</h1>';
		echo "You need to fulfill the sub requirements <a href='/subs'>here</a> before viewing this page.";
		require $dir . "/templates/sub-perks-description.php";
		echo "</div>";
	} else {
		if (isset($_GET["blog-type"]) && (isset($_GET["blog-id"]))) {
			$blog_type = $_GET["blog-type"];
			$blog_id = $_GET["blog-id"];
			require $dir . "/templates/blog.php";
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

			// $directories = array(
			// 	array("travelblog","NYC Travel Blog", "Follow Browntul on his adventures in New York City. January 2022."),
			// 	array("techblog","Tech Blog", "Take a look at Browntul's technological advances in this monthly blog."),
			// 	array("gamedevlogs","Game Dev Logs", "Deep dive into Browntul's thoughts as he makes web games for fun.")
			// );

			$directories = array();
			array_push($directories, array("search", "Search", "Search for a blog post."));
			$sql = "SELECT blog_type, name, description FROM blog_types";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					array_push($directories, array($row["blog_type"],$row["name"],$row["description"]));
				}
			}

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
			echo '<div class="tab-content bg-dark" id="blogdirectorycontent" style="padding:20px;color:white">';
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


				//$file_directory = array_filter(scandir(__DIR__ . "/" . $directory[0]), $find_md_file_name);
				//usort($file_directory, "file_compare");
				if ($directory[0] === "search") {
					echo "<br/>";
					echo '<form action="" method="get">
                    <input type="text" name="search-text" id="search-text" placeholder="Search..." value="'.$search_text.'"></input>
                    <button type="submit">Search</button>
                	</form>';
					$sql = 'SELECT * FROM blog_posts WHERE (LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",blog_name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",blog_content)>0) AND visible = 1 ORDER BY blog_date DESC, blog_id DESC, blog_name ASC;';
				} else {
					$sql = "SELECT * FROM blog_posts WHERE blog_type = \"".$directory[0]."\" AND visible = 1 ORDER BY blog_date DESC, blog_id DESC, blog_name ASC;";
				}
				//echo $sql;
				if ($directory[0] !== "search" || strlen($search_text) > 0) {
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while ($blog_entry = $result->fetch_assoc()) {
							$blog_date = $blog_entry["blog_date"];
							$blog_id = $blog_entry["blog_id"];
							$blog_name = $blog_entry["blog_name"];
							if ($title[0] === "-") {
								continue;
							}
							echo "<br/>";
							echo explode(" ",$blog_date)[0] . " - <a href=\"?blog-type=" .  $directory[0] . "&blog-id=" . $blog_id . "\">" . $blog_name . "</a>";
						}
					} else {
						if ($directory[0] === "search") {
							echo "(No search results...)";
						} else {
							echo ("(No blog entries...)");
						}
					}
				}
				echo "</div>";
			}
			echo "</div>";
		}
		
	}
}
?>
</div>
<?php require $dir . "/templates/footer.php" ?>	