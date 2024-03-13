<?php


$dir = dirname(__DIR__, 2);

// MYSQL support
require_once($dir . "/includes/mysql.php");

// Set search text if defined
if (isset($_GET["search-text"])) {
	$search_text = $_GET["search-text"];
} else {
	$search_text = "";
}

// If category doesn't end with "-tab", add it
// to support the legacy category parameter support
if (isset($_GET["category"])) {
	$needle_len = strlen("-tab");
	if (!($needle_len === 0 || 0 === substr_compare($_GET["category"], "-tab", - $needle_len))) {
		$_GET["category"] .= "-tab";
	}
}

// Set page title based on blog id if provided
if (isset($_GET["blog-type"]) && (isset($_GET["blog-id"]))) {
	$sql = "SELECT blog_name FROM blog_posts WHERE blog_id = \"".mysqli_real_escape_string($conn, $_GET['blog-id'])."\" AND blog_type = \"".mysqli_real_escape_string($conn, $_GET['blog-type'])."\";"; 
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($blog_post = $result->fetch_assoc()) {
			$blog_title = $blog_post["blog_name"];
		}
		$title = "$blog_title - Turtle Pond - Brown's Blog";
	} else {
		$title = "Turtle Pond - Brown's Blog";
	}
} else {
	$title = "Turtle Pond - Brown's Blog";
}

require $dir . "/templates/header.php" ?>
<div class='container body-container'>
<?php
 // User login status can change the display for call to action
$button_read_text = "Read";
if (!isset($_SESSION['user']) || !check_guild_membership($guild_id) || !check_roles($sub_perk_roles)) {
	// If user isn't logged in
	if (!isset($_SESSION['user'])) {
		$button_read_text = <<<SUBSCRIBE
		<i class='fa-brands fa-discord'></i>
		<i class="fa-brands fa-twitch"></i>
		<img style='border:0px;height:18px;margin-top:-4px;' src='https://res.cloudinary.com/browntulstar/image/private/c_pad,h_48/com.browntulstar/img/platform-kofi.webp' border='0' alt='ko-fi.com' />
		Login as sub to read
SUBSCRIBE;
	} else { // If user isn't subscribed
		$button_read_text = <<<SUBSCRIBE
		<i class="fa-brands fa-twitch"></i>
		<img style='border:0px;height:18px;margin-top:-4px;' src='https://res.cloudinary.com/browntulstar/image/private/c_pad,h_48/com.browntulstar/img/platform-kofi.webp' border='0' alt='ko-fi.com' />
		Sub on Twitch/Ko-fi to read
SUBSCRIBE;
	}
}

// If loading a blog page, check user status
if (isset($_GET["blog-type"]) && (isset($_GET["blog-id"]))) {
	// User unauthorized checks
	if (!isset($_SESSION['user']) || !check_guild_membership($guild_id) || !check_roles($sub_perk_roles)) {		
		// Force login page if user isn't logged in
		if (!isset($_SESSION['user'])) {
			redirect("/login.php");
			die();
		} else { // Otherwise they're just not subbed, display the call to action
			echo "<div class='alert alert-danger' role='alert'>
			<center>Error: Your Discord roles don't include being a Twitch or Ko-fi subscriber.<br>
			Read the sub perks below and pick a platform to subscribe!<br/>
			Make sure your Twitch is linked to Discord, or Discord is linked to Ko-fi.<br/>
			Then, log out and log back in again to read the blog posts.</center>
			</div>";
			echo '<h1 style="text-align: center">Brown\'s Blog</h1>';
			require $dir . "/templates/sub-perks-description.php";
		}
	} else { // User is authorized, load the blog pages
		$blog_type = $_GET["blog-type"];
		$blog_id = $_GET["blog-id"];
		require $dir . "/templates/blog.php";
	}
} else { // Show the home blog page
	echo '<script src="/assets/js/bootstrap-tab.js"></script>';
	// We need to get all directories from the database, plus the search tab
	$directories = array();
	array_push($directories, array("search", "All Posts", "View the most recent blog posts below, search for one, or pick a category above."));
	$sql = "SELECT blog_type, name, description FROM blog_types";
	$result = $conn->query($sql);
	// Store all categories in the directories array, but also check if the get parameters set the category already.
	$directory_category_found = false;
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			array_push($directories, array($row["blog_type"],$row["name"],$row["description"]));
			if ($row["blog_type"]."-tab" === $_GET["category"]) {
				$directory_category_found = true;
				$directory_to_browse = array($directories[array_key_last($directories)]);
			}				
		}
	}
	// If no category was defined, use search tab
	if (!$directory_category_found) {
		$_GET["category"] = "search-tab";
		$directory_to_browse = array($directories[0]);
	}

	// Title text
	echo '<h1 style="text-align: center;">Brown\'s Sub Blog</h1>';
	echo <<<ABOUT
		<center>Take a look at Browntul's blogs by clicking on the tabs below!</center><br/>
