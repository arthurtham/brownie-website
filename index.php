<?php
# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

# Including all the required scripts for demo
require __DIR__ . "/includes/functions.php";
require __DIR__ . "/includes/discord.php";
require __DIR__ . "/config.php";
require __DIR__ . "/includes/sessiontimer.php";
?>

<html>

<head>
	<title>BrowntulStar - Home</title>
	<link rel="stylesheet" href="/assets/css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>

<body>
	<?php require __DIR__ . "/templates/navbar.php" ?>
	<div class="container body-container">
		<h1 style="text-align: center;">Browntul</h1>
		<?php
		echo "<h2 style='color:red; font-weight:900; text-align: center;'>Home Page </h2><br/>";
		echo "<p><a href='subs'>Subs</a></p><br/>";
		?>
		</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>