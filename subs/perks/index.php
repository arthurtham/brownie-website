<?php
$dir = dirname(__DIR__, 2);
$title = "Turtle Pond - Sub Perks";
require $dir . "/templates/header.php";
?>
<?php
$_kofi_logo = "<img height='18' style='border:0px;height:18px;margin-top:-4px' src='https://res.cloudinary.com/browntulstar/image/private/c_pad,h_48/com.browntulstar/img/platform-kofi.webp' border='0' alt='Buy Me a Coffee at ko-fi.com' />";

echo '<div class="container body-container">';

echo '<div class="d-flex flex-column align-items-center justify-content-center">';
echo '<p><h1 class="text-center">Turtle Pond - Sub Perks</h1></p>';

echo <<<SUBPERKSHEADER
		<div class="row">
			<div class="col-lg-12">
SUBPERKSHEADER;
			require $dir . "/templates/sub-perks-description.php";
echo <<<SUBPERKSHEADER2
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-lg-12">
				<a class="btn btn-dark w-100 mb-2" href="https://www.twitch.tv/browntulstar" target="_blank">
					<i class="fa-brands fa-twitch"></i>
					Sub on Twitch
				</a>
				<a class="btn btn-dark w-100 mb-2" href='https://ko-fi.com/browntulstar' target='_blank'>
				$_kofi_logo Join on Ko-fi
				</a>
				<a class="btn btn-dark w-100 mb-2" href="/r/discord" target="_blank">
					<i class="fa-brands fa-discord"></i>
					Join Turtle Pond Discord Server
				</a>
			</div>
		</div>
	</div>
</div>
SUBPERKSHEADER2;
?>
<?php require $dir . "/templates/footer.php" ?>