ABOUT;
	//Set up tabs
	echo '<div class="nav-tabs-div"><ul class="nav nav-tabs" id="blogdirectory" role="tablist">';
	$show_active_toggle = "true";
	$show_active_text = "active";
	$show_active_href = "";
	$nav_tabs_html = "";
	foreach ($directories as $directory) {
		if (isset($_GET["category"])) {
			if (strcmp($_GET["category"], $directory[0] . "-tab") === 0) {
				$show_active_toggle = "true";
				$show_active_text = "active";
				$show_active_href = "#";
			} else {
				$show_active_toggle = "false";
				$show_active_text = " ";
				$show_active_href = "/subs/blog/$directory[0]/";
			}
		} else {
			$show_active_href = "/subs/blog/$directory[0]/";
		}
		$nav_tabs_html_helper = <<<ITEM
		<li class="nav-item" role="presentation">
			<a href="$show_active_href">
			<button 
			class="nav-link $show_active_text" 
			id="$directory[0]-tab" 
			type="button" 
			role="tab" 
			aria-controls="$directory[0]-tab" 
			aria-selected="$show_active_toggle">
			$directory[1]
			</button>
			</a>
		</li>
ITEM;
		// Add these data toggles back if reverting to dynamic tab display,
		// While also changing the href to "#"
		// **********************
		// data-bs-toggle="tab" 
		// data-bs-target="#$directory[0]-tab-content" 
		if ($show_active_toggle === "true") {
			$nav_tabs_html = $nav_tabs_html_helper . $nav_tabs_html;
		} else {
			$nav_tabs_html .= $nav_tabs_html_helper;
		}
		$show_active_toggle = "false";
		$show_active_text = "";
	}
	echo $nav_tabs_html;
	echo '</ul></div>';
	echo '<div class="tab-content bg-dark" id="blogdirectorycontent" style="padding:20px;color:white">';
	// $show_active_toggle = true;
	foreach ($directory_to_browse as $directory) {	
		echo '<div class="tab-pane fade';
		// Before, we would check what tab we were in so we can display the right one,
		// but now that we are explicitly defining the active tab,
		// the checks below are commented out as unnecessary.
		// *******************************
		// if (isset($_GET["category"])) {
		// 	if (!$directory_category_found || strcmp($_GET["category"], $directory[0] . "-tab") === 0) {
		// 		echo ' show active';
		// 		$show_active_toggle = false;
		// 	};
		// } else if ($show_active_toggle) {
		// 		echo ' show active';
		// 		$show_active_toggle = false;
		// }
		echo ' show active';
		echo '" id="'.$directory[0].'-tab-content" role="tabpanel" aria-labelledby="'.$directory[0].'-tab-content">';
		echo "<h3>" . $directory[1] . "</h3>";
		echo "<small>" . $directory[2] . "</small><br>";

		// Show searchbox on the search page only
		// Also deal with search criteria
		if ($directory[0] === "search") {
			echo "<br/>";
			echo '<form action="/subs/blog/" method="get">
			<div class="input-group mb-3" style="max-width:500px">
				<span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
				<input required class="form-control" type="text" name="search-text" id="search-text" aria-label="search-text" placeholder="" value="'.$search_text.'"></input>
				<button class="btn btn-success" type="submit">Search</button>
				<button class="btn btn-light" type="button"><a href="?" class="text-decoration-none" style="color:black">Show All</a></button>
			</div>
			</form>';
			if (strlen($search_text) > 0) {
				$sql_criteria = '(LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",blog_name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",blog_content)>0)';
			} else {
				$sql_criteria = "true"; // In the future, we can make a criteria for top highlights
			}
		} else {
			// Search blog posts only by category
			$sql_criteria = "blog_posts.blog_type = \"".mysqli_real_escape_string($conn, $directory[0])."\"";
		}

		//Pagination preparation
		$pagestartfrom = 0; // A variable to start reading from
		$page = max(intval($_GET["page"]),1);
		$entrylimit = 7; // How many results per page?
		if (isset($_GET["page"]) && isset($_GET["category"])) {
			if ($_GET["category"] == $directory[0]."-tab") {
				$pagestartfrom = max($page-1,0) * $entrylimit;
			}
		}
		$pagination_html = "";
		$pagination_html_details = "";

		//Prepare all sql statements
		$sql = "SELECT blog_posts.blog_id, blog_posts.blog_name, blog_posts.blog_date, blog_posts.blog_type, 
		blog_types.name as blog_type_name, blog_posts.blog_content,
		COUNT(*) OVER() AS total_entries
		FROM blog_posts LEFT JOIN blog_types ON blog_posts.blog_type = blog_types.blog_type 
		WHERE ".$sql_criteria." AND visible = 1 
		ORDER BY blog_date DESC, blog_id DESC, blog_name ASC
		LIMIT ".$pagestartfrom.", ".$entrylimit.";";

		$sql_count = "SELECT COUNT(*) AS total_entries FROM blog_posts WHERE ".$sql_criteria." AND visible = 1;";
		
		// Pagination widget - supports multiple tabs, but the webpage
		// now doesn't load all categories at once. Even then, leave the
		// page detection code so it's easy to revert in the future. 
		if (true) {//($directory[0] !== "search" || strlen($search_text) > 0) {
			$result_count = $conn->query($sql_count);
			$pagination_blog_type = $directory[0];
			if ($result_count->num_rows > 0) {
				$total_entries = $result_count->fetch_assoc();
				$total_entries = intval($total_entries["total_entries"]);
				$pagination_html .= '<hr />
				<span aria-label="page">
					<ul class="pagination">
						<li class="page-item"><a class="page-link" disabled style="color:black">Page</a></li>';
				for ($_i = 0; $_i < intdiv($total_entries-1, $entrylimit)+1; ++$_i) {
					$pagination_html .= '<li class="page-item';
					if (
						($_i == 0 && (!isset($_GET["category"]) || $_GET["category"] != $pagination_blog_type."-tab"))
						|| ($_i == 0 && !isset($_GET["page"]))
						|| (isset($_GET["page"]) && $_i == $page-1 && (isset($_GET["category"]) && $_GET["category"] === $pagination_blog_type."-tab"))
					) {
						//TODO: Yes, this is the page that we are on
						$pagination_html .= ' active" aria-current="page">
							<span class="page-link">'.($_i+1).'</span>
						</li>';
					} else {
						//TODO: No, we are not on this page
						$pagination_html .= '"><a class="page-link" href="?'.($directory[0] !== "search" ? ("category=".$pagination_blog_type.'-tab') : ("category=search-tab&search-text=$search_text")).'&page='.($_i+1).'">'.($_i+1).'</a></li>';
					}
				}
				$pagination_html .= '</ul>';
				$pagination_html_details = '</nav><p>Showing '.min($entrylimit,$total_entries,$total_entries-$pagestartfrom).' entries ('.($pagestartfrom+1).'-'.min($pagestartfrom+$entrylimit,$total_entries).' of '.$total_entries.')</p>';
			}

			echo $pagination_html;
			
			// Blog post results
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while ($blog_entry = $result->fetch_assoc()) {
					$blog_type = $blog_entry["blog_type"];
					$blog_name = $blog_entry["blog_name"];
					if ($blog_name[0] === "-") {
						continue;
					}
					$blog_date = date_format(date_create_from_format("Y-m-d",explode(" ",$blog_entry["blog_date"])[0]),"F d, Y");
					$blog_id = $blog_entry["blog_id"];
					$blog_type_name = $blog_entry["blog_type_name"];
					
					//Preg match first image
					preg_match("/\!\[.*]\((.*)\)/", $blog_entry["blog_content"], $blog_image_url);
					$blog_image_url = empty($blog_image_url[1]) ? "https://res.cloudinary.com/browntulstar/image/private/c_pad,w_200,h_200,ar_1:1/com.browntulstar/img/turtle-adult.webp" : $blog_image_url[1];
					// Echo blog post
					echo <<<LISTINGS
					<div class="card" style="width: 100%;color:black">
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-lg-4" oncontextmenu='return false;' ondragstart='return false;'>
										<center><img class="rounded shadow" src="$blog_image_url" style="max-height: 200px; max-width: min(100%,225px);" /></center>
										<br />
									</div>
									<div class="col-lg-8">
										<h4 class="card-title">$blog_name</h4>
										<p class="card-text">
											$blog_date - $blog_type_name<br/>
											<p><a class="btn btn-dark" href="/subs/blog/$blog_type/$blog_id">$button_read_text</a></p>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<br />
LISTINGS;
				}
				echo $pagination_html;
				echo $pagination_html_details;
			} else {
				// Some error messages that are releveant
				echo "<hr>";
				if (isset($_GET["category"]) && ($_GET["category"] != "search-tab") && isset($_GET["page"]) && intval($_GET["page"] > 0)) {
					echo "An error occured. Please try again or pick a page.";
				}
				else if ($directory[0] === "search") {
					echo "No search results.";
				} else {
					echo "No blog entries in this category.";
				}
			}
		}
		echo "</div>";
	}
	echo "</div>";
}	
?>
</div>
<?php require $dir . "/templates/footer.php" ?>	