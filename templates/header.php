<?php

if (!isset($dir)) {
    $dir = dirname(__DIR__, 1);
}
# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 0);

# Including all the required scripts
require $dir . "/includes/default-includes.php";
?>

<html>

<head>
	<?php require $dir . "/includes/ganalytics.php" ?>
	<?php require $dir . "/templates/header-includes.php" ?>
</head>

<body>
	<?php require $dir . "/templates/navbar.php" ?>