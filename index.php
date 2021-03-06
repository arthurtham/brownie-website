<?php
$dir = __DIR__;
$title = "BrowntulStar - Home";

require __DIR__ . "/templates/header.php" 
?>
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