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
	"Turtle Pond - Perks",
	"Turtle Pond - Perks Hub",
	"Turtle Pond - Perks Status",
	"Turtle Pond - Profile",
	"Players List - #BrownieVAL Draft Deluxe"
))
) {
	echo '<body class="profile">';
} else if (isset($title) && in_array($title, array(
	"BrowntulStar - IRIAM",
	"BrowntulStar - IRIAM Star Badge Rewards"
))
) {
	echo '<body class="iriam">';
} else {
	echo '<body>';
}

require $dir . "/templates/navbar.php";

?>

