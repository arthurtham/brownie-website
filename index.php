<?php
# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

# Including all the required scripts for demo
require __DIR__ . "/includes/functions.php";
require __DIR__ . "/includes/discord.php";
require __DIR__ . "/config.php";
?>

<html>

<head>
	<title>Demo - Discord Oauth</title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
	<?php require __DIR__ . "/templates/navbar.php" ?>
	<h1 style="text-align: center;">Turtle Pond</h1>
	<?php
    echo "<h2 style='color:red; font-weight:900; text-align: center;'>Home Page </h2><br/>";
    echo "<p><a href='subs'>Subs</a></p><br/>";
	?>
		
</body>

</html>