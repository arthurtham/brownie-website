<?php
$dir = dirname(__DIR__, 2);
$title = "Turtle Pond - Tank Engine Karaoke";
$find_md_file_name = function($v) { 
	return strpos($v, ".md");
};


require $dir . "/templates/header.php";
?>

<?php
if (!isset($_SESSION['user'])) { 
	echo '<div class="container body-container">';		
	echo "<div class='alert alert-danger' role='alert'>
	<center>You need to log in to Discord before viewing this page.</center>
	</div>";
	echo "<h1 class='text-center'>Karaoke</h1>";
	require $dir . "/templates/sub-perks-description.php";
	echo "</div>";
} else { // User is logged in
	if (!check_guild_membership($guild_id) || !check_roles($sub_perk_roles)) {
		echo '<div class="container body-container">';		
		echo "<div class='alert alert-danger' role='alert'>
		<center>You need to fulfill the sub requirements <a href='/subs'>here</a> before viewing this page.</center>
		</div>";
		echo "<h1 class='text-center'>Karaoke</h1>";
		require $dir . "/templates/sub-perks-description.php";
		echo "</div>";
	} else {
		echo '<div class="container body-container-no-bg" style="padding-bottom:3rem !important">';		
		echo "<h1 class='text-center text-white'>Tank Engine Karaoke</h1>";
		echo "<p class='text-center text-white'>Sing Along with Browntul the Tank Engine!</p>";
		echo "<hr/>";
		require_once $dir . "/templates/karaoke.php";
	}
}
?>
</div>
<?php require dirname(__DIR__, 2) . "/templates/footer.php" ?>	

