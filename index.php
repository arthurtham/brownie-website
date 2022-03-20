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
	<?php require __DIR__ . "/templates/header-includes.php" ?>
</head>

<body>
	<?php require __DIR__ . "/templates/navbar.php" ?>
	<div class="container">
		<?php
		if (isset($_GET['logout'])) {
			echo <<<LOGGEDOUT
			<div class="toast show fade position-absolute start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true" style="margin-top:50px">
			<div class="toast-header">
				<strong class="me-auto">You were logged out due to inactivity.</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			</div>
LOGGEDOUT;
		}
		if (isset($_GET['badauth'])) {
			echo <<<BADAUTH
			<div class="toast show fade position-absolute start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true" style="margin-top:50px">
			<div class="toast-header">
				<strong class="me-auto">Login unsuccessful. Please try again.</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			</div>
BADAUTH;
		}
		?>
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