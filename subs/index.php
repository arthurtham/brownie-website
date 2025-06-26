<?php
$dir = dirname(__DIR__, 1);
$title = "Turtle Pond - Perks Hub";
require $dir . "/templates/header.php";
?>

<div class="container-fluid body-container">
	<div class="row">
		<div class="col-md-12 home-div-col" style="padding-bottom: 100px">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 offset-lg-1">
						<center><img src="https://res.cloudinary.com/browntulstar/image/upload/s--s7BzgqvH--/c_scale,w_400/f_webp/v1/com.browntulstar/img/pngtuber-turtle-half.png?_a=BAAAV6E0" style="width:auto;max-width:min(70vw,400px)"></center>
						<div class="card">
							<div class="card-body">
								<div class="container">

		
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<h1 class="text-center">Turtle Pond - Perks Hub</h1>
			<p class="text-center">
			Choose a platform, watch and support, and benefit!</p>
		</div>
	</div>
<?php
$_kofi_logo = "<img height='18' style='border:0px;height:18px;margin-top:-4px' src='https://res.cloudinary.com/browntulstar/image/private/s--mOeZPgHn--/c_pad,h_48/f_webp/v1/com.browntulstar/img/platform-kofi?_a=BAAAUWGX' border='0' alt='Buy Me a Coffee at ko-fi.com' />";
echo <<<SUBPERKSHEADER
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
SUBPERKSHEADER;

if (isset($_SESSION['user'])) {
	require $dir . "/templates/profile-box.php";
}

