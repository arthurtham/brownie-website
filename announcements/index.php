<?php


$dir = dirname(__DIR__, 1);

require_once($dir . "/includes/mysql.php");
require_once($dir . "/includes/CloudinarySigner.php");

if (isset($_GET["search-text"])) {
	$search_text = $_GET["search-text"];
} else {
	$search_text = "";
}

if (isset($_GET["announcement-id"])) {
	$sql = "SELECT title FROM announcement_posts WHERE id = \"". mysqli_real_escape_string($conn, $_GET['announcement-id'])."\" AND published=1 LIMIT 1;"; 
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($announcement_embed = $result->fetch_assoc()) {
			$announcement_name = $announcement_embed["title"];
		}
		$title = "$announcement_name - BrowntulStar - Browntul Says";
	} else {
		$title = "BrowntulStar - Browntul Says";
	}
} else {
	$title = "BrowntulStar - Browntul Says";
}

require $dir . "/templates/header.php" ?>
<div class='container body-container'>
<?php
if (isset($_GET["announcement-id"])) {
	$announcement_id = $_GET["announcement-id"];
	require $dir . "/templates/announcement.php";
} else {
	echo '<script src="/assets/js/bootstrap-tab.js"></script>';
	echo '<h1 style="text-align: center;">Browntul Says</h1>';
	echo <<<ABOUT
		<center>Take a look at what Browntul has to say!</center><br/>
ABOUT;
	echo <<<ITEM
	<ul class="nav nav-tabs" id="blogdirectory" role="tablist">
	<li class="nav-item" role="presentation">
		<button 
		class="nav-link active" 
		id="announcements-tab" 
		data-bs-toggle="tab" 
		data-bs-target="#announcements-tab-content" 
		type="button" 
		role="tab" 
		aria-controls="announcements-tab" 
		aria-selected="true">Browntul Says</button>
	</li>
ITEM;
	echo '</ul>';
	echo '<div class="tab-content bg-dark" id="blogdirectorycontent" style="padding:20px;color:white">';
	echo '<div class="tab-pane fade show active id="announcements-tab-content" role="tabpanel" aria-labelledby="announcements-tab-content">';
	
	echo '<form action="/announcements/" method="get">
	<div class="input-group mb-3" style="max-width:500px">
		<span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
		<input required class="form-control" type="text" name="search-text" id="search-text" aria-label="search-text" placeholder="" value="'.$search_text.'"></input>
		<button class="btn btn-light" type="button"><a href="/announcements" class="text-decoration-none" style="color:black"><i class="fa-solid fa-circle-xmark"></i></a></button>
		<button class="btn btn-success" type="submit">Search</button>
	</div>
	</form>';
	if (isset($_GET["search-text"])) {
		$sql_criteria = ' AND (LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",title)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",content)>0) ';
	} 

	//Pagination preparation
	$page = max(intval($_GET["page"]),1);
	$entrylimit = 10; // How many results per page?
	$pagestartfrom = max($page-1,0) * $entrylimit;
	$pagination_html = "";
	$pagination_html_details = "";
	
	$sql = "SELECT * FROM announcement_posts WHERE published=1 AND visible=1 $sql_criteria ORDER BY publish_date DESC, id DESC, title ASC LIMIT $pagestartfrom, $entrylimit;";
	$sql_count = "SELECT COUNT(*) AS total_entries FROM announcement_posts WHERE published=1 $sql_criteria";

	$result_count = $conn->query($sql_count);
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
				($_i == 0 && !isset($_GET["page"]))
				|| (isset($_GET["page"]) && $_i == $page-1)
			) {
				$pagination_html .= ' active" aria-current="page">
					<span class="page-link">'.($_i+1).'</span>
				</li>';
			} else {
				$pagination_html .= '"><a class="page-link" href="?'.(isset($_GET["search-text"]) ? ("search-text=$search_text&") : "").'page='.($_i+1).'">'.($_i+1).'</a></li>';
			}
		}
		$pagination_html .= '</ul>';
		$pagination_html_details = '</nav><p>Showing '.min($entrylimit,$total_entries,$total_entries-$pagestartfrom).' entries ('.($pagestartfrom+1).'-'.min($pagestartfrom+$entrylimit,$total_entries).' of '.$total_entries.')</p>';
	}

	echo $pagination_html;
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$cldSigner = new CloudinarySigner();
		while ($announcement_embed = $result->fetch_assoc()) {
			$announcement_date = date_format(date_create_from_format("Y-m-d",explode(" ",$announcement_embed["publish_date"])[0]),"F d, Y");
			$announcement_id = $announcement_embed["id"];
			$announcement_name = $announcement_embed["title"];
			if ($title[0] === "-") {
				continue;
			}
			//Preg match first image
			$announcement_image_url;
			preg_match("/\!\[.*]\((.*)\)/", $announcement_embed["content"], $announcement_image_url);
			$announcement_image_url = empty($announcement_image_url[1]) ? "https://res.cloudinary.com/browntulstar/image/private/s--ZPURbd45--/c_pad,w_200,h_200,ar_1:1/f_webp/v1/com.browntulstar/img/turtle-adult?_a=BAAAUWGX" : ($cldSigner->signUrl($cldSigner->convertLocalUrlsToCloudinaryUrls($announcement_image_url[1])));
			
			// Find the first paragraph and then truncate it
			$announcement_snippet = Parsedown::instance()->setBreaksEnabled(true)->text($announcement_embed["content"]); // Returns HTML
			$announcement_snippet = strip_tags($announcement_snippet, array("<p>")); // Remove HTML tags except paragraphs
			// Get the first paragraph only, but make sure the paragraph is not empty. If it is, get the next one.
			preg_match_all("/<p>(.*?)<\/p>/", $announcement_snippet, $matches);
			// find a match that has a non-empty string
			$announcement_snippet_match = false;
			$announcement_snippet = "";
			foreach ($matches[1] as $paragraph) {
				if (trim($paragraph) !== "") {
					$announcement_snippet = $paragraph;
					$announcement_snippet_match = true;
					break;
				}
			}
			if ($announcement_snippet_match === false) {
				$announcement_snippet = "Check out this post!";
			} else {
				// Limit to up to 15 words
				$announcement_snippet = preg_replace('/\s+/', ' ', $announcement_snippet); // Remove extra spaces
				$announcement_snippet_limit = 25; // Limit to 15 words
				$announcement_snippet = explode(" ", $announcement_snippet, $announcement_snippet_limit); // Split into words
				if (count($announcement_snippet) > $announcement_snippet_limit-1) {
					$announcement_snippet = implode(" ", array_slice($announcement_snippet, 0, $announcement_snippet_limit-1)) . "..."; // Join the first 15 words
				} else {
					$announcement_snippet = implode(" ", $announcement_snippet); // Join all words
				}
			}
			
			echo "<br/>";
			// echo explode(" ",$announcement_date) . " - <a href=\"?announcement-id=" . $announcement_id . "\">" . $announcement_name . "</a>";
			echo <<<ANNOUNCEMENTPOST
			<div class="card" style="width: 100%;color:black">
				<div class="card-body">
					<div class="container">
						<div class="row">
							<div class="col-lg-4" oncontextmenu='return false;' ondragstart='return false;'>
								<center><img class="rounded shadow" src="$announcement_image_url" style="max-height: 200px; max-width: min(100%,225px);" /></center>
								<br />
							</div>
							<div class="col-lg-8">
								<h4 class="card-title">$announcement_name</h4>
								<p class="card-text">
									$announcement_date<br/>
									<em>$announcement_snippet</em>
									<p><a class="btn btn-dark" href="/announcements/$announcement_id/">Read</a></p>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
ANNOUNCEMENTPOST;
		}
		echo $pagination_html;
		echo $pagination_html_details;
	} else {
		echo "(No entries...)";
	}
	//echo $sql;
	echo "</div>";
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