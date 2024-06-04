<?php
$dir = __DIR__;
$title = "BrowntulStar - Home";

require __DIR__ . "/templates/header.php" 
?>
<div class="container body-container-home">
	<div id="center-block" class="d-flex align-items-center justify-content-center">
		<center><img src="https://res.cloudinary.com/browntulstar/image/private/c_pad,h_400/com.browntulstar/img/browntulstar-logo-v2-large.webp" style="width:100%;max-width:500px" />
		<div class="box bg-gradient shadow rounded" style="background-color: rgba(255,255,255,0.2); padding: 20px; width:100%; max-width:370px">
			<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
				<a class="btn btn-primary w-100" href="/stream">
					<i class="fa-brands fa-twitch"></i>
					Stream
				</a>
			</span>
			<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
				<a id="subs-button" class="btn btn-light w-100">Sub Perks</a>
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
jQuery(document).ready(function($) {
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
})
$("#subs-button").click(function() { 
	$("#navbarSupportedContent").attr("class", "navbar-collapse collapse show");
	$("#navbarSubs").trigger("click");
	$("#navbarSubs").attr("class", "nav-link dropdown-toggle show");
	$("#navbarSubs-menu").trigger("click");
	$("#navbarSubs-menu").attr("class", "dropdown-menu show");
	$("#navbarSubs-menu").attr("data-bs-popper", "static");
});
</script>

<?php 
$_FOOTER_HOME = false;
require __DIR__ . "/templates/footer.php" 
?>