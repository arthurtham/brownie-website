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
			<strong class="me-auto">You were logged out due to inactivity. Please log in again.</strong>
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
	if (isset($_GET['expired'])) {
		echo <<<EXPIRED
		<div class="toast show fade position-absolute start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true" style="margin-top:50px">
		<div class="toast-header">
			<strong class="me-auto">You're been logged in for a while. Please log in again.</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		</div>
EXPIRED;
	}
	?>
	<div class="d-flex align-items-center justify-content-center" style="height:100vh">
		<div class="box bg-light bg-gradient shadow" style="padding: 40px; border-radius: 10%; width:100%; max-width:500px">
			<center><img src="https://res.cloudinary.com/browntulstar/image/private/c_pad,h_200/com.browntulstar/img/browntulstar-logo-v1-large.webp" style="border-radius: 100%;width:auto;max-width:200px" />
			<h1>Browntul</h1>
			<h5>@browntulstar</h5>
			<p>Turtle Streamer and Shoutcaster/Producer</p>
			<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
				<a class="btn btn-dark w-100" href="/stream">
					<i class="fa-brands fa-twitch"></i>
					Stream
				</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
				<a href="/subs"  class="btn btn-danger w-100">Sub Perks</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center">
				<a href="/about" class="btn btn-secondary" style="width: 50%; margin-bottom:6px;">About</a>
				<a href="/about/credits"  class="btn btn-secondary" style="width: 50%; margin-bottom:6px;">Credits</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center">
				<a href="/shoutcasting"  class="btn btn-secondary" style="width: 50%; margin-bottom:6px;">Portfolio</a>
				<a href="/store"  class="btn btn-secondary" style="width: 50%; margin-bottom:6px;">Support</a>
			</span>
			</center>
		</div>
	</div>
</div>

<?php 
$_FOOTER_HOME = true;
require __DIR__ . "/templates/footer.php" 
?>