<?php

if (!isset($dir)) {
    $dir = dirname(__DIR__, 1);
}
# Enabling error display
error_reporting(0);
ini_set('display_errors', 0);
# PHP strict mode for sessions
ini_set('session.use_strict_mode', 1);


# Including all the required scripts
require $dir . "/includes/default-includes.php";
?>

<html>

<head>
	<?php include $dir . "/includes/ganalytics.php" ?>
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