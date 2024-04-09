<?php

if (!isset($dir)) {
    $dir = dirname(__DIR__, 1);
}

# Including all the required scripts
require $dir . "/includes/default-includes.php";
?>

<html>

<head>
	<?php include_once $dir . "/includes/ganalytics.php" ?>
	<?php require $dir . "/templates/header-includes.php" ?>
</head>

<?php if (isset($title) && in_array($title, array(
	"BrowntulStar - Home"
))
) {
	echo '<body class="home">';
} else if (isset($title) && in_array($title, array(
	"Turtle Pond - Sub Perks",
	"Turtle Pond - Profile",
	"Players List - #BrownieVAL Draft Deluxe"
))
) {
	echo '<body class="profile">';
} else {
	echo '<body>';
}
?>
	<?php require $dir . "/templates/navbar.php" ?>