<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Home";

require $dir . "/templates/header.php" 
?>
<div class="container body-container-home">
	<div id="center-block" class="d-flex align-items-center justify-content-center">
		<center><img src="https://res.cloudinary.com/browntulstar/image/private/s--gRiI4zsg--/c_pad,h_400/e_shadow/com.browntulstar/img/browntulstar-logo-v2-large.png" style="width:100%;max-width:500px" />
		<div class="box bg-gradient shadow rounded" style="background-color: rgba(255,255,255,0.2); padding: 20px; width:100%; max-width:370px">
			<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
				<a class="btn btn-primary w-100" href="/stream">
					<i class="fa-brands fa-twitch"></i>
					Stream
				</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
				<a href="#" id="navbarSubs-button" class="btn btn-success w-100"><i class="fa-solid fa-circle-check"></i> Sub Perks</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center">
				<a href="/about" class="btn btn-dark" style="width: 50%; margin-bottom:6px;">About</a>
				<a href="/about/credits"  class="btn btn-dark" style="width: 50%; margin-bottom:6px;">Credits</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center">
				<a href="/shoutcasting"  class="btn btn-dark" style="width: 50%; margin-bottom:6px;">Portfolio</a>
				<a href="/store"  class="btn btn-dark" style="width: 50%; margin-bottom:6px;">Support Me</a>
			</span>
			<small>@browntulstar</small>
			</center>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var alterCenterClass = function() {
		if (document.body.clientHeight < 701) {
			$('#center-block').removeClass("align-items-center");		
			}
		else{
			$('#center-block').addClass("align-items-center");
		}
	}
	$(window).resize(function(){
		alterCenterClass();
	});
	alterCenterClass();
});
</script>

<?php 
$_FOOTER_HOME = false;
require $dir . "/templates/footer.php" 
?>