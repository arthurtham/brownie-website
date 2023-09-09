<?php

if (!isset($dir)) {
    $dir = __DIR__;
}
# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

# Including all the required scripts
require $dir . "/includes/default-includes.php";
?>

<html>

<head>
	<?php // $title = "BrowntulStar - Home" ?>
	<?php require $dir . "/templates/header-includes.php" ?>
</head>

<body>
	<?php require $dir . "/templates/navbar.php" ?>