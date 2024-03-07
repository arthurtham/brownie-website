<?php
$dir = __DIR__;
$title = "BrowntulStar - Home";

require __DIR__ . "/templates/header.php" 
?>
<div class="container body-container-home">
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
			<strong class="me-auto">You have been logged in for a while. Please log in again to continue your journey.</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		</div>
EXPIRED;
	}
	?>
	<div id="center-block" class="d-flex align-items-center justify-content-center">
		<center><img src="https://res.cloudinary.com/browntulstar/image/private/c_pad,h_400/com.browntulstar/img/browntulstar-logo-v2-large.webp" style="width:100%;max-width:500px" />
		<div class="box bg-gradient shadow rounded" style="background-color: rgba(255,255,255,0.2); padding: 20px; width:100%; max-width:370px">
			<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
				<a class="btn btn-success w-100" href="/stream">
					<i class="fa-brands fa-twitch"></i>
					Stream
				</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
				<a href="/subs"  class="btn btn-light w-100">Sub Perks</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center">
				<a href="/about" class="btn btn-dark" style="width: 50%; margin-bottom:6px;">About</a>
				<a href="/about/credits"  class="btn btn-dark" style="width: 50%; margin-bottom:6px;">Credits</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center">
				<a href="/shoutcasting"  class="btn btn-dark" style="width: 50%; margin-bottom:6px;">Portfolio</a>
				<a href="/store"  class="btn btn-dark" style="width: 50%; margin-bottom:6px;">Support</a>
			</span>
			<small>@browntulstar</small>
			</center>
		</div>
	</div>
</div>

<script>
jQuery(document).ready(function($) {
	var alterCenterClass = function() {
		if(document.body.clientHeight < 701){
			$('#center-block').removeClass("align-items-center");		}
		else{
			$('#center-block').addClass("align-items-center");
		}
	}
	$(window).resize(function(){
		alterCenterClass();
	});
	alterCenterClass();
})
</script>

<?php 
$_FOOTER_HOME = false;
require __DIR__ . "/templates/footer.php" 
?>