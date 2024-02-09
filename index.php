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
	<div class="d-flex align-items-center justify-content-center" style="height:100%">
		<div class="box bg-light bg-gradient shadow" style="padding: 40px; border-radius: 10%">
			<center><img src="/assets/img/turtleavatar.png" style="border-radius: 100%;width:auto;max-width:200px" />
			<h1>Browntul</h1>
			<h5 style="margin-top:-10px">@browntulstar</h5>
			<p>Turtle Streamer and Shoutcaster/Producer</p>
			<span class="d-flex flex-row gap-1" style="text-align: center">
				<a href="/about" class="btn btn-success" style="width: 50%; margin-bottom:6px;">About</a>
				<a href="/subs"  class="btn btn-warning" style="width: 50%; margin-bottom:6px;">Sub Perks</a>
			</span>
			<span class="d-flex flex-row gap-2 justify-content-center">
				<a style="text-decoration: none;font-size:32px" href="https://twitch.tv/browntulstar" target="_blank">
					<i class="fab fa-twitch"></i>
				</a> 
				<a style="text-decoration: none;font-size:32px" href="https://x.com/browntulstar" target="_blank">
					<i class="fa-brands fa-x-twitter"></i>
				</a>
				<a style="text-decoration: none;font-size:32px" href="/youtube" target="_blank">
					<i class="fa-brands fa-youtube"></i>
				</a>
				<a style="text-decoration: none;font-size:32px" href="/tiktok" target="_blank">
					<i class="fa-brands fa-tiktok"></i>
				</a>
				<a style="text-decoration: none;font-size:32px" href="https://ko-fi.com/browntulstar" target="_blank">
					<i class="fa-solid fa-mug-hot"></i>
				</a>
			</span>
			<span class="d-flex flex-row justify-content-center">
				<a style="text-decoration: none;font-size:32px;padding:6px" href="/discord" target="_blank">
					<i class="fab fa-discord"></i>
				</a> 
				<a style="text-decoration: none;font-size:32px;padding:6px" href="mailto:browntulstar@browntulstar.com" target="_blank">
					<i class="fa-solid fa-envelope"></i>
				</a>
			</span>
			</center>
		</div>
	</div>
</div>

<script src='https://storage.ko-fi.com/cdn/scripts/overlay-widget.js'></script>
<script>
  kofiWidgetOverlay.draw('browntulstar', {
    'type': 'floating-chat',
    'floating-chat.donateButton.text': 'Support me',
    'floating-chat.donateButton.background-color': '#fcbf47',
    'floating-chat.donateButton.text-color': '#323842'
  });
</script>

<?php 
$_FOOTER_ENABLE = false; 
require __DIR__ . "/templates/footer.php" 
?>