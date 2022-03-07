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
	<script src="https://kit.fontawesome.com/7f5f717705.js" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>

<body>
	<?php require __DIR__ . "/templates/navbar.php" ?>
	<div class="container">
		<div class="d-flex align-items-center justify-content-center" style="height:100%">
			<div class="box bg-light bg-gradient shadow" style="padding: 40px; border-radius: 10%">
				<center><img src="/assets/img/browntulstar-logo.png" style="border-radius: 100%;width:auto;max-width:200px" />
				<h1 style="text-align: center;">Browntul</h1>
				<p>Streamer, Game Designer, Shoutcaster</p>
					<h2>
						<a style="text-decoration: none" href="https://twitch.tv/browntulstar" target="_blank">
							<i class="fab fa-twitch"></i>
						</a> 
						<a style="text-decoration: none" href="https://twitter.com/browntulstar" target="_blank">
							<i class="fab fa-twitter"></i>
						</a>
					</h2>
				</center>
			</div>
		</div>
	</div>

	<?php require __DIR__ . "/templates/footer.php" ?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>