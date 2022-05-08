<?php
$dir = dirname(__DIR__, 2);
$title = "Turtle Pond - Brown's Giveaways";
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
require $dir . "/includes/Parsedown.php"; 
require $dir . "/templates/header.php";
?>

<div class='container body-container'>
<?php
if (!isset($_SESSION['user'])) { 
	echo "<div class='alert alert-danger' role='alert'>
	<center>You need to log in to Discord before viewing this page.</center>
	</div>";
	echo "<h1 class='text-center'>Brown's Giveaways</h1>";
	require $dir . "/templates/sub-perks-description.php";
	echo "</div>";
} else { // User is logged in
	if (!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
		echo "<div class='alert alert-danger' role='alert'>
		<center>You need to fulfill the sub requirements <a href='/subs'>here</a> before viewing this page.</center>
		</div>";
		echo "<h1 class='text-center'>Brown's Giveaways</h1>";
		require $dir . "/templates/sub-perks-description.php";
		echo "</div>";
	} else {
		echo "<p class='text-center'>Claim sub-exclusive giveaways on this page, as a special thanks to you!</p>";
		echo "<hr/>";
		try {
			if ($myfile = fopen("giveaway-links.md", "r")) {
			echo Parsedown::instance()->text(fread($myfile, filesize("giveaway-links.md")));
			fclose($myfile);
			} else {
				echo "There's no sub giveaways going on right now.";
			}
		} catch (Exception $e) {
			echo "There's either no sub giveaways going on right now, or there was a problem loading them.";
		}
	}
}
?>
</div>
<?php require dirname(__DIR__, 2) . "/templates/footer.php" ?>	