echo <<<SUBPERKSHEADER
		</div>
	</div>
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<a class="btn btn-dark mb-2 w-100" href="/discord">
							<i class="fa-brands fa-discord"></i>
							Join Turtle Pond Discord Server		
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<a class="btn btn-danger mb-2 w-100" href="details">
							<i class="fa-solid fa-circle-info"></i>
							Details + How to Set Up Perks
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<a class="btn btn-dark mb-2 w-100" href="https://www.twitch.tv/browntulstar" target="_blank">
							<i class="fa-brands fa-twitch"></i>
							Subscribe
						</a>
					</div>
					<div class="col-sm-4">
						<a class="btn btn-dark mb-2 w-100" href='https://ko-fi.com/browntulstar' target='_blank'>
						$_kofi_logo
						Donate
						</a>
					</div>
					<div class="col-sm-4">
						<a class="btn btn-info mb-2 w-100" href='/iriam'>
						<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0">
						Gift
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<h1 class="text-center">Available Perks</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 mb-2 d-flex align-items-stretch">
			<div class="card h-100 w-100">
				<center>
					<img 
						loading="lazy" 
						src="https://res.cloudinary.com/browntulstar/image/private/s--KfoRY1En--/c_fit,w_150,h_150/f_webp/v1/com.browntulstar/img/platform-twitch.webp?_a=BAAAV6E0" 
						class="card-img-top" 
						style="height:150px;width:auto;padding:10px"
						alt="Twitch Perks"
					>
				</center>
				<div class="card-body text-center">
					<h3 class="card-title">Twitch Emotes</h3>
					<a href="https://twitch.tv/browntulstar" target="_blank" class="btn btn-dark mb-2"><i class="fa-brands fa-twitch"></i> Use on Twitch</a>
					<h5><span class="badge bg-danger">RED SHELLS (Twitch Subs)</span></h5>
					<p class="card-text">Use Twitch sub-exclusive emotes on Twitch and Discord.
					See <a href="/credits">artist credits</a> for credits!</p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-2 d-flex align-items-stretch">
			<div class="card h-100 w-100">
				<center>
					<img 
						loading="lazy" 
						src="https://res.cloudinary.com/browntulstar/image/upload/s--_-gDZIU6--/c_fit,w_150,h_150/f_webp/v1/com.browntulstar/img/iriam-logo?_a=BAAAV6E0" 
						class="card-img-top" 
						style="height:150px;width:auto;padding:10px"
						alt="IRIAM Reward Perks"
					>
				</center>
				<div class="card-body text-center">
					<h3 class="card-title">IRIAM ★ Rewards</h3>
					<a href="/subs/iriam-rewards" class="btn btn-info mb-2">
					<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0">
					IRIAM Rewards</a>
					<h5><span class="badge bg-primary">STARS (IRIAM 1★)<br>AND ABOVE</span></h5>
					<h5><span class="badge bg-warning text-black">GOLD SHELLS (Discord VIPs)<br>1★/2★ Rewards Only</span></h5>
					<p class="card-text">Receive exclusive Star Badge rewards by gifting gifts to Browntul on IRIAM.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 mb-2 d-flex align-items-stretch">
			<div class="card h-100 w-100">
				<center>
					<img 
						loading="lazy" 
						src="https://res.cloudinary.com/browntulstar/image/private/s--Ve0EgVxL--/c_fit,w_150,h_150/f_webp/v1/com.browntulstar/img/turtleyear-sm.png?_a=BAAAV6E0" 
						class="card-img-top" 
						style="height:150px;width:auto;padding:10px"
						alt="Browntul's Blog"
					>
				<div class="card-body text-center">
					<h3 class="card-title">Browntul's Blog</h3>
					<a href="/subs/blog" class="btn btn-dark mb-2">Read Browntul's Blog</a>
					<h5><span class="badge bg-danger">RED SHELLS (Twitch Subs)</span></h5>
					<h5><span class="badge bg-primary">SUPER STARS (IRIAM 2★)<br>AND ABOVE</span></h5>
					<h5><span class="badge bg-warning text-black">GOLD SHELLS (Discord VIPs)</span></h5>
					<p class="card-text">Read Browntul's Blog on his adventuers, technology, and more! 
					</p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-2 d-flex align-items-stretch">
			<div class="card h-100 w-100">
				<center>
					<img 
						loading="lazy" 
						src="https://res.cloudinary.com/browntulstar/image/upload/s--BLjgU7Ax--/c_fit,h_150,w_150/f_webp/v1/com.browntulstar/img/platform-discord.jpg?_a=BAAAV6E0" 
						class="card-img-top" 
						style="height:150px;width:auto;padding:10px"
						alt="Discord Perks"
					>
				</center>
				<div class="card-body text-center">
					<h3 class="card-title">Discord Channel</h3>
					<a href="/discord" class="btn btn-dark mb-2"><i class="fa-brands fa-discord"></i> Join Discord</a>
					<h5><span class="badge bg-danger">RED SHELLS (Twitch Subs)</span></h5>
					<h5><span class="badge bg-primary">STARS (IRIAM 1★)<br>AND ABOVE</span></h5>
					<h5><span class="badge bg-warning text-black">GOLD SHELLS (Discord VIPs)</span></h5>
					<p class="card-text">Gain access to an exclusive Discord channel where Browntul may share some sneak peaks at what's ahead.
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 mb-2 d-flex align-items-stretch">
			<div class="card h-100 w-100">
				<center>
					<img 
						loading="lazy" 
						src="https://res.cloudinary.com/browntulstar/image/private/s--Jwq3O9Cw--/c_fit,w_150,h_150/f_webp/v1/com.browntulstar/img/credits-portfolio-yeoubiame.png?_a=BAAAV6E0" 
						class="card-img-top" 
						style="height:150px;width:auto;padding:10px"
						alt="Tank Engine Karaoke"
					>
				<div class="card-body text-center">
					<h3 class="card-title">Tank Engine Karaoke</h3>
					<a href="/subs/karaoke" class="btn btn-dark mb-2">Listen to Karaoke</a>
					<h5><span class="badge bg-danger">RED SHELLS (Twitch Subs)</span></h5>
					<h5><span class="badge bg-primary">SUPER STARS (IRIAM 2★)<br>AND ABOVE</span></h5>
					<h5><span class="badge bg-warning text-black">GOLD SHELLS (Discord VIPs)</span></h5>
					<p class="card-text">Sing along with Browntul the Tank Engine! Formerly a meme reward, but returning for a limited run. 
					</p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-2 d-flex align-items-stretch">
			<div class="card h-100 w-100">
				<center>
					<img 
						loading="lazy" 
						src="https://res.cloudinary.com/browntulstar/image/private/s--hGiugx47--/c_fit,h_150,w_150/f_webp/v1/com.browntulstar/img/turtle-adult.webp?_a=BAAAV6E0" 
						class="card-img-top" 
						style="height:150px;width:auto;padding:10px"
						alt="And More"
					>
				<div class="card-body text-center">
					<h3 class="card-title">More Rewards!</h3>
					<p class="card-text">Stay tuned! You never know if there will be more perks you can gain!
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
SUBPERKSHEADER;

echo "	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>";

?>
<?php require $dir . "/templates/footer.php" ?>