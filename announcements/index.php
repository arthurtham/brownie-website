<?php


$dir = dirname(__DIR__, 1);

require_once($dir . "/includes/mysql.php");

if (isset($_GET["search-text"])) {
	$search_text = $_GET["search-text"];
} else {
	$search_text = "";
}

if (isset($_GET["announcement-id"])) {
	$sql = "SELECT announcement_name FROM announcement_embeds WHERE announcement_id = \"".$_GET['announcement-id']."\""; 
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($announcement_embed = $result->fetch_assoc()) {
			$announcement_name = $announcement_embed["announcement_name"];
		}
	}
	$title = "$announcement_name - Turtle Pond - Announcements";
} else {
	$title = "Turtle Pond - Announcements";
}

require $dir . "/templates/header.php" ?>
<div class='container body-container'>
<?php
if (isset($_GET["announcement-id"])) {
	$announcement_id = $_GET["announcement-id"];
	require $dir . "/templates/announcement.php";
} else {
	echo '<script src="/assets/js/bootstrap-tab.js"></script>';
	echo '<h1 style="text-align: center;">Announcements</h1>';
	echo <<<ABOUT
		<center>Take a look at the latest announcements straight from Browntul!</center><br/>
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
		aria-selected="true">Announcements</button>
	</li>
ITEM;
	echo '</ul>';
	echo '<div class="tab-content bg-dark" id="blogdirectorycontent" style="padding:20px;color:white">';
	echo '<div class="tab-pane fade show active id="announcements-tab-content" role="tabpanel" aria-labelledby="announcements-tab-content">';
	
	echo '<form action="/announcements/" method="get">
	<div class="input-group mb-3" style="max-width:500px">
		<span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
		<input required class="form-control" type="text" name="search-text" id="search-text" aria-label="search-text" placeholder="" value="'.$search_text.'"></input>
		<button class="btn btn-success" type="submit">Search</button>
		<button class="btn btn-light" type="button"><a href="?" class="text-decoration-none" style="color:black">Show All</a></button>
	</div>
	</form>';
	if (isset($_GET["search-text"])) {
		$sql_criteria = ' AND (LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",announcement_name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",announcement_embed)>0) ';
	} 

	//Pagination preparation
	$page = max(intval($_GET["page"]),1);
	$entrylimit = 5; // How many results per page?
	$pagestartfrom = max($page-1,0) * $entrylimit;
	$pagination_html = "";
	$pagination_html_details = "";
	
	$sql = "SELECT * FROM announcement_embeds WHERE published=1 $sql_criteria ORDER BY announcement_date DESC, announcement_id DESC, announcement_name ASC LIMIT $pagestartfrom, $entrylimit;";
	$sql_count = "SELECT COUNT(*) AS total_entries FROM announcement_embeds WHERE published=1";

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
				$pagination_html .= '"><a class="page-link" href="?'.($directory[0] !== "search" ? ("category=".$pagination_blog_type.'-tab') : ("category=search-tab&search-text=$search_text")).'&page='.($_i+1).'">'.($_i+1).'</a></li>';
			}
		}
		$pagination_html .= '</ul>';
		$pagination_html_details = '</nav><p>Showing '.min($entrylimit,$total_entries,$total_entries-$pagestartfrom).' entries ('.($pagestartfrom+1).'-'.min($pagestartfrom+$entrylimit,$total_entries).' of '.$total_entries.')</p>';
	}

	echo $pagination_html;
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($announcement_embed = $result->fetch_assoc()) {
			$announcement_date = date_format(date_create_from_format("Y-m-d",explode(" ",$announcement_embed["announcement_date"])[0]),"F d, Y");
			$announcement_id = $announcement_embed["announcement_id"];
			$announcement_name = $announcement_embed["announcement_name"];
			if ($title[0] === "-") {
				continue;
			}
			echo "<br/>";
			// echo explode(" ",$announcement_date) . " - <a href=\"?announcement-id=" . $announcement_id . "\">" . $announcement_name . "</a>";
			echo <<<ANNOUNCEMENTPOST
			<div class="card" style="width: 100%;color:black">
				<div class="card-body">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<h4 class="card-title">$announcement_name</h4>
								<p class="card-text">
									$announcement_date<br/>
									<p><a class="btn btn-dark" href="/announcements/$announcement_id">Read</a></p>
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
<?php require $dir . "/templates/footer.php" ?>	