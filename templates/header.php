<?php

if (!isset($dir)) {
    $dir = __DIR__;
}
# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

# Including all the required scripts for demo
require $dir . "/includes/functions.php";
require $dir . "/includes/discord.php";
require $dir . "/config.php";
require $dir . "/includes/sessiontimer.php";
?>

<html>

<head>
	<?php // $title = "BrowntulStar - Home" ?>
	<?php require $dir . "/templates/header-includes.php" ?>
</head>

<body>
	<?php require $dir . "/templates/navbar.php" ?>