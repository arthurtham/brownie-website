<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Privacy Policy";
$find_md_file_name = function($v) { 
	return strpos($v, ".md");
};

require $dir . "/includes/Parsedown.php"; 
require $dir . "/templates/header.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">

<?php
	try {
			if ($myfile = fopen("privacy-policy.md", "r")) {
			echo Parsedown::instance()->text(fread($myfile, filesize("privacy-policy.md")));
			fclose($myfile);
			} else {
				echo "There was an error loading the file.";
			}
		} catch (Exception $e) {
			echo "There was an error loading the file.";
		}
?>
</div>

<?php require $dir . "/templates/footer.php" ?>