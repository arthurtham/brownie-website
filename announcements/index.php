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
	<input type="text" name="search-text" id="search-text" placeholder="Search..." value="'.$search_text.'"></input>
	<button type="submit">Search</button>
	</form>';
	if (isset($_GET["search-text"])) {
		$sql = 'SELECT * FROM announcement_embeds WHERE published=1 AND (LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",announcement_name)>0 OR LOCATE("'.mysqli_real_escape_string($conn,$search_text).'",announcement_embed)>0) ORDER BY announcement_date DESC, announcement_id DESC, announcement_name ASC;';
	} else {
		$sql = 'SELECT * FROM announcement_embeds WHERE published=1 ORDER BY announcement_date DESC, announcement_id DESC, announcement_name ASC;';
	}
	//$sql = "SELECT * FROM blog_posts WHERE blog_type = \"".$directory[0]."\" AND visible = 1 ORDER BY blog_date DESC, blog_id DESC, blog_name ASC;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($announcement_embed = $result->fetch_assoc()) {
			$announcement_date = $announcement_embed["announcement_date"];
			$announcement_id = $announcement_embed["announcement_id"];
			$announcement_name = $announcement_embed["announcement_name"];
			if ($title[0] === "-") {
				continue;
			}
			echo "<br/>";
			echo explode(" ",$announcement_date)[0] . " - <a href=\"?announcement-id=" . $announcement_id . "\">" . $announcement_name . "</a>";
		}
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