<?php


$dir = dirname(__DIR__, 1);

require_once($dir . "/includes/mysql.php");
require_once($dir . "/includes/CloudinarySigner.php");

if (isset($_GET["query"])) {
	$search_text = $_GET["query"];
} else {
	$search_text = "";
}

if (isset($_GET["url"])) {
	$sql = "SELECT title FROM guide_posts WHERE url = \"" . mysqli_real_escape_string($conn, $_GET['url']) . "\" AND visible=1"; 
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($guide_post = $result->fetch_assoc()) {
			$guide_title = $guide_post["title"];
		}
		$title = "$guide_title - BrowntulStar - Guides";
	} else {
		$title = "BrowntulStar - Guides";
	}
} else {
	$title = "BrowntulStar - Guides";
}

require $dir . "/templates/header.php" ?>
<div class='container body-container'>
<?php
if (isset($_GET["url"])) {
	$guide_url = $_GET["url"];
	require $dir . "/templates/guide.php";
} else {
	echo '<script src="/assets/js/bootstrap-tab.js"></script>';
	echo '<h1 style="text-align: center;">Guides</h1>';
	echo <<<ABOUT
		<center>Need help? Read one of Browntul's guides for a few things he knows!</center><br/>
ABOUT;


	// Directory Setup
	$directories = array();
	array_push($directories, array("search", "All Guides", "View the most recent guides below, search for one, or pick a category above."));
	$sql = "SELECT displayname, category, description FROM guide_types WHERE visible = 1 ORDER BY displayname ASC;";
	$result = $conn->query($sql);
	$directory_category_found = false;
	if ($result->num_rows > 0) {
		while ($types = $result->fetch_assoc()) {
			array_push($directories, array($types["category"],$types["displayname"],$types["description"]));
			if ($types["category"] === $_GET["category"]) {
				$directory_category_found = true;
				$directory_to_browse = array($directories[array_key_last($directories)]);
			}				
		}
	}
	// If no category was defined, use search tab
	if (!$directory_category_found) {
		$_GET["category"] = "search";
		$directory_to_browse = array($directories[0]);
	}

	// Directory Tab Selector Setup
	echo <<<ITEM
	<ul class="nav nav-tabs" id="guidedirectory" role="tablist">
ITEM;
	foreach ($directories as $directory) {
		$_category = $directory[0];
		$_is_current_category = ($_category === $_GET["category"]);
		$_displayname = $directory[1];
		$_description = $directory[2];
		$_active = ($_is_current_category) ? " active" : "";
		$_href = ($_is_current_category) ? "#" : "/guides/category/".$directory[0]."/";
		echo <<<ITEM
		<li class="nav-item" role="presentation">
			<a href="$_href">
			<button class="nav-link$_active" id="$_category-tab" 
			data-bs-toggle="tab" data-bs-target="#$_category-tab-content" 
			type="button" role="tab" aria-controls="$_category-tab" aria-selected="true">$_displayname</button>
			</a>
		</li>
ITEM;
	}
	echo "</ul>";

	// Directory Tab Content Setup
	echo '<div class="tab-content bg-dark" id="guidedirectorycontent" style="padding:20px;color:white">';

	foreach ($directory_to_browse as $directory) {
		$_category = $directory[0];
		$_displayname = $directory[1];
		$_description = $directory[2];
		echo <<<ITEM
		<div class="tab-pane fade show active id="$_category-tab-content" role="tabpanel" 
		aria-labelledby="$_category-tab-content">
		<h2>$_displayname</h2>
		<p>$_description</p>
ITEM;
		echo "<br/>";
		echo '<form action="/guides/category/' . $_category . '" method="get">';
		// Search Bar
		echo '<div class="input-group mb-3" style="max-width:500px">
			<span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
			<input required class="form-control" type="text" name="query" id="query" aria-label="query" placeholder="" value="'.$search_text.'"></input>
			<button class="btn btn-success" type="submit">Search</button>
			<button class="btn btn-light" type="button"><a href="/guides/'.$_category.'/" class="text-decoration-none" style="color:black">Show All</a></button>
		</div>
		</form>';
		$sql_criteria = null;
		if (strlen($search_text) > 0) {
			$sql_criteria = '(LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",guide_posts.title)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",guide_posts.summary)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",guide_posts.content)>0)';
		}
		if ($_category !== "search") {
			if ($sql_criteria != null) {
			    $sql_criteria .= " AND ";
			}
			$sql_criteria .= "guide_posts.category = \"".mysqli_real_escape_string($conn, $directory[0])."\"";
		}
		if ($sql_criteria === null) {
			$sql_criteria = "true";
		}

		//Pagination
		$pagestartfrom = 0;
		$page = max(intval($_GET["page"]),1);
		$entrylimit = 10;
		if (isset($_GET["page"])) {
			$pagestartfrom = max($page-1,0) * $entrylimit;
		}
		$pagination_html = "";
		$pagination_html_details = "";

		//Prepare all sql statements
		$sql = "SELECT guide_posts.title, guide_posts.summary, guide_posts.content, guide_posts.category, 
		guide_types.displayname AS guide_type_name, guide_posts.publish_date, guide_posts.modified_date, guide_posts.published, guide_posts.visible, guide_posts.url 
		FROM guide_posts LEFT JOIN guide_types ON guide_posts.category = guide_types.category
		WHERE ". $sql_criteria ." AND guide_posts.visible = 1 AND guide_posts.published = 1
		ORDER BY guide_posts.publish_date DESC, guide_posts.modified_date DESC, guide_posts.title ASC
		LIMIT ".$pagestartfrom.", ".$entrylimit.";";

		$sql_count = "SELECT COUNT(*) AS total_entries FROM guide_posts WHERE ". $sql_criteria ." AND guide_posts.visible = 1 AND guide_posts.published = 1;";
		
		// Pagination
		$result_count = $conn->query($sql_count);
		$pagination_guide_type = $_category;
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
					($page === $_i+1)
				) {
					//TODO: Yes, this is the page that we are on
					$pagination_html .= ' active" aria-current="page">
						<span class="page-link">'.($_i+1).'</span>
					</li>';
				} else {
					//TODO: No, we are not on this page
					$pagination_html .= '"><a class="page-link" href="/guides/category/' . $pagination_guide_type . (strlen($search_text) ? ('?query=' . $search_text) : "") .(strlen($search_text) === 0 ? "?" : "&").'page='.($_i+1).'">'.($_i+1).'</a></li>';
				}
			}
			$pagination_html .= '</ul>';
			$pagination_html_details = '</nav><p>Showing '.min($entrylimit,$total_entries,$total_entries-$pagestartfrom).' entries ('.($pagestartfrom+1).'-'.min($pagestartfrom+$entrylimit,$total_entries).' of '.$total_entries.')</p>';
		}


		// Listings
		$result = $conn->query($sql);
		$cldSigner = new CloudinarySigner();
		if ($result->num_rows > 0) {
			echo $pagination_html;
			while ($guide_entry = $result->fetch_assoc()) {
				$guide_category = $guide_entry["category"];
				$guide_title = $guide_entry["title"];
				if ($guide_title[0] === "-") {
					continue;
				}
				$guide_publish_date = date_format(date_create_from_format("Y-m-d",explode(" ",$guide_entry["publish_date"])[0]),"F d, Y");
				$guide_url = $guide_entry["url"];
				$guide_type_displayname = $guide_entry["guide_type_name"];
				$guide_summary = $guide_entry["summary"];
				
				//Preg match first image
				preg_match("/\!\[.*]\((.*)\)/", $guide_entry["content"], $guide_image_url);
				$guide_image_url = empty($guide_image_url[1]) ? "https://res.cloudinary.com/browntulstar/image/private/s--ZPURbd45--/c_pad,w_200,h_200,ar_1:1/f_webp/v1/com.browntulstar/img/turtle-adult?_a=BAAAUWGX" : ($cldSigner->signUrl($cldSigner->convertLocalUrlsToCloudinaryUrls($guide_image_url[1])));
				// Echo guide description
				echo <<<LISTINGS
				<div class="card" style="width: 100%;color:black">
					<div class="card-body">
						<div class="container">
							<div class="row">
								<div class="col-lg-4" oncontextmenu='return false;' ondragstart='return false;'>
									<center><img class="rounded shadow" src="$guide_image_url" style="max-height: 200px; max-width: min(100%,225px);" /></center>
									<br />
								</div>
								<div class="col-lg-8">
									<h4 class="card-title">$guide_title</h4>
									<p class="card-text">
										$guide_publish_date - $guide_type_displayname<br/>
										<i>$guide_summary</i>
										<p><a class="btn btn-dark" href="/guides/post/$guide_url">View</a></p>
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
			echo "<hr><h6>Sorry, no guides found...</h6></center>";
		}
		echo "</div>";
	} 
	echo "</div>";
}
?>
</div>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
   document.querySelectorAll('img').forEach(function(img){
  	img.onerror = function(){this.style.display='none';};
   })
});
</script>
<?php require $dir . "/templates/footer.php" ?>	